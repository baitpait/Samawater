<aside class="sidebar sidebar-fixed sidebar-pills">
  <div class="sidebar-header" style="padding: 35px 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 15px;">
    <a href="{{ backpack_url('dashboard') }}" style="text-decoration: none; display: block;">
        <img src="{{ asset('logo/Logo-2.png') }}" alt="Sama Water" style="max-width: 150px; filter: drop-shadow(0 8px 15px rgba(0,0,0,0.3)); transition: transform 0.3s ease;">
        <div style="color: #fff; font-weight: 900; font-size: 22px; margin-top: 15px; letter-spacing: 1.5px; text-shadow: 0 2px 10px rgba(0,0,0,0.2);">مياه سما</div>
    </a>
  </div>
  
  {{-- Sidebar Content --}}
  <div class="sidebar-nav-wrapper" style="padding: 0 5px;">
    @include(backpack_view('inc.menu_items'))
  </div>

  {{-- Floating Toggle Button for Mobile --}}
  <button class="mobile-sidebar-toggle d-lg-none" id="mobileSidebarToggle">
    <i class="la la-bars"></i>
  </button>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('mobileSidebarToggle');
        const body = document.body;
        
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                body.classList.toggle('sidebar-show');
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (body.classList.contains('sidebar-show') && !e.target.closest('.sidebar')) {
                body.classList.remove('sidebar-show');
            }
        });
    });
  </script>

  <style>
    /* تحسينات إضافية للسايدبار لضمان اللون الأبيض الصريح */
    .sidebar .nav-link, 
    .sidebar .nav-link span, 
    .sidebar .nav-link i {
        color: #ffffff !important;
        opacity: 1 !important; /* أبيض صريح بدون شفافية */
        transition: all 0.3s ease !important;
    }
    
    .sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.15) !important;
        transform: translateX(-5px) !important;
    }
    
    .sidebar .nav-link.active {
        background: linear-gradient(135deg, #1e3a5f 0%, #6f6af8 100%) !important;
        box-shadow: 0 4px 15px rgba(111, 106, 248, 0.3) !important;
    }

    .sidebar .nav-link i {
        margin-left: 12px !important;
        font-size: 1.2rem !important;
    }

    .sidebar .nav-title {
        color: #ffffff !important;
        opacity: 0.6 !important; /* عناوين الأقسام أبيض هادئ */
        font-size: 11px !important;
        font-weight: 800 !important;
        padding: 25px 25px 10px !important;
        letter-spacing: 1.2px !important;
    }
    
    /* حركة خفيفة للشعار عند التحويم */
    .sidebar-header a:hover img {
        transform: scale(1.05);
    }
  </style>
</aside>
