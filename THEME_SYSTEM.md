# MULTI-DESIGN THEME CUSTOMIZATION ENGINE — ARCHITECTURE & REFERENCE

**Project:** Vishnupriyan R — Portfolio  
**Stack:** Laravel 9 · Vanilla Modern JavaScript · Modular Scoped CSS · SVG Vector Design  
**Live Site:** https://vishnupriyanweb.free.nf/

---

## 1. Overview & Core Philosophy

The Multi-Design Theme Customization Engine provides a live, interactive design switcher supporting **seven completely distinct visual design systems** while preserving identical underlying data, content, structure, and functionality.

Unlike naive color-swapping themes, each theme implements an authentic design philosophy encompassing:
- Bespoke typography stacks (editorial serif, neo-grotesque sans, monospace/impact, material fonts)
- Unique surface treatments (frosted glass blur, soft neumorphic dual shadows, 3D skeuomorphic bevels, brutalist hard shadows, material dp elevations)
- Distinct button geometries, hover physics, and active click depths
- Distinct card borders, corner radiuses, and elevation transitions
- Context-aware background media (cinematic looping forest video in Nature, replaced by dedicated textures, mesh gradients, or solid planes in other themes)
- Light/Dark mode variants for themes where appropriate (Flat, Neumorphism, Glassmorphism, Material)

---

## 2. System Architecture

```
d:\xampp\htdocs\mywork\vichuprofile/
│
├── theme-engine/
│   ├── theme-config.js          # Theme metadata, color swatches, taglines, and inline SVG previews
│   ├── theme-storage.js         # Exception-safe localStorage wrapper (keys: vp_portfolio_theme, vp_portfolio_theme_mode)
│   └── theme-manager.js         # Core controller: DOM data-theme mutation, drawer UI, media sync, event bus
│
├── themes/
│   ├── nature-cinematic.css     # Theme 1: Forest green & warm cream, editorial Fraunces, video hero
│   ├── flat-design.css          # Theme 2: Minimalist solid planes, 0px shadows, 0 gradients, crisp lines
│   ├── neumorphism.css          # Theme 3: Soft UI surfaces, dual extruded/inset shadows, light/dark
│   ├── glassmorphism.css        # Theme 4: Frosted glass blur, luminous borders, aurora mesh gradients
│   ├── skeuomorphism.css        # Theme 5: Tactile parchment, stitched borders, 3D beveled buttons
│   ├── brutalism.css            # Theme 6: 3.5px black borders, 5px hard black shadows, pop colors
│   └── material-design.css      # Theme 7: Material 3 elevation surfaces, rounded cards, tonal hierarchy
│
├── assets/
│   └── textures/
│       ├── grain.png            # Existing procedural film grain
│       ├── paper-fiber.svg      # Procedural fiber/paper texture for Skeuomorphism
│       └── brutalist-grid.svg   # Architectural coordinate grid pattern for Brutalism
│
├── style.css                    # Imports themes/*.css upfront; styles FAB and slide-over drawer
├── script.js                    # Initializes ThemeManager.init() on load
└── portfolio.blade.php          # Includes anti-FOUC head script, FAB button, drawer container, scripts
```

---

## 3. The Seven Visual Design Systems

| Theme ID | Design System | Typography | Signature Surface Treatment | Background Treatment |
|---|---|---|---|---|
| `nature` | **Nature Cinematic** (Default) | Fraunces serif + Inter sans | Warm cream panels (`rgba(243,240,229,0.94)`), organic soft drop shadows | Looping video (`hero-forest.mp4`) + poster still + veil |
| `flat` | **Flat Design** | Modern Neo-Grotesque sans | 0px shadows, 0 gradients, 2px solid divider lines, sharp 4px radius | Crisp clean solid planes (`#f8fafc` / `#0f172a` in dark) |
| `neumorphism` | **Neumorphism** | Clean soft modern sans | Soft extruded surfaces (`7px 7px 15px var(--nm-shadow), -7px -7px 15px var(--nm-light)`), inset form inputs | Monochromatic surface blending (`#e0e5ec` / `#1e1e24` dark) |
| `glassmorphism` | **Glassmorphism** | High-contrast geometric sans | Frosted glass (`backdrop-filter: blur(16px) saturate(180%)`), 1px luminous borders | Deep midnight aurora radial mesh gradients |
| `skeuomorphism` | **Skeuomorphism** | Classic serif + letterpress | Tactile paper cards, stitched dashed borders, 3D beveled buttons | Subtle procedural paper-fiber texture (`paper-fiber.svg`) |
| `brutalism` | **Brutalism / Neubrutalism** | Heavyweight bold headlines | 3.5px solid black borders, 5px hard offset black shadows (`box-shadow: 5px 5px 0 #000`) | Bold yellow/cream canvas with architectural grid (`brutalist-grid.svg`) |
| `material` | **Material Design (M3)** | Roboto / system-ui | Layered elevation surfaces (Level 1–3 shadows), 16px rounded corners | Tonal surface container (`#fdfbff` / `#141218` dark) |

