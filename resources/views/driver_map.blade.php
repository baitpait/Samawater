<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🗺️ تتبع الموزعين - سما</title>
    
    <!-- Google Fonts - Cairo -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Line Awesome Icons -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            overflow: hidden;
        }

        /* ===== Header ===== */
        .map-header {
            background: linear-gradient(135deg, #6f6af8 0%, #7c7cff 100%);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 4px 20px rgba(111, 106, 248, 0.3);
            z-index: 1000;
            position: relative;
        }

        .map-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .map-header .badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            position: fixed;
            right: 0;
            top: 0;
            width: 320px;
            height: 100vh;
            background: white;
            box-shadow: -4px 0 20px rgba(0, 0, 0, 0.1);
            z-index: 999;
            overflow-y: auto;
            padding: 1.5rem;
            transform: translateX(0);
            transition: transform 0.3s ease;
        }

        .sidebar.hidden {
            transform: translateX(100%);
        }

        .sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .sidebar-header h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .toggle-sidebar {
            background: #f3f4f6;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .toggle-sidebar:hover {
            background: #e5e7eb;
        }

        /* ===== Search ===== */
        .search-box {
            margin-bottom: 1.5rem;
        }

        .search-box input {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            width: 100%;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .search-box input:focus {
            outline: none;
            border-color: #7c7cff;
            box-shadow: 0 0 0 3px rgba(124, 124, 255, 0.1);
        }

        /* ===== Distributor List ===== */
        .distributor-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .distributor-item {
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .distributor-item:hover {
            background: #f3f4f6;
            border-color: #7c7cff;
            transform: translateX(-4px);
        }

        .distributor-item.active {
            background: linear-gradient(135deg, #f5f3ff, #ede9fe);
            border-color: #7c7cff;
        }

        .distributor-item h5 {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 0.5rem 0;
        }

        .distributor-item .info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .distributor-item .info i {
            width: 16px;
            margin-left: 0.5rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .status-online {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-offline {
            background: #fee2e2;
            color: #dc2626;
        }

        /* ===== Map Container ===== */
        .map-container {
            margin-right: 320px;
            height: calc(100vh - 80px);
            margin-top: 80px;
            transition: margin-right 0.3s ease;
        }

        .map-container.full-width {
            margin-right: 0;
        }

        #map {
            width: 100%;
            height: 100%;
        }

        /* ===== Info Window ===== */
        .info-window-content {
            padding: 0.5rem;
            min-width: 200px;
        }

        .info-window-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .info-window-line {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            color: #4b5563;
        }

        .info-window-line i {
            width: 20px;
            color: #7c7cff;
        }

        /* ===== Toggle Button (Mobile) ===== */
        .toggle-sidebar-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #6f6af8, #7c7cff);
            color: white;
            border: none;
            border-radius: 50%;
            box-shadow: 0 8px 24px rgba(124, 124, 255, 0.4);
            z-index: 998;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .toggle-sidebar-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 32px rgba(124, 124, 255, 0.5);
        }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                transform: translateX(100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .map-container {
                margin-right: 0;
            }

            .toggle-sidebar-btn {
                display: flex;
            }

            .map-header {
                padding: 1rem;
            }

            .map-header h1 {
                font-size: 1.25rem;
            }
        }

        /* ===== Loading ===== */
        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: #f5f7fa;
        }

        .spinner {
            width: 48px;
            height: 48px;
            border: 4px solid #e5e7eb;
            border-top-color: #7c7cff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1S2XCTSIyNrvBM-cLyC3gQl0p7YmqsXY"></script>
</head>
<body>

    <!-- Header -->
    <div class="map-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1>
                <i class="las la-map-marked"></i>
                تتبع الموزعين
                <span class="badge" id="distributorsCount">0</span>
            </h1>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ backpack_url('dashboard') }}" class="btn btn-light btn-sm">
                    <i class="las la-home"></i>
                    الرئيسية
                </a>
                <button class="toggle-sidebar d-md-none" onclick="toggleSidebar()">
                    <i class="las la-bars"></i>
                </button>
                <button class="btn btn-light btn-sm" onclick="refreshLocations()">
                    <i class="las la-sync-alt"></i>
                    تحديث
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>قائمة الموزعين</h3>
            <button class="toggle-sidebar d-none d-md-block" onclick="toggleSidebar()">
                <i class="las la-times"></i>
            </button>
        </div>

        <div class="search-box">
            <input type="text" id="searchInput" placeholder="🔍 ابحث عن موزع..." onkeyup="filterDistributors()">
        </div>

        <div class="distributor-list" id="distributorList">
            <div class="text-center text-muted py-4">
                <i class="las la-spinner la-spin fs-3"></i>
                <p class="mt-2">جاري التحميل...</p>
            </div>
        </div>
    </div>

    <!-- Map Container -->
    <div class="map-container" id="mapContainer">
        <div id="map"></div>
    </div>

    <!-- Toggle Sidebar Button (Mobile) -->
    <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
        <i class="las la-list"></i>
    </button>

    <script>
        let map;
        let markers = {};
        let infoWindow = new google.maps.InfoWindow();
        let distributors = [];
        let activeDistributorId = null;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 31.5, lng: 35.0 },
                zoom: 11,
                styles: [
                    {
                        featureType: "poi",
                        elementType: "labels",
                        stylers: [{ visibility: "off" }]
                    }
                ]
            });

            loadDistributors();
            setInterval(loadDistributors, 5000); // تحديث كل 5 ثوان
        }

        function loadDistributors() {
            fetch("/api/drivers/locations")
                .then(response => response.json())
                .then(data => {
                    distributors = data;
                    updateDistributorsCount(data.length);
                    renderDistributorList(data);
                    updateMarkers(data);
                })
                .catch(err => {
                    console.error("Error loading distributors:", err);
                    document.getElementById("distributorList").innerHTML = `
                        <div class="text-center text-danger py-4">
                            <i class="las la-exclamation-triangle fs-3"></i>
                            <p class="mt-2">حدث خطأ في تحميل البيانات</p>
                        </div>
                    `;
                });
        }

        function updateDistributorsCount(count) {
            document.getElementById("distributorsCount").textContent = count;
        }

        function renderDistributorList(data) {
            const listContainer = document.getElementById("distributorList");
            
            if (data.length === 0) {
                listContainer.innerHTML = `
                    <div class="text-center text-muted py-4">
                        <i class="las la-inbox fs-3"></i>
                        <p class="mt-2">لا يوجد موزعين</p>
                    </div>
                `;
                return;
            }

            listContainer.innerHTML = data.map(dist => {
                const isOnline = dist.last_update && isRecentUpdate(dist.last_update);
                const statusClass = isOnline ? 'status-online' : 'status-offline';
                const statusText = isOnline ? 'نشط' : 'غير نشط';
                const activeClass = activeDistributorId === dist.id ? 'active' : '';

                return `
                    <div class="distributor-item ${activeClass}" onclick="focusDistributor(${dist.id})">
                        <h5>${dist.name || 'غير محدد'}</h5>
                        <div class="info">
                            <div><i class="las la-phone"></i> ${dist.phone || 'غير متوفر'}</div>
                            <div><i class="las la-clock"></i> ${formatLastUpdate(dist.last_update)}</div>
                        </div>
                        <span class="status-badge ${statusClass}">${statusText}</span>
                    </div>
                `;
            }).join('');
        }

        function updateMarkers(data) {
            // إنشاء مجموعة من IDs الموزعين الحاليين
            const currentIds = new Set(data.map(d => d.id));
            
            // حذف الـ markers التي لم تعد موجودة في البيانات
            Object.keys(markers).forEach(id => {
                if (!currentIds.has(parseInt(id))) {
                    markers[id].setMap(null);
                    delete markers[id];
                }
            });

            data.forEach(dist => {
                if (!dist.latitude || !dist.longitude) return;

                const pos = {
                    lat: parseFloat(dist.latitude),
                    lng: parseFloat(dist.longitude)
                };

                const id = dist.id;
                const isOnline = dist.last_update && isRecentUpdate(dist.last_update);

                if (!markers[id]) {
                    markers[id] = new google.maps.Marker({
                        map: map,
                        position: pos,
                        title: dist.name,
                        icon: {
                            url: "https://eliyaa.baitpait.space/logo/truck.png",
                            scaledSize: new google.maps.Size(50, 50),
                            anchor: new google.maps.Point(25, 50)
                        },
                        animation: isOnline ? google.maps.Animation.DROP : null,
                        visible: true // التأكد من أن الـ marker مرئي
                    });

                    markers[id].addListener("click", function () {
                        showInfo(dist, pos);
                        focusDistributor(id);
                    });
                } else {
                    // تحديث موضع الـ marker فقط إذا تغير
                    const currentPos = markers[id].getPosition();
                    if (currentPos.lat() !== pos.lat || currentPos.lng() !== pos.lng) {
                        markers[id].setPosition(pos);
                    }
                    
                    // التأكد من أن الـ marker مرئي
                    markers[id].setVisible(true);
                    
                    // تحديث الـ animation فقط إذا كان الموزع نشطاً
                    if (isOnline && markers[id].getAnimation() !== google.maps.Animation.DROP) {
                        markers[id].setAnimation(google.maps.Animation.DROP);
                    } else if (!isOnline && markers[id].getAnimation() !== null) {
                        markers[id].setAnimation(null);
                    }
                }
            });
        }

        function showInfo(dist, pos) {
            const isOnline = dist.last_update && isRecentUpdate(dist.last_update);
            const content = `
                <div class="info-window-content">
                    <div class="info-window-title">${dist.name || 'غير محدد'}</div>
                    <div class="info-window-line">
                        <i class="las la-phone"></i>
                        <span>${dist.phone || 'غير متوفر'}</span>
                    </div>
                    <div class="info-window-line">
                        <i class="las la-clock"></i>
                        <span>${formatLastUpdate(dist.last_update)}</span>
                    </div>
                    <div class="info-window-line">
                        <i class="las la-map-marker-alt"></i>
                        <span>${pos.lat.toFixed(6)}, ${pos.lng.toFixed(6)}</span>
                    </div>
                    <div class="info-window-line">
                        <i class="las la-circle"></i>
                        <span style="color: ${isOnline ? '#16a34a' : '#dc2626'}">
                            ${isOnline ? 'نشط الآن' : 'غير نشط'}
                        </span>
                    </div>
                </div>
            `;

            infoWindow.setContent(content);
            infoWindow.setPosition(pos);
            infoWindow.open(map, markers[dist.id]); // ربط InfoWindow بالـ marker مباشرة
            
            // التأكد من أن الـ marker مرئي بعد فتح InfoWindow
            if (markers[dist.id]) {
                markers[dist.id].setVisible(true);
            }
        }

        function focusDistributor(id) {
            const dist = distributors.find(d => d.id === id);
            if (!dist || !dist.latitude || !dist.longitude) return;

            activeDistributorId = id;
            renderDistributorList(distributors);

            const pos = {
                lat: parseFloat(dist.latitude),
                lng: parseFloat(dist.longitude)
            };

            map.setCenter(pos);
            map.setZoom(15);
            
            // التأكد من أن الـ marker مرئي قبل فتح InfoWindow
            if (markers[id]) {
                markers[id].setVisible(true);
                showInfo(dist, pos);
                
                markers[id].setAnimation(google.maps.Animation.BOUNCE);
                setTimeout(() => {
                    if (markers[id]) {
                        markers[id].setAnimation(null);
                    }
                }, 2000);
            }
        }

        function filterDistributors() {
            const searchTerm = document.getElementById("searchInput").value.toLowerCase();
            const items = document.querySelectorAll(".distributor-item");

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? 'block' : 'none';
            });
        }

        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const mapContainer = document.getElementById("mapContainer");
            
            sidebar.classList.toggle("hidden");
            sidebar.classList.toggle("show");
            mapContainer.classList.toggle("full-width");
        }

        function refreshLocations() {
            loadDistributors();
        }

        function isRecentUpdate(lastUpdate) {
            if (!lastUpdate) return false;
            const updateTime = new Date(lastUpdate);
            const now = new Date();
            const diffMinutes = (now - updateTime) / (1000 * 60);
            return diffMinutes < 10; // نشط إذا كان آخر تحديث أقل من 10 دقائق
        }

        function formatLastUpdate(lastUpdate) {
            if (!lastUpdate) return 'لم يتم التحديث';
            
            const updateTime = new Date(lastUpdate);
            const now = new Date();
            const diffMinutes = Math.floor((now - updateTime) / (1000 * 60));
            
            if (diffMinutes < 1) return 'الآن';
            if (diffMinutes < 60) return `منذ ${diffMinutes} دقيقة`;
            
            const diffHours = Math.floor(diffMinutes / 60);
            if (diffHours < 24) return `منذ ${diffHours} ساعة`;
            
            const diffDays = Math.floor(diffHours / 24);
            return `منذ ${diffDays} يوم`;
        }

        window.onload = initMap;
    </script>

</body>
</html>
