# portfolio

# Portfolio — Vishnupriyan R

Professional developer portfolio featuring a live **Multi-Design Theme Customization Engine** supporting seven complete visual design systems (Nature Cinematic, Flat Design, Neumorphism, Glassmorphism, Skeuomorphism, Brutalism, Material Design), all sharing the same content, data, and responsive functionality.

## Live Website
- **URL:** [https://vishnupriyanweb.free.nf/](https://vishnupriyanweb.free.nf/)

## Tech Stack
- **Backend:** Laravel 9 (PHP 8.2) · MySQL
- **Frontend:** Vanilla JavaScript (Modern ES6+) · Scoped Modular CSS · SVG Vector Graphics
- **Architecture:** Multi-Theme Engine (`data-theme`), Zero-FOUC persistence, Offline-first self-hosted assets (OFL Fraunces & Inter)

## Visual Design Systems
1. **Nature Cinematic (Default):** Forest green & warm cream, editorial typography, atmospheric looped video hero.
2. **Flat Design:** Minimalist solid surfaces, 0px shadows, 0 gradients, crisp lines, neo-grotesque hierarchy (with Light/Dark modes).
3. **Neumorphism:** Soft UI dual-shadow extruded and inset components, pill controls (with Light/Dark modes).
4. **Glassmorphism:** Multi-layered frosted glass panels (`backdrop-filter: blur(16px)`), luminous borders, aurora mesh gradients.
5. **Skeuomorphism:** Tactile parchment surfaces, stitched borders, 3D beveled buttons, and letterpress typography.
6. **Brutalism / Neubrutalism:** Thick 3.5px solid black borders, hard offset 5px black drop shadows, high-voltage pop colors.
7. **Material Design:** Material 3 elevation surfaces (dp levels), rounded card containers, and clean Roboto typography (with Light/Dark modes).

## Key Features
- **Live Customization Drawer:** Slide-over panel on desktop, ergonomic bottom-sheet on mobile devices (`< 768px`).
- **Zero-FOUC:** Synchronous `<head>` loader prevents any flash of wrong theme on page load.
- **Context-Aware Media:** Looping hero video is automatically paused and hidden on non-nature themes to reveal bespoke theme textures.
- **Accessible & Motion-Aware:** Full keyboard navigation (`Tab` / `Escape`), ARIA dialog standards, and strict adherence to `prefers-reduced-motion`.

## Local Development
```bash
# Clone the repository
git clone https://github.com/vishnupriyan003/portfolio.git
cd portfolio

# Run via XAMPP or PHP built-in server
php -S localhost:8000
```
