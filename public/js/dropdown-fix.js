/**
 * Dropdown Fix for Bootstrap 4 in Backpack
 * Handles positioning and visibility issues
 */
(function() {
    'use strict';

    function fixDropdowns() {
        // Find all dropdown toggles
        const toggles = document.querySelectorAll('[data-toggle="dropdown"]');
        
        toggles.forEach(toggle => {
            if (toggle.dataset.fixInitialized) return;
            toggle.dataset.fixInitialized = 'true';

            toggle.addEventListener('click', function(e) {
                const parent = this.closest('.dropdown') || this.closest('.btn-group');
                if (!parent) return;

                const menu = parent.querySelector('.dropdown-menu');
                if (!menu) return;

                // Close other dropdowns
                document.querySelectorAll('.dropdown-menu.show').forEach(m => {
                    if (m !== menu) m.classList.remove('show');
                });

                // Toggle this one
                menu.classList.toggle('show');
                parent.classList.toggle('show');

                if (menu.classList.contains('show')) {
                    // Position fix if clipped
                    const rect = menu.getBoundingClientRect();
                    if (rect.right > window.innerWidth) {
                        menu.style.left = 'auto';
                        menu.style.right = '0';
                    }
                    
                    // Ensure parent has high z-index
                    parent.style.zIndex = '1050';
                    const tr = parent.closest('tr');
                    if (tr) tr.style.zIndex = '1050';
                } else {
                    parent.style.zIndex = '';
                    const tr = parent.closest('tr');
                    if (tr) tr.style.zIndex = '';
                }

                e.preventDefault();
                e.stopPropagation();
            });
        });
    }

    // Close on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown') && !e.target.closest('.btn-group')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(m => {
                m.classList.remove('show');
                const parent = m.closest('.dropdown') || m.closest('.btn-group');
                if (parent) {
                    parent.classList.remove('show');
                    parent.style.zIndex = '';
                    const tr = parent.closest('tr');
                    if (tr) tr.style.zIndex = '';
                }
            });
        }
    });

    // Run periodically to catch dynamic elements (like DataTables)
    setInterval(fixDropdowns, 1000);
    
    // Also run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fixDropdowns);
    } else {
        fixDropdowns();
    }
})();
