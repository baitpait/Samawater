// Global guards for Backpack custom scripts
(function () {
  'use strict';

  function ensureCrudNamespace() {
    if (!window.crud) {
      window.crud = {};
    }
    if (!window.crud.table) {
      window.crud.table = {};
    }
    if (!window.crud.table.dataTableConfiguration) {
      window.crud.table.dataTableConfiguration = null;
    }
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
    } else if (typeof window.Noty === 'function' && typeof window.Noty.overrideDefaults === 'undefined') {
      // If Noty exists but overrideDefaults is missing, add it
      window.Noty.overrideDefaults = function() {
        // No-op: will be replaced when real Noty loads
        return;
      };
    }
  }

  function patchSelect2Guard() {
    if (!window.jQuery || !window.jQuery.fn || !window.jQuery.fn.select2) {
      return false;
    }

    // DO NOT define window.define.amd = true here, it breaks DataTables.
    // Prevent Select2 i18n AMD errors when define is missing by patching Select2 instead.

    var original = window.jQuery.fn.select2;
    if (original.__guarded) return true;

    var wrapped = function () {
      try {
        var first = this && this[0];
        if (first && first.getAttribute && first.getAttribute('data-guarded') === 'true') {
          return this;
        }
      } catch (e) {
        // ignore and fall through
      }
      return original.apply(this, arguments);
    };

    wrapped.__guarded = true;
    window.jQuery.fn.select2 = wrapped;
    return true;
  }

  function isCrudEditOrCreate() {
    var path = window.location.pathname || '';
    return /\/admin\/.+\/(edit|create)$/.test(path);
  }

  function ensureClientSelectExists() {
    // If no client select exists on edit/create, insert a hidden one
    // to stop repeated Select2 retries in custom scripts.
    var existing = document.querySelector('select[name="client_id"], select.client-select-ajax');
    if (existing) return;

    if (!isCrudEditOrCreate()) return;

    var dummy = document.createElement('select');
    dummy.name = 'client_id';
    dummy.className = 'client-select-ajax';
    dummy.style.display = 'none';
    dummy.setAttribute('data-guarded', 'true');
    document.body.appendChild(dummy);
  }

  function patchInitClientSelect2() {
    if (typeof window.initClientSelect2 !== 'function') return false;
    if (window.initClientSelect2.__guarded) return true;

    var original = window.initClientSelect2;
    var wrapped = function () {
      var visibleClientSelect = document.querySelector(
        'select[name="client_id"]:not([data-guarded="true"])'
      );
      var guardedOnly = document.querySelector('select[data-guarded="true"]');
      if (guardedOnly && !visibleClientSelect) {
        return;
      }
      return original.apply(this, arguments);
    };

    wrapped.__guarded = true;
    window.initClientSelect2 = wrapped;
    return true;
  }

  function patchDataTablesResponsive() {
    if (!window.jQuery || !window.jQuery.fn) {
      return false;
    }
    
    // إصلاح DataTable و dataTable أولاً
    if (!window.jQuery.fn.DataTable && window.jQuery.fn.dataTable) {
      window.jQuery.fn.DataTable = window.jQuery.fn.dataTable;
    }
    if (window.jQuery.fn.DataTable && !window.jQuery.fn.dataTable) {
      window.jQuery.fn.dataTable = window.jQuery.fn.DataTable;
    }

    // Ensure DataTable function exists
    if (!window.jQuery.fn.DataTable && !window.jQuery.fn.dataTable) {
      return false;
    }

    // Ensure dataTable namespace exists
    if (!window.jQuery.fn.dataTable) {
      if (window.jQuery.fn.DataTable) {
        window.jQuery.fn.dataTable = window.jQuery.fn.DataTable;
      } else {
        return false;
      }
    }

    // If Responsive plugin failed to load, provide a no-op constructor
    if (!window.jQuery.fn.dataTable.Responsive) {
      window.jQuery.fn.dataTable.Responsive = function () {
        return {
          rebuild: function() { return this; },
          recalc: function() { return this; },
          display: {
            modal: function() { return function() { return ''; }; }
          }
        };
      };
      // إضافة إلى DataTable أيضاً
      if (window.jQuery.fn.DataTable) {
        window.jQuery.fn.DataTable.Responsive = window.jQuery.fn.dataTable.Responsive;
      }
    }

    return true;
  }

  function ensureDataTablesAvailable() {
    if (!window.jQuery || !window.jQuery.fn) {
      return false;
    }

    // If DataTable is not available, wait for it
    if (typeof window.jQuery.fn.DataTable !== 'function' && typeof window.jQuery.fn.dataTable !== 'function') {
      return false;
    }

    // Ensure dataTable namespace exists
    if (!window.jQuery.fn.dataTable) {
      // Create dataTable namespace if it doesn't exist
      if (typeof window.jQuery.fn.DataTable === 'function') {
        window.jQuery.fn.dataTable = window.jQuery.fn.DataTable;
      } else if (typeof window.jQuery.fn.dataTable === 'function') {
        // Already exists
      } else {
        return false;
      }
    }

    return true;
  }

  function ensureNotyComplete() {
    if (typeof window.Noty === 'function') {
      // Ensure overrideDefaults exists
      if (typeof window.Noty.overrideDefaults === 'undefined') {
        window.Noty.overrideDefaults = function() {
          // No-op: will be replaced when real Noty loads
          return;
        };
      }
    }
  }

  function initGuards() {
    
    
    // Ensure bootstrap is available on window if loaded locally
    if (typeof window.bootstrap === 'undefined' && typeof bootstrap !== 'undefined') {
      window.bootstrap = bootstrap;
      
    }
    
    ensureCrudNamespace();
    ensureNotyComplete();
    ensureClientSelectExists();

    // Patch select2 when available
    var attempts = 0;
    var timer = setInterval(function () {
      attempts += 1;
      
      // Ensure Noty is complete
      ensureNotyComplete();
      
      // Ensure DataTables is available first
      var dataTablesAvailable = ensureDataTablesAvailable();
      
      
      
      var patchedSelect2 = patchSelect2Guard();
      var patchedInit = patchInitClientSelect2();
      var patchedDataTables = dataTablesAvailable ? patchDataTablesResponsive() : false;
      if ((patchedSelect2 && patchedInit && patchedDataTables) || attempts >= 50) {
        clearInterval(timer);
        
      }
    }, 100);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initGuards);
  } else {
    initGuards();
  }
})();
