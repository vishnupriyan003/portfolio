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

// ── 3D Character Playground (Three.js WebGL Engine) ─────────────────────
(() => {
  const section = document.getElementById("playground");
  const canvas = document.getElementById("playgroundCanvas");
  const wrapper = document.getElementById("canvasWrapper");
  const loadingEl = document.getElementById("playgroundLoading");
  const loadingText = document.getElementById("loadingHeroText");
  const statusText = document.getElementById("heroStatusText");
  const chipButtons = document.querySelectorAll(".hero-chip");
  const actionButtons = document.querySelectorAll(".action-btn");
  const specialBtn = document.getElementById("specialActionBtn");
  const actionPills = document.getElementById("actionPills");
  const hintText = document.querySelector(".playground-hint span");

  if (!section || !canvas || !wrapper || typeof window.THREE === "undefined") {
    return;
  }

  // ── Hero definitions & configurations ──
  const HERO_CONFIG = {
    robot: {
      name: "Robot",
      url: "assets/models/robot.glb",
      scale: 0.38,
      yOffset: -1.05,
      cameraDist: 3.8,
      specialLabel: "⚡ Dance",
      actions: {
        idle: ["Idle", "Standing"],
        walk: ["Walking"],
        run: ["Running"],
        action: ["Dance", "Jump"]
      }
    },
    soldier: {
      name: "Soldier",
      url: "assets/models/soldier.glb",
      scale: 1.3,
      yOffset: -1.3,
      cameraDist: 3.5,
      specialLabel: "⚡ Action",
      actions: {
        idle: ["Idle"],
        walk: ["Walk"],
        run: ["Run"],
        action: ["TPose", "Run"]
      }
    },
    xbot: {
      name: "Xbot",
      url: "assets/models/xbot.glb",
      scale: 1.3,
      yOffset: -1.3,
      cameraDist: 3.5,
      specialLabel: "⚡ Agree",
      actions: {
        idle: ["idle"],
        walk: ["walk"],
        run: ["run"],
        action: ["agree", "headShake"]
      }
    },
    fox: {
      name: "Fox",
      url: "assets/models/fox.glb",
      scale: 0.019,
      yOffset: -0.9,
      cameraDist: 3.2,
      specialLabel: "⚡ Prowl",
      actions: {
        idle: ["Survey"],
        walk: ["Walk"],
        run: ["Run"],
        action: ["Run", "Survey"]
      }
    },
    flamingo: {
      name: "Flamingo",
      url: "assets/models/flamingo.glb",
      scale: 0.02,
      yOffset: 0.2,
      cameraDist: 3.8,
      isLoopOnly: true,
      statusLabel: "Flying Loop",
      actions: {}
    }
  };

  // ── Three.js Scene Variables ──
  let scene, camera, renderer, clock, mixer;
  let currentModel = null;
  let activeHeroKey = "robot";
  let activeActionType = "idle";
  let currentAnimationAction = null;
  let animationActions = {};
  let modelAnimations = [];
  let isInitialized = false;
  let isVisible = false;
  let rafId = null;

  // ── Orbit Camera & Interaction State ──
  let isDragging = false;
  let pointerStartX = 0;
  let pointerStartY = 0;
  let targetTheta = 0;
  let targetPhi = Math.PI / 2.3;
  let currentTheta = 0;
  let currentPhi = Math.PI / 2.3;
  let targetRadius = 3.8;
  let currentRadius = 3.8;
  let lastUserInteraction = Date.now();
  const raycaster = new THREE.Raycaster();
  const mouseVec = new THREE.Vector2();

  function initScene() {
    clock = new THREE.Clock();
    scene = new THREE.Scene();

    const width = wrapper.clientWidth || 800;
    const height = wrapper.clientHeight || 540;

    camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 100);
    updateCameraPosition();

    renderer = new THREE.WebGLRenderer({
      canvas: canvas,
      antialias: true,
      alpha: true,
      powerPreference: "high-performance"
    });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
    renderer.setSize(width, height);
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    if (renderer.outputEncoding) {
      renderer.outputEncoding = THREE.sRGBEncoding;
    }

    // ── Lighting ──
    const hemiLight = new THREE.HemisphereLight(0xffffff, 0xe2dac9, 1.0);
    hemiLight.position.set(0, 20, 0);
    scene.add(hemiLight);

    const dirLight = new THREE.DirectionalLight(0xfff5e6, 1.25);
    dirLight.position.set(4, 8, 5);
    dirLight.castShadow = true;
    dirLight.shadow.mapSize.width = 1024;
    dirLight.shadow.mapSize.height = 1024;
    dirLight.shadow.camera.near = 0.5;
    dirLight.shadow.camera.far = 25;
    dirLight.shadow.camera.left = -3;
    dirLight.shadow.camera.right = 3;
    dirLight.shadow.camera.top = 3;
    dirLight.shadow.camera.bottom = -3;
    dirLight.shadow.bias = -0.001;
    scene.add(dirLight);

    const fillLight = new THREE.DirectionalLight(0xcde6ff, 0.45);
    fillLight.position.set(-4, 3, -3);
    scene.add(fillLight);

    // ── Soft Contact Shadow Floor Plane ──
    const floorGeo = new THREE.PlaneGeometry(16, 16);
    const floorMat = new THREE.ShadowMaterial({ opacity: 0.16 });
    const floor = new THREE.Mesh(floorGeo, floorMat);
    floor.rotation.x = -Math.PI / 2;
    floor.position.y = -1.1;
    floor.receiveShadow = true;
    scene.add(floor);

    attachEvents();
    loadHero("robot");
  }

  function updateCameraPosition() {
    currentTheta += (targetTheta - currentTheta) * 0.08;
    currentPhi += (targetPhi - currentPhi) * 0.08;
    currentRadius += (targetRadius - currentRadius) * 0.08;

    // Constrain phi so camera cannot flip upside down
    currentPhi = Math.max(0.15, Math.min(Math.PI / 2 - 0.05, currentPhi));

    camera.position.x = currentRadius * Math.sin(currentPhi) * Math.sin(currentTheta);
    camera.position.y = currentRadius * Math.cos(currentPhi);
    camera.position.z = currentRadius * Math.sin(currentPhi) * Math.cos(currentTheta);
    camera.lookAt(0, 0, 0);
  }

  // ── Model Loader ──
  const modelCache = {};
  const loader = new THREE.GLTFLoader();

  function loadHero(heroKey) {
    const config = HERO_CONFIG[heroKey];
    if (!config) return;

    activeHeroKey = heroKey;
    showLoading(`Loading ${config.name}...`);

    // Update hero chips UI
    chipButtons.forEach((btn) => {
      const isActive = btn.dataset.hero === heroKey;
      btn.classList.toggle("is-active", isActive);
      btn.setAttribute("aria-pressed", String(isActive));
    });

    // Update Special Action button label & Action pills visibility
    if (specialBtn && config.specialLabel) {
      specialBtn.querySelector("span").textContent = config.specialLabel;
    }
    if (actionPills) {
      actionPills.style.display = config.isLoopOnly ? "none" : "";
    }
    if (hintText) {
      hintText.textContent = config.isLoopOnly
        ? "Drag to orbit · Scroll to zoom · Continuous flying loop"
        : "Drag to orbit · Scroll to zoom · Click character for action move";
    }

    targetRadius = config.cameraDist;

    if (modelCache[heroKey]) {
      setupModel(modelCache[heroKey], config);
      hideLoading();
      return;
    }

    loader.load(
      config.url,
      (gltf) => {
        modelCache[heroKey] = gltf;
        setupModel(gltf, config);
        hideLoading();
      },
      undefined,
      (err) => {
        console.warn("Failed to load 3D hero:", heroKey, err);
        hideLoading();
      }
    );
  }

  function setupModel(gltf, config) {
    if (currentModel) {
      scene.remove(currentModel);
    }
    if (mixer) {
      mixer.stopAllAction();
    }

    // Clone scene for multiple usages if cached
    const root = gltf.scene || gltf.scenes[0];
    currentModel = root;
    currentModel.scale.setScalar(config.scale);
    currentModel.position.set(0, config.yOffset, 0);

    currentModel.traverse((child) => {
      if (child.isMesh) {
        child.castShadow = true;
        child.receiveShadow = true;
      }
    });

    scene.add(currentModel);

    // Setup Animation Mixer
    modelAnimations = gltf.animations || [];
    mixer = new THREE.AnimationMixer(currentModel);
    animationActions = {};

    modelAnimations.forEach((clip) => {
      animationActions[clip.name] = mixer.clipAction(clip);
    });

    // Play loop for loop-only models (e.g. Flamingo flying loop) or reset to Idle
    if (config.isLoopOnly) {
      if (modelAnimations.length > 0) {
        const loopAction = mixer.clipAction(modelAnimations[0]);
        loopAction.play();
        currentAnimationAction = loopAction;
      }
      if (statusText) {
        statusText.textContent = config.statusLabel || "Flying Loop";
      }
    } else {
      setActiveAction("idle");
    }
  }

  function findClipForAction(actionType) {
    const config = HERO_CONFIG[activeHeroKey];
    if (!config || !modelAnimations.length) return null;

    const candidates = config.actions[actionType] || [];

    // If candidate is a number index (like Flamingo)
    if (typeof candidates[0] === "number" && modelAnimations[candidates[0]]) {
      return modelAnimations[candidates[0]];
    }

    for (const name of candidates) {
      const found = modelAnimations.find(
        (clip) => clip.name.toLowerCase() === String(name).toLowerCase()
      );
      if (found) return found;
    }

    // Fallback: first available animation clip
    return modelAnimations[0] || null;
  }

  function setActiveAction(actionType) {
    activeActionType = actionType;

    // Update HUD Action Buttons UI
    actionButtons.forEach((btn) => {
      const isMatch = btn.dataset.action === actionType;
      btn.classList.toggle("is-active", isMatch);
    });

    // Update Status Badge Text
    if (statusText) {
      const labels = {
        idle: "Idle",
        walk: "Walking",
        run: "Running",
        action: HERO_CONFIG[activeHeroKey]?.specialLabel || "Action"
      };
      statusText.textContent = labels[actionType] || "Active";
    }

    if (!mixer) return;

    const clip = findClipForAction(actionType);
    if (!clip) return;

    const newAction = mixer.clipAction(clip);

    if (currentAnimationAction && currentAnimationAction !== newAction) {
      currentAnimationAction.fadeOut(0.28);
    }

    newAction.reset().fadeIn(0.28).play();
    currentAnimationAction = newAction;
  }

  function showLoading(msg) {
    if (loadingText) loadingText.textContent = msg;
    if (loadingEl) loadingEl.classList.remove("is-hidden");
  }

  function hideLoading() {
    if (loadingEl) loadingEl.classList.add("is-hidden");
  }

  // ── Animation Loop ──
  function tick() {
    if (!isVisible) {
      rafId = null;
      return;
    }

    const delta = clock.getDelta();

    // Inactivity Auto-spin (after 4s)
    if (Date.now() - lastUserInteraction > 4000 && !isDragging) {
      targetTheta += 0.005;
    }

    updateCameraPosition();

    if (mixer) {
      mixer.update(delta);
    }

    renderer.render(scene, camera);
    rafId = requestAnimationFrame(tick);
  }

  function startLoop() {
    if (!rafId && isVisible) {
      clock.start();
      rafId = requestAnimationFrame(tick);
    }
  }

  function stopLoop() {
    if (rafId) {
      cancelAnimationFrame(rafId);
      rafId = null;
    }
  }

  // ── Pointer & Orbit Drag Events ──
  function attachEvents() {
    // Hero chip switching
    chipButtons.forEach((btn) => {
      btn.addEventListener("click", () => {
        const heroKey = btn.dataset.hero;
        if (heroKey && heroKey !== activeHeroKey) {
          loadHero(heroKey);
          lastUserInteraction = Date.now();
        }
      });
    });

    // Action pill switching
    actionButtons.forEach((btn) => {
      btn.addEventListener("click", () => {
        const action = btn.dataset.action;
        if (action) {
          setActiveAction(action);
          lastUserInteraction = Date.now();
        }
      });
    });

    // Mouse Drag on canvas
    wrapper.addEventListener("mousedown", (e) => {
      isDragging = true;
      pointerStartX = e.clientX;
      pointerStartY = e.clientY;
      lastUserInteraction = Date.now();
    });

    window.addEventListener("mousemove", (e) => {
      if (!isDragging) return;
      const dx = e.clientX - pointerStartX;
      const dy = e.clientY - pointerStartY;
      pointerStartX = e.clientX;
      pointerStartY = e.clientY;

      targetTheta -= dx * 0.008;
      targetPhi -= dy * 0.008;
      lastUserInteraction = Date.now();
    });

    window.addEventListener("mouseup", (e) => {
      if (isDragging) {
        isDragging = false;
        lastUserInteraction = Date.now();
      }
    });

    // Click on character to trigger action animation
    wrapper.addEventListener("click", (e) => {
      if (!currentModel || !camera) return;

      const rect = canvas.getBoundingClientRect();
      mouseVec.x = ((e.clientX - rect.left) / rect.width) * 2 - 1;
      mouseVec.y = -((e.clientY - rect.top) / rect.height) * 2 + 1;

      raycaster.setFromCamera(mouseVec, camera);
      const intersects = raycaster.intersectObjects(currentModel.children, true);

      if (intersects.length > 0) {
        if (HERO_CONFIG[activeHeroKey]?.isLoopOnly) return;
        // Toggle action on click
        const nextAction = activeActionType === "action" ? "idle" : "action";
        setActiveAction(nextAction);
        lastUserInteraction = Date.now();
      }
    });

    // Touch Drag on mobile
    wrapper.addEventListener("touchstart", (e) => {
      if (e.touches.length === 1) {
        isDragging = true;
        pointerStartX = e.touches[0].clientX;
        pointerStartY = e.touches[0].clientY;
        lastUserInteraction = Date.now();
      }
    }, { passive: true });

    window.addEventListener("touchmove", (e) => {
      if (!isDragging || e.touches.length !== 1) return;
      const dx = e.touches[0].clientX - pointerStartX;
      const dy = e.touches[0].clientY - pointerStartY;
      pointerStartX = e.touches[0].clientX;
      pointerStartY = e.touches[0].clientY;

      targetTheta -= dx * 0.01;
      targetPhi -= dy * 0.01;
      lastUserInteraction = Date.now();
    }, { passive: true });

    window.addEventListener("touchend", () => {
      isDragging = false;
      lastUserInteraction = Date.now();
    });

    // Zoom on wheel
    wrapper.addEventListener("wheel", (e) => {
      e.preventDefault();
      targetRadius = Math.max(2.0, Math.min(6.0, targetRadius + e.deltaY * 0.003));
      lastUserInteraction = Date.now();
    }, { passive: false });

    // Window Resize
    let resizeTimer = null;
    window.addEventListener("resize", () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        if (!renderer || !camera || !wrapper) return;
        const width = wrapper.clientWidth;
        const height = wrapper.clientHeight;
        camera.aspect = width / height;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height);
      }, 150);
    });
  }

  // ── IntersectionObserver: Lazy load and pause when offscreen ──
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        isVisible = entry.isIntersecting;
        if (isVisible) {
          if (!isInitialized) {
            isInitialized = true;
            initScene();
          }
          startLoop();
        } else {
          stopLoop();
        }
      });
    },
    { rootMargin: "150px" }
  );

  observer.observe(section);
})();

// ── Career Focus Drawer Toggle ─────────────────────────────────────────
(() => {
  const drawerToggle = document.getElementById("drawerToggle");
  const careerDrawer = document.getElementById("careerDrawer");

  if (!drawerToggle || !careerDrawer) {
    return;
  }

  drawerToggle.addEventListener("click", () => {
    const isExpanded = drawerToggle.getAttribute("aria-expanded") === "true";
    const nextState = !isExpanded;

    drawerToggle.setAttribute("aria-expanded", String(nextState));
    careerDrawer.setAttribute("aria-hidden", String(!nextState));

    const toggleText = drawerToggle.querySelector(".toggle-text");
    if (toggleText) {
      toggleText.textContent = nextState ? "Show Less" : "Dive Deeper";
    }
  });
})();
