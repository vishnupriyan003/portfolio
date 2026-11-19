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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
  <div class="preloader" id="preloader" role="status" aria-live="polite" aria-label="Loading portfolio">
    <div class="preloader-card">
      <img src="{{ asset('image/logo.png') }}" alt="">
      <span>{{ $content['name'] }}</span>
      <div class="preloader-bar" aria-hidden="true"><span></span></div>
    </div>
  </div>

  <div class="cursor-dot" aria-hidden="true"></div>
  <div class="cursor-ring" aria-hidden="true"></div>

  <video autoplay muted loop playsinline id="myVideo" preload="metadata" aria-hidden="true">
    <source src="{{ asset('bg.mp4') }}" type="video/mp4">
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
      <a href="#skills" class="nav-link">Skills</a>
      <a href="#experience" class="nav-link">Experience</a>
      <a href="#projects" class="nav-link">Projects</a>
      <a href="#contact" class="nav-link">Contact</a>
    </nav>
  </header>

  <main>
    <section id="home" class="hero section">
      <div class="hero-copy">
        <p class="eyebrow">{{ $content['role'] }}</p>
        <h1>{{ $content['hero_title'] }}</h1>
        <p class="hero-summary">{{ $content['summary'] }}</p>
        <div class="hero-actions">
          <a class="btn btn-primary" href="#projects"><i class="fas fa-laptop-code"></i> View Work</a>
          <a class="btn btn-secondary" href="{{ asset($content['resume_pdf']) }}" target="_blank" rel="noopener"><i class="fas fa-file-download"></i> Resume</a>
        </div>
        <div class="popularity-badge" aria-label="Portfolio popularity">
          <i class="fas fa-chart-line"></i>
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

      <aside class="game-panel" aria-label="Developer game stats">
        <div class="game-panel-header">
          <span>DEV QUEST</span>
          <strong>LVL 12</strong>
        </div>
        <div class="xp-bar"><span style="width: 78%"></span></div>
        <div class="game-grid">
          <span><b>HP</b> Clean UI</span>
          <span><b>MP</b> PHP Logic</span>
          <span><b>XP</b> MySQL</span>
          <span><b>SKILL</b> UX Flow</span>
        </div>
      </aside>
    </section>

    <section id="skills" class="section content-band">
      <div class="section-heading">
        <p class="eyebrow">Capabilities</p>
        <h2>Skills shaped by real web application work.</h2>
      </div>

      <div class="skills-grid">
        @foreach ($content['skills'] as $skill)
          <article class="info-card">
            <i class="fas {{ $skill['icon'] ?: 'fa-code' }}"></i>
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
            <span><i class="fas fa-check"></i> {{ $point }}</span>
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
            <img src="{{ asset($certificate['image']) }}" alt="{{ $certificate['title'] }} certificate"><span>{{ $certificate['title'] }}</span>
          </button>
        @endforeach
        <article class="certificate-note">
          <i class="fas fa-award"></i>
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
          <img src="{{ asset($preview) }}" alt="Resume page {{ $index + 1 }} preview">
        @endforeach
      </div>
      <a href="{{ asset($content['resume_pdf']) }}" class="btn btn-primary" target="_blank" rel="noopener">
        <i class="fas fa-file-pdf"></i> Open Resume PDF
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
        <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i> Send Message</button>
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
      <a href="mailto:{{ $content['email'] }}"><i class="fas fa-envelope"></i> Email</a>
      <a href="tel:{{ preg_replace('/\s+/', '', $content['phone']) }}"><i class="fas fa-phone-alt"></i> {{ $content['phone'] }}</a>
      <a href="{{ $content['github'] }}" target="_blank" rel="noopener"><i class="fab fa-github"></i> GitHub</a>
      <a href="{{ $content['linkedin'] }}" target="_blank" rel="noopener"><i class="fab fa-linkedin"></i> LinkedIn</a>
    </div>
  </footer>

  <script src="{{ asset('script.js') }}"></script>
</body>
</html>
