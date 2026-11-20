const nav = document.getElementById("primaryNav");
const menuToggle = document.querySelector(".menu-toggle");
const navLinks = document.querySelectorAll(".nav-link");
const sections = document.querySelectorAll(".section[id], footer[id]");
const lightbox = document.getElementById("certificateLightbox");
const lightboxImage = lightbox.querySelector("img");
const lightboxTitle = lightbox.querySelector("p");
const lightboxClose = lightbox.querySelector(".lightbox-close");
const preloader = document.getElementById("preloader");
const cursorDot = document.querySelector(".cursor-dot");
const cursorRing = document.querySelector(".cursor-ring");
const animatedItems = document.querySelectorAll(
  ".content-band, .split-section, .education-section, .certificates-section, .details-section, .resume-section, .contact-form-section, .info-card, .timeline-item, .project-points span, .project-list article, .education-grid article, .certificate-card, .certificate-note, .details-grid article, .resume-preview-images img"
);

// Initialize Multi-Design Theme Engine
if (typeof ThemeManager !== "undefined") {
  ThemeManager.init();
}

document.body.classList.add("is-loaded");

function hidePreloader() {
  if (!preloader) {
    return;
  }

  preloader.classList.add("is-hidden");
}

window.addEventListener("load", hidePreloader);
setTimeout(hidePreloader, 1600);

const canAnimateCursor = window.matchMedia("(pointer: fine)").matches
  && !window.matchMedia("(prefers-reduced-motion: reduce)").matches;

if (canAnimateCursor && cursorDot && cursorRing) {
  document.body.classList.add("has-custom-cursor");
  let ringX = 0;
  let ringY = 0;
  let dotX = 0;
  let dotY = 0;
  let trailTick = 0;

  function drawCursor() {
    ringX += (dotX - ringX) * 0.18;
    ringY += (dotY - ringY) * 0.18;
    cursorDot.style.transform = `translate(${dotX}px, ${dotY}px) translate(-50%, -50%)`;
    cursorRing.style.transform = `translate(${ringX}px, ${ringY}px) translate(-50%, -50%)`;
    requestAnimationFrame(drawCursor);
  }

  window.addEventListener("mousemove", (event) => {
    dotX = event.clientX;
    dotY = event.clientY;
    trailTick += 1;

    if (trailTick % 4 === 0) {
      const trail = document.createElement("span");
      trail.className = "cursor-trail";
      trail.style.left = `${event.clientX}px`;
      trail.style.top = `${event.clientY}px`;
      document.body.appendChild(trail);
      setTimeout(() => trail.remove(), 600);
    }
  });

  document.querySelectorAll("a, button, input, textarea, .certificate-card, .theme-preview-card, .theme-settings-btn, .theme-drawer-close, .theme-mode-btn, .theme-reset-btn").forEach((item) => {
    item.addEventListener("mouseenter", () => cursorRing.classList.add("is-active"));
    item.addEventListener("mouseleave", () => cursorRing.classList.remove("is-active"));
  });

  drawCursor();
}

function setMenuState(isOpen) {
  nav.classList.toggle("is-open", isOpen);
  document.body.classList.toggle("menu-open", isOpen);
  menuToggle.setAttribute("aria-expanded", String(isOpen));
  menuToggle.setAttribute("aria-label", isOpen ? "Close navigation" : "Open navigation");
}

menuToggle.addEventListener("click", () => {
  setMenuState(!nav.classList.contains("is-open"));
});

navLinks.forEach((link) => {
  link.addEventListener("click", () => {
    setMenuState(false);
  });
});

const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) {
        return;
      }

      navLinks.forEach((link) => {
        const isActive = link.getAttribute("href") === `#${entry.target.id}`;
        link.classList.toggle("active", isActive);

        if (isActive) {
          link.setAttribute("aria-current", "location");
        } else {
          link.removeAttribute("aria-current");
        }
      });
    });
  },
  {
    rootMargin: "-35% 0px -55% 0px",
    threshold: 0,
  }
);

sections.forEach((section) => observer.observe(section));

animatedItems.forEach((item) => item.classList.add("reveal"));

const revealObserver = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("is-visible");
        revealObserver.unobserve(entry.target);
      }
    });
  },
  {
    rootMargin: "0px 0px -12% 0px",
    threshold: 0.12,
  }
);

animatedItems.forEach((item) => revealObserver.observe(item));

document.querySelectorAll(".certificate-card").forEach((card) => {
  card.addEventListener("click", () => {
    lightboxImage.src = card.dataset.full;
    lightboxImage.alt = card.dataset.title;
    lightboxTitle.textContent = card.dataset.title;
    lightbox.classList.add("is-open");
    lightbox.setAttribute("aria-hidden", "false");
  });
});

