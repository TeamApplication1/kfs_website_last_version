<div class="row g-3 mb-5">
    <div class="col-6 col-md-4 col-lg-3 col-xl">
        <a href="{{ route('citizen.dashboard.services') }}" class="text-decoration-none">
            <div class="stat-card blue shadow-sm" style="padding:18px">
                <div class="card-inner d-flex align-items-center gap-2">
                    <div class="info flex-grow-1">
                        <h3 style="font-size:1.6rem">{{ $stats['services'] }}</h3>
                        <p style="font-size:0.7rem;margin:0">خدمات عامة</p>
                    </div>
                    <i class="fas fa-briefcase icon-bg" style="font-size:3rem"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-lg-3 col-xl">
        <a href="{{ route('citizen.dashboard.gis') }}" class="text-decoration-none">
            <div class="stat-card teal shadow-sm" style="padding:18px">
                <div class="card-inner d-flex align-items-center gap-2">
                    <div class="info flex-grow-1">
                        <h3 style="font-size:1.6rem">{{ $stats['gis'] }}</h3>
                        <p style="font-size:0.7rem;margin:0">خدمات مكانية</p>
                    </div>
                    <i class="fas fa-map-marked-alt icon-bg" style="font-size:3rem"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-lg-3 col-xl">
        <a href="{{ route('citizen.dashboard.estidama') }}" class="text-decoration-none">
            <div class="stat-card green shadow-sm" style="padding:18px">
                <div class="card-inner d-flex align-items-center gap-2">
                    <div class="info flex-grow-1">
                        <h3 style="font-size:1.6rem">{{ $stats['estidama'] }}</h3>
                        <p style="font-size:0.7rem;margin:0">استدامة</p>
                    </div>
                    <i class="fas fa-graduation-cap icon-bg" style="font-size:3rem"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-lg-3 col-xl">
        <a href="{{ route('citizen.dashboard.monitoring') }}" class="text-decoration-none">
            <div class="stat-card gold shadow-sm" style="padding:18px">
                <div class="card-inner d-flex align-items-center gap-2">
                    <div class="info flex-grow-1">
                        <h3 style="font-size:1.6rem">{{ $stats['complaints'] }}</h3>
                        <p style="font-size:0.7rem;margin:0">شكاوي</p>
                    </div>
                    <i class="fas fa-clipboard-list icon-bg" style="font-size:3rem"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-lg-3 col-xl">
        <a href="{{ route('citizen.dashboard.monitoring') }}" class="text-decoration-none">
            <div class="stat-card purple shadow-sm" style="padding:18px">
                <div class="card-inner d-flex align-items-center gap-2">
                    <div class="info flex-grow-1">
                        <h3 style="font-size:1.6rem">{{ $stats['suggestions'] }}</h3>
                        <p style="font-size:0.7rem;margin:0">مقترحات</p>
                    </div>
                    <i class="fas fa-lightbulb icon-bg" style="font-size:3rem"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-lg-3 col-xl">
        <a href="{{ route('citizen.dashboard.monitoring') }}" class="text-decoration-none">
            <div class="stat-card orange shadow-sm" style="padding:18px">
                <div class="card-inner d-flex align-items-center gap-2">
                    <div class="info flex-grow-1">
                        <h3 style="font-size:1.6rem">{{ $stats['contactMessages'] }}</h3>
                        <p style="font-size:0.7rem;margin:0">رسائل تواصل</p>
                    </div>
                    <i class="fas fa-envelope icon-bg" style="font-size:3rem"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-lg-3 col-xl">
        <a href="{{ route('citizen.dashboard.monitoring') }}" class="text-decoration-none">
            <div class="stat-card red shadow-sm" style="padding:18px">
                <div class="card-inner d-flex align-items-center gap-2">
                    <div class="info flex-grow-1">
                        <h3 style="font-size:1.6rem">{{ $stats['emergencyReports'] }}</h3>
                        <p style="font-size:0.7rem;margin:0">بلاغات طوارئ</p>
                    </div>
                    <i class="fas fa-shield-alt icon-bg" style="font-size:3rem"></i>
                </div>
            </div>
        </a>
    </div>
</div>