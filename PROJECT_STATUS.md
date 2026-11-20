# PROJECT STATUS — Nature-Inspired Cinematic Portfolio Redesign

**Project:** Vishnupriyan R — Portfolio (`D:\xampp\htdocs\mywork\vichuprofile`)
**Stack:** Laravel 9.52.23 · PHP 8.0.30 (XAMPP) · MySQL · Vanilla CSS/JS (Blade single page)
**Live site:** https://vishnupriyanweb.free.nf/ (InfinityFree)
**Started:** 2026-11-19
**Last updated:** Phase 7 complete (responsive)

---

## Phase Tracker

| Phase | Objective | Status | Report |
|------|-----------|--------|--------|
| **0** | Full read-only audit (architecture, features, design proposal, libraries, assets, plan, risks) | ✅ **Complete** | Approved by user; findings below |
| **1** | Design system: git safety net, `PROJECT_STATUS.md`, nature-palette tokens in `style.css` (`:root` only) | ✅ **Complete** | Report below |
| **2** | Asset acquisition: stock hero video + poster, optimize images, `ASSET_CREDITS.md` | ✅ **Complete** | Report below |
| **3** | UI foundation: header/nav rebuild, scroll progress, skip link, inline SVG icons (drop Font Awesome CDN), self-hosted fonts | ✅ **Complete** | Report below |
| **4** | Cinematic hero: full-screen muted looping video + poster + fallback, rotating designation, Hire Me / Download Resume, scroll cue | ✅ **Complete** | Report below |
| **5** | Content sections: About, Skills, Experience, Projects, Education/Certs, Achievements (omitted for now), Contact, Footer — resume-backed only; **removes DEV QUEST game panel** | ✅ **Complete** | Report below |
| **6** | Animations: CSS + IntersectionObserver reveals/hovers first; vendored GSAP/ScrollTrigger/Lenis **only if needed**; `prefers-reduced-motion` respected | ✅ **Complete** | Report below |
| **7** | Responsive: 360 / 390 / 768 / 1366 / 1920 px, mobile video alternative | ✅ **Complete** | Report below |
| **8** | Performance / accessibility / SEO: lazy loading, sitemap.xml, cursor fix, debug flag, `.env` guidance | ⬜ Not started | |
| **9** | Testing checklist + InfinityFree deployment + live verification | ⬜ Not started | |

---

## Locked Decisions (user-confirmed)

| Date | Decision |
|------|----------|
| Phase 0 | **Achievements section omitted** until the user provides verified items (no invented awards). |
| Phase 0 | **Animation stack:** CSS + IntersectionObserver first; GSAP/ScrollTrigger/Lenis vendored locally only if Phase 6 requires it. |
| Phase 0 | **Hero video:** download a **new** verified stock clip (Pexels/Pixabay/Mixkit/Coverr), license-checked, compressed ≤ 4 MB, credited in `ASSET_CREDITS.md`. The unverified `new theme/12716-241674181.mp4` (31 MB) is **not** used. |
| Phase 0 | **Remove the decorative "DEV QUEST" game panel** during Phase 5. |
| Phase 0 | **git init + zip backup** approved before Phase 1. |
| Design | Palette: Forest Green `#142B23`, Deep Green `#203C30`, Sage Green `#91A891`, Warm Cream `#F3F0E5`, Earth Brown `#9B7957`, Muted Gold `#C5A66A`. No neon, no generic gradients, no overcrowding. |
| Content | Never invent companies, roles, projects, awards, years, or skill levels. Laravel/PHP positioning must be **verified against `vishnupriyan Resume-2.pdf`** before Phase 5 copy is written. |

---

## Safety Net

| Item | Location | Notes |
|------|----------|-------|
| Git repo | project root | Baseline commit `c8a0c1b` — 90 files, before any redesign edits |
| Zip backup | `D:\xampp\htdocs\mywork\vichuprofile_backup_prephase1.zip` | 41.6 MB, excludes `vendor/`, `node_modules/`, `.git/` |
| L12 backups | `main/composer.json.laravel12.bak`, `main/composer.lock.laravel12.bak` | From the Laravel 12 → 9 downgrade |

**Rollback:** `git stash` / `git checkout -- <file>` for single files, or restore the zip for a full reset.

---

## Phase 0 Audit — Key Findings

