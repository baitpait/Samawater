<script>
(function() {
    'use strict';
    
    // تم إزالة كود الـ dropdown اليدوي والاعتماد على Bootstrap 4 الأصلي
    // لضمان عدم حدوث تعارضات برمجية.
    
    function init() {
        console.log('Distributor list scripts initialized');
    }
    
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }
})();
</script>
