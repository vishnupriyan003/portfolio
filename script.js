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
  ".content-band, .split-section, .education-section, .certificates-section, .details-section, .resume-section, .contact-form-section, .info-card, .timeline-item, .education-grid article, .certificate-card, .certificate-note, .details-grid article, .resume-preview-images img"
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

  document.querySelectorAll("a, button, input, textarea, .certificate-card").forEach((item) => {
    item.addEventListener("mouseenter", () => cursorRing.classList.add("is-active"));
    item.addEventListener("mouseleave", () => cursorRing.classList.remove("is-active"));
  });

  drawCursor();
}

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
    closeLightbox();
  }
});

// Scroll progress bar (Phase 3) — rAF-throttled
const progressBar = document.querySelector(".scroll-progress span");
let scrollTicking = false;

function paintScrollState() {
  const doc = document.documentElement;
  const scrollable = doc.scrollHeight - doc.clientHeight;
  const percent = scrollable > 0 ? Math.min(100, (doc.scrollTop / scrollable) * 100) : 0;

  if (progressBar) {
    progressBar.style.width = `${percent}%`;
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

// Reduced motion: the rotator and reveals are gated above; nothing else to
// animate — the light editorial hero has no video or particles anymore.

// ── Dev Lab: tabs, filters, snippet copy + Bug Hunter arcade ────────────
(() => {
  const devlab = document.getElementById("devlab");
  if (!devlab) {
    return;
  }

  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)")
    .matches;

  /* ── Mode tabs (Pro Tricks ⇄ Bug Hunter Arcade) ─────────────────── */
  const tabButtons = devlab.querySelectorAll(".devlab-tab-btn");

  tabButtons.forEach((button) => {
    button.addEventListener("click", () => {
      tabButtons.forEach((other) => {
        const isActive = other === button;
        other.classList.toggle("is-active", isActive);
        other.setAttribute("aria-selected", String(isActive));

        const panel = document.getElementById(other.getAttribute("aria-controls"));
        if (panel) {
          panel.classList.toggle("is-active", isActive);
        }
      });
    });
  });

  /* ── Category filters ───────────────────────────────────────────── */
  const filterPills = devlab.querySelectorAll(".filter-pill");
  const tipCards = devlab.querySelectorAll(".tip-card");

  filterPills.forEach((pill) => {
    pill.addEventListener("click", () => {
      const filter = pill.dataset.filter;

      filterPills.forEach((item) => item.classList.toggle("is-active", item === pill));
      tipCards.forEach((card) => {
        const visible = filter === "all" || card.dataset.category === filter;
        card.classList.toggle("is-filtered-out", !visible);
      });
    });
  });

  /* ── Snippet copy buttons ───────────────────────────────────────── */
  async function copyText(text) {
    if (navigator.clipboard && window.isSecureContext) {
      await navigator.clipboard.writeText(text);
      return;
    }

    const helper = document.createElement("textarea");
    helper.value = text;
    helper.setAttribute("readonly", "");
    helper.style.position = "fixed";
    helper.style.opacity = "0";
    document.body.appendChild(helper);
    helper.select();
    document.execCommand("copy");
    helper.remove();
  }

  devlab.querySelectorAll(".copy-snippet-btn").forEach((button) => {
    button.addEventListener("click", async () => {
      const card = button.closest(".tip-card");
      const code = card ? card.querySelector("pre code") : null;
      const label = button.querySelector(".copy-label");

      if (!code) {
        return;
      }

      try {
        await copyText(code.innerText);

        if (label) {
          label.textContent = "Copied!";
        }
        button.classList.add("is-copied");

        window.setTimeout(() => {
          if (label) {
            label.textContent = "Copy";
          }
          button.classList.remove("is-copied");
        }, 1500);
      } catch (error) {
        if (label) {
          label.textContent = "Retry";
        }
      }
    });
  });

  /* ── Bug Hunter arcade ──────────────────────────────────────────── */
  const grid = document.getElementById("arcadeGrid");
  const startOverlay = document.getElementById("arcadeStartOverlay");
  const gameOverOverlay = document.getElementById("arcadeGameOverOverlay");
  const startButton = document.getElementById("startGameBtn");
  const restartButton = document.getElementById("restartGameBtn");

  if (!grid || !startOverlay || !gameOverOverlay || !startButton || !restartButton) {
    return;
  }

  const cells = Array.from(grid.querySelectorAll(".code-cell"));
  const scoreEl = document.getElementById("gameScore");
  const comboEl = document.getElementById("gameCombo");
  const timeEl = document.getElementById("gameTime");
  const bestEl = document.getElementById("gameHighScore");
  const timerBar = document.getElementById("timerProgress");
  const audioToggle = document.getElementById("gameAudioToggle");
  const audioIconOn = document.getElementById("audioIconOn");
  const audioIconOff = document.getElementById("audioIconOff");

  const BEST_KEY = "bugHunterBest";
  const MUTE_KEY = "bugHunterMuted";
  const ROUND_MS = 25000;
  const MAX_COMBO = 5;
  const HIT_POINTS = 10;

  let score = 0;
  let combo = 1;
  let maxCombo = 1;
  let squashed = 0;
  let best = 0;
  let muted = false;
  let running = false;
  let startedAt = 0;
  let remaining = ROUND_MS;
  let rafId = 0;
  let spawnTimer = 0;
  let bugTimer = 0;
  let roundTimer = 0;
  let activeBug = null;
  let audioContext = null;

  function readStore(key, fallback) {
    try {
      const value = window.localStorage.getItem(key);
      return value === null ? fallback : value;
    } catch (error) {
      return fallback;
    }
  }

  function writeStore(key, value) {
    try {
      window.localStorage.setItem(key, value);
    } catch (error) {
      /* storage unavailable — session-only state is fine */
    }
  }

  best = parseInt(readStore(BEST_KEY, "0"), 10) || 0;
  muted = readStore(MUTE_KEY, "0") === "1";

  function syncAudioUI() {
    if (audioIconOn) audioIconOn.classList.toggle("is-hidden", muted);
    if (audioIconOff) audioIconOff.classList.toggle("is-hidden", !muted);
  }

  syncAudioUI();
  render();

  function beep(frequency, duration, type = "square") {
    if (muted) {
      return;
    }

    try {
      const AudioCtor = window.AudioContext || window.webkitAudioContext;
      if (!AudioCtor) return;

      audioContext = audioContext || new AudioCtor();
      if (audioContext.state === "suspended") {
        audioContext.resume();
      }

      const oscillator = audioContext.createOscillator();
      const gain = audioContext.createGain();
      const now = audioContext.currentTime;

      oscillator.type = type;
      oscillator.frequency.setValueAtTime(frequency, now);
      gain.gain.setValueAtTime(0.05, now);
      gain.gain.exponentialRampToValueAtTime(0.0001, now + duration);

      oscillator.connect(gain);
      gain.connect(audioContext.destination);
      oscillator.start(now);
      oscillator.stop(now + duration);
    } catch (error) {
      /* audio is a nicety — never break the game for it */
    }
  }

  if (audioToggle) {
    audioToggle.addEventListener("click", () => {
      muted = !muted;
      writeStore(MUTE_KEY, muted ? "1" : "0");
      syncAudioUI();
      beep(660, 0.07, "sine");
    });
  }

  function render() {
    if (scoreEl) scoreEl.textContent = String(score);
    if (comboEl) comboEl.textContent = `x${combo}`;
    if (timeEl) timeEl.textContent = `${Math.ceil(remaining / 1000)}s`;
    if (bestEl) bestEl.textContent = String(best);
    if (timerBar) timerBar.style.width = `${(remaining / ROUND_MS) * 100}%`;
  }

  function clearBugs() {
    window.clearTimeout(bugTimer);
    window.clearTimeout(spawnTimer);
    bugTimer = 0;
    spawnTimer = 0;

    if (activeBug) {
      const cell = activeBug.closest(".code-cell");
      activeBug.remove();
      activeBug = null;
      if (cell) cell.classList.remove("is-live");
    }

    grid.querySelectorAll(".bug").forEach((bug) => bug.remove());
    grid.querySelectorAll(".code-cell.is-live").forEach((cell) => cell.classList.remove("is-live"));
    grid.querySelectorAll(".score-floater").forEach((floater) => floater.remove());
  }

  function nextSpawnDelay() {
    const elapsed = ROUND_MS - remaining;
    return Math.max(320, 760 - elapsed / 45) + Math.random() * 220;
  }

  function scheduleSpawn(delay) {
    window.clearTimeout(spawnTimer);
    spawnTimer = window.setTimeout(() => {
      spawnBug();
      if (running) {
        scheduleSpawn(nextSpawnDelay());
      }
    }, delay);
  }

  function spawnBug() {
    if (!running || activeBug) {
      return;
    }

    const freeCells = cells.filter((cell) => !cell.classList.contains("is-live"));
    if (!freeCells.length) {
      return;
    }

    const cell = freeCells[Math.floor(Math.random() * freeCells.length)];
    const target = cell.querySelector(".bug-target");
    if (!target) {
      return;
    }

    const bug = document.createElement("button");
    bug.type = "button";
    bug.className = "bug";
    bug.textContent = "🐞";
    bug.setAttribute("aria-label", "Squash bug");

    if (document.body.classList.contains("has-custom-cursor")) {
      const ring = document.querySelector(".cursor-ring");
      if (ring) {
        bug.addEventListener("mouseenter", () => ring.classList.add("is-active"));
        bug.addEventListener("mouseleave", () => ring.classList.remove("is-active"));
      }
    }

    target.appendChild(bug);
    cell.classList.add("is-live");
    activeBug = bug;

    const life = reduceMotion ? 1600 : Math.max(760, 1250 - (ROUND_MS - remaining) / 45);
    bugTimer = window.setTimeout(() => missBug(), life);

    bug.addEventListener("click", (event) => {
      event.stopPropagation();
      squashBug(bug, cell);
    });
  }

  function removeBug(bug, cell) {
    window.clearTimeout(bugTimer);
    bugTimer = 0;

    if (bug) bug.remove();
    if (cell) cell.classList.remove("is-live");

    if (activeBug === bug) {
      activeBug = null;
    }
  }

  function addFloater(cell, text) {
    const floater = document.createElement("span");
    floater.className = "score-floater";
    floater.textContent = text;
    cell.appendChild(floater);
    window.setTimeout(() => floater.remove(), 700);
  }

  function squashBug(bug, cell) {
    if (!running || activeBug !== bug) {
      return;
    }

    const gained = HIT_POINTS * combo;
    score += gained;
    squashed += 1;
    combo = Math.min(MAX_COMBO, combo + 1);
    maxCombo = Math.max(maxCombo, combo);

    removeBug(bug, cell);
    addFloater(cell, `+${gained}`);
    beep(760 + combo * 90, 0.07);
    render();
  }

  function missBug() {
    if (!running) {
      return;
    }

    if (combo > 1) {
      combo = 1;
      beep(220, 0.12, "sawtooth");
    }

    removeBug(activeBug, activeBug ? activeBug.closest(".code-cell") : null);
    render();
  }

  // Clicking empty code (not a bug) breaks the combo — rewards clean aim.
  grid.addEventListener("click", (event) => {
    if (!running || event.target.closest(".bug")) {
      return;
    }

    if (combo > 1) {
      combo = 1;
      beep(220, 0.1, "sawtooth");
      render();
    }
  });

  function rankFor(value) {
    if (value >= 320) return { title: "Principal Bug Slayer", emoji: "👑" };
    if (value >= 180) return { title: "Senior Problem Solver", emoji: "🏆" };
    if (value >= 90) return { title: "Mid-Level Debugger", emoji: "🐞" };
    return { title: "Junior Intern", emoji: "🐣" };
  }

  function tick(now) {
    if (!running) {
      return;
    }

    remaining = Math.max(0, ROUND_MS - (now - startedAt));

    if (remaining <= 0) {
      endGame();
      return;
    }

    render();
    rafId = window.requestAnimationFrame(tick);
  }

  function startGame() {
    score = 0;
    combo = 1;
    maxCombo = 1;
    squashed = 0;
    remaining = ROUND_MS;
    running = false;

    window.clearTimeout(roundTimer);
    roundTimer = 0;

    if (timerBar) {
      timerBar.classList.add("is-resetting");
    }

    clearBugs();
    render();

    if (timerBar) {
      window.setTimeout(() => timerBar && timerBar.classList.remove("is-resetting"), 420);
    }

    startOverlay.classList.add("is-hidden");
    gameOverOverlay.classList.add("is-hidden");

    // Let the timer bar refill before the sprint clock starts.
    roundTimer = window.setTimeout(() => {
      roundTimer = 0;
      running = true;
      startedAt = window.performance.now();
      rafId = window.requestAnimationFrame(tick);
      scheduleSpawn(420);
      beep(520, 0.08, "sine");
    }, 380);
  }

  function endGame() {
    if (!running) {
      return;
    }

    running = false;
    remaining = 0;

    window.cancelAnimationFrame(rafId);
    window.clearTimeout(roundTimer);
    clearBugs();

    if (timerBar) {
      timerBar.classList.add("is-resetting");
    }

    render();

    if (timerBar) {
      window.setTimeout(() => timerBar && timerBar.classList.remove("is-resetting"), 420);
    }

    if (score > best) {
      best = score;
      writeStore(BEST_KEY, String(best));
      if (bestEl) bestEl.textContent = String(best);
    }

    const rank = rankFor(score);
    const title = document.getElementById("gameOverRankTitle");
    const emoji = document.getElementById("gameOverEmoji");
    const finalScore = document.getElementById("finalScoreVal");
    const finalSquashed = document.getElementById("finalSquashedVal");
    const finalCombo = document.getElementById("finalComboVal");

    if (title) title.textContent = rank.title;
    if (emoji) emoji.textContent = rank.emoji;
    if (finalScore) finalScore.textContent = String(score);
    if (finalSquashed) finalSquashed.textContent = `${squashed} bugs`;
    if (finalCombo) finalCombo.textContent = `x${maxCombo}`;

    gameOverOverlay.classList.remove("is-hidden");
    beep(392, 0.12, "sine");
    window.setTimeout(() => beep(523, 0.12, "sine"), 140);
    window.setTimeout(() => beep(659, 0.18, "sine"), 280);
  }

  startButton.addEventListener("click", startGame);
  restartButton.addEventListener("click", startGame);

  // Leaving the tab mid-round ends the sprint (no silent timers in background).
  document.addEventListener("visibilitychange", () => {
    if (!document.hidden) {
      return;
    }

    if (running) {
      endGame();
      return;
    }

    if (roundTimer) {
      window.clearTimeout(roundTimer);
      roundTimer = 0;
      startOverlay.classList.remove("is-hidden");
    }
  });
})();