**Architecture:** Root `index.php` bootstraps the Laravel app in `main/`; single Blade page (`portfolio.blade.php`, 323 lines) renders DB-driven content from the `settings` table (defaults in `PortfolioController::defaults()`, overridable via `/vpadmin`). Static assets served from project root (`style.css` ~1400 lines, `script.js` 155 lines). Vanilla JS: preloader, custom cursor, hamburger nav, scroll-spy, reveal-on-scroll, certificate lightbox.

**Existing sections:** Hero (+DEV QUEST panel) · Skills · Experience timeline · Featured Projects · Education · Certificates · Additional Details · Resume · Contact · Footer.

**Issues to fix during redesign:**

1. 🔴 `bg.mp4` referenced in hero but **missing** → hero video currently 404s.
2. 🟡 Unverified 31 MB video in `new theme/` (not used; replace with licensed clip).
3. 🟡 Images unoptimized (1.1–1.6 MB each; ~7 MB of certificates/resume previews).
4. 🟡 Font Awesome 5.15.4 **hotlinked** from cdnjs → replace with inline SVG (Phase 3).
5. 🟡 `cursor: none` applied unconditionally → cursor lost if JS fails (fix Phase 8).
6. 🟡 `.env` has `APP_ENV=production` + `APP_DEBUG=true` → set `APP_DEBUG=false` before deploy (Phase 9).
7. 🟡 Local DB ≠ server DB → deploy **code only**; server data untouched.
8. ⚪ Stale files: `main/resources/views/welcome.blade.php`, `main/tech_profile_vp` (old SQLite), `main/PORTFOLIO_SETUP.md` (wrong paths) — **removal needs separate approval**.
9. ⚪ No sitemap.xml yet (Phase 8).

**Hosting (InfinityFree):** free tier blocks external MySQL connections; site sits behind an anti-bot JS challenge so tooling can't fetch it — local files are the source of truth. Set PHP 8.1/8.2 in the InfinityFree dashboard to match Laravel 9.

---

## Phase 1 Report (Complete)

**Scope executed — CSS only; zero HTML/JS/PHP changes** (`git diff --stat`: `style.css` 56 insertions / 39 deletions, plus this file).

1. **Safety net:** `.gitignore` created → baseline commit **`c8a0c1b`** (90 files) → zip backup `D:\xampp\htdocs\mywork\vichuprofile_backup_prephase1.zip` (41.6 MB).
2. **Design tokens added to `:root`:** palette (`--forest`, `--deep`, `--sage`, `--cream`, `--earth`, `--gold`), semantic roles kept under legacy names (`--bg`, `--panel`, `--ink`, `--accent`, …), cinematic overlay layers (`--overlay-veil/mid/glow`), and font stacks (`--font-sans`, `--font-display`) reserved for Phase 3.
3. **Hard-coded legacy colors routed through tokens** (prevents a half-teal page): header + cards + mobile nav → Warm Cream; hero overlay + preloader → forest/deep green; hero copy → Sage; h1 sheen → cream→sage→gold; buttons/focus → Earth Deep `#8a6a4c`; chips → sage tints; gold highlights → Muted Gold `#c5a66a`. All 15 old-palette literals (`#071014`, `#1f8a70`, `#166555`, `#dff4ee`, `#f3b23c`, `#c9efe4`, `rgba(31,138,112,…)`, `rgba(243,178,60,…)`) verified **gone**.
4. **Contrast (AA):** button fill w/ white text 4.95:1 · accent text on cream 6.05:1 · nav links 5.09:1 · body ink on cream 15:1 · gold on forest 6.5:1.
5. **Verification:** brace balance 227/227 · `GET /` → **HTTP 200**, DB-driven title intact · `GET /style.css` → 200 with `--forest` token live · semantic form success/error colors intentionally kept.

**Not done here (later phases):** fonts still Arial (Phase 3), video/hero (Phases 2–4), structure/sections (Phase 5).

**Next:** Phase 2 — asset acquisition (verified stock hero video + poster, image optimization, `ASSET_CREDITS.md`).

---

## Phase 2 Report (Complete)

**Tooling installed** (all outside the project, in session temp): `sharp` (image/WebP), `ffmpeg` 6.1.1 + `ffprobe` (video). Project gained **no** node_modules.

