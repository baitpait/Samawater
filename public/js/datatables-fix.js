// Fix for DataTable global object usage
(function() {
  'use strict';
  
  // دالة لإصلاح DataTables إذا تضرر
  function fixDataTables() {
      if (!window.jQuery || !window.jQuery.fn) {
          return false;
      }

      // إصلاح DataTable و dataTable
      if (!window.jQuery.fn.DataTable && window.jQuery.fn.dataTable) {
          window.jQuery.fn.DataTable = window.jQuery.fn.dataTable;
      }
      
      if (window.jQuery.fn.DataTable && !window.jQuery.fn.dataTable) {
          window.jQuery.fn.dataTable = window.jQuery.fn.DataTable;
      }

      // إصلاح مشكلة Responsive Plugin المفقود - نسخة أقوى
      if (window.jQuery.fn.DataTable) {
          // إنشاء namespace dataTable إذا لم يكن موجوداً
          if (!window.jQuery.fn.dataTable) {
              window.jQuery.fn.dataTable = window.jQuery.fn.DataTable;
          }
          
          // Mock Responsive Plugin إذا كان مفقوداً
          if (!window.jQuery.fn.DataTable.Responsive) {
              window.jQuery.fn.DataTable.Responsive = function() { 
                  return {
                      rebuild: function() { return this; },
                      recalc: function() { return this; },
                      display: {
                          modal: function() { return function() { return ''; }; }
                      }
                  }; 
              };
          }
          
          // إضافة Responsive إلى dataTable namespace أيضاً
          if (window.jQuery.fn.dataTable && !window.jQuery.fn.dataTable.Responsive) {
              window.jQuery.fn.dataTable.Responsive = window.jQuery.fn.DataTable.Responsive;
          }
      }
      
      return true;
  }

  // Create DataTable global if it doesn't exist but jQuery.fn.DataTable does
  function ensureDataTableGlobal() {
    fixDataTables();

    if (typeof window.jQuery !== 'undefined' && window.jQuery.fn && window.jQuery.fn.DataTable) {
      // If DataTable global doesn't exist, create it from jQuery.fn.DataTable
      if (typeof window.DataTable === 'undefined') {
        window.DataTable = {
          api: true, // علامة لتمييز أن هذا هو الـ Mock الخاص بنا
          Api: function(table) {
             return window.jQuery(table).DataTable();
          },
          isDataTable: function(table) {
             return window.jQuery.fn.DataTable.isDataTable(table);
          }
        };
        
        // ربط الخصائص الثابتة
        Object.assign(window.DataTable, window.jQuery.fn.DataTable);

        
        
      }
    }
  }
  
  
  
  // Try to ensure DataTable global immediately
  ensureDataTableGlobal();
  
  // Try again after DOM ready - محاولات أكثر
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
      
      setTimeout(ensureDataTableGlobal, 50);
      setTimeout(ensureDataTableGlobal, 100);
      setTimeout(ensureDataTableGlobal, 200);
      setTimeout(ensureDataTableGlobal, 500);
      setTimeout(ensureDataTableGlobal, 1000);
      setTimeout(ensureDataTableGlobal, 2000);
    });
  } else {
    setTimeout(ensureDataTableGlobal, 50);
    setTimeout(ensureDataTableGlobal, 100);
    setTimeout(ensureDataTableGlobal, 200);
    setTimeout(ensureDataTableGlobal, 500);
    setTimeout(ensureDataTableGlobal, 1000);
    setTimeout(ensureDataTableGlobal, 2000);
  }
  
  // Monitor for jQuery and DataTables - فحص مستمر
  var checkInterval = setInterval(function() {
    fixDataTables(); // إصلاح مستمر
    
    if (typeof window.jQuery !== 'undefined' && window.jQuery.fn && window.jQuery.fn.DataTable) {
      ensureDataTableGlobal();
      // التحقق من Responsive أيضاً
      if (window.jQuery.fn.DataTable && !window.jQuery.fn.DataTable.Responsive) {
        fixDataTables();
      }
    }
  }, 100); // فحص كل 100ms بدلاً من 200ms
  
  // Stop after 15 seconds (زيادة الوقت)
  setTimeout(function() {
    clearInterval(checkInterval);
    
  }, 15000);
})();
