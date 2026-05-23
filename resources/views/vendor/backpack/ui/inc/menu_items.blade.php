{{-- This file is used for menu items by any Backpack v6 theme --}}

@php
    $isDistributor = backpack_user()?->isDistributor() ?? false;
@endphp

<nav class="sidebar-nav">
    <ul class="nav navbar-nav">
        {{-- ============================================
            لوحة التحكم
            ============================================ --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ backpack_url('dashboard') }}">
                <i class="la la-home"></i>
                <span>الرئيسية</span>
            </a>
        </li>

        <li class="sidebar-divider"></li>

        {{-- ============================================
            إدارة العملاء
            ============================================ --}}
        <li class="menu-section-label">إدارة العملاء</li>
        <x-backpack::menu-item title="المشتركين" icon="la la-chart-bar" :link="route('reports.filters')" />
        @if (! $isDistributor)
            <x-backpack::menu-item title="التقارير المتقدمة" icon="la la-chart-line" :link="route('reports.advanced')" />
        @endif

        <li class="sidebar-divider"></li>

        {{-- ============================================
            التسليمات
            ============================================ --}}
        <li class="menu-section-label">التسليمات</li>
        <li class="nav-item">
            <a class="nav-link" href="{{ backpack_url('delivery/create') }}">
                <i class="la la-plus"></i>
                <span>إضافة تسليم</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('delivery.list') }}">
                <i class="la la-truck"></i>
                <span>قائمة التسليم</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('reports.clients_delivery_overview') }}">
                <i class="la la-list"></i>
                <span>التسليمات</span>
            </a>
        </li>

        @if (! $isDistributor)
            <li class="sidebar-divider"></li>

            {{-- ============================================
                الموزعين
                ============================================ --}}
            <li class="menu-section-label">الموزعين</li>
            <x-backpack::menu-item title="الموزعين" icon="la la-car" :link="route('distributors.list')" />

            <li class="sidebar-divider"></li>

            {{-- ============================================
                المالية
                ============================================ --}}
            <li class="menu-section-label">المالية</li>
            <x-backpack::menu-item title="فواتير مبيعات" icon="la la-file-invoice" :link="backpack_url('invoice')" />
            <x-backpack::menu-item title="مدفوعات المشتركين" icon="la la-money-bill" :link="backpack_url('client-payment')" />
            <x-backpack::menu-item title="الصندوق المالي" icon="la la-balance-scale" :link="route('reports.treasury-custody')" />
            <x-backpack::menu-item title="صندوق الشركة" icon="la la-coins" :link="route('reports.company-treasury')" />
            <x-backpack::menu-item title="الحركة المالية الشاملة" icon="la la-stream" :link="route('reports.financial-movements-unified')" />
            <x-backpack::menu-item title="أمانات المشتركين" icon="la la-hand-holding" :link="backpack_url('client-deposit')" />

            <li class="sidebar-divider"></li>

            {{-- ============================================
                المصروفات والموردين
                ============================================ --}}
            <li class="menu-section-label">المصروفات والموردين</li>
            <x-backpack::menu-item title="فئات المصروفات" icon="la la-folder" :link="backpack_url('expense-category')" />
            <x-backpack::menu-item title="المصروفات" icon="la la-money-bill" :link="backpack_url('expense')" />
            <x-backpack::menu-item title="الموردين" icon="la la-truck" :link="backpack_url('vendor')" />
            <x-backpack::menu-item title="مدفوعات الموردين" icon="la la-money-bill-wave" :link="backpack_url('vendor-payment')" />

            <li class="sidebar-divider"></li>

            {{-- ============================================
                المخزون
                ============================================ --}}
            <li class="menu-section-label">المخزون</li>
            <x-backpack::menu-item title="المخزون" icon="la la-warehouse" :link="backpack_url('inventory-item')" />

            <li class="sidebar-divider"></li>

            {{-- ============================================
                الإعدادات
                ============================================ --}}
            <li class="menu-section-label">الإعدادات</li>
            <x-backpack::menu-item title="المدن" icon="la la-map-marker-alt" :link="backpack_url('city')" />
            <x-backpack::menu-item title="أنواع الاشتراكات" icon="la la-tags" :link="backpack_url('subscription-type')" />
            <x-backpack::menu-item title="حالة الاشتراك" icon="la la-info-circle" :link="backpack_url('subscription-status')" />

            <li class="sidebar-divider"></li>

            {{-- ============================================
                النظام
                ============================================ --}}
            <li class="menu-section-label">النظام</li>
            @if(backpack_user()?->canManageUsers())
                <x-backpack::menu-item title="المستخدمين" icon="la la-users-cog" :link="backpack_url('user')" />
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{{ route('backup.download') }}" 
                   onclick="return confirm('هل تريد تحميل نسخة احتياطية من قاعدة البيانات؟\n\nسيتم تحميل ملف SQL يحتوي على جميع البيانات.\n\nملاحظة: قد يستغرق التحميل بضع لحظات.');">
                    <i class="la la-download"></i>
                    <span>نسخة احتياطية</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://wa.me/970599814758" target="_blank">
                    <i class="la la-headset"></i>
                    <span>الدعم الفني</span>
                </a>
            </li>

            <li class="sidebar-divider"></li>
        @endif

        <li class="sidebar-divider"></li>

        {{-- ============================================
            الحساب
            ============================================ --}}
        <li class="menu-section-label">الحساب</li>
        <x-backpack::menu-item title="حسابي" icon="la la-user" :link="backpack_url('account')" />
        <x-backpack::menu-item title="تسجيل الخروج" icon="la la-sign-out-alt" :link="backpack_url('logout')" />
    </ul>
</nav>

<script>
// عند فتح أي صفحة من القائمة الجانبية نبدأ من أعلى الصفحة (لا استعادة لموضع التمرير السابق)
window.addEventListener('load', function() {
    window.scrollTo(0, 0);
    if (typeof document.documentElement.scrollTo === 'function') {
        document.documentElement.scrollTo(0, 0);
    }
});
</script>
