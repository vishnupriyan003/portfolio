<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portfolio Settings</title>
  <style>
    * { box-sizing: border-box; }
    body { margin: 0; font-family: Arial, Helvetica, sans-serif; color: #102027; background: #eef5f3; line-height: 1.5; }
    header { position: sticky; top: 0; z-index: 5; display: flex; gap: 16px; align-items: center; justify-content: space-between; padding: 16px 24px; background: #fff; box-shadow: 0 10px 30px rgba(16, 32, 39, .08); }
    h1 { margin: 0; font-size: 26px; }
    main { width: min(1120px, calc(100% - 32px)); margin: 28px auto 60px; }
    form.settings { display: grid; gap: 20px; }
    .panel { padding: 24px; border-radius: 8px; background: #fff; box-shadow: 0 12px 34px rgba(16, 32, 39, .08); }
    .panel h2 { margin: 0 0 16px; font-size: 21px; }
    .metrics { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-bottom: 20px; }
    .metric { padding: 18px; border-radius: 8px; color: #fff; background: #102027; }
    .metric span { display: block; color: #dff4ee; font-size: 13px; font-weight: 800; text-transform: uppercase; }
    .metric strong { display: block; margin-top: 6px; font-size: 30px; line-height: 1; }
    .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
    label { display: block; margin-bottom: 8px; font-weight: 800; }
    input, textarea { width: 100%; min-height: 44px; padding: 10px 12px; border: 1px solid #ccd6d8; border-radius: 7px; font: inherit; }
    textarea { min-height: 120px; resize: vertical; }
    .help { margin: 6px 0 0; color: #5a6870; font-size: 13px; }
    .actions { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
    button, a.button { display: inline-flex; min-height: 44px; align-items: center; justify-content: center; padding: 0 16px; border-radius: 7px; font-weight: 800; text-decoration: none; cursor: pointer; }
    button.primary { border: 0; color: #fff; background: #1f8a70; }
    button.secondary, a.button { border: 1px solid #c8d7d3; color: #166555; background: #dff4ee; }
    .success { margin-bottom: 20px; padding: 14px 16px; border-radius: 7px; color: #14532d; background: #dcfce7; }
    .error { margin-bottom: 20px; padding: 14px 16px; border-radius: 7px; color: #7f1d1d; background: #fee2e2; }
    .message-list { display: grid; gap: 12px; }
    .message-card { padding: 16px; border: 1px solid #d7e2df; border-radius: 8px; background: #f8fbfa; }
    .message-card header { position: static; display: flex; padding: 0; box-shadow: none; background: transparent; }
    .message-card h3 { margin: 0; font-size: 17px; }
    .message-card small { color: #5a6870; }
    .message-card p { margin: 10px 0 0; color: #34454d; }
    .asset-preview { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; margin-top: 12px; }
    .asset-preview figure { margin: 0; overflow: hidden; border: 1px solid #d7e2df; border-radius: 8px; background: #f8fbfa; }
    .asset-preview img { width: 100%; aspect-ratio: 4 / 3; object-fit: cover; display: block; }
    .asset-preview figcaption { padding: 8px; color: #5a6870; font-size: 12px; word-break: break-word; }
    @media (max-width: 760px) { header, .grid, .metrics, .asset-preview { grid-template-columns: 1fr; } header { display: grid; } }
  </style>
</head>
<body>
  <header>
    <h1>Portfolio Settings</h1>
    <div class="actions">
      <a class="button" href="{{ route('portfolio') }}" target="_blank" rel="noopener">View Portfolio</a>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button class="secondary" type="submit">Logout</button>
      </form>
    </div>
  </header>

  <main>
    <section class="metrics">
      <div class="metric">
        <span>Portfolio Views</span>
        <strong>{{ number_format($views) }}</strong>
      </div>
      <div class="metric">
        <span>Total Messages</span>
        <strong>{{ number_format($totalMessages) }}</strong>
      </div>
      <div class="metric">
        <span>Unread Messages</span>
        <strong>{{ number_format($unreadMessages) }}</strong>
      </div>
    </section>

    @if (session('success'))
      <div class="success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form class="settings" method="POST" action="{{ route('admin.update') }}" enctype="multipart/form-data">
      @csrf

      <section class="panel">
        <h2>Hero & Contact</h2>
        <div class="grid">
          <div>
            <label for="name">Name</label>
            <input id="name" name="name" value="{{ old('name', $settings['name']) }}" required>
          </div>
          <div>
            <label for="role">Role</label>
            <input id="role" name="role" value="{{ old('role', $settings['role']) }}" required>
          </div>
          <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $settings['email']) }}" required>
          </div>
          <div>
            <label for="phone">Phone</label>
            <input id="phone" name="phone" value="{{ old('phone', $settings['phone']) }}" required>
          </div>
          <div>
            <label for="github">GitHub URL</label>
            <input id="github" name="github" type="url" value="{{ old('github', $settings['github']) }}" required>
          </div>
          <div>
            <label for="linkedin">LinkedIn URL</label>
            <input id="linkedin" name="linkedin" type="url" value="{{ old('linkedin', $settings['linkedin']) }}" required>
          </div>
          <div>
            <label for="location">Location</label>
            <input id="location" name="location" value="{{ old('location', $settings['location']) }}" required>
          </div>
          <div>
            <label for="relocation">Relocation Text</label>
            <input id="relocation" name="relocation" value="{{ old('relocation', $settings['relocation']) }}">
          </div>
        </div>
        <div style="margin-top: 16px;">
          <label for="hero_title">Hero Title</label>
          <input id="hero_title" name="hero_title" value="{{ old('hero_title', $settings['hero_title']) }}" required>
        </div>
        <div style="margin-top: 16px;">
          <label for="summary">Summary</label>
          <textarea id="summary" name="summary" required>{{ old('summary', $settings['summary']) }}</textarea>
        </div>
      </section>

      <section class="panel">
        <h2>Profile Content</h2>
        <label for="stats">Stats</label>
        <textarea id="stats" name="stats" required>{{ old('stats', $settings['stats']) }}</textarea>
        <p class="help">One per line: value|label</p>

        <label for="skills" style="margin-top: 16px;">Skills</label>
        <textarea id="skills" name="skills" required>{{ old('skills', $settings['skills']) }}</textarea>
        <p class="help">One per line: title|description|FontAwesome icon class</p>

        <label for="experience" style="margin-top: 16px;">Experience</label>
        <textarea id="experience" name="experience" required>{{ old('experience', $settings['experience']) }}</textarea>
        <p class="help">One per line: date/meta|job title|description</p>
      </section>

      <section class="panel">
        <h2>Project & Education</h2>
        <div>
          <label for="project_title">Project Title</label>
          <input id="project_title" name="project_title" value="{{ old('project_title', $settings['project_title']) }}" required>
        </div>
        <div style="margin-top: 16px;">
          <label for="project_description">Project Description</label>
          <textarea id="project_description" name="project_description" required>{{ old('project_description', $settings['project_description']) }}</textarea>
        </div>
        <div class="grid" style="margin-top: 16px;">
          <div>
            <label for="project_tags">Project Tags</label>
            <input id="project_tags" name="project_tags" value="{{ old('project_tags', $settings['project_tags']) }}" required>
            <p class="help">Comma separated: HTML, CSS, PHP</p>
          </div>
          <div>
            <label for="project_points">Project Points</label>
            <textarea id="project_points" name="project_points" required>{{ old('project_points', $settings['project_points']) }}</textarea>
            <p class="help">One point per line.</p>
          </div>
        </div>
        <label for="education" style="margin-top: 16px;">Education</label>
        <textarea id="education" name="education" required>{{ old('education', $settings['education']) }}</textarea>
        <p class="help">One per line: years|title|details</p>
      </section>

      <section class="panel">
        <h2>Certificates & Resume</h2>

        <label for="certificates">Certificates</label>
        <textarea id="certificates" name="certificates" required>{{ old('certificates', $settings['certificates']) }}</textarea>
        <p class="help">One per line: certificate title|image path. Example: HTML|image/html.png</p>

        <div class="asset-preview">
          @foreach (preg_split('/\r\n|\r|\n/', trim($settings['certificates'])) as $certificateLine)
            @php
              $certificateParts = array_map('trim', explode('|', $certificateLine, 2));
            @endphp
            @if (! empty($certificateParts[0]) && ! empty($certificateParts[1]))
              <figure>
                <img src="{{ asset($certificateParts[1]) }}" alt="{{ $certificateParts[0] }}">
                <figcaption>{{ $certificateParts[0] }}</figcaption>
              </figure>
            @endif
          @endforeach
        </div>

        <div class="grid" style="margin-top: 16px;">
          <div>
            <label for="new_certificate_title">Add Certificate Title</label>
            <input id="new_certificate_title" name="new_certificate_title" value="{{ old('new_certificate_title') }}">
          </div>
          <div>
            <label for="new_certificate_image">Add Certificate Image</label>
            <input id="new_certificate_image" name="new_certificate_image" type="file" accept="image/*">
          </div>
        </div>

        <div style="margin-top: 18px;">
          <label for="resume_pdf">Resume PDF Path</label>
          <input id="resume_pdf" name="resume_pdf" value="{{ old('resume_pdf', $settings['resume_pdf']) }}" required>
          <p class="help">Current PDF path used by the Resume buttons.</p>
        </div>

        <div style="margin-top: 16px;">
          <label for="resume_file">Upload New Resume PDF</label>
          <input id="resume_file" name="resume_file" type="file" accept="application/pdf">
          <p class="help">Uploading a PDF will replace the resume path automatically.</p>
        </div>

        <label for="resume_previews" style="margin-top: 16px;">Resume Preview Images</label>
        <textarea id="resume_previews" name="resume_previews" required>{{ old('resume_previews', $settings['resume_previews']) }}</textarea>
        <p class="help">One image path per line. Uploading new preview images below will replace this list.</p>

        <div class="asset-preview">
          @foreach (preg_split('/\r\n|\r|\n/', trim($settings['resume_previews'])) as $previewPath)
            @if (trim($previewPath) !== '')
              <figure>
                <img src="{{ asset(trim($previewPath)) }}" alt="Resume preview">
                <figcaption>{{ trim($previewPath) }}</figcaption>
              </figure>
            @endif
          @endforeach
        </div>

        <div style="margin-top: 16px;">
          <label for="resume_preview_files">Upload New Resume Preview Images</label>
          <input id="resume_preview_files" name="resume_preview_files[]" type="file" accept="image/*" multiple>
        </div>
      </section>

      <section class="panel">
        <h2>SEO Settings</h2>
        <div>
          <label for="seo_title">SEO Title</label>
          <input id="seo_title" name="seo_title" value="{{ old('seo_title', $settings['seo_title']) }}" required>
        </div>
        <div style="margin-top: 16px;">
          <label for="seo_description">SEO Description</label>
          <textarea id="seo_description" name="seo_description" required>{{ old('seo_description', $settings['seo_description']) }}</textarea>
        </div>
        <div style="margin-top: 16px;">
          <label for="seo_keywords">SEO Keywords</label>
          <textarea id="seo_keywords" name="seo_keywords" required>{{ old('seo_keywords', $settings['seo_keywords']) }}</textarea>
          <p class="help">Comma separated keywords for search engines.</p>
        </div>
        <div style="margin-top: 16px;">
          <label for="google_site_verification">Google Search Console Verification</label>
          <input id="google_site_verification" name="google_site_verification" value="{{ old('google_site_verification', $settings['google_site_verification']) }}" maxlength="255" placeholder="e.g. AbC123xyz...=">
          <p class="help">Paste the token from Google Search Console → Settings → Ownership verification. Leave blank if not set up yet.</p>
        </div>
        <div style="margin-top: 16px;">
          <label for="bing_site_verification">Bing Webmaster Verification</label>
          <input id="bing_site_verification" name="bing_site_verification" value="{{ old('bing_site_verification', $settings['bing_site_verification']) }}" maxlength="255" placeholder="msvalidate.01 token">
          <p class="help">Paste the content value from Bing Webmaster Tools. Leave blank if not set up yet.</p>
        </div>
      </section>

      <section class="panel">
        <h2>Admin Account</h2>
        <div class="grid">
          <div>
            <label for="admin_username">Admin Username</label>
            <input id="admin_username" name="admin_username" value="{{ old('admin_username', $settings['admin_username']) }}" required>
          </div>
          <div>
            <label for="admin_password">New Password</label>
            <input id="admin_password" name="admin_password" type="password" autocomplete="new-password">
            <p class="help">Leave blank to keep current password.</p>
          </div>
          <div>
            <label for="admin_password_confirmation">Confirm New Password</label>
            <input id="admin_password_confirmation" name="admin_password_confirmation" type="password" autocomplete="new-password">
          </div>
        </div>
      </section>

      <div class="actions">
        <button class="primary" type="submit">Save Settings</button>
        <a class="button" href="{{ route('portfolio') }}" target="_blank" rel="noopener">Preview</a>
      </div>
    </form>

    <section class="panel" style="margin-top: 20px;">
      <h2>Contact Form Messages</h2>
      <div class="message-list">
        @forelse ($messages as $message)
          <article class="message-card">
            <header>
              <div>
                <h3>{{ $message->subject ?: 'Portfolio enquiry' }}</h3>
                <small>{{ $message->name }} | {{ $message->email }} | {{ $message->created_at->format('d M Y, h:i A') }}</small>
              </div>
            </header>
            <p>{{ $message->message }}</p>
          </article>
        @empty
          <p class="help">No contact messages yet.</p>
        @endforelse
      </div>
    </section>
  </main>
</body>
</html>