---

## 4. Execution Lifecycle & Zero-FOUC Strategy

To guarantee that the user never sees a flash of the wrong theme upon page load:

1. **Inline Anti-FOUC Script in `<head>`:**
   Placed immediately before `<link rel="stylesheet">` in `portfolio.blade.php`:
   ```html
   <script>
     (function () {
       try {
         var t = localStorage.getItem("vp_portfolio_theme") || "nature";
         var m = localStorage.getItem("vp_portfolio_theme_mode") || "default";
         document.documentElement.setAttribute("data-theme", t);
         if (m && m !== "default") {
           document.documentElement.setAttribute("data-theme-mode", m);
         }
       } catch (e) {}
     })();
   </script>
   ```
2. **Upfront Modular CSS Loading:**
   `style.css` imports all 7 theme stylesheets at the very top via `@import`. Because the stylesheets are already loaded in memory, switching themes only requires modifying the `data-theme` attribute on `<html>`, which triggers instant CSS rule application with **zero network latency and zero page reload**.
3. **Media Sync:**
   `ThemeManager.syncMedia(themeId)` monitors the active theme:
   - When `themeId === "nature"`: unhides `#myVideo`, `.hero-still`, and starts playback (respecting `prefers-reduced-motion`).
   - When `themeId !== "nature"`: pauses `#myVideo`, and hides `#myVideo`, `.hero-still`, and `.site-overlay` via `[data-theme]:not([data-theme="nature"]) { display: none !important; }`.

---

## 5. How to Add an 8th Theme in the Future

Adding a new theme to the portfolio is strictly modular:

1. **Create the Theme Stylesheet:**
   Create `themes/my-new-theme.css`:
   ```css
   :root[data-theme="my-new-theme"] {
     --theme-name: "my-new-theme";
     --bg: #...;
     --panel: #...;
     --ink: #...;
     --accent: #...;
     --line: #...;
   }
   [data-theme="my-new-theme"] body { ... }
   [data-theme="my-new-theme"] .btn-primary { ... }
   /* Component overrides */
   ```
2. **Import into `style.css`:**
   Add `@import url("themes/my-new-theme.css");` at the top of `style.css`.
3. **Register in `theme-engine/theme-config.js`:**
   Add a new entry to `THEME_CONFIG.themes`:
   ```javascript
   {
     id: "my-new-theme",
     name: "Cyberpunk High-Tech",
     tagline: "Neon & Angular",
     description: "Ultra-high contrast glowing neon accents and angular HUD panels.",
     hasLightDark: false,
     colors: ["#0a0a12", "#00ffcc", "#ff0055", "#ffe600"],
     svgIcon: `<svg>...</svg>`,
     previewSvg: `<svg>...</svg>`
   }
   ```
   The engine automatically generates the preview card, sets up click handlers, handles persistence, and updates the drawer UI without requiring any changes to Blade templates or manager scripts.

---

## 6. Accessibility & Performance Verification

- **Reduced Motion:** All drawer transitions, button hovers, and background videos honor `prefers-reduced-motion: reduce`.
- **Keyboard Navigation:** The drawer can be opened via the keyboard-focusable settings button, navigated using standard `Tab` / `Enter` / `Space`, and closed instantly with the `Escape` key.
- **Screen Reader Support:** ARIA attributes are maintained (`role="dialog"`, `aria-modal="true"`, `aria-pressed`, `aria-hidden`, `aria-label`).
- **Zero Third-Party CDNs:** 100% self-hosted assets and native system fonts; offline capable.
