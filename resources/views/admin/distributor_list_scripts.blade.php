<script>
(function() {
    'use strict';
    
    // تهيئة Bootstrap dropdowns
    function initBootstrapDropdowns() {
        var toggles = document.querySelectorAll(".unified-actions-dropdown .dropdown-toggle:not([data-dropdown-initialized])");
        
        toggles.forEach(function(toggle) {
            toggle.setAttribute("data-dropdown-initialized", "true");
            
            // إضافة event listener للـ click على toggle فقط
            toggle.addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var dropdown = toggle.closest(".unified-actions-dropdown");
                if (!dropdown) return;
                
                var menu = dropdown.querySelector(".dropdown-menu");
                if (!menu) return;
                
                var isOpen = menu.classList.contains("show");
                
                // إغلاق جميع dropdowns الأخرى
                document.querySelectorAll(".unified-actions-dropdown .dropdown-menu").forEach(function(m) {
                    if (m !== menu) {
                        m.classList.remove("show");
                        m.style.display = "none";
                    }
                });
                
                // تبديل حالة dropdown الحالي
                if (isOpen) {
                    menu.classList.remove("show");
                    menu.style.display = "none";
                } else {
                    menu.classList.add("show");
                    menu.style.display = "block";
                    menu.style.position = "absolute";
                    menu.style.right = "0";
                    menu.style.left = "auto";
                    menu.style.top = "100%";
                    menu.style.marginTop = "4px";
                    menu.style.zIndex = "99999";
                    menu.style.minWidth = "200px";
                }
            });
        });
    }
    
    // دالة لإعادة تهيئة dropdowns
    function reinitDropdowns() {
        // إزالة data-initialized لإعادة التهيئة
        document.querySelectorAll(".unified-actions-dropdown .dropdown-toggle").forEach(function(toggle) {
            toggle.removeAttribute("data-dropdown-initialized");
        });
        
        // إعادة تهيئة
        setTimeout(initBootstrapDropdowns, 50);
    }
    
    // تهيئة عند تحميل الصفحة
    function init() {
        reinitDropdowns();
    }
    
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(init, 100);
        });
    } else {
        setTimeout(init, 100);
    }
    
    // إعادة تهيئة بعد تحميل DataTables
    if (typeof window.jQuery !== "undefined" && window.jQuery.fn && window.jQuery.fn.DataTable) {
        // بعد رسم الجدول
        jQuery(document).on("draw.dt", function() {
            reinitDropdowns();
        });
        
        // بعد تحميل الجدول
        jQuery(document).on("crudTableLoaded", function() {
            reinitDropdowns();
        });
    }
    
    // إعادة تهيئة بعد تحميل الصفحة بالكامل
    window.addEventListener("load", function() {
        setTimeout(reinitDropdowns, 300);
    });
    
    // إغلاق dropdown عند النقر خارجها
    // لكن لا نتداخل مع عمل الروابط والأزرار داخل dropdown (خاصة زر الحذف)
    document.addEventListener("click", function(e) {
        // إذا كان النقر على رابط أو زر داخل dropdown menu، نسمح بالسلوك الافتراضي
        // هذا مهم جداً لزر الحذف الذي يستخدم onclick
        var clickedLink = e.target.closest(".dropdown-menu a");
        var clickedButton = e.target.closest(".dropdown-menu button");
        
        if (clickedLink || clickedButton) {
            // السماح بالسلوك الافتراضي - لا نغلق dropdown ولا نتداخل مع onclick
            return;
        }
        
        // إذا كان النقر خارج dropdown، نغلق جميع dropdowns
        if (!e.target.closest(".unified-actions-dropdown")) {
            document.querySelectorAll(".unified-actions-dropdown .dropdown-menu").forEach(function(menu) {
                menu.classList.remove("show");
                menu.style.display = "none";
            });
        }
    }, false); // استخدام capture: false للتأكد من عدم التداخل مع onclick
})();
</script>