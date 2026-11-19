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
  ".content-band, .split-section, .education-section, .certificates-section, .details-section, .resume-section, .contact-form-section, .game-panel, .info-card, .timeline-item, .project-points span, .project-list article, .education-grid article, .certificate-card, .certificate-note, .details-grid article, .resume-preview-images img"
);

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

  document.querySelectorAll("a, button, input, textarea, .certificate-card").forEach((item) => {
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
