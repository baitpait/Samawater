/**
 * Simple Sidebar Toggle
 * تبديل بسيط للقائمة الجانبية
 */

(function() {
    'use strict';
    
    let isInitialized = false;
    
    function toggleSidebar() {
        const body = document.body;
        if (!body) return;
        
        body.classList.toggle('sidebar-closed');
        
        const isClosed = body.classList.contains('sidebar-closed');
        localStorage.setItem('sidebarClosed', isClosed ? 'true' : 'false');
        
        // Update icon
        const toggleBtn = document.getElementById('sidebarToggle');
        if (toggleBtn) {
            const icon = toggleBtn.querySelector('i');
            if (icon) {
                if (isClosed) {
                    icon.classList.remove('la-bars');
                    icon.classList.add('la-angle-right');
                } else {
                    icon.classList.remove('la-angle-right');
                    icon.classList.add('la-bars');
                }
            }
        }
    }
    
    function initSidebarToggle() {
        if (isInitialized) return;
        
        const toggleBtn = document.getElementById('sidebarToggle');
        const body = document.body;
        
        if (!toggleBtn || !body) {
            setTimeout(initSidebarToggle, 100);
            return;
        }
        
        isInitialized = true;
        
        // Load saved state
        const savedState = localStorage.getItem('sidebarClosed');
        if (savedState === 'true') {
            body.classList.add('sidebar-closed');
            const icon = toggleBtn.querySelector('i');
            if (icon) {
                icon.classList.remove('la-bars');
                icon.classList.add('la-angle-right');
            }
        }
        
        // Add click event
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleSidebar();
        });
        
        // Also support onclick as fallback
        toggleBtn.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleSidebar();
        };
    }
    
    // Initialize
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebarToggle);
    } else {
        initSidebarToggle();
    }
    
    // Retry after a delay if still not initialized
    setTimeout(function() {
        if (!isInitialized) {
            initSidebarToggle();
        }
    }, 500);
})();
