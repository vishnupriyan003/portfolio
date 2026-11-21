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
      <a href="#skills" class="nav-link">Skills</a>
      <a href="#experience" class="nav-link">Experience</a>
      <a href="#projects" class="nav-link">Projects</a>
      <a href="#devlab" class="nav-link">Dev Lab</a>
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

    <section id="devlab" class="section section-card content-band devlab-section" aria-labelledby="devlabTitle">
      <div class="section-heading">
        <p class="eyebrow">Developer Playground</p>
        <h2 id="devlabTitle">Dev Lab: Tricks, Tips & Arcade</h2>
        <p class="section-subtext">Interactive code tricks, modern productivity snippets, and a live bug-hunting mini-game.</p>
      </div>

      <!-- Segmented Mode Tabs -->
      <div class="devlab-tab-nav" role="tablist" aria-label="Dev Lab Modes">
        <button type="button" class="devlab-tab-btn is-active" id="tabTipsBtn" role="tab" aria-selected="true" aria-controls="devlabTipsVault">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
          Pro Tricks & Tips
        </button>
        <button type="button" class="devlab-tab-btn" id="tabGameBtn" role="tab" aria-selected="false" aria-controls="devlabGameArena">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="6" width="20" height="12" rx="3"/><path d="M6 12h4m-2-2v4"/><circle cx="17" cy="10" r="1"/><circle cx="15" cy="13" r="1"/></svg>
          Bug Hunter Arcade
        </button>
      </div>

      <!-- TAB 1: TIPS & TRICKS VAULT -->
      <div class="devlab-view is-active" id="devlabTipsVault" role="tabpanel" aria-labelledby="tabTipsBtn">
        <!-- Category Filter Pills -->
        <div class="devlab-filters" role="group" aria-label="Filter tips by technology">
          <button type="button" class="filter-pill is-active" data-filter="all">All Tricks</button>
          <button type="button" class="filter-pill" data-filter="css">CSS Magic</button>
          <button type="button" class="filter-pill" data-filter="js">Modern JS</button>
          <button type="button" class="filter-pill" data-filter="php">PHP 8+ Pro</button>
          <button type="button" class="filter-pill" data-filter="tools">DevTools</button>
        </div>

        <!-- Tip Cards Grid -->
        <div class="tips-grid">
          <!-- Tip 1 -->
          <article class="tip-card" data-category="css">
            <div class="tip-card-header">
              <span class="tip-badge badge-css">CSS Grid</span>
              <button type="button" class="copy-snippet-btn" aria-label="Copy code snippet" title="Copy code">
                <svg class="copy-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                <span class="copy-label">Copy</span>
              </button>
            </div>
            <h3>Fluid One-Line Responsive Grid</h3>
            <p>Eliminate complex media queries. Use CSS Grid auto-fit with minmax for fluid columns that adapt automatically to any screen size.</p>
            <div class="code-box">
              <div class="code-header"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span><span class="code-title">layout.css</span></div>
              <pre><code><span class="token-selector">.responsive-grid</span> {
  <span class="token-prop">display</span>: grid;
  <span class="token-prop">grid-template-columns</span>: <span class="token-val">repeat(auto-fit, minmax(280px, 1fr))</span>;
  <span class="token-prop">gap</span>: <span class="token-val">1.5rem</span>;
}</code></pre>
            </div>
          </article>

          <!-- Tip 2 -->
          <article class="tip-card" data-category="css">
            <div class="tip-card-header">
              <span class="tip-badge badge-css">CSS Magic</span>
              <button type="button" class="copy-snippet-btn" aria-label="Copy code snippet" title="Copy code">
                <svg class="copy-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                <span class="copy-label">Copy</span>
              </button>
            </div>
            <h3>Luminous Gradient Border Card</h3>
            <p>Create sleek gradient borders using dual background layers with padding-box and border-box clipping without extra wrapper elements.</p>
            <div class="code-box">
              <div class="code-header"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span><span class="code-title">glow-card.css</span></div>
              <pre><code><span class="token-selector">.glow-card</span> {
  <span class="token-prop">border</span>: <span class="token-val">2px solid transparent</span>;
  <span class="token-prop">background</span>:
    <span class="token-val">linear-gradient(#fff, #fff) padding-box</span>,
    <span class="token-val">linear-gradient(135deg, #10b981, #6366f1) border-box</span>;
  <span class="token-prop">border-radius</span>: <span class="token-val">16px</span>;
}</code></pre>
            </div>
          </article>

          <!-- Tip 3 -->
          <article class="tip-card" data-category="js">
            <div class="tip-card-header">
              <span class="tip-badge badge-js">Performance</span>
              <button type="button" class="copy-snippet-btn" aria-label="Copy code snippet" title="Copy code">
                <svg class="copy-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                <span class="copy-label">Copy</span>
              </button>
            </div>
            <h3>Lightweight Zero-Dependency Debounce</h3>
            <p>Prevent server overload and sluggish search inputs with this clean functional debounce closure in 5 lines of pure modern JavaScript.</p>
            <div class="code-box">
              <div class="code-header"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span><span class="code-title">debounce.js</span></div>
              <pre><code><span class="token-kw">const</span> <span class="token-fn">debounce</span> = (fn, delay = <span class="token-num">300</span>) => {
  <span class="token-kw">let</span> timer;
  <span class="token-kw">return</span> (...args) => {
    <span class="token-fn">clearTimeout</span>(timer);
    timer = <span class="token-fn">setTimeout</span>(() => fn(...args), delay);
  };
};</code></pre>
            </div>
          </article>

          <!-- Tip 4 -->
          <article class="tip-card" data-category="js">
            <div class="tip-card-header">
              <span class="tip-badge badge-js">Modern JS</span>
              <button type="button" class="copy-snippet-btn" aria-label="Copy code snippet" title="Copy code">
                <svg class="copy-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                <span class="copy-label">Copy</span>
              </button>
            </div>
            <h3>Native Deep Clone with structuredClone()</h3>
            <p>Stop using <code>JSON.parse(JSON.stringify(obj))</code> which loses Dates, Sets, Maps, and regexes. Modern browsers provide native deep cloning.</p>
            <div class="code-box">
              <div class="code-header"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span><span class="code-title">clone.js</span></div>
              <pre><code><span class="token-comment">// Preserves Dates, Maps, Sets & circular references</span>
<span class="token-kw">const</span> state = { user: <span class="token-str">"Vichu"</span>, tags: <span class="token-kw">new</span> <span class="token-fn">Set</span>([<span class="token-str">"PHP"</span>, <span class="token-str">"JS"</span>]) };
<span class="token-kw">const</span> cloned = <span class="token-fn">structuredClone</span>(state);</code></pre>
            </div>
          </article>

          <!-- Tip 5 -->
          <article class="tip-card" data-category="php">
            <div class="tip-card-header">
              <span class="tip-badge badge-php">PHP 8+</span>
              <button type="button" class="copy-snippet-btn" aria-label="Copy code snippet" title="Copy code">
                <svg class="copy-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                <span class="copy-label">Copy</span>
              </button>
            </div>
            <h3>PHP 8 Match & Nullsafe Operator</h3>
            <p>Replace verbose switch statements and repeated <code>isset()</code> guards with strictly-evaluated match expressions and nullsafe chaining.</p>
            <div class="code-box">
              <div class="code-header"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span><span class="code-title">Controller.php</span></div>
              <pre><code><span class="token-var">$status</span> = <span class="token-kw">match</span>(<span class="token-var">$code</span>) {
    <span class="token-num">200</span>, <span class="token-num">201</span> => <span class="token-str">'Success'</span>,
    <span class="token-num">404</span>      => <span class="token-str">'Not Found'</span>,
    <span class="token-kw">default</span>  => <span class="token-str">'Error'</span>,
};

<span class="token-var">$city</span> = <span class="token-var">$user</span>?->profile?->address?->city ?? <span class="token-str">'Karur'</span>;</code></pre>
            </div>
          </article>

          <!-- Tip 6 -->
          <article class="tip-card" data-category="tools">
            <div class="tip-card-header">
              <span class="tip-badge badge-tools">DevTools</span>
              <button type="button" class="copy-snippet-btn" aria-label="Copy code snippet" title="Copy code">
                <svg class="copy-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                <span class="copy-label">Copy</span>
              </button>
            </div>
            <h3>DevTools console.table & copy() Power</h3>
            <p>Inspect arrays in a neat sortable tabular view, and copy any inspected DOM node directly into your operating system clipboard.</p>
            <div class="code-box">
              <div class="code-header"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span><span class="code-title">DevTools Console</span></div>
              <pre><code><span class="token-comment">// 1. Formats object arrays into a clean sortable table</span>
<span class="token-fn">console.table</span>(users, [<span class="token-str">"id"</span>, <span class="token-str">"name"</span>, <span class="token-str">"role"</span>]);

<span class="token-comment">// 2. Copies selected Elements Inspector node to clipboard</span>
<span class="token-fn">copy</span>($0);</code></pre>
            </div>
          </article>
        </div>
      </div>

      <!-- TAB 2: BUG HUNTER ARCADE GAME -->
      <div class="devlab-view" id="devlabGameArena" role="tabpanel" aria-labelledby="tabGameBtn">
        <div class="arcade-container">
          <!-- Terminal Header & HUD -->
          <div class="arcade-hud">
            <div class="hud-left">
              <span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span>
              <span class="hud-title">BugHunter_IDE_v1.0.js</span>
            </div>
            <div class="hud-stats">
              <div class="hud-pill"><span class="hud-label">Score</span> <strong class="hud-val" id="gameScore">0</strong></div>
              <div class="hud-pill"><span class="hud-label">Combo</span> <strong class="hud-val" id="gameCombo">x1</strong></div>
              <div class="hud-pill"><span class="hud-label">Time</span> <strong class="hud-val" id="gameTime">25s</strong></div>
              <div class="hud-pill"><span class="hud-label">Best</span> <strong class="hud-val" id="gameHighScore">0</strong></div>
              <button type="button" class="hud-audio-btn" id="gameAudioToggle" aria-label="Toggle Sound Effects" title="Toggle audio">
                <svg id="audioIconOn" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>
                <svg id="audioIconOff" class="is-hidden" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><line x1="23" y1="9" x2="17" y2="15"/><line x1="17" y1="9" x2="23" y2="15"/></svg>
              </button>
            </div>
          </div>

          <!-- Progress Bar for Timer -->
          <div class="arcade-timer-bar" aria-hidden="true"><span id="timerProgress"></span></div>

          <!-- 3x3 Interactive IDE Code Matrix -->
          <div class="arcade-matrix-stage" id="arcadeStage">
            <div class="arcade-grid" id="arcadeGrid">
              <!-- 9 Cells representing code editor windows -->
              <div class="code-cell" data-cell="0"><span class="cell-line">01</span><code>fn.bootstrap()</code><div class="bug-target" aria-label="Squash bug"></div></div>
              <div class="code-cell" data-cell="1"><span class="cell-line">02</span><code>auth.guard()</code><div class="bug-target" aria-label="Squash bug"></div></div>
              <div class="code-cell" data-cell="2"><span class="cell-line">03</span><code>db.query()</code><div class="bug-target" aria-label="Squash bug"></div></div>
              <div class="code-cell" data-cell="3"><span class="cell-line">04</span><code>api.fetch()</code><div class="bug-target" aria-label="Squash bug"></div></div>
              <div class="code-cell" data-cell="4"><span class="cell-line">05</span><code>cache.set()</code><div class="bug-target" aria-label="Squash bug"></div></div>
              <div class="code-cell" data-cell="5"><span class="cell-line">06</span><code>render.view()</code><div class="bug-target" aria-label="Squash bug"></div></div>
              <div class="code-cell" data-cell="6"><span class="cell-line">07</span><code>route.dispatch()</code><div class="bug-target" aria-label="Squash bug"></div></div>
              <div class="code-cell" data-cell="7"><span class="cell-line">08</span><code>json.encode()</code><div class="bug-target" aria-label="Squash bug"></div></div>
              <div class="code-cell" data-cell="8"><span class="cell-line">09</span><code>return status;</code><div class="bug-target" aria-label="Squash bug"></div></div>
            </div>

            <!-- Start Game Overlay -->
            <div class="arcade-overlay" id="arcadeStartOverlay">
              <div class="overlay-card">
                <span class="overlay-icon">👾</span>
                <h3>Bug Hunter Arcade</h3>
                <p>Software bugs are corrupting the codebase! Click and squash as many bugs as you can in <strong>25 seconds</strong> to build combos and unlock your developer rank.</p>
                <button type="button" class="btn btn-primary start-game-btn" id="startGameBtn">
                  🚀 Start Debugging Sprint
                </button>
              </div>
            </div>

            <!-- Game Over Victory Overlay -->
            <div class="arcade-overlay is-hidden" id="arcadeGameOverOverlay">
              <div class="overlay-card">
                <span class="overlay-rank-emoji" id="gameOverEmoji">🏆</span>
                <p class="overlay-kicker">Debugging Sprint Finished</p>
                <h3 id="gameOverRankTitle">Senior Problem Solver</h3>
                <div class="game-results-grid">
                  <div><span class="res-label">Score</span><strong class="res-val" id="finalScoreVal">0</strong></div>
                  <div><span class="res-label">Squashed</span><strong class="res-val" id="finalSquashedVal">0 bugs</strong></div>
                  <div><span class="res-label">Max Combo</span><strong class="res-val" id="finalComboVal">x1</strong></div>
                </div>
                <button type="button" class="btn btn-primary start-game-btn" id="restartGameBtn">
                  🔄 Play Again
                </button>
              </div>
            </div>
          </div>
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

  <script src="{{ asset('script.js') }}"></script>
</body>
</html>
