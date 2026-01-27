// AMD define shim for Select2 i18n scripts
(function () {
  'use strict';
  
  // DO NOT define window.define.amd = true here, it breaks DataTables.
  // We only need to ensure select2.amd.define exists for i18n scripts.

  function ensureSelect2Amd() {
    if (!window.jQuery || !window.jQuery.fn) return false;
    if (window.jQuery.fn.select2 && window.jQuery.fn.select2.amd) {
      return true;
    }

    // Intercept select2 assignment to guarantee amd.define exists
    if (!window.jQuery.fn.__select2Guarded) {
      try {
        var stored = window.jQuery.fn.select2;
        Object.defineProperty(window.jQuery.fn, 'select2', {
          configurable: true,
          get: function () { return stored; },
          set: function (val) {
            stored = val;
            if (stored && !stored.amd) {
              stored.amd = { define: function () { return undefined; } };
            }
          }
        });
        window.jQuery.fn.__select2Guarded = true;
        if (stored && !stored.amd) {
          stored.amd = { define: function () { return undefined; } };
        }
      } catch (e) {
        // Fallback: direct patch
        if (window.jQuery.fn.select2 && !window.jQuery.fn.select2.amd) {
          window.jQuery.fn.select2.amd = { define: function () { return undefined; } };
        }
      }
    }
    return true;
  }

  var tries = 0;
  var timer = setInterval(function () {
    tries += 1;
    if (ensureSelect2Amd() || tries >= 50) {
      clearInterval(timer);
    }
  }, 100);
})();
