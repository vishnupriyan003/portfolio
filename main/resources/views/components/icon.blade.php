{{--
  Inline SVG icon set — replaces the Font Awesome CDN entirely (Phase 3).
  Usage: <x-icon name="check" />            (decorative, aria-hidden)
         <x-icon name="github" label="GitHub" />  (meaningful, role=img)
  Legacy Font Awesome names (fa-code, fa-server, fa-database, fa-tools) are
  accepted too: the fa- prefix is stripped, so DB-stored icon keys keep working.
  License: these paths were authored for this project (MIT for this codebase).
--}}
@props(['name', 'label' => null])

@php
    $name = strtolower(trim((string) $name));
    $name = preg_replace('/^fa[srlb]?-?/', '', $name) ?: 'code';
    $known = ['code', 'server', 'database', 'tools', 'laptop', 'download', 'trending',
              'check', 'award', 'pdf', 'send', 'envelope', 'phone', 'github', 'linkedin'];
    if (!in_array($name, $known, true)) {
        $name = 'code';
    }
    $isBrand = in_array($name, ['github', 'linkedin'], true);
    $fill = $isBrand ? 'currentColor' : 'none';
    $stroke = $isBrand ? 'none' : 'currentColor';
@endphp

<svg class="icon icon-{{ $name }}" viewBox="0 0 24 24" width="24" height="24"
     fill="{{ $fill }}" stroke="{{ $stroke }}" stroke-width="1.8"
     stroke-linecap="round" stroke-linejoin="round" focusable="false"
     @if ($label) role="img" aria-label="{{ $label }}" @else aria-hidden="true" @endif>
    @switch($name)
        @case('code')
            <polyline points="8.5 6 3.5 12 8.5 18"></polyline>
            <polyline points="15.5 6 20.5 12 15.5 18"></polyline>
            <line x1="13.4" y1="4.4" x2="10.6" y2="19.6"></line>
            @break
        @case('server')
            <rect x="3.5" y="4" width="17" height="6.6" rx="2"></rect>
            <rect x="3.5" y="13.4" width="17" height="6.6" rx="2"></rect>
            <line x1="7.2" y1="7.3" x2="7.25" y2="7.3"></line>
            <line x1="7.2" y1="16.7" x2="7.25" y2="16.7"></line>
            @break
        @case('database')
            <ellipse cx="12" cy="5.8" rx="7.8" ry="3.1"></ellipse>
            <path d="M4.2 5.8v6.1c0 1.71 3.49 3.1 7.8 3.1s7.8-1.39 7.8-3.1V5.8"></path>
            <path d="M4.2 11.9v6.1c0 1.71 3.49 3.1 7.8 3.1s7.8-1.39 7.8-3.1v-6.1"></path>
            @break
        @case('tools')
            <line x1="3.5" y1="7.5" x2="20.5" y2="7.5"></line>
            <line x1="3.5" y1="16.5" x2="20.5" y2="16.5"></line>
            <circle cx="9" cy="7.5" r="2.3"></circle>
            <circle cx="15.5" cy="16.5" r="2.3"></circle>
            @break
        @case('laptop')
            <rect x="4" y="4.8" width="16" height="10.8" rx="1.8"></rect>
            <line x1="2.2" y1="19.4" x2="21.8" y2="19.4"></line>
            @break
        @case('download')
            <line x1="12" y1="3.8" x2="12" y2="14.8"></line>
            <polyline points="7.6 10.6 12 15 16.4 10.6"></polyline>
            <path d="M5 19.4h14"></path>
            @break
        @case('trending')
            <polyline points="3.2 16.8 9.2 10.8 13 14.6 20.8 6.6"></polyline>
            <polyline points="15.6 6.6 20.8 6.6 20.8 11.6"></polyline>
            @break
        @case('check')
            <polyline points="4.6 12.6 9.6 17.6 19.4 6.6"></polyline>
            @break
        @case('award')
            <circle cx="12" cy="9" r="5.4"></circle>
            <path d="M8.6 13.4 7.2 20.8 12 18.2 16.8 20.8 15.4 13.4"></path>
            @break
        @case('pdf')
            <path d="M14 3.4H7.4a2 2 0 0 0-2 2v13.2a2 2 0 0 0 2 2h9.2a2 2 0 0 0 2-2V7.8z"></path>
            <polyline points="14 3.4 14 7.8 18.4 7.8"></polyline>
            <line x1="8.6" y1="13.2" x2="15.2" y2="13.2"></line>
            <line x1="8.6" y1="16.6" x2="13.2" y2="16.6"></line>
            @break
        @case('send')
            <path d="M21.4 2.6 10.8 13.2"></path>
            <path d="M21.4 2.6 14.8 21.4 10.8 13.2 2.6 9.2z"></path>
            @break
        @case('envelope')
            <rect x="3" y="5" width="18" height="14" rx="2"></rect>
            <path d="m3.6 6.6 8.4 6.3 8.4-6.3"></path>
            @break
        @case('phone')
            <path d="M20.9 16.9v2.5a1.6 1.6 0 0 1-1.74 1.6 15.5 15.5 0 0 1-6.79-2.41 15.3 15.3 0 0 1-4.72-4.72A15.5 15.5 0 0 1 5.24 7.06 1.6 1.6 0 0 1 6.83 5.32h2.5a1.6 1.6 0 0 1 1.6 1.37c.1.76.28 1.5.54 2.21a1.6 1.6 0 0 1-.36 1.67l-1.06 1.06a12.7 12.7 0 0 0 4.68 4.68l1.06-1.06a1.6 1.6 0 0 1 1.67-.36c.71.26 1.45.44 2.21.54a1.6 1.6 0 0 1 1.37 1.61z"></path>
            @break
        @case('github')
            <path d="M12 .5C5.73.5.98 5.24.98 11.52c0 4.86 3.15 8.98 7.52 10.44.55.1.75-.24.75-.53v-1.86c-3.06.67-3.7-1.48-3.7-1.48-.5-1.27-1.22-1.61-1.22-1.61-1-.68.08-.67.08-.67 1.1.08 1.68 1.13 1.68 1.13.98 1.68 2.57 1.2 3.2.92.1-.71.38-1.2.7-1.48-2.44-.28-5.01-1.22-5.01-5.44 0-1.2.43-2.18 1.13-2.95-.11-.28-.49-1.4.11-2.92 0 0 .92-.3 3.02 1.13a10.5 10.5 0 0 1 5.5 0c2.1-1.43 3.02-1.13 3.02-1.13.6 1.52.22 2.64.11 2.92.7.77 1.13 1.75 1.13 2.95 0 4.23-2.58 5.16-5.03 5.43.4.34.75 1 .75 2.02v3c0 .29.2.64.76.53 4.36-1.46 7.51-5.58 7.51-10.44C23.02 5.24 18.27.5 12 .5z"></path>
            @break
        @case('linkedin')
            <path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9h3.9v12H3zM9.1 9h3.74v1.64h.05c.52-.95 1.79-1.96 3.68-1.96 3.93 0 4.66 2.53 4.66 5.83V21h-3.9v-5.75c0-1.37-.03-3.14-1.94-3.14-1.95 0-2.24 1.5-2.24 3.04V21H9.1z"></path>
            @break
    @endswitch
</svg>
