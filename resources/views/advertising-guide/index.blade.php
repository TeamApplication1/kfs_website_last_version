@extends('layouts.app')
@section('title', 'الدليل الإرشادي للإعلانات')
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        html, body { height: 100%; overflow: hidden; }
        #page-wrapper { display: flex; flex-direction: column; height: 100vh; overflow: hidden; }
        .ad-guide-page { flex: 1; display: flex; flex-direction: column; background: #0a0f1a; font-family: 'Cairo', sans-serif; position: relative; min-height: 0; }

        #map { flex: 1; width: 100%; z-index: 1; min-height: 0; }

        .map-controls {
            position: absolute;
            top: 200px;
            left: 20px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .map-controls .ctrl-btn {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            border: none;
            background: rgba(15, 23, 36, 0.85);
            backdrop-filter: blur(8px);
            color: #d4a843;
            font-size: 1.1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3);
        }

        .map-controls .ctrl-btn:hover {
            background: #1a2740;
            transform: scale(1.05);
        }

        .map-controls .ctrl-btn.active {
            background: #d4a843;
            color: #0f1724;
        }

        /* Side panel */
        .side-panel {
            position: absolute;
            top: 280px;
            right: 20px;
            z-index: 1000;
            width: 320px;
            max-height: calc(100vh - 140px);
            background: rgba(15, 23, 36, 0.92);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s, opacity 0.3s;
        }

        .side-panel.collapsed {
            transform: translateX(340px);
            opacity: 0;
            pointer-events: none;
        }

        .side-panel-header {
            padding: 16px 20px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .side-panel-header h5 {
            margin: 0;
            font-weight: 800;
            color: #fff;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        .side-panel-header .collapse-btn {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            font-size: 1rem;
            padding: 0;
        }

        .side-panel-search {
            padding: 12px 20px;
        }

        .side-panel-search input {
            width: 100%;
            padding: 8px 14px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            font-size: 0.82rem;
            outline: none;
            font-family: 'Cairo', sans-serif;
        }

        .side-panel-search input::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        .side-panel-list {
            flex: 1;
            overflow-y: auto;
            padding: 4px 12px 12px;
        }

        .side-panel-list::-webkit-scrollbar {
            width: 4px;
        }

        .side-panel-list::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .street-group {
            margin-bottom: 4px;
        }

        .street-group-header {
            padding: 10px 12px;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 600;
            font-size: 0.85rem;
        }

        .street-group-header:hover {
            background: rgba(255, 255, 255, 0.04);
            color: #fff;
        }

        .street-group-header .badge-ct {
            background: rgba(212, 168, 67, 0.15);
            color: #d4a843;
            border-radius: 50px;
            padding: 1px 10px;
            font-size: 0.7rem;
            font-weight: 800;
        }

        .street-group-header .arrow {
            transition: transform 0.2s;
            display: inline-block;
            margin-left: 6px;
        }

        .street-group-header .arrow.open {
            transform: rotate(90deg);
        }

        .street-items {
            padding-right: 12px;
            display: none;
        }

        .street-items.open {
            display: block;
        }

        .street-ad-item {
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.55);
            border-right: 2px solid transparent;
            margin-bottom: 2px;
        }

        .street-ad-item:hover {
            background: rgba(255, 255, 255, 0.04);
            color: #fff;
            border-right-color: #d4a843;
        }

        .street-ad-item .ad-type-tag {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-left: 6px;
        }

        /* Hero info bar */
        .info-bar {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            background: rgba(15, 23, 36, 0.85);
            backdrop-filter: blur(8px);
            border-radius: 50px;
            padding: 8px 28px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            direction: ltr;
            white-space: nowrap;
        }

        .info-bar h1 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 800;
            color: #fff;
            display: inline;
        }

        .info-bar span {
            color: #d4a843;
        }

        .info-bar .sub {
            color: rgba(255, 255, 255, 0.35);
            font-size: 0.75rem;
            margin-right: 10px;
        }

        /* Measurement display */
        .measure-display {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            background: rgba(15, 23, 36, 0.9);
            backdrop-filter: blur(8px);
            border-radius: 14px;
            padding: 10px 24px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            color: #fff;
            font-weight: 700;
            font-size: 0.9rem;
            display: none;
            direction: ltr;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        .measure-display.show {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .measure-display .val {
            color: #d4a843;
            font-size: 1.1rem;
        }

        .measure-display .close-measure {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            padding: 0 4px;
            font-size: 1rem;
        }

        /* Popup */
        .ad-popup .leaflet-popup-content-wrapper {
            background: #0f1724;
            color: #fff;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .ad-popup .leaflet-popup-tip {
            background: #0f1724;
        }

        .ad-popup .form-control,
        .ad-popup .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            border-radius: 8px;
            font-size: 0.82rem;
        }

        .ad-popup .form-control:focus,
        .ad-popup .form-select:focus {
            border-color: #d4a843;
            box-shadow: 0 0 0 2px rgba(212, 168, 67, 0.15);
        }

        .ad-popup .form-label {
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
        }

        .leaflet-control-zoom a {
            background: rgba(15, 23, 36, 0.85) !important;
            color: #d4a843 !important;
            border-color: rgba(255, 255, 255, 0.06) !important;
        }

        .leaflet-control-zoom {
            border: none !important;
        }

        @media (max-width: 991px) {
            .info-bar { padding: 6px 18px; }
            .info-bar h1 { font-size: 0.8rem; }
            .info-bar .sub { font-size: 0.65rem; margin-right: 6px; }
            .map-controls { top: auto; bottom: 100px; left: 10px; }
        }

        @media (max-width: 767px) {
            .side-panel {
                width: 280px;
                right: 10px;
                top: 10px;
                max-height: calc(100vh - 180px);
            }

            .side-panel.collapsed {
                transform: translateX(300px);
            }

            .info-bar { display: none; }

            .map-controls {
                top: auto;
                bottom: 90px;
                left: 10px;
            }

            .measure-display {
                bottom: 80px;
                font-size: 0.7rem;
                padding: 6px 14px;
                max-width: calc(100% - 80px);
                white-space: nowrap;
                overflow-x: auto;
            }
        }

        @media (max-width: 480px) {
            .side-panel {
                width: 260px;
                right: 5px;
                top: 5px;
                max-height: calc(100vh - 170px);
                border-radius: 12px;
            }
            .map-controls { bottom: 85px; left: 5px; }
            .map-controls .ctrl-btn { width: 36px; height: 36px; font-size: 0.8rem; }
            .ctrl-btn { width: 36px; height: 36px; font-size: 0.8rem; }
            .measure-display { bottom: 75px; left: 5px; max-width: calc(100% - 60px); font-size: 0.65rem; padding: 4px 10px; }
        }
    </style>
@endpush

@section('content')
    <main class="ad-guide-page">
        <div id="map"></div>

        <!-- Info bar -->
        <div class="info-bar">
            <h1><span>الدليل الإرشادي</span> للإعلانات</h1>
            <span class="sub">محافظة كفر الشيخ</span>
        </div>

    <!-- Left controls -->
    <div class="map-controls" id="mapControls">
        <button class="ctrl-btn" id="toggleSidebarBtn" title="قائمة الشوارع"><i class="fas fa-list"></i></button>
        <button class="ctrl-btn" id="toggleMeasureBtn" title="قياس المسافة"><i class="fas fa-ruler"></i></button>
        <button class="ctrl-btn" id="resetViewBtn" title="العرض الافتراضي"><i class="fas fa-home"></i></button>
        @auth
        <button class="ctrl-btn" id="addPointBtn" title="إضافة إعلان" style="background:rgba(212,168,67,0.25);color:#d4a843"><i class="fas fa-plus"></i></button>
        @endauth
    </div>

        <!-- Side panel -->
        <div class="side-panel" id="sidePanel">
            <div class="side-panel-header">
                <h5><i class="fas fa-road ms-2" style="color:#d4a843"></i> الشوارع</h5>
                <button class="collapse-btn" id="collapseSidebarBtn"><i class="fas fa-times"></i></button>
            </div>
            <div class="side-panel-search">
                <input type="text" id="streetSearch" placeholder="ابحث عن شارع...">
            </div>
            <div class="side-panel-list" id="streetList">
                <div class="text-center py-4" style="color:rgba(255,255,255,0.2)">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                </div>
            </div>
        </div>

        <!-- Measure display -->
        <div class="measure-display" id="measureDisplay">
            <span>المسافة: <span class="val" id="measureVal">0</span> م</span>
            <span style="color:rgba(255,255,255,0.2)">|</span>
            <span>أضف نقاط متعددة — انقر مرتين للإنهاء</span>
            <button class="close-measure" id="closeMeasure"><i class="fas fa-times"></i></button>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
        const isAdmin = {{ auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin')) ? 'true' : 'false' }};

        // ── Map ──
        const map = L.map('map', {
            center: [31.110, 30.940],
            zoom: 13,
            zoomControl: true,
        });

        // Google Earth style: Esri satellite + labels
        const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 20,
            maxNativeZoom: 18,
            attribution: '&copy; Esri, Maxar, Earthstar Geographics'
        }).addTo(map);

        const labels = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 17,
                maxNativeZoom: 17,
                attribution: '&copy; Esri'
            }).addTo(map);

        // Fix map container sizing issues
        function fixMapSize() {
            map.invalidateSize();
        }
        setTimeout(fixMapSize, 200);
        setTimeout(fixMapSize, 600);
        window.addEventListener('resize', fixMapSize);
        // Forces recalc if navbar/footer shift layout
        const observer = new ResizeObserver(fixMapSize);
        observer.observe(document.getElementById('map'));

        // Fallback: if satellite tiles fail, use OSM
        let fallbackAdded = false;
        map.on('tileerror', function(e) {
            if (fallbackAdded) return;
            fallbackAdded = true;
            map.removeLayer(satellite);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
        });

        const markers = L.featureGroup().addTo(map);
        const typeColors = {
            'لافتة': '#3498db',
            'باص': '#e74c3c',
            'تليفزيوني': '#2ecc71',
            'إلكتروني': '#f39c12',
            default: '#9b59b6'
        };

        function iconColor(type) {
            const c = typeColors[type] || typeColors.default;
            return L.divIcon({
                html: `<div style="position:relative;width:30px;height:42px">
                    <svg viewBox="0 0 24 36" width="30" height="42">
                        <path d="M12 0C5.4 0 0 5.4 0 12c0 9 12 24 12 24s12-15 12-24C24 5.4 18.6 0 12 0z" fill="${c}" stroke="#fff" stroke-width="1.5"/>
                        <circle cx="12" cy="12" r="5" fill="#fff"/>
                    </svg>
                </div>`,
                iconSize: [30, 42],
                iconAnchor: [15, 42],
                popupAnchor: [0, -42],
                className: ''
            });
        }

        let allAds = [];

        function loadPoints() {
            fetch('/advertising-guide/points')
                .then(r => r.json())
                .then(data => {
                    allAds = data;
                    markers.clearLayers();
                    buildStreets(data);
                    data.forEach(ad => {
                        const m = L.marker([ad.lat, ad.lng], {
                                icon: iconColor(ad.type)
                            })
                            .bindPopup(buildPopup(ad), {
                                className: 'ad-popup'
                            });
                        markers.addLayer(m);
                    });
                });
        }

        // ── Streets sidebar ──
        function buildStreets(ads) {
            const groups = {};
            ads.forEach(a => {
                if (!groups[a.street_name]) groups[a.street_name] = [];
                groups[a.street_name].push(a);
            });

            const container = document.getElementById('streetList');
            let html = '';
            const sorted = Object.keys(groups).sort((a, b) => groups[b].length - groups[a].length || a.localeCompare(b,
                'ar'));

            sorted.forEach((street, si) => {
                const items = groups[street];
                html += `<div class="street-group" data-street="${street}">
            <div class="street-group-header" onclick="toggleStreet(this)">
                <span><span class="arrow">❮</span> ${street}</span>
                <span class="badge-ct">${items.length}</span>
            </div>
            <div class="street-items">`;
                items.forEach(ad => {
                    html += `<div class="street-ad-item" onclick="flyTo(${ad.lat},${ad.lng},${ad.id})">
                <span class="ad-type-tag" style="background:${typeColors[ad.type]||typeColors.default}"></span>
                ${ad.type} ${ad.height ? '· ' + ad.height + 'م' : ''} ${ad.size ? '· ' + ad.size : ''}
            </div>`;
                });
                html += `</div></div>`;
            });

            if (!sorted.length) {
                html = '<div class="text-center py-4" style="color:rgba(255,255,255,0.2)">لا توجد إعلانات بعد.</div>';
            }

            container.innerHTML = html;
            // Auto-open first
            const first = container.querySelector('.street-items');
            if (first) {
                first.classList.add('open');
                container.querySelector('.arrow')?.classList.add('open');
            }
        }

        function toggleStreet(el) {
            const items = el.nextElementSibling;
            const arrow = el.querySelector('.arrow');
            items.classList.toggle('open');
            arrow.classList.toggle('open');
        }

        // ── Search ──
        document.getElementById('streetSearch')?.addEventListener('input', function() {
            const q = this.value.trim();
            document.querySelectorAll('.street-group').forEach(g => {
                const name = g.dataset.street;
                const match = !q || name.includes(q);
                g.style.display = match ? '' : 'none';
                if (match && q) {
                    g.querySelector('.street-items')?.classList.add('open');
                    g.querySelector('.arrow')?.classList.add('open');
                }
            });
        });

        // ── Fly to / highlight ──
        let activeMarkerLayer = null;

        function flyTo(lat, lng, id) {
            map.flyTo([lat, lng], 17);
            if (activeMarkerLayer) {
                map.removeLayer(activeMarkerLayer);
                activeMarkerLayer = null;
            }
            activeMarkerLayer = L.circleMarker([lat, lng], {
                radius: 20,
                color: '#d4a843',
                fillColor: '#d4a843',
                fillOpacity: 0.15,
                weight: 2
            }).addTo(map);
            setTimeout(() => {
                markers.eachLayer(l => {
                    const ll = l.getLatLng();
                    if (Math.abs(ll.lat - lat) < 0.0001 && Math.abs(ll.lng - lng) < 0.0001) {
                        l.openPopup();
                    }
                });
            }, 500);
        }

        function buildPopup(ad) {
            return `<div style="font-family:'Cairo',sans-serif;min-width:200px">
        <h6 style="margin:0 0 6px;font-weight:800;color:#d4a843">${ad.type}</h6>
        <p style="margin:0 0 4px;font-size:0.82rem;color:rgba(255,255,255,0.6)"><i class="fas fa-map-pin ms-1"></i> ${ad.street_name}</p>
        ${ad.height ? `<p style="margin:0 0 4px;font-size:0.82rem;color:rgba(255,255,255,0.6)"><i class="fas fa-ruler-vertical ms-1"></i> الارتفاع: ${ad.height} م</p>` : ''}
        ${ad.size ? `<p style="margin:0 0 4px;font-size:0.82rem;color:rgba(255,255,255,0.6)"><i class="fas fa-expand ms-1"></i> المقاس: ${ad.size}</p>` : ''}
        ${ad.description ? `<p style="margin:0 0 6px;font-size:0.82rem;color:rgba(255,255,255,0.4)">${ad.description}</p>` : ''}
        ${isAdmin ? `<hr style="margin:8px 0;border-color:rgba(255,255,255,0.06)">
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm flex-fill" style="background:#d4a843;color:#0f1724;font-weight:700;border:none;border-radius:50px" onclick="editAd(${ad.id})">تعديل</button>
                        <button class="btn btn-sm flex-fill" style="background:rgba(255,255,255,0.06);color:#e74c3c;font-weight:700;border:none;border-radius:50px" onclick="deleteAd(${ad.id})">حذف</button>
                    </div>` : ''}
    </div>`;
        }

        // ── Measurement tool ──
        let measuring = false;
        let measurePoints = [];
        let measurePolyline = null;
        let measureMarkers = [];

        document.getElementById('toggleMeasureBtn')?.addEventListener('click', function() {
            clearMeasure();
            measuring = !measuring;
            this.classList.toggle('active');
            document.getElementById('measureDisplay').classList.toggle('show', measuring);
        });

        document.getElementById('closeMeasure')?.addEventListener('click', function() {
            measuring = false;
            document.getElementById('toggleMeasureBtn').classList.remove('active');
            document.getElementById('measureDisplay').classList.remove('show');
            clearMeasure();
        });

        function clearMeasure() {
            measurePoints = [];
            if (measurePolyline) {
                map.removeLayer(measurePolyline);
                measurePolyline = null;
            }
            measureMarkers.forEach(m => map.removeLayer(m));
            measureMarkers = [];
            document.getElementById('measureVal').textContent = '0';
        }

        map.on('click', function(e) {
            if (!measuring) {
                // If sidebar open and clicking outside, close measurement pulse
                return;
            }
            const latlng = e.latlng;
            measurePoints.push(latlng);

            const marker = L.circleMarker(latlng, {
                radius: 6,
                color: '#fff',
                fillColor: '#ff4444',
                fillOpacity: 1,
                weight: 2
            }).addTo(map);
            measureMarkers.push(marker);

            if (measurePoints.length >= 2) {
                if (measurePolyline) map.removeLayer(measurePolyline);
                const totalM = measurePoints.reduce((sum, p, i) => {
                    if (i === 0) return 0;
                    return sum + p.distanceTo(measurePoints[i - 1]);
                }, 0);
                measurePolyline = L.polyline(measurePoints, {
                    color: '#ff4444',
                    weight: 3,
                    dashArray: '8, 6',
                    opacity: 0.95
                }).addTo(map);

                document.getElementById('measureVal').textContent = totalM < 1000 ?
                    totalM.toFixed(1) + ' م' :
                    (totalM / 1000).toFixed(2) + ' كم';
            }
        });

        // Double-click to finish measurement
        map.on('dblclick', function(e) {
            if (!measuring) return;
            measuring = false;
            document.getElementById('toggleMeasureBtn').classList.remove('active');
            e.originalEvent?.preventDefault();
            return false;
        });

        // ── Sidebar toggle ──
        document.getElementById('toggleSidebarBtn')?.addEventListener('click', function() {
            document.getElementById('sidePanel').classList.toggle('collapsed');
        });
        document.getElementById('collapseSidebarBtn')?.addEventListener('click', function() {
            document.getElementById('sidePanel').classList.add('collapsed');
        });

        // ── Reset view ──
        document.getElementById('resetViewBtn')?.addEventListener('click', function() {
            map.setView([31.110, 30.940], 13);
            if (activeMarkerLayer) {
                map.removeLayer(activeMarkerLayer);
                activeMarkerLayer = null;
            }
        });

        function showAddForm(lat, lng) {
            const form = document.createElement('div');
            form.innerHTML = `
        <h6 style="font-weight:800;margin:0 0 10px;color:#d4a843">إضافة إعلان جديد</h6>
        <label class="form-label">الشارع *</label>
        <input class="form-control" id="f-street" placeholder="اسم الشارع">
        <label class="form-label">نوع الإعلان *</label>
        <select class="form-select" id="f-type">
            <option value="لافتة">لافتة</option>
            <option value="باص">باص</option>
            <option value="تليفزيوني">تليفزيوني</option>
            <option value="إلكتروني">إلكتروني</option>
            <option value="أخرى">أخرى</option>
        </select>
        <label class="form-label">الارتفاع (م)</label>
        <input class="form-control" id="f-height" type="number" step="0.1" placeholder="متر">
        <label class="form-label">المقاس</label>
        <input class="form-control" id="f-size" placeholder="مثلاً 3×2 م">
        <label class="form-label">وصف</label>
        <textarea class="form-control" id="f-desc" rows="2"></textarea>
        <div class="d-flex gap-2 mt-2">
            <button class="btn btn-sm flex-fill" style="background:#d4a843;color:#0f1724;font-weight:700;border:none;border-radius:50px" onclick="saveAd(${lat},${lng})">حفظ</button>
            <button class="btn btn-sm flex-fill" style="background:rgba(255,255,255,0.06);color:#fff;font-weight:700;border:none;border-radius:50px" onclick="map.closePopup()">إلغاء</button>
        </div>
    `;
            L.popup({
                    maxWidth: 300,
                    className: 'ad-popup'
                })
                .setLatLng([lat, lng])
                .setContent(form)
                .openOn(map);
        }

        function saveAd(lat, lng) {
            const val = id => { const v = document.getElementById(id)?.value; return v === '' ? null : v; };
            const data = {
                street_name: val('f-street'),
                type: val('f-type'),
                height: val('f-height'),
                size: val('f-size'),
                description: val('f-desc'),
                lat,
                lng,
            };
            fetch('/advertising-guide/points', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data),
                })
                .then(async r => {
                    if (!r.ok) {
                        const body = await r.text();
                        throw new Error('فشل الحفظ (' + r.status + ')');
                    }
                    return r.json();
                })
                .then(() => {
                    map.closePopup();
                    loadPoints();
                })
                .catch(e => alert('خطأ: ' + e.message));
        }

        function editAd(id) {
            const ad = allAds.find(a => a.id === id);
            if (!ad) return;
            const form = document.createElement('div');
            form.innerHTML = `
        <h6 style="font-weight:800;margin:0 0 10px;color:#d4a843">تعديل الإعلان</h6>
        <label class="form-label">الشارع *</label>
        <input class="form-control" id="ef-street" value="${ad.street_name}">
        <label class="form-label">النوع *</label>
        <select class="form-select" id="ef-type">
            ${['لافتة','باص','تليفزيوني','إلكتروني','أخرى'].map(t =>
                `<option value="${t}" ${ad.type === t ? 'selected' : ''}>${t}</option>`
            ).join('')}
        </select>
        <label class="form-label">الارتفاع (م)</label>
        <input class="form-control" id="ef-height" type="number" step="0.1" value="${ad.height || ''}">
        <label class="form-label">المقاس</label>
        <input class="form-control" id="ef-size" value="${ad.size || ''}">
        <label class="form-label">وصف</label>
        <textarea class="form-control" id="ef-desc" rows="2">${ad.description || ''}</textarea>
        <div class="d-flex gap-2 mt-2">
            <button class="btn btn-sm flex-fill" style="background:#d4a843;color:#0f1724;font-weight:700;border:none;border-radius:50px" onclick="updateAd(${id})">حفظ</button>
            <button class="btn btn-sm flex-fill" style="background:rgba(255,255,255,0.06);color:#fff;font-weight:700;border:none;border-radius:50px" onclick="map.closePopup()">إلغاء</button>
        </div>
    `;
            map.closePopup();
            L.popup({
                    maxWidth: 300,
                    className: 'ad-popup'
                })
                .setLatLng([ad.lat, ad.lng])
                .setContent(form)
                .openOn(map);
        }

        function updateAd(id) {
            const ad = allAds.find(a => a.id === id);
            const val = id => { const v = document.getElementById(id)?.value; return v === '' ? null : v; };
            const data = {
                street_name: val('ef-street'),
                type: val('ef-type'),
                height: val('ef-height'),
                size: val('ef-size'),
                description: val('ef-desc'),
                lat: ad.lat,
                lng: ad.lng,
            };
            fetch(`/advertising-guide/points/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data),
                })
                .then(async r => {
                    if (!r.ok) {
                        const body = await r.text();
                        throw new Error('فشل التحديث (' + r.status + ')');
                    }
                    return r.json();
                })
                .then(() => {
                    map.closePopup();
                    loadPoints();
                })
                .catch(e => alert('خطأ: ' + e.message));
        }

        function deleteAd(id) {
            if (!confirm('هل تريد حذف هذا الإعلان?')) return;
            fetch(`/advertising-guide/points/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(r => {
                    if (!r.ok) throw new Error('فشل الحذف');
                    map.closePopup();
                    loadPoints();
                })
                .catch(e => alert('خطأ: ' + e.message));
        }

        // ── Add mode: click on map to place a point ──
        let addModeActive = false;

        document.getElementById('addPointBtn')?.addEventListener('click', function() {
            addModeActive = !addModeActive;
            this.style.background = addModeActive ? '#d4a843' : 'rgba(212,168,67,0.25)';
            this.style.color = addModeActive ? '#0f1724' : '#d4a843';
            if (addModeActive) {
                map.getContainer().style.cursor = 'crosshair';
            } else {
                map.getContainer().style.cursor = '';
            }
        });

        map.on('click', function(e) {
            if (addModeActive && !measuring) {
                addModeActive = false;
                document.getElementById('addPointBtn').style.background = 'rgba(212,168,67,0.25)';
                document.getElementById('addPointBtn').style.color = '#d4a843';
                map.getContainer().style.cursor = '';
                showAddForm(e.latlng.lat, e.latlng.lng);
            }
        });

        // ── Right-click also adds point ──
        map.on('contextmenu', function(e) {
            showAddForm(e.latlng.lat, e.latlng.lng);
        });

        loadPoints();
    </script>
@endpush
