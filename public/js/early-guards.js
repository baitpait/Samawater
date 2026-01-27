// Early guards for global dependencies
(function () {
  'use strict';

  // DO NOT define window.define.amd = true here, it breaks DataTables and other UMD modules
  // which will try to use AMD instead of attaching to window.jQuery.

  if (typeof window.Noty === 'undefined') {
    window.Noty = function () {
      return {
        show: function () { return undefined; }
      };
    };
    // Add overrideDefaults method to stub to prevent errors
    window.Noty.overrideDefaults = function() {
      // No-op: will be replaced when real Noty loads
      return;
    };
  }

  // Ensure bootstrap is available on window if loaded
  if (typeof window.bootstrap === 'undefined' && typeof bootstrap !== 'undefined') {
    window.bootstrap = bootstrap;
  }

  // Preserve DataTables plugin if jQuery gets overwritten.
  var dtCache = {
    DataTable: null,
    dataTable: null,
    dataTableSettings: null,
    dataTableExt: null,
    Responsive: null,
  };

  function snapshotDataTables($) {
    if (!$ || !$.fn) return;
    if (typeof $.fn.DataTable === 'function') dtCache.DataTable = $.fn.DataTable;
    if (typeof $.fn.dataTable === 'function') dtCache.dataTable = $.fn.dataTable;
    if ($.fn.dataTable && $.fn.dataTableSettings) dtCache.dataTableSettings = $.fn.dataTableSettings;
    if ($.fn.dataTable && $.fn.dataTableExt) dtCache.dataTableExt = $.fn.dataTableExt;
    // Also cache Responsive if available
    if ($.fn.dataTable && $.fn.dataTable.Responsive) {
      dtCache.Responsive = $.fn.dataTable.Responsive;
    }
  }

  function restoreDataTables($) {
    if (!$ || !$.fn) return;
    if (dtCache.DataTable && typeof $.fn.DataTable !== 'function') $.fn.DataTable = dtCache.DataTable;
    if (dtCache.dataTable && typeof $.fn.dataTable !== 'function') $.fn.dataTable = dtCache.dataTable;
    if (dtCache.dataTableSettings && !$.fn.dataTableSettings) $.fn.dataTableSettings = dtCache.dataTableSettings;
    if (dtCache.dataTableExt && !$.fn.dataTableExt) $.fn.dataTableExt = dtCache.dataTableExt;
    // Restore Responsive if it was cached
    if (dtCache.Responsive && $.fn.dataTable && !$.fn.dataTable.Responsive) {
      $.fn.dataTable.Responsive = dtCache.Responsive;
    }
    // Ensure dataTable namespace exists if DataTable exists
    if (typeof $.fn.DataTable === 'function' && typeof $.fn.dataTable !== 'function') {
      $.fn.dataTable = $.fn.DataTable;
    }
  }

  function guardWindowProperty(prop) {
    var stored = window[prop];
    try {
      Object.defineProperty(window, prop, {
        configurable: true,
        get: function () { return stored; },
        set: function (val) {
          
          stored = val;
          // When jQuery changes, try to restore DataTables plugin if we have it cached.
          try { 
            restoreDataTables(stored);
            // Also snapshot the new jQuery if it has DataTables
            if (stored && stored.fn) {
              snapshotDataTables(stored);
            }
            
          } catch (e) {
            
          }
        }
      });
    } catch (e) {
      // ignore if property is non-configurable
    }
  }

  // Install guards as early as possible.
  guardWindowProperty('jQuery');
  guardWindowProperty('$');

  // Prevent loading jQuery from CDN
  // This is a radical fix to stop double loading of jQuery
  var observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
      if (mutation.addedNodes) {
        mutation.addedNodes.forEach(function(node) {
          if (node.tagName === 'SCRIPT' && node.src && node.src.includes('cdn.jsdelivr.net') && node.src.includes('jquery')) {
            
            node.parentNode.removeChild(node);
            console.warn('[Guard] Blocked loading of jQuery from CDN: ' + node.src);
          }
        });
      }
    });
  });
  
  if (document.head) {
      observer.observe(document.head, { childList: true, subtree: true });
  }
  if (document.body) {
      observer.observe(document.body, { childList: true, subtree: true });
  } else {
      document.addEventListener('DOMContentLoaded', function() {
          observer.observe(document.body, { childList: true, subtree: true });
      });
  }

  // Ensure Noty has overrideDefaults when it loads
  function ensureNotyComplete() {
    if (typeof window.Noty === 'function' && typeof window.Noty.overrideDefaults === 'undefined') {
      window.Noty.overrideDefaults = function() {
        // No-op: will be replaced when real Noty loads
        return;
      };
    }
  }

  // Snapshot DataTables once it becomes available.
  var tries = 0;
  var timer = setInterval(function () {
    tries += 1;
    
    // Check and fix Noty
    ensureNotyComplete();
    
    if (window.jQuery && window.jQuery.fn) {
      snapshotDataTables(window.jQuery);
      // Always try to restore if we have cache and DataTables is missing
      if (dtCache.DataTable && typeof window.jQuery.fn.DataTable !== 'function') {
        restoreDataTables(window.jQuery);
      }
      
    }
    if (tries >= 100 || (dtCache.DataTable && dtCache.dataTable && window.jQuery && window.jQuery.fn && window.jQuery.fn.DataTable)) {
      clearInterval(timer);
      
    }
  }, 100);
  
  
})();
