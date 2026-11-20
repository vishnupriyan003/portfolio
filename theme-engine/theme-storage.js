/**
 * Multi-Design Theme Customization Engine - Storage Service
 * Robust, exception-safe localStorage wrapper for theme and mode persistence.
 */
const ThemeStorage = (function () {
  const THEME_KEY = "vp_portfolio_theme";
  const MODE_KEY = "vp_portfolio_theme_mode";

  function isAvailable() {
    try {
      const test = "__storage_test__";
      window.localStorage.setItem(test, test);
      window.localStorage.removeItem(test);
      return true;
    } catch (e) {
      return false;
    }
  }

  function getStoredTheme(fallback = "nature") {
    if (!isAvailable()) return fallback;
    try {
      const val = window.localStorage.getItem(THEME_KEY);
      return val || fallback;
    } catch (e) {
      console.warn("ThemeStorage: failed to read theme", e);
      return fallback;
    }
  }

  function setStoredTheme(themeId) {
    if (!isAvailable()) return;
    try {
      window.localStorage.setItem(THEME_KEY, themeId);
    } catch (e) {
      console.warn("ThemeStorage: failed to save theme", e);
    }
  }

  function getStoredMode(fallback = "default") {
    if (!isAvailable()) return fallback;
    try {
      const val = window.localStorage.getItem(MODE_KEY);
      return val || fallback;
    } catch (e) {
      console.warn("ThemeStorage: failed to read mode", e);
      return fallback;
    }
  }

  function setStoredMode(mode) {
    if (!isAvailable()) return;
    try {
      window.localStorage.setItem(MODE_KEY, mode);
    } catch (e) {
      console.warn("ThemeStorage: failed to save mode", e);
    }
  }

  function clearSettings() {
    if (!isAvailable()) return;
    try {
      window.localStorage.removeItem(THEME_KEY);
      window.localStorage.removeItem(MODE_KEY);
    } catch (e) {
      console.warn("ThemeStorage: failed to clear settings", e);
    }
  }

  return {
    isAvailable,
    getStoredTheme,
    setStoredTheme,
    getStoredMode,
    setStoredMode,
    clearSettings,
  };
})();

if (typeof module !== "undefined" && module.exports) {
  module.exports = ThemeStorage;
}