function closeLightbox() {
  lightbox.classList.remove("is-open");
  lightbox.setAttribute("aria-hidden", "true");
  lightboxImage.src = "";
}

lightboxClose.addEventListener("click", closeLightbox);

lightbox.addEventListener("click", (event) => {
  if (event.target === lightbox) {
    closeLightbox();
  }
});

document.addEventListener("keydown", (event) => {
  if (event.key === "Escape") {
    setMenuState(false);
    closeLightbox();
  }
});

// Scroll progress bar + condensed header (Phase 3) — rAF-throttled
const progressBar = document.querySelector(".scroll-progress span");
const siteHeader = document.querySelector(".site-header");
let scrollTicking = false;

function paintScrollState() {
  const doc = document.documentElement;
  const scrollable = doc.scrollHeight - doc.clientHeight;
  const percent = scrollable > 0 ? Math.min(100, (doc.scrollTop / scrollable) * 100) : 0;

  if (progressBar) {
    progressBar.style.width = `${percent}%`;
  }

  if (siteHeader) {
    siteHeader.classList.toggle("is-scrolled", window.scrollY > 24);
  }

  scrollTicking = false;
}

window.addEventListener(
  "scroll",
  () => {
    if (!scrollTicking) {
      scrollTicking = true;
      requestAnimationFrame(paintScrollState);
    }
  },
  { passive: true }
);

paintScrollState();

// ── Phase 4: cinematic hero ────────────────────────────────────────
const prefersReducedMotion = window.matchMedia(
  "(prefers-reduced-motion: reduce)"
);

// Rotating designation — phrases arrive from the server (existing content only)
const rotator = document.querySelector(".designation-rotator");
if (rotator && !prefersReducedMotion.matches) {
  let phrases;
  try {
    phrases = JSON.parse(rotator.dataset.designations || "[]");
  } catch {
    phrases = [];
  }

  if (Array.isArray(phrases) && phrases.length > 1) {
    let phraseIndex = 0;
    setInterval(() => {
      rotator.classList.add("is-changing");
      setTimeout(() => {
        phraseIndex = (phraseIndex + 1) % phrases.length;
        rotator.textContent = phrases[phraseIndex];
        rotator.classList.remove("is-changing");
      }, 300);
    }, 3400);
  }
}

// Scroll cue — hide once the visitor leaves the hero
const scrollCue = document.querySelector(".scroll-cue");
if (scrollCue) {
  window.addEventListener(
    "scroll",
    () => {
      scrollCue.classList.toggle("is-hidden", window.scrollY > 120);
    },
    { passive: true }
  );
}

// Ambient hero particles — decorative, skipped for reduced motion
const particleHost = document.querySelector(".hero-particles");
if (particleHost && !prefersReducedMotion.matches) {
  const PARTICLE_COUNT = 16;
  const frag = document.createDocumentFragment();

  for (let i = 0; i < PARTICLE_COUNT; i += 1) {
    const dot = document.createElement("span");
    dot.className = "particle" + (i % 2 ? " is-sage" : "");
    dot.style.left = `${Math.random() * 100}%`;
    dot.style.setProperty("--drift", `${(Math.random() - 0.5) * 80}px`);
    dot.style.animationDuration = `${9 + Math.random() * 9}s`;
    dot.style.animationDelay = `${-Math.random() * 16}s`;
    dot.style.width = dot.style.height = `${2 + Math.random() * 3}px`;
    frag.appendChild(dot);
  }

  particleHost.appendChild(frag);
}

// Reduced motion: stop the hero video (the static poster still shows)
const heroVideo = document.getElementById("myVideo");

// Mobile (Phase 7): abort the video download entirely — CSS hides it and
// the poster still layer serves as the background instead.
const skipVideoForViewport = heroVideo !== null
  && window.matchMedia("(max-width: 760px)").matches;

if (skipVideoForViewport) {
  heroVideo.pause();
  heroVideo.removeAttribute("autoplay");
  heroVideo.querySelectorAll("source").forEach((source) => source.remove());
  heroVideo.load(); // cancels any in-flight request
}

function applyMotionPreference(event) {
  if (!heroVideo || skipVideoForViewport) return;

  const currentTheme = typeof ThemeManager !== "undefined" ? ThemeManager.getCurrentTheme() : "nature";
  if (currentTheme !== "nature") {
    heroVideo.pause();
    return;
  }

  if (event.matches) {
    heroVideo.pause();
    heroVideo.removeAttribute("autoplay");
  } else {
    heroVideo.setAttribute("autoplay", "");
    heroVideo.play().catch(() => {
      /* autoplay blocked — poster fallback remains visible */
    });
  }
}

applyMotionPreference(prefersReducedMotion);
prefersReducedMotion.addEventListener("change", applyMotionPreference);