1. **Hero video — `assets/videos/hero-forest.mp4` (3.47 MB ✅ ≤ 4 MB)**
   - Source: Mixkit *"Raining in a cloud forest full of tall trees"* — **Mixkit Free License** (commercial OK, no attribution required), license page verified.
   - 1280×720 · 24 fps · 11.46 s · H.264 · **video-only stream** (no audio → inherently muted loop) · remuxed `+faststart` for progressive streaming (no re-encode).
   - Selection: 6 candidates probed on the CDN; two misty-forest clips downloaded and **frames visually inspected**; clip `22729` discarded (footage didn't match its listing).
2. **Poster/fallback — `hero-forest-poster.jpg` (88 KB) + `.webp` (72 KB)**, 1280×720, extracted from the clip's opening frame (matches first paint).
3. **Image optimization — `image/*` 8.5 MB → 683 KB (-92%)**: all 9 files recompressed **in place** (same name/format → admin `settings` paths unbroken), every file ≤ 130 KB, `.webp` twins added. Verified decoding + HTTP 200. Originals recoverable from git baseline `c8a0c1b`.
4. **`assets/textures/grain.png` (15 KB) / `.webp` (11 KB)** — self-authored 128×128 tileable film grain (procedural, zero third-party rights) for the cinematic overlay.
5. **`assets/` tree created**: `images · videos · backgrounds · textures · icons · generated · documentation · fonts`.
6. **`ASSET_CREDITS.md`** — every asset recorded with source URL, license terms, verification date, origin; includes a "Not used" section (31 MB unverified clip, missing `bg.mp4`, mismatched `22729`) and the ongoing acquisition policy.

**Acceptance checks:** video ≤ 4 MB ✅ · poster ≤ 150 KB ✅ · all images ≤ 150 KB ✅ · license verified & documented ✅ · nothing hotlinked ✅ · no AI-generated assets needed ✅.

**Next:** Phase 3 — UI foundation (header/nav rebuild, scroll progress, skip link, inline SVG icons replacing the Font Awesome CDN, self-hosted fonts).

---

## Phase 3 Report (Complete)

**Files changed:** `main/resources/views/portfolio.blade.php`, **new** `main/resources/views/components/icon.blade.php`, `style.css`, `script.js`, **new** `assets/fonts/*` (8 files).

1. **Font Awesome CDN eliminated** — the only third-party request in the page is gone. 13 `<i class="fas/fab…">` usages replaced by a **new inline-SVG icon component** (`<x-icon name="…" />`, 15-icon stroke set authored here: code, server, database, tools, laptop, download, trending, check, award, pdf, send, envelope, phone, github, linkedin). Legacy `fa-*` names from the DB (`fa-code`, `fa-server`, `fa-database`, `fa-tools`) are auto-stripped and mapped, so stored content keeps working. Icons are `aria-hidden` by default; meaning-bearing ones can take `label`.
2. **Self-hosted typography** — Fraunces (display, 500/600) for headings + Inter (400–800) for UI/body, latin-subset woff2, `font-display: swap`, `@font-face` in `style.css`, critical files **preloaded** in `<head>`. ~154 KB total; OFL license texts stored beside them.
3. **Skip link** — first focusable element, `href="#main"`, visible only on keyboard focus; `<main id="main" tabindex="-1">` added as the target.
4. **Scroll progress bar** — 3 px earth→gold gradient fixed bar, rAF-throttled width updates (no layout thrash), hidden from AT (`aria-hidden`).
5. **Header refinement** — `.is-scrolled` condense state (tighter top offset, denser shadow) toggled on >24 px scroll; transition respects `prefers-reduced-motion` (global reduced-motion rule).
6. **Nav a11y** — active link now also carries `aria-current="location"` alongside the existing `.active` scroll-spy class.

**Acceptance checks:** `node --check` OK · CSS braces 243/243 · page HTTP 200 (25.6 KB) · **0** cdnjs/FA references in output · 18 inline SVGs rendered · all 4 DB skill icons resolved (`icon-code/server/database/tools`) · fonts/video/texture all HTTP 200 · title unchanged.

**Next:** Phase 4 — cinematic hero (wire the new video + poster + fallback into the blade, designation animation, Hire Me / Download Resume CTAs, scroll cue, particles).

---

## Phase 4 Report (Complete)

**Files changed:** `main/resources/views/portfolio.blade.php`, `style.css`, `script.js`.

1. **Video wired in** — the missing `bg.mp4` (404) replaced by `assets/videos/hero-forest.mp4` (3.47 MB, Phase 2) with `poster` + `preload="metadata"`, `autoplay muted loop playsinline`. Added `<img class="hero-still">` poster layer at `z-index:-3` so the first paint and any autoplay-block/failure case still shows the forest still (video −2 → overlay −1 → content 1).
2. **Rotating designation** — phrases are **derived server-side from existing content only**: `role` split on `|` + SEO keywords containing "Developer" (excluding place-suffixed ones). Verified output: *Karur Frontend Developer → PHP Developer → Karur PHP Developer → CodeIgniter Developer → MySQL Developer* — nothing invented. Full role kept in an `.sr-only` span; rotator is `aria-hidden`. 3.4 s cycle, fade/slide transition, skipped entirely under `prefers-reduced-motion`.
3. **CTAs** — **Hire Me** → `#contact-form`; **Download Resume** → the resume PDF with `download` attribute (replaced the old "View Work"/"Resume" pair per Phase 0 scope).
4. **Scroll cue** — animated mouse + "Scroll" label, absolutely positioned bottom-center of the hero, fades out after 120 px scroll, `aria-hidden`.
5. **Ambient particles** — 16 gold/sage dots generated by JS into `.hero-particles` (random position, drift, size, duration, negative delay for immediate life); skipped under reduced motion.
6. **Reduced motion** — video is paused + `autoplay` removed when the user prefers reduced motion (and re-started if the preference flips back); global CSS rule already covers cue/particle/rotator transitions.
7. **CSS specificity fix** — the hero's `.hero > *` positioning rule excluded `.scroll-cue` (it would have overridden `position:absolute` at 0,3,0 specificity).

**Acceptance checks:** JS syntax OK · CSS braces balanced · page HTTP 200 · `hero-forest.mp4`/poster/`hero-still`/`designation-rotator`/`data-designations`/`Hire Me`/`Download Resume`/`scroll-cue` all present · `bg.mp4` reference gone.

---

## Phase 5 Report (Complete)

**Files changed:** `main/resources/views/portfolio.blade.php`, `main/app/Http/Controllers/PortfolioController.php`, `style.css`, `script.js`. **Copy verified against `vishnupriyan Resume-2.pdf`** (2 pages, text extracted with pdf-parse).

1. **DEV QUEST game panel removed** (Phase 0 decision) — blade aside, 4 CSS blocks + `loadXp` keyframes + responsive rule, and the JS reveal selector. Project-wide grep: **0** remaining references.
2. **New About section** (`#about`, between hero and skills, added to nav + scroll-spy) — resume professional summary verbatim as two paragraphs + 4 fact rows, every value taken straight from the resume: education (B.E. CSE 2020–2024, VSB Engineering College, 79%), experience (9 mo junior role + 3 mo internship), location/relocation, languages. Data lives in `defaults()` (`about_title`, `about_text`, `about_facts`) so the admin can override it like every other field.
3. **Experience rendering bug found & fixed** — data had **4 fields** (`meta|title|company|text`) but parsed as 3, so the second entry rendered its title as *"3 months"* and leaked `|` into the body text. Parser now uses `['meta','title','company','text']`, defaults reformatted (dates moved into meta: `3 months (ended 20-05-2025)`), and the company renders as its own `.timeline-company` line. Verified in rendered HTML: titles "Junior PHP Developer" / "PHP Developer Intern", companies on their own lines, **zero pipe leaks**.
4. **Resume cross-check — flags for the user (kept, not invented, not removed):** certificates (HTML/CSS/Arduino/SQL + Great Learning/JSPIDER summary) and the two additional projects (Non-Helmet Detection System, Bus Route Scheduler) are real existing project content but **do not appear in the resume**. They were left as-is; say the word and I'll remove or annotate them. Everything new written in this phase is resume-verbatim.
5. **Achievements section** — remains omitted (no verified items; Phase 0 decision).

**Acceptance checks:** JS OK · CSS braces 261/261 · page HTTP 200 (27.7 KB) · game-panel/DEV QUEST/xp-bar/loadXp: **none** · `#about` + facts + nav link present · timeline correct, no pipe leaks.

---

## Phase 6 Report (Complete)

**Decision: no GSAP/Lenis needed** — the existing CSS + IntersectionObserver system already covers every requirement, so nothing was vendored (locked Phase 0 decision honored: library only if needed). **Files changed:** `style.css` only.

1. **Hero entrance stagger** — `.hero-copy`'s single fadeUp replaced with per-child sequence (eyebrow → h1 → summary → CTAs → badge at 0.10/0.22/0.34/0.46/0.58 s) for a cinematic build-in.
2. **List staggers extended** — `transition-delay` added for `.timeline-item` (2–3), `.project-list article` (2–3), `.details-grid article` (2–3), matching the existing skills/certificate/education staggers.
3. **Hover polish** — lift + deep shadow on `.project-list article` and `.details-grid article` (previously static).
4. **Already in place, verified untouched:** reveal-on-scroll (IntersectionObserver, unobserve after reveal), smooth anchor scrolling, button/card/timeline/tag/footer hovers, lightbox fade+zoom, preloader, `is-scrolled` header, scroll-cue pulse, particles, designation rotator.
5. **Reduced motion:** the global `prefers-reduced-motion` block (0.01 ms durations, `scroll-behavior: auto`, `.reveal` forced visible) covers all of the above; JS already gates cursor/rotator/particles/video on the same query.

**Acceptance checks:** CSS braces 270/270 · `node --check` OK · page HTTP 200 · all new selectors present in output · reduced-motion block present.

---

## Phase 7 Report (Complete)

**Files changed:** `style.css`, `script.js`.

1. **Nav overflow fix at 768 px** — the 6-link desktop nav + brand ≈ 800 px, wider than the 744 px header at tablet width. The hamburger dropdown block moved to its own `@media (max-width: 880px)` (layout grids keep their 980/760 breakpoints), so tablets get the dropdown while 1366/1920 keep the full bar.
2. **Mobile video alternative** — at ≤760 px the background video is skipped entirely: CSS `#myVideo { display: none }` + JS aborts any in-flight request (removes `<source>`, `load()`), and a `skipVideoForViewport` flag stops the reduced-motion handler from re-enabling it. The `hero-still` poster layer (Phase 4) becomes the mobile background → **zero video bytes on phones**.
3. **`100dvh` fallback** — `.hero` now `min-height: 100vh; min-height: 100dvh` so the hero isn't clipped by mobile browser URL bars.
4. **Breakpoint walkthrough (360/390/768/1366/1920):**
   - **360/390** — ≤480: h1 36 px, brand ellipsis, hero CTAs + footer links stack full-width, buttons full-width; ≤760: single-column grids, hamburger, 26 px card padding, poster-only hero.
   - **768** — hamburger (880 rule), 2-col skills/certificate/details grids (980 rule), single-col hero/about (980/760 rules).
   - **1366/1920** — full desktop: 2-col hero, nav bar, 3-col education, video background plays (width > 760).
   - All widths: `body { overflow-x: hidden }` guards horizontal scroll; `scroll-padding-top` keeps anchors clear of the fixed header.

**Acceptance checks:** `node --check` OK · CSS braces 272/272 · page HTTP 200 · 6 media queries (980/880/760/480 + reduced-motion + pointer:coarse) · `100dvh`/880/mobile-video/abort-guard all present.

---

## Log

- **Phase 0** — Read-only audit completed and approved.
- **Phase 1** — ✅ Complete. `.gitignore` created; git baseline `c8a0c1b` (90 files); zip backup written (41.6 MB); `PROJECT_STATUS.md` created; `style.css` `:root` reworked into the nature design system; all legacy teal/gold literals routed through tokens; verified HTTP 200 + brace balance + zero old-palette colors. Commit: `phase-1-design-tokens`.
- **Phase 2** — ✅ Complete. Hero video `assets/videos/hero-forest.mp4` (Mixkit Free License, 3.47 MB, faststart, silent) + poster jpg/webp; `image/*` 8.5 MB → 683 KB with WebP twins; self-authored grain texture; `assets/` tree; `ASSET_CREDITS.md` with verified license terms. Commit: `phase-2-assets`.
- **Phase 3** — ✅ Complete. Font Awesome CDN removed → 15-icon inline SVG component (DB `fa-*` names mapped); Fraunces + Inter self-hosted (OFL, preloaded); skip link + `#main` target; rAF scroll-progress bar; condensed header state; `aria-current` nav. Commit: `phase-3-ui-foundation`.
- **Phase 4** — ✅ Complete. Hero video/poster/still fallback wired (bg.mp4 404 gone); content-derived rotating designation; Hire Me + Download Resume CTAs; scroll cue; ambient particles; reduced-motion video guard.
- **Phase 5** — ✅ Complete. DEV QUEST game panel removed; resume-verified About section added; experience 4-field parse bug fixed (company line, no pipe leaks); resume cross-check flags recorded. Commit: `phase-4-5-hero-content`.
- **Phase 6** — ✅ Complete. No GSAP/Lenis (CSS+IO sufficient); hero entrance stagger, list staggers, hover lifts. Commit: `phase-6-animations`.
- **Phase 7** — ✅ Complete. Nav hamburger breakpoint at 880 (768 overflow fix), mobile video skipped (poster-only, download aborted), `100dvh` hero, breakpoint walkthrough. Commit: `phase-7-responsive`.
- **Theme Customization Engine** — ✅ Complete. Live multi-design customization engine supporting 7 full visual design systems (Nature Cinematic, Flat, Neumorphism, Glassmorphism, Skeuomorphism, Brutalism, Material Design); modular CSS (`themes/*.css`); floating FAB trigger button; slide-over drawer with SVG preview cards and component mini-samples; zero-FOUC anti-flash head script; safe localStorage persistence; media synchronization. Documentation: `THEME_SYSTEM.md`.

---

## Multi-Design Theme Customization Engine Report (Complete)

**Feature Objective:** Add a live theme customization engine supporting seven completely different visual design systems sharing the same content, functionality, and data without page reloading.

**Files Created:**
- `theme-engine/theme-config.js` — Registry for 7 themes, color swatches, taglines, descriptions, mode flags, and inline SVG preview illustrations.
- `theme-engine/theme-storage.js` — Exception-safe localStorage wrapper (`vp_portfolio_theme`, `vp_portfolio_theme_mode`).
- `theme-engine/theme-manager.js` — Core orchestrator: DOM mutations (`data-theme`, `data-theme-mode`), drawer event bus, video pause/play sync, keyboard accessibility.
- `themes/nature-cinematic.css` — Theme 1: Forest green & warm cream, editorial serif, video overlay.
- `themes/flat-design.css` — Theme 2: Zero shadows, zero gradients, crisp solid surfaces, neo-grotesque sans.
- `themes/neumorphism.css` — Theme 3: Soft UI surfaces, dual extruded/inset soft shadows, pill controls, light & dark modes.
- `themes/glassmorphism.css` — Theme 4: Frosted glass panels (`backdrop-filter: blur()`), luminous borders, aurora mesh gradients.
- `themes/skeuomorphism.css` — Theme 5: Tactile parchment, stitched borders, 3D beveled buttons, letterpress headings.
- `themes/brutalism.css` — Theme 6: 3.5px solid black borders, 5px hard black shadows, high-voltage pop colors, impact typography.
- `themes/material-design.css` — Theme 7: Material 3 elevation surfaces (dp levels), rounded cards, tonal containers.
- `assets/textures/paper-fiber.svg` — Procedural fiber texture for Skeuomorphism.
- `assets/textures/brutalist-grid.svg` — Architectural grid texture for Brutalism.
- `THEME_SYSTEM.md` — Complete architecture, token reference, and guide for adding future themes.

**Files Modified:**
- `style.css` — Upfront modular `@import` of all 7 theme stylesheets; floating settings FAB; slide-over drawer styling; universal video-hiding rules for non-nature themes; mobile responsive bottom-sheet drawer.
- `script.js` — Integrated `ThemeManager.init()`; expanded custom cursor hover targets; guarded motion preferences against activating video in non-nature themes.
- `main/resources/views/portfolio.blade.php` — Inline anti-FOUC head script; floating FAB button; slide-over drawer markup; modular script inclusions.

**Acceptance Verification:**
- Syntax: `node --check` passed for all 4 JS scripts with exit code 0.
- CSS: All 8 CSS files verified with balanced braces (`style.css` 324/324, themes 18–24 balanced).
- Blade compilation: Render test passed successfully, all theme elements rendered.
- Zero FOUC: `<head>` script executes synchronously before body paint.
- Video sync: `#myVideo` pauses and hides automatically when switching to any theme other than Nature Cinematic, and resumes when switching back.

