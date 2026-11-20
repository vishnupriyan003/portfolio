<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="{{ $content['seo_description'] }}">
  <meta name="keywords" content="{{ $content['seo_keywords'] }}">
  <meta name="author" content="Vishnupriyan ai">
  <meta name="robots" content="index, follow">
  <meta name="geo.region" content="IN-TN">
  <meta name="geo.placename" content="Karur, Tamil Nadu">
  <link rel="canonical" href="{{ url('/') }}">
  <meta property="og:type" content="profile">
  <meta property="og:title" content="{{ $content['seo_title'] }}">
  <meta property="og:description" content="{{ $content['seo_description'] }}">
  <meta property="og:image" content="{{ asset('image/vishnupriyan_r.jpg') }}">
  <meta property="og:url" content="{{ url('/') }}">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $content['seo_title'] }}">
  <meta name="twitter:description" content="{{ $content['seo_description'] }}">
  <meta name="twitter:image" content="{{ asset('image/vishnupriyan_r.jpg') }}">
  <link rel="icon" type="image/png" href="{{ asset('image/icon.png') }}">
  <title>{{ $content['seo_title'] }}</title>
  <link rel="preload" href="{{ asset('assets/fonts/fraunces-latin-600-normal.woff2') }}" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="{{ asset('assets/fonts/inter-latin-400-normal.woff2') }}" as="font" type="font/woff2" crossorigin>
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
  <link rel="stylesheet" href="{{ asset('style.css') }}">
  @php
    $schema = [
      '@context' => 'https://schema.org',
      '@type' => 'Person',
      'name' => $content['name'],
      'jobTitle' => $content['role'],
      'email' => $content['email'],
      'telephone' => $content['phone'],
      'address' => $content['location'],
      'url' => url('/'),
      'sameAs' => [$content['github'], $content['linkedin']],
      'knowsAbout' => ['Frontend Development', 'PHP', 'CodeIgniter', 'MySQL', 'React', 'JavaScript', 'Tailwind CSS', 'Figma', 'UI/UX Design', 'Karur web development'],
    ];
  @endphp
  <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
