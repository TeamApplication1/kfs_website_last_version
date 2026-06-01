<aside class="dashboard-sidebar shadow-sm">
    <div class="sidebar-sticky-top">
        <div class="user-profile-section">
            <div class="avatar-box">
                <i class="fas fa-user"></i>
                <span class="online-indicator"></span>
            </div>
            <h5 class="user-name">{{ $user->name }}</h5>
            <p class="user-role">مواطن مفعل</p>
        </div>

        <nav class="sidebar-nav-custom">
            <div class="nav-group">
                <label>الرئيسية</label>
                <a href="{{ route('citizen.dashboard') }}" class="nav-item {{ $activeNav === 'overview' ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> <span>نظرة عامة</span>
                </a>
            </div>

            <div class="nav-group">
                <label>طلباتي</label>
                <a href="{{ route('citizen.dashboard.services') }}" class="nav-item {{ $activeNav === 'services' ? 'active' : '' }}">
                    <i class="fas fa-briefcase"></i> <span>خدمات عامة</span>
                </a>
                <a href="{{ route('citizen.dashboard.gis') }}" class="nav-item {{ $activeNav === 'gis' ? 'active' : '' }}">
                    <i class="fas fa-map-marked-alt"></i> <span>خدمات مكانية</span>
                </a>
                <a href="{{ route('citizen.dashboard.estidama') }}" class="nav-item {{ $activeNav === 'estidama' ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap"></i> <span>استدامة</span>
                </a>
            </div>

            <div class="nav-group">
                <label>التواصل والمراقبة</label>
                <a href="{{ route('citizen.dashboard.monitoring') }}" class="nav-item {{ $activeNav === 'monitoring' ? 'active' : '' }}">
                    <i class="fas fa-comments-alt"></i> <span>الشكاوي والمقترحات</span>
                </a>
                <a href="{{ route('citizen.dashboard.fulfillment') }}" class="nav-item {{ $activeNav === 'fulfillment' ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i> <span>الاستيفاء والمتابعة</span>
                    @if (isset($fulfillmentCount) && $fulfillmentCount > 0)
                        <span class="badge bg-warning text-dark me-auto" style="font-size:0.7rem;padding:2px 8px">{{ $fulfillmentCount }}</span>
                    @endif
                </a>
            </div>

            <div class="nav-group">
                <label>خدمات التقديم</label>
                <a href="{{ route('services.index') }}" class="nav-item">
                    <i class="fas fa-concierge-bell"></i> <span>دليل الخدمات</span>
                </a>
                <a href="{{ route('complaints.create') }}" class="nav-item">
                    <i class="fas fa-exclamation-triangle"></i> <span>تقديم شكوى</span>
                </a>
                <a href="{{ route('suggestions.create') }}" class="nav-item">
                    <i class="fas fa-lightbulb"></i> <span>إضافة مقترح</span>
                </a>
                <a href="{{ route('emergency.create') }}" class="nav-item">
                    <i class="fas fa-shield-alt"></i> <span>بلاغ طوارئ</span>
                </a>
                <a href="{{ route('surveys.service.create') }}" class="nav-item">
                    <i class="fas fa-star"></i> <span>تقييم الأداء</span>
                </a>
            </div>

            <div class="nav-group">
                <label>أدوات الاستكشاف</label>
                <a href="{{ route('directory.index') }}" class="nav-item">
                    <i class="fas fa-map-signs"></i> <span>دليل المناطق</span>
                </a>
                <a href="{{ route('governorate.map') }}" class="nav-item">
                    <i class="fas fa-globe-asia"></i> <span>الخريطة التفاعلية</span>
                </a>
                <a href="{{ route('estidama.index') }}" class="nav-item">
                    <i class="fas fa-leaf"></i> <span>منصة استدامة</span>
                </a>
            </div>

            <div class="nav-group">
                <label>الحساب</label>
                <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> <span>تسجيل خروج</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </nav>
    </div>
</aside>