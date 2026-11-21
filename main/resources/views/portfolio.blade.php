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
  <meta name="geo.placename" content="Karur, Tamil Nadu, India">
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
  <link rel="preload" href="{{ asset('assets/fonts/instrumentserif-latin-400-normal.woff2') }}" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="{{ asset('assets/fonts/instrumentserif-latin-400-italic.woff2') }}" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="{{ asset('assets/fonts/inter-latin-400-normal.woff2') }}" as="font" type="font/woff2" crossorigin>
  <link rel="stylesheet" href="{{ asset('style.css') }}">
  @php
    $jobTitle = trim(explode('|', $content['role'])[0]);
    $jobTitle = trim(explode('@', $jobTitle)[0]) ?: $jobTitle;
    $schema = [
      '@context' => 'https://schema.org',
      '@type' => 'Person',
      'name' => $content['name'],
      'jobTitle' => $jobTitle,
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

  <header class="site-header">
    <a class="brand" href="#home" aria-label="{{ $content['name'] }} home">
      <img src="{{ asset('image/logo.png') }}" alt="">
      <span>{{ $content['name'] }}</span>
    </a>

    <nav class="primary-nav" id="primaryNav" aria-label="Primary navigation">
      <a href="#home" class="nav-link">Home</a>
      <a href="#about" class="nav-link">About</a>
      <a href="#career" class="nav-link">Career</a>
      <a href="#skills" class="nav-link">Skills</a>
      <a href="#experience" class="nav-link">Experience</a>
      <a href="#projects" class="nav-link">Projects</a>
      <a href="#playground" class="nav-link">Playground</a>
      <a href="#contact" class="nav-link">Contact</a>
    </nav>

    <a class="btn btn-primary header-cta" href="#contact-form">Hire Me
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M8 7h9v9"/></svg>
    </a>
  </header>

  <main id="main" tabindex="-1">
    @php
      // Rotating designation phrases are derived only from existing content:
      // the role (split on "|") + SEO keywords that name a designation.
      // Keyword phrases longer than 4 words are skipped so location-stuffed
      // SEO phrases never leak into the hero as fake job titles.
      $designations = collect(preg_split('/\s*\|\s*/', trim($content['role'])))
          ->merge(collect(explode(',', $content['seo_keywords']))
              ->map(fn ($k) => trim($k))
              ->filter(fn ($k) => $k !== '' && stripos($k, 'Developer') !== false && !str_ends_with($k, 'Karur') && str_word_count($k) <= 4))
          ->filter()
          ->unique()
          ->values()
          ->take(5);
    @endphp
    <section id="home" class="hero section">
      <div class="hero-copy">
        <h1>{{ $content['hero_title'] }}</h1>
        <p class="hero-italic">
          <span class="sr-only">{{ $content['role'] }}</span>
          <span class="designation-rotator" aria-hidden="true" data-designations='@json($designations)'>{{ $designations[0] ?? $content['role'] }}</span>
        </p>
        <p class="hero-summary">{{ $content['summary'] }}</p>
        <div class="hero-actions">
          <a class="btn btn-primary" href="#contact-form">Hire Me
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
          </a>
          <a class="btn btn-secondary" href="{{ asset($content['resume_pdf']) }}" download><x-icon name="download" /> Download Resume</a>
        </div>
      </div>

      <div class="hero-stage">
        <svg class="hero-connectors" aria-hidden="true" viewBox="0 0 1000 560" preserveAspectRatio="none">
          <path d="M180 150 C 300 210, 360 250, 430 300" />
          <path d="M830 175 C 720 230, 655 275, 585 315" />
        </svg>

        <aside class="float-card float-card-left" aria-label="Quick highlights">
          <span class="chip-icon chip-green"><x-icon name="award" /></span>
          <div class="float-stats">
            @foreach ($content['stats'] as $stat)
              <span><strong>{{ $stat['value'] }}</strong> {{ $stat['label'] }}</span>
            @endforeach
          </div>
        </aside>

        <aside class="float-card float-card-right" aria-label="Portfolio popularity">
          <span class="chip-icon chip-purple"><x-icon name="trending" /></span>
          <p class="float-stat-value">{{ number_format($views) }}</p>
          <p class="float-stat-label">portfolio views</p>
        </aside>

        <figure class="hero-portrait">
          <img src="{{ asset('image/vishnupriyan_r.jpg') }}" alt="{{ $content['name'] }}" fetchpriority="high" decoding="async">
        </figure>

        @foreach (collect($content['skills'])->take(3) as $index => $skill)
          <span class="photo-chip photo-chip-{{ $index + 1 }}" aria-hidden="true">
            <span class="photo-dot photo-dot-{{ $index + 1 }}"></span>{{ $skill['title'] }}
          </span>
        @endforeach

        <div class="hero-badge" aria-hidden="true">
          <svg viewBox="0 0 120 120">
            <defs>
              <path id="badgeCircle" d="M60,60 m-45,0 a45,45 0 1,1 90,0 a45,45 0 1,1 -90,0" />
            </defs>
            <text><textPath href="#badgeCircle">OPEN TO RELOCATE · KARUR, TAMIL NADU · </textPath></text>
            <text class="badge-star" x="60" y="67" text-anchor="middle">✦</text>
          </svg>
        </div>
      </div>

      <div class="hero-meta hero-meta-left" aria-hidden="true">
        <span class="meta-rule"></span>
        <p>Based in {{ $content['location'] }}</p>
      </div>
      <div class="hero-meta hero-meta-right" aria-hidden="true">
        <p>{{ $content['relocation'] }}</p>
        <span class="meta-star">✦</span>
      </div>
    </section>

    <section id="about" class="section section-card content-band" aria-labelledby="aboutTitle">
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
          @if (!empty($content['about_chips']))
            <div class="about-chips" aria-label="Core technologies">
              @foreach ($content['about_chips'] as $chip)
                <span class="about-chip-pill">{{ $chip }}</span>
              @endforeach
            </div>
          @endif
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

    <section id="career" class="section section-card content-band" aria-labelledby="careerTitle">
      <div class="section-heading">
        <p class="eyebrow">Career Focus</p>
        <h2 id="careerTitle">{{ $content['career_title'] }}</h2>
      </div>

      <div class="career-grid">
        @foreach ($content['career_points'] as $point)
          <article class="info-card career-card">
            <span class="career-label">{{ $point['label'] }}</span>
            <p>{{ $point['value'] }}</p>
          </article>
        @endforeach
      </div>

      @if (!empty($content['career_deep']))
        <div class="career-drawer-wrapper">
          <div id="careerDrawer" class="career-drawer" aria-hidden="true">
            <div class="career-drawer-inner career-grid">
              @foreach ($content['career_deep'] as $point)
                <article class="info-card career-card card-accent">
                  <span class="career-label">{{ $point['label'] }}</span>
                  <p>{{ $point['value'] }}</p>
                </article>
              @endforeach
            </div>
          </div>
          <button type="button" class="btn btn-secondary drawer-toggle" id="drawerToggle" aria-expanded="false" aria-controls="careerDrawer">
            <span class="toggle-text">Dive Deeper</span>
            <svg class="icon icon-chevron" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
          </button>
        </div>
      @endif
    </section>

    <section id="skills" class="section section-card content-band">
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

    <section id="experience" class="section section-card split-section">
      <div class="section-heading">
        <p class="eyebrow">Experience</p>
        <h2>Professional experience across client projects and live product work.</h2>
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

    <section id="projects" class="section section-card content-band">
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

    <section class="section section-card education-section" aria-labelledby="educationTitle">
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

    <section class="section section-card certificates-section" aria-labelledby="certificatesTitle">
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

    <section class="section section-card details-section" aria-labelledby="detailsTitle">
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

    <section class="section section-card resume-section" aria-labelledby="resumeTitle">
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

    <section id="playground" class="section section-card content-band playground-section" aria-labelledby="playgroundTitle">
      <div class="section-heading">
        <p class="eyebrow">Interactive 3D</p>
        <h2 id="playgroundTitle">3D Character Playground</h2>
        <p class="section-subtext">Real-time WebGL viewport powered by Three.js. Switch between 5 animated heroes, drag to rotate in 360°, and trigger custom action moves.</p>
      </div>

      <!-- Character Picker Chips -->
      <div class="playground-chip-bar" role="group" aria-label="Select 3D Character">
        <button type="button" class="hero-chip is-active" data-hero="robot" aria-pressed="true">
          <span class="hero-chip-icon">🤖</span>
          <span class="hero-chip-name">Robot</span>
        </button>
        <button type="button" class="hero-chip" data-hero="astronaut" aria-pressed="false">
          <span class="hero-chip-icon">🧑‍🚀</span>
          <span class="hero-chip-name">Astronaut</span>
        </button>
        <button type="button" class="hero-chip" data-hero="horse" aria-pressed="false">
          <span class="hero-chip-icon">🐎</span>
          <span class="hero-chip-name">Horse</span>
        </button>
        <button type="button" class="hero-chip" data-hero="fox" aria-pressed="false">
          <span class="hero-chip-icon">🦊</span>
          <span class="hero-chip-name">Fox</span>
        </button>
        <button type="button" class="hero-chip" data-hero="flamingo" aria-pressed="false">
          <span class="hero-chip-icon">🦩</span>
          <span class="hero-chip-name">Flamingo</span>
        </button>
      </div>

      <!-- 3D Stage -->
      <div class="playground-stage" id="playgroundStage">
        <div class="playground-canvas-wrapper" id="canvasWrapper">
          <canvas id="playgroundCanvas" aria-label="3D Interactive Canvas"></canvas>
        </div>

        <!-- Loading Spinner -->
        <div class="playground-loading is-hidden" id="playgroundLoading" aria-live="polite">
          <div class="spinner-ring"></div>
          <p id="loadingHeroText">Loading 3D Hero...</p>
        </div>

        <!-- HUD Status & Action Triggers -->
        <div class="playground-hud">
          <div class="hud-status-badge">
            <span class="hud-status-dot"></span>
            <span class="hud-status-text" id="heroStatusText">Idle</span>
          </div>

          <div class="hud-action-pills" id="actionPills">
            <button type="button" class="action-btn is-active" data-action="idle">
              <span>Idle</span>
            </button>
            <button type="button" class="action-btn" data-action="walk">
              <span>Walk</span>
            </button>
            <button type="button" class="action-btn" data-action="run">
              <span>Run</span>
            </button>
            <button type="button" class="action-btn action-special" data-action="action" id="specialActionBtn">
              <span>⚡ Action</span>
            </button>
          </div>
        </div>

        <div class="playground-hint" aria-hidden="true">
          <span>Drag to orbit · Scroll to zoom · Click character for action move</span>
        </div>
      </div>
    </section>

    <section id="contact-form" class="section section-card contact-form-section" aria-labelledby="contactFormTitle">
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

  <footer id="contact" class="site-footer section section-card">
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

  <script src="{{ asset('assets/vendor/three.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/GLTFLoader.js') }}"></script>
  <script src="{{ asset('script.js') }}"></script>
</body>
</html>
