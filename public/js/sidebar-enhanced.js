/**
 * Enhanced Sidebar Functionality
 * تحسين وظائف القائمة الجانبية
 */

document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle Functionality
    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const appBody = document.querySelector('.app-body');
    const sidebarSearch = document.getElementById('sidebarSearch');
    
    // Create toggle button if it doesn't exist
    if (!sidebarToggle && sidebar) {
        const toggleBtn = document.createElement('button');
        toggleBtn.className = 'sidebar-toggle-btn';
        toggleBtn.id = 'sidebarToggle';
        toggleBtn.title = 'إخفاء/إظهار القائمة';
        toggleBtn.innerHTML = '<i class="las la-bars"></i>';
        
        // Insert at the beginning of sidebar or after brand
        const sidebarBrand = sidebar.querySelector('.sidebar-brand');
        const sidebarNav = sidebar.querySelector('.nav') || sidebar.querySelector('.navbar-nav');
        
        if (sidebarBrand) {
            sidebarBrand.style.position = 'relative';
            sidebarBrand.appendChild(toggleBtn);
        } else if (sidebarNav) {
            sidebar.insertBefore(toggleBtn, sidebarNav);
        } else {
            sidebar.insertBefore(toggleBtn, sidebar.firstChild);
        }
    }
    
    // Create search bar if it doesn't exist
    if (!sidebarSearch && sidebar) {
        const searchWrapper = document.createElement('div');
        searchWrapper.className = 'sidebar-search';
        searchWrapper.innerHTML = `
            <div class="sidebar-search-wrapper">
                <i class="las la-search sidebar-search-icon"></i>
                <input type="text" class="sidebar-search-input" id="sidebarSearch" placeholder="قائمة البحث..." autocomplete="off">
            </div>
        `;
        
        // Insert after brand or before nav
        const sidebarBrand = sidebar.querySelector('.sidebar-brand');
        const sidebarNav = sidebar.querySelector('.nav') || sidebar.querySelector('.navbar-nav');
        
        if (sidebarBrand && sidebarNav) {
            sidebar.insertBefore(searchWrapper, sidebarNav);
        } else if (sidebarNav) {
            sidebar.insertBefore(searchWrapper, sidebarNav);
        } else {
            sidebar.appendChild(searchWrapper);
        }
    }
    
    // Load saved state
    const savedState = localStorage.getItem('sidebarCollapsed');
    if (savedState === 'true' && sidebar) {
        sidebar.classList.add('sidebar-collapsed');
        if (appBody) appBody.classList.add('sidebar-collapsed');
        const toggleBtn = document.getElementById('sidebarToggle');
        if (toggleBtn) {
            const icon = toggleBtn.querySelector('i');
            if (icon) {
                icon.classList.remove('la-bars');
                icon.classList.add('la-angle-right');
            }
        }
    }
    
    // Toggle Sidebar
    const toggleBtn = document.getElementById('sidebarToggle');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            if (!sidebar) return;
            
            sidebar.classList.toggle('sidebar-collapsed');
            if (appBody) appBody.classList.toggle('sidebar-collapsed');
            
            const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
            
            const icon = this.querySelector('i');
            if (icon) {
                if (isCollapsed) {
                    icon.classList.remove('la-bars');
                    icon.classList.add('la-angle-right');
                } else {
                    icon.classList.remove('la-angle-right');
                    icon.classList.add('la-bars');
                }
            }
        });
    }
    
    // Sidebar Search Functionality
    const searchInput = document.getElementById('sidebarSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const menuItems = document.querySelectorAll('.sidebar .nav-link');
            
            menuItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                const navItem = item.closest('.nav-item');
                
                if (text.includes(searchTerm)) {
                    if (navItem) navItem.style.display = '';
                } else {
                    if (navItem) navItem.style.display = 'none';
                }
            });
        });
    }
    
    // Menu Category Toggle Functionality
    const categoryTitles = document.querySelectorAll('.menu-category-title');
    categoryTitles.forEach(title => {
        title.addEventListener('click', function() {
            const category = this.closest('.menu-category');
            if (!category) return;
            
            const items = category.querySelector('.menu-category-items');
            const arrow = this.querySelector('.menu-category-arrow');
            
            if (items) {
                items.classList.toggle('collapsed');
                if (arrow) arrow.classList.toggle('collapsed');
            }
        });
    });
});
