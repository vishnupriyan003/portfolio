# Portfolio — Vishnupriyan R

Professional developer portfolio built with Laravel 9, featuring a single polished **"Editorial Light"** design: warm off-white canvas, Instrument Serif display typography, centered hero with a black-and-white portrait and floating info cards, white rounded card sections, and a monochrome palette with restrained pastel accent chips.

## Live Website
- **URL:** [https://vishnupriyanweb.free.nf/](https://vishnupriyanweb.free.nf/)

## Tech Stack
- **Backend:** Laravel 9 (PHP 8.0/8.2) · MySQL
- **Frontend:** Vanilla JavaScript (Modern ES6+) · Single design-system CSS · Inline SVG vector graphics
- **Typography:** Instrument Serif (display, regular + italic) & Inter (UI/body) — self-hosted OFL woff2, no CDN requests

## Design System
- **Canvas:** warm off-white `#f6f4ef` with white rounded cards (thin borders, soft shadows)
- **Type:** Instrument Serif headlines with italic accent lines · Inter for UI and body copy
- **Actions:** dark pill buttons (`Hire Me`, submit) paired with white pill buttons (`Download Resume`)
- **Nav:** static top bar — logo left, centered pill navigation with active-section state, dark CTA right (wraps to a second row on mobile, no hamburger)
- **Accents:** pastel green / orange / purple chips used sparingly for icons, tags and highlights
- **Hero:** centered editorial headline + rotating designation, B&W arch-framed portrait, floating stat cards with thin connector lines, circular "open to relocate" badge

## Key Features
- DB-driven content with `/vpadmin` admin editor (all copy, skills, projects, certificates and settings come from the `settings` table)
- Reveal-on-scroll animations, custom cursor, scroll progress bar, certificate lightbox, contact form with validation
- Fully responsive (360 → 1920 px) and `prefers-reduced-motion` aware
- Self-hosted fonts and assets — zero third-party runtime requests; SEO meta + JSON-LD Person schema

## Local Development
```bash
# Clone the repository
git clone https://github.com/vishnupriyan003/portfolio.git
cd portfolio

# Run via XAMPP or PHP built-in server (project root = front controller)
php -S localhost:8000
```
