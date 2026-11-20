/**
 * Multi-Design Theme Customization Engine - Core Theme Manager
 * Orchestrates theme application, DOM synchronization, drawer controls, and media handling.
 */
const ThemeManager = (function () {
  let currentTheme = "nature";
  let currentMode = "default";
  let isDrawerOpen = false;

  // DOM Elements
  let drawerEl = null;
  let overlayEl = null;
  let triggerBtn = null;
  let cardsContainerEl = null;
  let variantToggleEl = null;
  let lightModeBtn = null;
  let darkModeBtn = null;
  let defaultModeBtn = null;
  let resetBtn = null;
  let videoEl = null;
  let heroStillEl = null;

  function init() {
    // 1. Resolve DOM Elements
    drawerEl = document.getElementById("themeCustomizationDrawer");
    overlayEl = document.getElementById("themeDrawerBackdrop");
    triggerBtn = document.querySelector(".theme-settings-btn");
    cardsContainerEl = document.getElementById("themeCardsContainer");
    variantToggleEl = document.getElementById("themeVariantSection");
    lightModeBtn = document.querySelector('[data-mode-btn="light"]');
    darkModeBtn = document.querySelector('[data-mode-btn="dark"]');
    defaultModeBtn = document.querySelector('[data-mode-btn="default"]');
    resetBtn = document.getElementById("themeResetBtn");
    videoEl = document.getElementById("myVideo");
    heroStillEl = document.querySelector(".hero-still");

    // 2. Load stored preferences or fallback
    currentTheme = ThemeStorage.getStoredTheme(THEME_CONFIG.defaultTheme);
    currentMode = ThemeStorage.getStoredMode(THEME_CONFIG.defaultMode);

    // 3. Render theme cards into drawer
    renderThemeCards();

    // 4. Bind event listeners
    bindEvents();

    // 5. Apply active theme state to DOM
    applyTheme(currentTheme, currentMode, false);
  }

  function renderThemeCards() {
    if (!cardsContainerEl || !THEME_CONFIG || !THEME_CONFIG.themes) return;

    cardsContainerEl.innerHTML = THEME_CONFIG.themes
      .map((theme) => {
        const isActive = theme.id === currentTheme;
        const colorDots = theme.colors
          .map(
            (c) =>
              `<span class="theme-color-dot" style="background-color: ${c}" title="${c}"></span>`
          )
          .join("");

        return `
        <article class="theme-preview-card ${isActive ? "is-active" : ""}" data-theme-id="${theme.id}" tabindex="0" role="button" aria-pressed="${isActive}" aria-label="Select ${theme.name} theme">
          <div class="theme-card-preview-box">
            ${theme.previewSvg}
          </div>
          <div class="theme-card-body">
            <div class="theme-card-header">
              <div class="theme-title-wrap">
                <span class="theme-icon-badge">${theme.svgIcon}</span>
                <div>
                  <h3 class="theme-name">${theme.name}</h3>
                  <span class="theme-tagline">${theme.tagline}</span>
                </div>
              </div>
              <span class="theme-badge ${isActive ? "badge-active" : "badge-select"}">
                ${isActive ? "Active" : "Select"}
              </span>
            </div>
            <p class="theme-description">${theme.description}</p>
            <div class="theme-card-footer">
              <div class="theme-swatches" aria-label="Theme color palette">
                ${colorDots}
              </div>
              <div class="theme-sample-pill">Sample</div>
            </div>
          </div>
        </article>`;
      })
      .join("");
  }

  function applyTheme(themeId, mode = "default", persist = true) {
    const matched = THEME_CONFIG.themes.find((t) => t.id === themeId);
    if (!matched) {
      themeId = THEME_CONFIG.defaultTheme;
    }

    currentTheme = themeId;
    currentMode = mode;

    // Set root attribute
    document.documentElement.setAttribute("data-theme", themeId);
    if (mode && mode !== "default") {
      document.documentElement.setAttribute("data-theme-mode", mode);
    } else {
      document.documentElement.removeAttribute("data-theme-mode");
    }

    // Media sync: hero video should only play in Nature Cinematic
    syncMedia(themeId);

    // Save preferences
    if (persist) {
      ThemeStorage.setStoredTheme(themeId);
      ThemeStorage.setStoredMode(mode);
    }

    // Update UI states
    updateDrawerUI();

    // Dispatch event
    window.dispatchEvent(
      new CustomEvent("themechange", {
        detail: { theme: themeId, mode: mode },
      })
    );
  }

  function syncMedia(themeId) {
    if (!videoEl) return;

    const prefersReducedMotion = window.matchMedia(
      "(prefers-reduced-motion: reduce)"
    ).matches;

    if (themeId === "nature") {
      if (heroStillEl) heroStillEl.style.display = "";
      videoEl.style.display = "";
      if (!prefersReducedMotion) {
        const playPromise = videoEl.play();
        if (playPromise !== undefined) {
          playPromise.catch(() => {});
        }
      }
    } else {
      videoEl.pause();
    }
  }

  function updateDrawerUI() {
    // 1. Update card active classes & ARIA
    if (cardsContainerEl) {
      const cards = cardsContainerEl.querySelectorAll(".theme-preview-card");
      cards.forEach((card) => {
        const tid = card.getAttribute("data-theme-id");
        const isActive = tid === currentTheme;
        card.classList.toggle("is-active", isActive);
        card.setAttribute("aria-pressed", String(isActive));
        const badge = card.querySelector(".theme-badge");
        if (badge) {
          badge.className = `theme-badge ${isActive ? "badge-active" : "badge-select"}`;
          badge.textContent = isActive ? "Active" : "Select";
        }
      });
    }

    // 2. Update variant toggle section visibility & active button
    const currentThemeObj = THEME_CONFIG.themes.find((t) => t.id === currentTheme);
    if (variantToggleEl) {
      if (currentThemeObj && currentThemeObj.hasLightDark) {
        variantToggleEl.classList.remove("is-hidden");
      } else {
        variantToggleEl.classList.add("is-hidden");
      }
    }

    // Update variant mode button states
    [
      { btn: defaultModeBtn, val: "default" },
      { btn: lightModeBtn, val: "light" },
      { btn: darkModeBtn, val: "dark" },
    ].forEach(({ btn, val }) => {
      if (btn) {
        const isSel = (currentMode || "default") === val;
        btn.classList.toggle("is-active", isSel);
        btn.setAttribute("aria-pressed", String(isSel));
      }
    });

    // 3. Update trigger button tooltip/state
    if (triggerBtn) {
      triggerBtn.setAttribute("aria-expanded", String(isDrawerOpen));
    }
  }

  function openDrawer() {
    if (!drawerEl) return;
    isDrawerOpen = true;
    drawerEl.classList.add("is-open");
    drawerEl.setAttribute("aria-hidden", "false");
    if (overlayEl) overlayEl.classList.add("is-open");
    document.body.classList.add("theme-drawer-open");
    if (triggerBtn) triggerBtn.setAttribute("aria-expanded", "true");

    // Focus the first focusable element inside drawer
    const closeBtn = drawerEl.querySelector(".theme-drawer-close");
    if (closeBtn) closeBtn.focus();
  }

  function closeDrawer() {
    if (!drawerEl) return;
    isDrawerOpen = false;
    drawerEl.classList.remove("is-open");
    drawerEl.setAttribute("aria-hidden", "true");
    if (overlayEl) overlayEl.classList.remove("is-open");
    document.body.classList.remove("theme-drawer-open");
    if (triggerBtn) {
      triggerBtn.setAttribute("aria-expanded", "false");
      triggerBtn.focus();
    }
  }

  function toggleDrawer() {
    if (isDrawerOpen) {
      closeDrawer();
    } else {
      openDrawer();
    }
  }

  function resetToDefault() {
    ThemeStorage.clearSettings();
    applyTheme(THEME_CONFIG.defaultTheme, THEME_CONFIG.defaultMode, true);
  }

  function bindEvents() {
    // Trigger button
    if (triggerBtn) {
      triggerBtn.addEventListener("click", toggleDrawer);
    }

    // Backdrop click
    if (overlayEl) {
      overlayEl.addEventListener("click", closeDrawer);
    }

    // Close button
    const closeBtn = drawerEl ? drawerEl.querySelector(".theme-drawer-close") : null;
    if (closeBtn) {
      closeBtn.addEventListener("click", closeDrawer);
    }

    // Reset button
    if (resetBtn) {
      resetBtn.addEventListener("click", resetToDefault);
    }

    // Card selection (click + enter/space key)
    if (cardsContainerEl) {
      cardsContainerEl.addEventListener("click", (e) => {
        const card = e.target.closest(".theme-preview-card");
        if (!card) return;
        const themeId = card.getAttribute("data-theme-id");
        if (themeId) {
          applyTheme(themeId, currentMode, true);
        }
      });

      cardsContainerEl.addEventListener("keydown", (e) => {
        if (e.key === "Enter" || e.key === " ") {
          const card = e.target.closest(".theme-preview-card");
          if (card) {
            e.preventDefault();
            const themeId = card.getAttribute("data-theme-id");
            if (themeId) {
              applyTheme(themeId, currentMode, true);
            }
          }
        }
      });
    }

    // Variant Mode buttons
    [
      { btn: defaultModeBtn, mode: "default" },
      { btn: lightModeBtn, mode: "light" },
      { btn: darkModeBtn, mode: "dark" },
    ].forEach(({ btn, mode }) => {
      if (btn) {
        btn.addEventListener("click", () => {
          applyTheme(currentTheme, mode, true);
        });
      }
    });

    // Keyboard navigation: Escape key closes drawer
    window.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && isDrawerOpen) {
        closeDrawer();
      }
    });
  }

  return {
    init,
    applyTheme,
    openDrawer,
    closeDrawer,
    toggleDrawer,
    resetToDefault,
    getCurrentTheme: () => currentTheme,
    getCurrentMode: () => currentMode,
  };
})();

if (typeof module !== "undefined" && module.exports) {
  module.exports = ThemeManager;
}