</head>
<body>
  <a class="skip-link" href="#main">Skip to content</a>
  <div class="scroll-progress" aria-hidden="true"><span></span></div>

  <div class="preloader" id="preloader" role="status" aria-live="polite" aria-label="Loading portfolio">
    <div class="preloader-card">
      <img src="{{ asset('image/logo.png') }}" alt="">
      <span>{{ $content['name'] }}</span>
      <div class="preloader-bar" aria-hidden="true"><span></span></div>
    </div>
  </div>

  <div class="cursor-dot" aria-hidden="true"></div>
  <div class="cursor-ring" aria-hidden="true"></div>

  <img class="hero-still" src="{{ asset('assets/videos/hero-forest-poster.jpg') }}" alt="" aria-hidden="true" fetchpriority="high" decoding="async">
  <video autoplay muted loop playsinline preload="metadata" id="myVideo"
         poster="{{ asset('assets/videos/hero-forest-poster.jpg') }}" aria-hidden="true">
    <source src="{{ asset('assets/videos/hero-forest.mp4') }}" type="video/mp4">
  </video>
  <div class="site-overlay" aria-hidden="true"></div>

  <header class="site-header">
    <a class="brand" href="#home" aria-label="{{ $content['name'] }} home">
      <img src="{{ asset('image/logo.png') }}" alt="">
      <span>{{ $content['name'] }}</span>
    </a>

    <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primaryNav" aria-label="Open navigation">
      <span></span><span></span><span></span>
    </button>

    <nav class="primary-nav" id="primaryNav" aria-label="Primary navigation">
      <a href="#home" class="nav-link">Home</a>
      <a href="#about" class="nav-link">About</a>
      <a href="#skills" class="nav-link">Skills</a>
      <a href="#experience" class="nav-link">Experience</a>
      <a href="#projects" class="nav-link">Projects</a>
      <a href="#contact" class="nav-link">Contact</a>
    </nav>
  </header>

  <main id="main" tabindex="-1">
    @php
      // Rotating designation phrases are derived only from existing content:
      // the role (split on "|") + SEO keywords that name a designation.
      $designations = collect(preg_split('/\s*\|\s*/', trim($content['role'])))
          ->merge(collect(explode(',', $content['seo_keywords']))
              ->map(fn ($k) => trim($k))
              ->filter(fn ($k) => $k !== '' && stripos($k, 'Developer') !== false && !str_ends_with($k, 'Karur')))
          ->filter()
          ->unique()
          ->values()
          ->take(5);
    @endphp
    <section id="home" class="hero section">
      <div class="hero-particles" aria-hidden="true"></div>
      <div class="hero-copy">
        <p class="eyebrow">
          <span class="sr-only">{{ $content['role'] }}</span>
          <span class="designation-rotator" aria-hidden="true" data-designations='@json($designations)'>{{ $designations[0] ?? $content['role'] }}</span>
        </p>
        <h1>{{ $content['hero_title'] }}</h1>
        <p class="hero-summary">{{ $content['summary'] }}</p>
        <div class="hero-actions">
          <a class="btn btn-primary" href="#contact-form"><x-icon name="envelope" /> Hire Me</a>
          <a class="btn btn-secondary" href="{{ asset($content['resume_pdf']) }}" download><x-icon name="download" /> Download Resume</a>
        </div>
        <div class="popularity-badge" aria-label="Portfolio popularity">
          <x-icon name="trending" />
          <span>{{ number_format($views) }} portfolio views</span>
        </div>
      </div>

      <aside class="profile-card" aria-label="Profile highlights">
        <img class="profile-photo" src="{{ asset('image/vishnupriyan_r.jpg') }}" alt="{{ $content['name'] }}">
        <div>
          <h2>{{ $content['name'] }}</h2>
          <p>{{ $content['role'] }}</p>
        </div>
        <div class="quick-stats">
          @foreach ($content['stats'] as $stat)
            <span><strong>{{ $stat['value'] }}</strong> {{ $stat['label'] }}</span>
          @endforeach
        </div>
      </aside>

      <div class="scroll-cue" aria-hidden="true">
        <span class="scroll-cue-mouse"><span></span></span>
        <span class="scroll-cue-label">Scroll</span>
      </div>
    </section>

    <section id="about" class="section content-band" aria-labelledby="aboutTitle">
      <div class="section-heading">
        <p class="eyebrow">About</p>
        <h2 id="aboutTitle">{{ $content['about_title'] }}</h2>
      </div>

      <div class="about-layout">
        <div class="about-copy">
          @foreach (preg_split('/\R{2,}/', trim($content['about_text'])) as $paragraph)
            @if (trim($paragraph) !== '')
              <p>{{ trim($paragraph) }}</p>
            @endif
          @endforeach
        </div>
        <dl class="about-facts">
          @foreach ($content['about_facts'] as $fact)
            <div>
              <dt>{{ $fact['label'] }}</dt>
              <dd>{{ $fact['value'] }}</dd>
            </div>
          @endforeach
        </dl>
      </div>
    </section>

    <section id="skills" class="section content-band">
      <div class="section-heading">
        <p class="eyebrow">Capabilities</p>
        <h2>Skills shaped by real web application work.</h2>
      </div>

      <div class="skills-grid">
        @foreach ($content['skills'] as $skill)
          <article class="info-card">
            <span class="icon-chip"><x-icon :name="$skill['icon'] ?: 'code'" /></span>
            <h3>{{ $skill['title'] }}</h3>
            <p>{{ $skill['text'] }}</p>
          </article>
        @endforeach
      </div>
    </section>

    <section id="experience" class="section split-section">
      <div class="section-heading">
        <p class="eyebrow">Experience</p>
        <h2>Practical development across internship and junior developer roles.</h2>
      </div>

      <div class="timeline">
        @foreach ($content['experience'] as $item)
          <article class="timeline-item">
            <div class="timeline-marker"></div>
            <div class="timeline-content">
              <p class="timeline-meta">{{ $item['meta'] }}</p>
              <h3>{{ $item['title'] }}</h3>
              <p class="timeline-company">{{ $item['company'] }}</p>
              <p>{{ $item['text'] }}</p>
            </div>
          </article>
        @endforeach
      </div>
    </section>

    <section id="projects" class="section content-band">
      <div class="section-heading">
        <p class="eyebrow">Featured Project</p>
        <h2>{{ $content['project_title'] }}</h2>
      </div>

      <div class="project-showcase">
        <div class="project-copy">
          <p>{{ $content['project_description'] }}</p>
          <div class="tag-list" aria-label="Project technologies">
            @foreach ($content['project_tags'] as $tag)
              <span>{{ $tag }}</span>
            @endforeach
          </div>
        </div>
        <div class="project-points">
          @foreach ($content['project_points'] as $point)
            <span><x-icon name="check" /> {{ $point }}</span>
          @endforeach
        </div>
      </div>

      <div class="project-list" aria-label="Additional resume projects">
        @foreach ($content['additional_projects'] as $project)
          <article>
            <h3>{{ $project['title'] }}</h3>
            <p>{{ $project['text'] }}</p>
            <span>{{ $project['tags'] }}</span>
          </article>
        @endforeach
      </div>
    </section>

    <section class="section education-section" aria-labelledby="educationTitle">
      <div class="section-heading">
        <p class="eyebrow">Education</p>
        <h2 id="educationTitle">Academic Profile</h2>
      </div>
      <div class="education-grid">
        @foreach ($content['education'] as $education)
          <article>
            <span>{{ $education['year'] }}</span>
            <h3>{{ $education['title'] }}</h3>
            <p>{{ $education['text'] }}</p>
          </article>
        @endforeach
      </div>
    </section>

    <section class="section certificates-section" aria-labelledby="certificatesTitle">
      <div class="section-heading">
        <p class="eyebrow">Certifications</p>
        <h2 id="certificatesTitle">Learning & Certificates</h2>
      </div>
      <div class="certificate-grid">
        @foreach ($content['certificates'] as $certificate)
          <button type="button" class="certificate-card" data-full="{{ asset($certificate['image']) }}" data-title="{{ $certificate['title'] }} Certificate">
            <img src="{{ asset($certificate['image']) }}" alt="{{ $certificate['title'] }} certificate" loading="lazy" decoding="async"><span>{{ $certificate['title'] }}</span>
          </button>
        @endforeach
        <article class="certificate-note">
          <span class="icon-chip"><x-icon name="award" /></span>
          <h3>More Resume Certifications</h3>
          <p>{{ $content['certification_summary'] }}</p>
        </article>
      </div>
    </section>

    <section class="section details-section" aria-labelledby="detailsTitle">
      <div class="section-heading">
        <p class="eyebrow">Additional Details</p>
        <h2 id="detailsTitle">Resume-backed strengths.</h2>
      </div>
      <div class="details-grid">
        <article>
          <h3>Soft Skills</h3>
          <p>{{ implode(', ', $content['soft_skills']) }}.</p>
        </article>
        <article>
          <h3>Languages</h3>
          <p>{{ implode(' and ', $content['languages']) }}.</p>
        </article>
        <article>
          <h3>Location Preference</h3>
          <p>{{ $content['location'] }} and {{ lcfirst($content['relocation']) }}.</p>
        </article>
      </div>
    </section>

    <section class="section resume-section" aria-labelledby="resumeTitle">
      <div class="section-heading">
        <p class="eyebrow">Resume</p>
        <h2 id="resumeTitle">Preview and Download</h2>
      </div>
      <div class="resume-preview-images">
        @foreach ($content['resume_previews'] as $index => $preview)
          <img src="{{ asset($preview) }}" alt="Resume page {{ $index + 1 }} preview" loading="lazy" decoding="async">
        @endforeach
      </div>
      <a href="{{ asset($content['resume_pdf']) }}" class="btn btn-primary" target="_blank" rel="noopener">
        <x-icon name="pdf" /> Open Resume PDF
      </a>
    </section>

    <section id="contact-form" class="section contact-form-section" aria-labelledby="contactFormTitle">
      <div class="section-heading">
        <p class="eyebrow">Start A Conversation</p>
        <h2 id="contactFormTitle">Send a project message</h2>
      </div>

      @if (session('contact_success'))
        <div class="form-alert">{{ session('contact_success') }}</div>
      @endif

      <form class="contact-form" method="POST" action="{{ route('contact.store') }}">
        @csrf
        <div class="form-grid">
          <label>
            <span>Name</span>
            <input name="name" value="{{ old('name') }}" required maxlength="120">
          </label>
          <label>
            <span>Email</span>
            <input name="email" type="email" value="{{ old('email') }}" required maxlength="160">
          </label>
        </div>
        <label>
          <span>Subject</span>
          <input name="subject" value="{{ old('subject') }}" maxlength="160">
        </label>
        <label>
          <span>Message</span>
          <textarea name="message" required minlength="10" maxlength="3000">{{ old('message') }}</textarea>
        </label>
        @if ($errors->any())
          <div class="form-error">{{ $errors->first() }}</div>
        @endif
        <button class="btn btn-primary" type="submit"><x-icon name="send" /> Send Message</button>
      </form>
    </section>
  </main>

  <div class="lightbox" id="certificateLightbox" aria-hidden="true">
    <button type="button" class="lightbox-close" aria-label="Close certificate preview">&times;</button>
    <img src="" alt="">
    <p></p>
  </div>

  <footer id="contact" class="site-footer section">
    <div>
      <p class="eyebrow">Contact</p>
      <h2>Let us build something useful.</h2>
      <p>{{ $content['location'] }} | {{ $content['relocation'] }}</p>
    </div>
    <div class="footer-links">
      <a href="mailto:{{ $content['email'] }}"><x-icon name="envelope" /> Email</a>
      <a href="tel:{{ preg_replace('/\s+/', '', $content['phone']) }}"><x-icon name="phone" /> {{ $content['phone'] }}</a>
      <a href="{{ $content['github'] }}" target="_blank" rel="noopener"><x-icon name="github" /> GitHub</a>
      <a href="{{ $content['linkedin'] }}" target="_blank" rel="noopener"><x-icon name="linkedin" /> LinkedIn</a>
    </div>
  </footer>

  <!-- Floating Theme Customization Trigger Button -->
  <button class="theme-settings-btn" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="themeCustomizationDrawer" aria-label="Customize Design">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <circle cx="12" cy="12" r="3"></circle>
      <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
    </svg>
    <span class="theme-settings-tooltip">Customize Design</span>
  </button>

  <!-- Theme Customization Drawer Backdrop -->
  <div class="theme-drawer-backdrop" id="themeDrawerBackdrop" aria-hidden="true"></div>

  <!-- Theme Customization Slide-Over Drawer -->
  <aside class="theme-drawer" id="themeCustomizationDrawer" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="themeDrawerTitle">
    <div class="theme-drawer-header">
      <div class="theme-drawer-title-wrap">
        <h2 id="themeDrawerTitle">Customize Your Experience</h2>
        <span class="theme-drawer-subtitle">7 Live Visual Design Systems</span>
      </div>
      <button class="theme-drawer-close" type="button" aria-label="Close customization panel">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>

    <div class="theme-drawer-body">
      <!-- Optional Variant Mode Toggle (for themes that support Light/Dark) -->
      <section class="theme-variant-section is-hidden" id="themeVariantSection" aria-label="Theme mode variants">
        <span class="theme-variant-label">Color Variant</span>
        <div class="theme-mode-buttons">
          <button class="theme-mode-btn is-active" type="button" data-mode-btn="default" aria-pressed="true">Default</button>
          <button class="theme-mode-btn" type="button" data-mode-btn="light" aria-pressed="false">Light</button>
          <button class="theme-mode-btn" type="button" data-mode-btn="dark" aria-pressed="false">Dark</button>
        </div>
      </section>

      <!-- Theme Cards List -->
      <div class="theme-cards-list" id="themeCardsContainer" role="radiogroup" aria-label="Available themes">
        <!-- Injected dynamically by ThemeManager -->
      </div>
    </div>

    <div class="theme-drawer-footer">
      <button class="theme-reset-btn" id="themeResetBtn" type="button">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
          <path d="M3 3v5h5"></path>
        </svg>
        Reset to Default (Nature)
      </button>
    </div>
  </aside>

  <script src="{{ asset('theme-engine/theme-config.js') }}"></script>
  <script src="{{ asset('theme-engine/theme-storage.js') }}"></script>
  <script src="{{ asset('theme-engine/theme-manager.js') }}"></script>
  <script src="{{ asset('script.js') }}"></script>
</body>
</html>
