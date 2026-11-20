/**
 * Multi-Design Theme Customization Engine - Theme Registry & Config
 * Defines metadata, colors, taglines, and inline SVG preview illustrations for 7 design systems.
 */
const THEME_CONFIG = {
  defaultTheme: "nature",
  defaultMode: "default",

  themes: [
    {
      id: "nature",
      name: "Nature Cinematic",
      tagline: "Editorial & Organic",
      description: "Forest green and warm cream palette, editorial serif typography, cinematic video overlays, and organic surfaces.",
      hasLightDark: false,
      colors: ["#142b23", "#203c30", "#f3f0e5", "#c5a66a"],
      svgIcon: `<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>`,
      previewSvg: `<svg viewBox="0 0 120 72" width="100%" height="72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="120" height="72" rx="6" fill="#142b23"/>
        <rect x="8" y="10" width="104" height="24" rx="4" fill="#203c30" fill-opacity="0.8"/>
        <rect x="14" y="16" width="40" height="4" rx="2" fill="#f3f0e5"/>
        <rect x="14" y="24" width="24" height="3" rx="1.5" fill="#91a891"/>
        <circle cx="98" cy="22" r="5" fill="#c5a66a"/>
        <rect x="8" y="40" width="50" height="24" rx="4" fill="#f3f0e5" fill-opacity="0.95"/>
        <rect x="64" y="40" width="48" height="24" rx="4" fill="#f3f0e5" fill-opacity="0.95"/>
        <rect x="14" y="46" width="30" height="3" rx="1.5" fill="#101e19"/>
        <rect x="14" y="53" width="38" height="4" rx="2" fill="#8a6a4c"/>
        <rect x="70" y="46" width="28" height="3" rx="1.5" fill="#101e19"/>
        <rect x="70" y="53" width="36" height="4" rx="2" fill="#8a6a4c"/>
      </svg>`
    },
    {
      id: "flat",
      name: "Flat Design",
      tagline: "Minimal & Crisp",
      description: "Zero shadows, zero gradients, vibrant solid planes, crisp solid lines, and clean geometric layouts.",
      hasLightDark: true,
      colors: ["#ffffff", "#2563eb", "#0f172a", "#f97316"],
      svgIcon: `<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="0"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>`,
      previewSvg: `<svg viewBox="0 0 120 72" width="100%" height="72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="120" height="72" rx="0" fill="#f8fafc"/>
        <rect x="8" y="8" width="104" height="22" fill="#2563eb"/>
        <rect x="14" y="15" width="46" height="4" fill="#ffffff"/>
        <rect x="14" y="22" width="28" height="2" fill="#93c5fd"/>
        <rect x="8" y="36" width="48" height="28" fill="#ffffff" stroke="#e2e8f0" stroke-width="1.5"/>
        <rect x="14" y="42" width="32" height="4" fill="#0f172a"/>
        <rect x="14" y="50" width="36" height="8" fill="#f97316"/>
        <rect x="62" y="36" width="50" height="28" fill="#ffffff" stroke="#e2e8f0" stroke-width="1.5"/>
        <rect x="68" y="42" width="32" height="4" fill="#0f172a"/>
        <rect x="68" y="50" width="38" height="8" fill="#2563eb"/>
      </svg>`
    },
    {
      id: "neumorphism",
      name: "Neumorphism",
      tagline: "Soft UI & Tactile",
      description: "Subtle extruded and inset dual-directional soft shadows, monochromatic background blending, and soft rounded pills.",
      hasLightDark: true,
      colors: ["#e0e5ec", "#b8b9be", "#ffffff", "#4d658d"],
      svgIcon: `<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4"/></svg>`,
      previewSvg: `<svg viewBox="0 0 120 72" width="100%" height="72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <filter id="nmExtrude" x="-20%" y="-20%" width="140%" height="140%">
            <feDropShadow dx="-3" dy="-3" stdDeviation="2.5" flood-color="#ffffff" flood-opacity="0.9"/>
            <feDropShadow dx="3" dy="3" stdDeviation="2.5" flood-color="#b0b5be" flood-opacity="0.6"/>
          </filter>
        </defs>
        <rect width="120" height="72" rx="8" fill="#e0e5ec"/>
        <rect x="10" y="10" width="100" height="22" rx="8" fill="#e0e5ec" filter="url(#nmExtrude)"/>
        <rect x="18" y="16" width="38" height="4" rx="2" fill="#384358"/>
        <rect x="18" y="23" width="24" height="3" rx="1.5" fill="#718096"/>
        <circle cx="94" cy="21" r="5" fill="#4d658d"/>
        <rect x="10" y="38" width="46" height="26" rx="8" fill="#e0e5ec" filter="url(#nmExtrude)"/>
        <rect x="16" y="44" width="26" height="4" rx="2" fill="#384358"/>
        <rect x="16" y="52" width="34" height="6" rx="3" fill="#4d658d"/>
        <rect x="64" y="38" width="46" height="26" rx="8" fill="#e0e5ec" filter="url(#nmExtrude)"/>
        <rect x="70" y="44" width="26" height="4" rx="2" fill="#384358"/>
        <rect x="70" y="52" width="34" height="6" rx="3" fill="#384358"/>
      </svg>`
    },
    {
      id: "glassmorphism",
      name: "Glassmorphism",
      tagline: "Translucent & Vivid",
      description: "Multi-layered frosted glass panels, rich backdrop blur, luminous border lines, and vivid aurora mesh gradients.",
      hasLightDark: true,
      colors: ["#090d16", "#6366f1", "#06b6d4", "rgba(255,255,255,0.18)"],
      svgIcon: `<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v18H3z"/><path d="M3 14l8-8"/><path d="M13 21l8-8"/></svg>`,
      previewSvg: `<svg viewBox="0 0 120 72" width="100%" height="72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <radialGradient id="glsMesh1" cx="20%" cy="30%" r="60%">
            <stop offset="0%" stop-color="#6366f1"/>
            <stop offset="100%" stop-color="#090d16"/>
          </radialGradient>
          <radialGradient id="glsMesh2" cx="80%" cy="80%" r="50%">
            <stop offset="0%" stop-color="#06b6d4"/>
            <stop offset="100%" stop-color="#090d16" stop-opacity="0"/>
          </radialGradient>
        </defs>
        <rect width="120" height="72" rx="8" fill="url(#glsMesh1)"/>
        <rect width="120" height="72" rx="8" fill="url(#glsMesh2)" style="mix-blend-mode: screen;"/>
        <rect x="8" y="10" width="104" height="22" rx="6" fill="#ffffff" fill-opacity="0.12" stroke="#ffffff" stroke-opacity="0.35" stroke-width="1"/>
        <rect x="14" y="16" width="44" height="4" rx="2" fill="#ffffff"/>
        <rect x="14" y="23" width="26" height="3" rx="1.5" fill="#a5f3fc"/>
        <rect x="8" y="38" width="48" height="26" rx="6" fill="#ffffff" fill-opacity="0.14" stroke="#ffffff" stroke-opacity="0.3" stroke-width="1"/>
        <rect x="14" y="44" width="28" height="4" rx="2" fill="#ffffff"/>
        <rect x="14" y="52" width="36" height="6" rx="3" fill="#38bdf8" fill-opacity="0.8"/>
        <rect x="62" y="38" width="50" height="26" rx="6" fill="#ffffff" fill-opacity="0.14" stroke="#ffffff" stroke-opacity="0.3" stroke-width="1"/>
        <rect x="68" y="44" width="28" height="4" rx="2" fill="#ffffff"/>
        <rect x="68" y="52" width="38" height="6" rx="3" fill="#818cf8" fill-opacity="0.8"/>
      </svg>`
    },
    {
      id: "skeuomorphism",
      name: "Skeuomorphism",
      tagline: "Physical & Tactile",
      description: "Warm parchment surfaces, stitched borders, realistic beveled 3D buttons, letterpress text, and physical depth.",
      hasLightDark: false,
      colors: ["#f5f0eb", "#4a2e18", "#c49a45", "#22170f"],
      svgIcon: `<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10"/><path d="M6 10h10"/></svg>`,
      previewSvg: `<svg viewBox="0 0 120 72" width="100%" height="72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <linearGradient id="skBtn" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0%" stop-color="#b8834c"/>
            <stop offset="50%" stop-color="#8a5a2a"/>
            <stop offset="100%" stop-color="#5c3814"/>
          </linearGradient>
          <filter id="skShadow">
            <feDropShadow dx="0" dy="2" stdDeviation="1.5" flood-color="#000000" flood-opacity="0.25"/>
          </filter>
        </defs>
        <rect width="120" height="72" rx="6" fill="#f4ece1"/>
        <rect x="6" y="6" width="108" height="60" rx="4" fill="none" stroke="#d5c5ae" stroke-width="1.5" stroke-dasharray="3 2"/>
        <rect x="10" y="10" width="100" height="22" rx="4" fill="#fffcf7" filter="url(#skShadow)"/>
        <rect x="16" y="16" width="38" height="4" rx="1" fill="#3b2413"/>
        <rect x="16" y="23" width="22" height="3" rx="1" fill="#7a634e"/>
        <rect x="10" y="38" width="46" height="24" rx="4" fill="#fffcf7" filter="url(#skShadow)"/>
        <rect x="16" y="44" width="26" height="3" rx="1" fill="#3b2413"/>
        <rect x="16" y="50" width="34" height="7" rx="3" fill="url(#skBtn)"/>
        <rect x="64" y="38" width="46" height="24" rx="4" fill="#fffcf7" filter="url(#skShadow)"/>
        <rect x="70" y="44" width="26" height="3" rx="1" fill="#3b2413"/>
        <rect x="70" y="50" width="34" height="7" rx="3" fill="url(#skBtn)"/>
      </svg>`
    },
    {
      id: "brutalism",
      name: "Brutalism",
      tagline: "Bold & High-Voltage",
      description: "Thick 3.5px solid black borders, hard offset 5px black drop shadows, high-voltage pop colors, and punchy typography.",
      hasLightDark: false,
      colors: ["#ffffff", "#000000", "#ffea00", "#ff3366"],
      svgIcon: `<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m2 4 3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14"/></svg>`,
      previewSvg: `<svg viewBox="0 0 120 72" width="100%" height="72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="120" height="72" rx="0" fill="#fff9d6"/>
        <rect x="12" y="12" width="98" height="20" rx="0" fill="#000000"/>
        <rect x="8" y="8" width="98" height="20" rx="0" fill="#ffea00" stroke="#000000" stroke-width="2.5"/>
        <rect x="14" y="14" width="46" height="5" fill="#000000"/>
        <rect x="14" y="21" width="24" height="3" fill="#000000"/>
        <rect x="11" y="39" width="46" height="24" rx="0" fill="#000000"/>
        <rect x="8" y="36" width="46" height="24" rx="0" fill="#ffffff" stroke="#000000" stroke-width="2.5"/>
        <rect x="13" y="41" width="28" height="4" fill="#000000"/>
        <rect x="13" y="48" width="36" height="7" fill="#ff3366" stroke="#000000" stroke-width="1.5"/>
        <rect x="67" y="39" width="46" height="24" rx="0" fill="#000000"/>
        <rect x="64" y="36" width="46" height="24" rx="0" fill="#ffffff" stroke="#000000" stroke-width="2.5"/>
        <rect x="69" y="41" width="28" height="4" fill="#000000"/>
        <rect x="69" y="48" width="36" height="7" fill="#00f0ff" stroke="#000000" stroke-width="1.5"/>
      </svg>`
    },
    {
      id: "material",
      name: "Material Design",
      tagline: "Elevation & Motion",
      description: "Material 3 elevation surfaces, rounded card containers, crisp typography, and responsive interaction states.",
      hasLightDark: true,
      colors: ["#fdfbff", "#4f46e5", "#e0e7ff", "#1b1b1f"],
      svgIcon: `<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 2 7l10 5 10-5-10-5Z"/><path d="m2 17 10 5 10-5"/><path d="m2 12 10 5 10-5"/></svg>`,
      previewSvg: `<svg viewBox="0 0 120 72" width="100%" height="72" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <filter id="matElev" x="-10%" y="-10%" width="120%" height="120%">
            <feDropShadow dx="0" dy="2" stdDeviation="2" flood-color="#000000" flood-opacity="0.12"/>
          </filter>
        </defs>
        <rect width="120" height="72" rx="8" fill="#fdfbff"/>
        <rect x="8" y="8" width="104" height="22" rx="6" fill="#e0e7ff" filter="url(#matElev)"/>
        <rect x="14" y="14" width="42" height="4" rx="2" fill="#312e81"/>
        <rect x="14" y="21" width="26" height="3" rx="1.5" fill="#4338ca"/>
        <circle cx="98" cy="19" r="6" fill="#4f46e5"/>
        <rect x="8" y="36" width="48" height="26" rx="6" fill="#ffffff" filter="url(#matElev)"/>
        <rect x="14" y="42" width="26" height="3" rx="1.5" fill="#1e1b4b"/>
        <rect x="14" y="49" width="36" height="7" rx="3.5" fill="#4f46e5"/>
        <rect x="62" y="36" width="50" height="26" rx="6" fill="#ffffff" filter="url(#matElev)"/>
        <rect x="68" y="42" width="26" height="3" rx="1.5" fill="#1e1b4b"/>
        <rect x="68" y="49" width="38" height="7" rx="3.5" fill="#e0e7ff"/>
      </svg>`
    }
  ]
};

if (typeof module !== "undefined" && module.exports) {
  module.exports = THEME_CONFIG;
}
