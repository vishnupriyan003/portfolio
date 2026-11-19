# PROJECT STATUS — Nature-Inspired Cinematic Portfolio Redesign

**Project:** Vishnupriyan R — Portfolio (`D:\xampp\htdocs\mywork\vichuprofile`)
**Stack:** Laravel 9.52.23 · PHP 8.0.30 (XAMPP) · MySQL · Vanilla CSS/JS (Blade single page)
**Live site:** https://vishnupriyanweb.free.nf/ (InfinityFree)
**Started:** 2026-11-19
**Last updated:** Phase 1 complete (design system)

---

## Phase Tracker

| Phase | Objective | Status | Report |
|------|-----------|--------|--------|
| **0** | Full read-only audit (architecture, features, design proposal, libraries, assets, plan, risks) | ✅ **Complete** | Approved by user; findings below |
| **1** | Design system: git safety net, `PROJECT_STATUS.md`, nature-palette tokens in `style.css` (`:root` only) | ✅ **Complete** | Report below |
| **2** | Asset acquisition: stock hero video + poster, optimize images, `ASSET_CREDITS.md` | ⬜ Not started | Requires Phase 1 approval |
| **3** | UI foundation: header/nav rebuild, scroll progress, skip link, inline SVG icons (drop Font Awesome CDN) | ⬜ Not started | |
| **4** | Cinematic hero: full-screen muted looping video + poster + fallback, rotating designation, Hire Me / Download Resume, scroll cue | ⬜ Not started | |
| **5** | Content sections: About, Skills, Experience, Projects, Education/Certs, Achievements (omitted for now), Contact, Footer — resume-backed only; **removes DEV QUEST game panel** | ⬜ Not started | |
| **6** | Animations: CSS + IntersectionObserver reveals/hovers first; vendored GSAP/ScrollTrigger/Lenis **only if needed**; `prefers-reduced-motion` respected | ⬜ Not started | |
| **7** | Responsive: 360 / 390 / 768 / 1366 / 1920 px, mobile video alternative | ⬜ Not started | |
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

## Log

- **Phase 0** — Read-only audit completed and approved.
- **Phase 1** — ✅ Complete. `.gitignore` created; git baseline `c8a0c1b` (90 files); zip backup written (41.6 MB); `PROJECT_STATUS.md` created; `style.css` `:root` reworked into the nature design system; all legacy teal/gold literals routed through tokens; verified HTTP 200 + brace balance + zero old-palette colors. Commit: `phase-1-design-tokens`.
