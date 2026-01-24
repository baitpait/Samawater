<style>
/* ================================
   Ultra Modern Sidebar Style (Eliyaa)
   مع خط Cairo العربي
   ================================ */
.sidebar-divider {
    margin: 14px 10px;
    height: 2px;
    background: #cdcdcd;
    border-radius: 5px;
}
.app-body > .sidebar {
    background: #ffffff !important;
    width: 240px !important;
    border-radius: 20px;
    padding: 15px 20px 30px 20px !important;
    margin: 25px !important;
    height: calc(100vh - 50px);
    position: fixed !important;
    right: 0 !important; /* RTL */
    top: 0;
    box-shadow: 0 8px 18px #cdcdcd;
    display: flex;
    flex-direction: column;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
}

/* إزالة الخلفيات القديمة */
.sidebar .sidebar-nav,
.sidebar .nav {
    background: transparent !important;
}

/* شكل الروابط */
.sidebar .nav .nav-link {
    padding: 12px 18px !important;
    margin: 4px 0;
    border-radius: 20px;
    font-size: 15px;
    color: #3d3d3d !important;
    font-weight: 500;
    display: flex !important;
    align-items: center;
    gap: 12px;
    transition: 0.2s;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
}

/* Active Bubble */
.sidebar .nav .nav-link.active {
    background: #42A5F5 !important; /* بنفسجي فاتح جداً */
    color: #fff !important;
    font-weight: 600;
    box-shadow: inset 0 0 8px rgba(0,0,0,0.05);
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
}

/* الأيقونات */
.sidebar .nav .nav-link i {
    font-size: 18px;
    color: inherit !important;
}

/* === FOOTER (ACCOUNT + LOGOUT + MODE) === */

.sidebar-footer {
    margin-top: auto;
    padding-top: 15px;
    border-top: 1px solid #f0f0f3;
}

.sidebar-footer .nav-link {
    padding: 12px 16px !important;
    border-radius: 20px;
    font-size: 15px;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: #fff !important;
    transition: 0.2s;
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
}

.sidebar-footer .nav-link:hover {
    background: #fff !important;
    color: #6b4cff !important;
}

/* زر light/dark */
.sidebar-mode-btn {
    background: #ffffff;
    padding: 10px;
    border-radius: 20px;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.12);
    margin-top: 16px;
    cursor: pointer;
}

.sidebar-mode-btn i {
    font-size: 18px;
    color: #6b4cff;
}

/* مسافات القائمة */
.sidebar .nav {
    margin-top: 30px;
}

/* ================================
   Sidebar Logo - احترافي
   ================================ */
.sidebar-logo-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0;
    margin: 0;
    margin-bottom: 0;
    border-bottom: none;
}

.logo-section {
    margin: 0 !important;
    padding: 0 !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
}

.logo-section .sidebar-logo-wrapper {
    margin-top: 0 !important;
    padding-top: 0 !important;
}

.sidebar-logo-link {
    display: flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    transition: all 0.3s ease;
    padding: 10px;
    border-radius: 16px;
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    box-shadow: 0 4px 15px rgba(111, 106, 248, 0.1);
}

.sidebar-logo-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(111, 106, 248, 0.2);
    background: linear-gradient(135deg, #f0f2ff 0%, #e8ebff 100%);
}

.sidebar-logo {
    max-width: 140px;
    height: auto;
    display: block;
    filter: drop-shadow(0 2px 8px rgba(111, 106, 248, 0.15));
    transition: all 0.3s ease;
}

.sidebar-logo-link:hover .sidebar-logo {
    transform: scale(1.05);
    filter: drop-shadow(0 4px 12px rgba(111, 106, 248, 0.25));
}

.logo-section {
    margin-bottom: 0 !important;
    padding: 0 !important;
}

.logo-section .nav-link {
    padding: 0 !important;
    margin: 0 !important;
    border-radius: 0 !important;
    background: transparent !important;
}

/* fix layout with custom sidebar */
.app-body {
    display: flex !important;
    flex-direction: row-reverse !important; /* RTL */
}

.main {
    width: 100%;
    padding-right: 280px !important; /* مساحة للسايدبار */
    padding-left: 20px !important;
    padding-top: 25px !important;
}

/* Scrollbar جميل وناعم */
/* ✅ إخفاء شريط التمرير مع بقاء التمرير */
.sidebar-nav {
    overflow-y: auto;
    scrollbar-width: none;       /* Firefox */
    -ms-overflow-style: none;    /* IE / Edge */
}

.sidebar-nav::-webkit-scrollbar {
    display: none;               /* Chrome / Safari */
}


.sidebar-nav::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background-color: #bfbfbf;
    border-radius: 10px;
}


</style>


@if (backpack_auth()->check())
    <div class="{{ backpack_theme_config('classes.sidebar') }}">
<nav class="sidebar-nav">

        <!-- القائمة الرئيسية -->
        <ul class="nav flex-column" style="flex-grow: 1;">
          @include(backpack_view('inc.sidebar_content'))
        </ul>
      </nav>

    </div>
@endif


@push('before_scripts')
  <script type="text/javascript">
    let sidebarClass = (document.body.className.match(/sidebar-(sm|md|lg|xl)-show/) || ['sidebar-lg-show'])[0];
    let sidebarTransition = function(value) {
        document.querySelector('.app-body > .sidebar').style.transition = value || '';
    };
    let sessionState = sessionStorage.getItem('sidebar-collapsed');
    if (sessionState) {
      sidebarTransition("none");
      document.body.classList.toggle(sidebarClass, sessionState === '1');
      setTimeout(sidebarTransition, 100);
    }
  </script>
@endpush

@push('after_scripts')
  <script>
    document.querySelectorAll('.sidebar-toggler').forEach(function(toggler) {
        toggler.addEventListener('click', function() {
            sessionStorage.setItem('sidebar-collapsed', Number(!document.body.classList.contains(sidebarClass)))
            setTimeout(function() {
                if(typeof crud !== "undefined" && crud.table) {
                    crud.table.fixedHeader.adjust();
                }
            }, 300);
        })
    });

    var full_url = "{{ Request::fullUrl() }}";
    var $navLinks = $(".sidebar-nav li a, .app-header li a");

    var $curentPageLink = $navLinks.filter(
        function() { return $(this).attr('href') === full_url; }
    );

    if(!$curentPageLink.length > 0){
        $curentPageLink = $navLinks.filter( function() {
            if ($(this).attr('href')?.startsWith(full_url)) return true;
            if (full_url.startsWith($(this).attr('href'))) return true;
            return false;
        });
    }

    $curentPageLink.parents('li').addClass('open');
    $curentPageLink.each(function() {
        $(this).addClass('active');
    });
  </script>
@endpush
