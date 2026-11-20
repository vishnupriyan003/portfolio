# ASSET CREDITS — Vishnupriyan Portfolio (editorial-light redesign)

Every asset used on this site is **stored locally** in `assets/` (or `image/`) — nothing is hotlinked from third-party CDNs.
Legend: **Source** = where it came from · **License** = usage terms verified on the stated date · **Origin** = downloaded / self-generated / pre-existing.

---

## Videos

| File | Source | License | Origin | Notes |
|------|--------|---------|--------|-------|
| `assets/videos/hero-forest.mp4` | Mixkit — *"Raining in a cloud forest full of tall trees"* (mixkit.co/free-stock-video/raining-in-a-cloud-forest-full-of-tall-trees-22728/) | Mixkit Free License — free for commercial & non-commercial use, **no attribution required**; the clip itself may not be redistributed/resold as stock. Verified: https://mixkit.co/license/ (2026-11-19) | downloaded 2026-11-19 | 1280×720 · 24 fps · 11.46 s · H.264 · video-only stream (no audio, ideal for muted loop) · faststart remuxed · **3.47 MB** (≤ 4 MB target) |

## Poster / fallback images

| File | Source | License | Origin | Notes |
|------|--------|---------|--------|-------|
| `assets/videos/hero-forest-poster.jpg` (88 KB) · `.webp` (72 KB) | first frame of `hero-forest.mp4` (Mixkit clip above) | Same Mixkit Free License as the video | downloaded | 1280×720 — shown while the video loads (`preload="metadata"`), and as the static/mobile fallback. No hotlinking. |

## Backgrounds & textures

| File | Source | License | Origin | Notes |
|------|--------|---------|--------|-------|
| `assets/textures/grain.png` · `.webp` | authored for this project (procedural noise) | 100% own asset — no third-party rights | self-generated | 128×128 tileable film-grain overlay, cream-tinted, alpha ≤ ~18% |

## Fonts (self-hosted, `assets/fonts/`)

No font is hotlinked — all files live in the project and are preloaded via `@font-face` with `font-display: swap`.

| File(s) | Family | License | Origin | Notes |
|---------|--------|---------|--------|-------|
| `instrumentserif-latin-400-normal.woff2` (20.5 KB) · `instrumentserif-latin-400-italic.woff2` (21.6 KB) | **Instrument Serif** — display serif (headlines + italic accent lines) | SIL Open Font License 1.1 (`OFL-InstrumentSerif.txt` in this folder) | downloaded from the official Google Fonts CDN (`fonts.gstatic.com`, 2026-11-20); byte-identical source also mirrored by the official `@fontsource/instrument-serif` npm package | latin subset only; verified `wOF2` magic bytes |
| `inter-latin-400/500/600/700/800-normal.woff2` (23–24 KB each) | **Inter** — UI/body sans | SIL Open Font License 1.1 (`OFL-Inter.txt`) | downloaded via official `@fontsource/inter` npm package (2026-11-19) | latin subset only |
| `fraunces-latin-500-normal.woff2` · `fraunces-latin-600-normal.woff2` | Fraunces — **retired** (no longer referenced after the UI reset) | SIL Open Font License 1.1 (`OFL-Fraunces.txt`) | downloaded via `@fontsource/fraunces` (2026-11-19) | kept on disk, not loaded |

Total active font payload: ~171 KB (7 files, woff2, subsetted to latin).

## Site images (`image/` — pre-existing, optimized in place)

All files below already existed in the project. Phase 2 **recompressed them in place** (same filename & format, so admin-managed `settings` paths keep working) and added a `.webp` twin for future `<picture>` use. Originals remain recoverable from git baseline `c8a0c1b`.

| File | Before | After | WebP twin | Origin |
|------|--------|-------|-----------|--------|
| `image/Arduino.jpeg` | 1,135 KB (3200×2316) | 116 KB (1100×796) | 98 KB | pre-existing |
| `image/css.jpg` | 1,588 KB (4961×3780) | 40 KB (1000×762) | 29 KB | pre-existing |
| `image/sql.jpg` | 1,586 KB (4961×3780) | 40 KB (1000×762) | 29 KB | pre-existing |
| `image/html.png` | 116 KB (1045×721) | 36 KB (900×621) | 20 KB | pre-existing |
| `image/icon.png` | 28 KB (500×500) | 8 KB | 14 KB | pre-existing |
| `image/logo.png` | 56 KB (350×350) | 14 KB | 12 KB | pre-existing |
| `image/respage1.jpg` | 1,374 KB (2481×3509) | 128 KB (1200×1697) | 112 KB | pre-existing |
| `image/respage2.jpg` | 1,430 KB (2481×3509) | 129 KB (1200×1697) | 115 KB | pre-existing |
| `image/vishnupriyan_r.jpg` | 220 KB (1152×1440) | 120 KB | 69 KB | pre-existing |

**Total: 8.5 MB → 683 KB (-92%)**, every image ≤ 130 KB.

> Provenance note: the original `image/*` files were already in the project before this redesign; their upstream source is unknown. They are personal/portfolio content (skill graphics, resume-page previews, profile photo) used to represent the owner's own work. If any is later found to be third-party material, replace it with a licensed asset from the list above.

## Not used

| Item | Reason |
|------|--------|
| `assets/videos/hero-forest.mp4` + `hero-forest-poster.jpg`/`.webp` | Licensed and verified (Mixkit), but the **editorial-light UI reset removed the video hero** — files kept on disk, no longer rendered. |
| `assets/textures/grain.png` / `.webp` | Self-authored film grain for the old cinematic overlay — no longer rendered after the UI reset. |
| `assets/textures/paper-fiber.svg` · `brutalist-grid.svg` | Textures for the removed Skeuomorphism/Brutalism themes — **deleted** with the theme engine (2026-11-20). |
| `new theme/12716-241674181.mp4` (31.1 MB) | Source/license unverified → excluded from the design by user decision (Phase 0). Left in place; not deleted. |
| `bg.mp4` | Referenced by the old hero but **missing from the project** (404) — superseded in Phase 4; hero since removed. |
| Mixkit clip `22729` ("Gloomy forest…", 4.1 MB) | Downloaded during Phase 2 selection but its actual footage was **not** a forest (listing/asset mismatch) → discarded, not used. |

---

## Policy

1. Prefer free stock sources: **Pexels, Pixabay, Mixkit, Coverr** — verify the license page before downloading.
2. Never hotlink; always download into `assets/`, then optimize (WebP/AVIF images, compressed video + poster).
3. AI-generated assets only when no suitable free stock exists — each one recorded here with its generator and prompt.
4. Every new file added in later phases **must** get a row here in the same commit.
