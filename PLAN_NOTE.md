# Vishnupriyan Portfolio — Master Handoff & Implementation Plan

**Generated:** 2026-11-21  
**Repository:** `https://github.com/vishnupriyan003/portfolio.git`  
**Active Working Branch:** `2026-11-20`  
**Current Baseline Commit:** `b70b0f6` (Layout pass: consistent section rhythm, unified card grids, resume before Dev Lab)  
**Live Site:** [https://vishnupriyanweb.free.nf/](https://vishnupriyanweb.free.nf/)  
**Stack:** Laravel 9.52 (PHP 8.2) · MySQL · Vanilla ES6+ JS · Scoped Modern CSS · Self-hosted Instrument Serif & Inter (OFL)

---

## 1. Executive Summary & Purpose

This document serves as the **single-source handoff note** requested by Vishnupriyan to continue development seamlessly on his laptop. It captures:
1. **Database Backup & Migration State:** How to start fresh on the laptop with a complete, reproducible database.
2. **Current Working Tree:** What has been completed up to commit `b70b0f6`.
3. **Plan A (Next to implement):** About column spacing fix, deduplicating Education, adding the new **Career Focus** section, and the expandable **Dive Deeper** drawer.
4. **Plan B (Queued):** 3D Character Playground replacing the Dev Lab with 5 switchable animated GLTF heroes (Robot, Soldier, Xbot, Fox, Flamingo).

---

## 2. Laptop Setup Guide & Database Migrations

### 2.1 Cloning & Environment Setup on Laptop
```bash
# 1. Clone repository to your local web root (e.g. D:/xampp/htdocs/mywork/vichuprofile or E:/xampp/htdocs/...)
git clone https://github.com/vishnupriyan003/portfolio.git
cd portfolio

# 2. Switch to active development branch
git checkout 2026-11-20

# 3. Configure Laravel environment
cd main
cp .env.example .env   # or copy from existing main/.env
php artisan key:generate
```

### 2.2 Database Initialization Options
The repository includes **two foolproof ways** to initialize the database on your laptop:

#### Method 1: Laravel Migrations (Recommended)
All table structures and seed data are managed in `main/database/migrations/`:
- `0001_01_01_000000_create_users_table.php` (Users & password reset)
- `0001_01_01_000001_create_cache_table.php` (Cache & cache locks)
- `0001_01_01_000002_create_jobs_table.php` (Queues & failed jobs)
- `2026_05_01_000000_create_settings_table.php` (Settings table schema)
- `2026_05_01_010000_create_contact_messages_table.php` (Contact form submissions)
- `2026_11_21_000000_seed_initial_database_backup.php` (**New:** automatically inserts initial `portfolio_views: 79` into `settings`)

To run:
```bash
# Inside main/
php artisan migrate
# Or to reset and seed fresh:
php artisan migrate:fresh --seed
```

#### Method 2: Raw SQL Dump Import
A full standalone SQL dump is saved at:  
📂 `main/database/backup_if0_41802168_vichu.sql`

To import directly via MySQL CLI or phpMyAdmin:
```bash
mysql -u root -p if0_41802168_vichu < main/database/backup_if0_41802168_vichu.sql
```

### 2.3 Starting Local Development
```bash
# Run via XAMPP Apache, or PHP built-in server:
php -S localhost:8000
```
Open `http://localhost:8000` (or `http://localhost/mywork/vichuprofile/`).

---

## 3. Plan A: About Spacing Fix, Career Focus Section & "Dive Deeper"

### 3.1 Problem Statement & User Direction
1. **About column imbalance:** The left text column was shorter than the right fact cards, leaving an awkward blank space.
2. **Duplicate section:** Education was displayed twice (once as an About fact card and again in the dedicated Academic Profile section).
3. **Career content addition:** Incorporate Vishnupriyan's rich professional background from ChatGPT notes, filtered strictly to **career-only** items (omitting salary, chit funds, health, aquarium, and personal travel budgets).

### 3.2 Implementation Details

#### File: `main/app/Http/Controllers/PortfolioController.php`
In `defaults()`:
1. **Remove Education fact card from `about_facts`:**  
   Reduce to 3 clean cards:
   ```php
   'about_facts' => "Experience | Jun 2025 - present · 1 yr 5 mos as PHP Developer at Knock The Globe Technologies, plus 3 mo internship\nBased in | Karur, Tamil Nadu, India · open to relocating for the right opportunity\nLanguages | English and Tamil",
   ```
2. **Add 3rd paragraph to `about_text` to balance the left column:**
   ```php
   "Currently a PHP Developer at Knock The Globe Technologies, shipping and maintaining production web applications for 81 client projects — healthcare, jewellery, textile e-commerce, finance and travel — covering CRM modules, invoice and GST logic, Excel imports, WhatsApp API integrations, and live-site support."
   ```
3. **Add `about_chips`:**
   ```php
   'about_chips' => 'PHP, CodeIgniter 4, Laravel, MySQL, JavaScript, REST APIs, Bootstrap, Git',
   ```
4. **Add new Career Focus data keys:**
   - `career_title`: "Practical delivery across production applications and client systems."
   - `career_points`:
     ```text
     Core stack | PHP 7.4–8.3, CodeIgniter 3 & 4, Laravel, MySQL, HTML/CSS/JS, Bootstrap, jQuery, DataTables, REST APIs
     Client delivery | CRM pages, invoice & GST logic, Excel imports (PhpSpreadsheet), bill PDFs via WhatsApp Business Cloud API, live-site debugging
     Industries | 81 client projects — healthcare (Somasundaram Eye Hospital), jewellery (NPN Jewellery), textile e-commerce (Texspace), finance, travel
     Freelancing | Fiverr & Truelancer gigs: PHP/Laravel builds, admin panels, bug fixes, API integration, payment gateways, deployment
     Learning path | React, Node/Express, Angular, .NET CRUD, Dart alongside daily PHP delivery
     ```
   - `career_deep`:
     ```text
     Next phase | Grow freelance income through PHP development and hosting maintenance, sharpen Laravel ecosystem expertise
     Building now | Textile ERP (fabric stages: Kora, White, Dyeing, Printed -> POs -> receipts -> delivery-based stock) + ATOM AI personal PHP assistant
     Daily routine | Consistent weekday regimen: 2 hours coding practice + 1 hour dedicated project work
     Long-term goal | Internationally employable full-stack software engineer with opportunities for international work
     Study focus | GATE Computer Science preparation alongside daily production engineering
     ```

#### File: `main/resources/views/portfolio.blade.php`
1. Render `.about-chips` under the About paragraphs.
2. Insert `<section id="career" class="section section-card content-band">` between `#about` and `#skills`.
   - Render 5 cards in `.career-grid` using the unified `.info-card` aesthetic.
   - Render the expandable **"Dive Deeper ▾"** pill button with smooth accordion expansion.

#### File: `style.css` & `script.js`
- Style `.about-chips` pills.
- Add `.career-grid` (reusing existing card variables).
- Add ~15 lines in `script.js` for the accordion toggle (`aria-expanded`, max-height / grid-template-rows transition).

---

## 4. Plan B: 3D Character Playground (Replacing Dev Lab)

### 4.1 Concept & User Choice
The user requested replacing the Dev Lab / Bug Hunter game with an interactive **3D Character Playground** featuring 5 switchable top-rated animated GLTF heroes.
Because commercial superhero assets (e.g. Spider-Man) carry strict copyright and CORS issues, the playground uses 5 premier, open-source animated GLTF models:
1. **RobotExpressive** (three.js MIT) — Idle, Walking, Running, Jump, Dance
2. **Soldier** — Idle, Walk, Run
3. **Xbot** — Action humanoid: Idle, Walk, Run
4. **Fox** — Walk, Run, Survey
5. **Flamingo** — Flying loop

### 4.2 Interactions Supported
1. **Chip Hero Switching:** Robot · Soldier · Xbot · Fox · Flamingo (click chip fades out current model and loads next).
2. **Drag to Rotate:** Pointer drag smoothly orbits the 3D camera.
3. **Click / Tap Action:** Clicking the character triggers an action animation (Jump / Dance).
4. **Auto-Play Animation Loop:** Natural idle -> walk -> run cycle.
5. **Auto-Rotate Showcase:** Slowly spins after 4 seconds of inactivity.

### 4.3 Technical Architecture
- Local `assets/vendor/three.module.js` and `assets/vendor/GLTFLoader.js` (zero CDN dependency, works offline).
- Models stored locally in `models/heroes/*.glb` (each verified < 10 MB).
- Lazy-loaded via `IntersectionObserver` when `#playground` approaches viewport so initial page load stays instantaneous.

---

## 5. Verification Checklist for Laptop

When continuing on your laptop, run this checklist:
- [ ] `git status` confirms you are on branch `2026-11-20`.
- [ ] `main/.env` points to local MySQL (`127.0.0.1:3306`, DB: `if0_41802168_vichu`).
- [ ] `php artisan migrate` runs cleanly without errors.
- [ ] `php -S localhost:8000` starts the site.
- [ ] Visiting `http://localhost:8000` loads the Editorial Light portfolio.
- [ ] Ready to run Plan A (About spacing + Career Focus section).

---

*End of Note — All files committed and pushed to remote branch `2026-11-20`.*
