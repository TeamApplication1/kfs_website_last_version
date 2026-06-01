<div class="top-nav-dash bg-white shadow-sm mb-4 px-4 py-2">
    <div class="d-flex justify-content-between align-items-center w-100">
        <div class="brand-box d-flex align-items-center gap-3">
            <a href="{{ route('citizen.dashboard') }}" class="text-decoration-none">
                <img src="{{ Storage::url($settings['site_logo_header'] ?? '') }}" height="45"
                    class="me-2" alt="logo">
            </a>
            <div class="d-none d-md-block">
                <h6 class="mb-0 fw-bold" style="color:var(--dash-navy);font-size:0.95rem">{{ $settings['site_name'] ?? 'محافظة كفر الشيخ' }}</h6>
                <span class="small" style="color:#8492a6">بوابة المواطن الإلكترونية</span>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if (auth()->user()->isEmployee())
                <a href="{{ route('employee.erp.index') }}"
                    class="btn btn-outline-dark btn-sm rounded-pill px-3">
                    <i class="fas fa-laptop-code me-1"></i> بوابة الموظفين
                </a>
            @endif
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 d-none d-md-inline-flex">
                <i class="fas fa-home ms-1"></i> الرئيسية
            </a>
            <div class="dropdown d-inline-block">
                <button class="btn btn-light border rounded-pill px-3 py-1 dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle" style="color:var(--dash-gold);font-size:1.2rem"></i>
                    <span class="small fw-bold d-none d-md-inline" style="color:var(--dash-navy)">{{ $user->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 p-2" style="min-width:180px">
                    <li><span class="dropdown-item-text small text-muted">{{ $user->email }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item rounded-2 py-2" href="{{ route('citizen.dashboard') }}">
                            <i class="fas fa-th-large ms-2" style="color:var(--dash-gold)"></i>لوحة التحكم
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item rounded-2 py-2 text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off ms-2"></i>تسجيل خروج
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>