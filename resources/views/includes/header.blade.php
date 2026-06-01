<!-- ======================= Header Start ======================= -->
<header class="header-main">
    <div class="top-bar" id="top-bar">
        <div class="container d-flex justify-content-center justify-content-md-between align-items-center">

            <div class="d-none d-md-block date-time" id="date-time-container">
            </div>

            <div class="social-links d-flex align-items-center">
                <span>الموقع الان تجريبي وسيتم اطلاقه قريبا </span>
                <!-- <span>تابعنا علي مواقع التواصل الاجتماعي</span> -->
                <!-- <a href="https://x.com/kfs_gov" aria-label="X"><i class="fab fa-x-twitter"></i></a>
                <a href="https://www.facebook.com/KafrelsheikhGovernorate" aria-label="Facebook"><i
                        class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/kafr_elsheikh_gov" aria-label="Instagram"><i
                        class="fab fa-instagram"></i></a>
                <a href="https://youtube.com/@kafrelsheikhgovernorate583" aria-label="YouTube"><i
                        class="fab fa-youtube"></i></a>
                <a href="https://whatsapp.com/channel/0029VadcREoLI8YgR28sFz40" aria-label="WhatsApp"><i
                        class="fab fa-whatsapp"></i></a>
                <a href="#" aria-label="Telegram"><i class="fab fa-telegram-plane"></i></a>
                <a href="https://www.threads.net/kafr_elsheikh_gov" aria-label="threads"><i
                        class="fab fa-threads"></i></a>
                <a href="https://www.tiktok.com/@kfs_gov" aria-label="TikTok"><i class="fab fa-tiktok"></i></a> -->
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm main-nav">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ Storage::url($settings['site_logo_header']) }}" alt="شعار المحافظة" class="logo-img" />
            </a>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">الرئيسية</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            عن المحافظة
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
                            <li><a class="dropdown-item" href="{{ route('about') }}">عن المحافظة </a></li>
                            {{-- <li><a class="dropdown-item" href="#">إنجازات الدولة بالمحافظة</a></li> --}}
                            <li><a class="dropdown-item" href="{{ route('about.governor') }}">كلمة المحافظ</a></li>

                            {{-- This is the multi-level dropdown --}}
                            <li class="dropdown-submenu">
                                <a class="dropdown-item" href="#">
                                    قيادات المحافظة
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('officials.show', ['role' => 'governor']) }}">المحافظ</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('officials.show', ['role' => 'deputy-governor']) }}">نائب
                                            المحافظ</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('officials.show', ['role' => 'secretary-general']) }}">السكرتير
                                            العام</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('officials.show', ['role' => 'assistant-secretary-general']) }}">السكرتير
                                            العام المساعد</a></li>
                                </ul>
                            </li>

                            <li><a class="dropdown-item" href="{{ route('governorate.map') }}">خريطة المحافظة</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('posts.index') ? 'active' : '' }}"
                            href="{{ route('posts.index') }}">الأخبار</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link " href="{{ route('services.index') }}">
                            الخدمات
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('projects.index') ? 'active' : '' }}"
                            href="{{ route('projects.index') }}">المشروعات</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ request()->routeIs('investments.index') ? 'active' : '' }}"
                            href="{{ route('investments.index') }}">الاستثمار</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ request()->routeIs('landmarks.index') ? 'active' : '' }}"
                            href="{{ route('landmarks.index') }}">السياحة</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            تواصل معنا
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('contact.index') }}">الدعم الفني </a></li>
                            <li><a class="dropdown-item" href="{{ route('requests.index') }}">تقديم شكوي أو بلاغ </a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('suggestions.create') }}">تقديم مقترح </a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('surveys.service.create') }}">تقييم مستوى
                                    أداء
                                    الخدمات
                                </a>
                            </li>

                        </ul>
                    </li>
                </ul>
                {{-- Authentication links --}}
                <div class="d-flex align-items-center auth-links">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary me-2">تسجيل الدخول</a>
                        {{-- <a href="{{ route('register.citizen') }}" class="btn btn-primary">حساب جديد</a> --}}
                    @else
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i> مرحبا، {{ Str::words(Auth::user()->name, 1, '') }}
                            </a>
                            <ul class="dropdown-menu">

                                {{-- لوحة تحكم المواطن --}}
                                <li>
                                    <a class="dropdown-item justify-content-start"
                                        href="{{ route('citizen.dashboard') }}">
                                        <i class="fas fa-columns ms-2"></i> لوحة التحكم
                                    </a>
                                </li>

                                {{-- بوابة الموظفين ERP (تظهر فقط للموظفين) --}}
                                @if (auth()->user()->isEmployee())
                                    <li>
                                        <a class="dropdown-item fw-bold justify-content-start"
                                            href="{{ route('employee.erp.index') }}">
                                            <i class="fas fa-briefcase ms-2"></i> بوابة الموظفين (ERP)
                                        </a>
                                    </li>
                                @endif

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                {{-- تسجيل الخروج --}}
                                <li>
                                    <a class="dropdown-item text-danger justify-content-start"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt ms-2"></i> تسجيل الخروج
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>

                {{-- START: Custom Language Switcher --}}
                <div class="language-switcher dropdown">
                    <button class="language-switcher-button dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-globe"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end text-center">
                        <li><a class="dropdown-item" onclick="setLanguage('ar')">العربية</a></li>
                        <li><a class="dropdown-item" onclick="setLanguage('en')">English</a></li>
                        <li><a class="dropdown-item" onclick="setLanguage('fr')">Français</a></li>
                        <li><a class="dropdown-item" onclick="setLanguage('de')">Deutsch</a></li>
                        <li><a class="dropdown-item" onclick="setLanguage('es')">Español</a></li>
                        <li><a class="dropdown-item" onclick="setLanguage('zh-CN')">中文 (Chinese)</a></li>
                        <li><a class="dropdown-item" onclick="setLanguage('ja')">日本語 (Japanese)</a></li>
                        <li><a class="dropdown-item" onclick="setLanguage('ko')">한국어 (Korean)</a></li>
                    </ul>
                    <div id="google_translate_element" style="display:none"></div>
                </div>
                {{-- END: Custom Language Switcher --}}
                {{-- زر فتح البحث --}}
                <button class="header-search-btn" id="searchTrigger" title="ابحث في الموقع">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <button class="navbar-toggler" type="button" id="mobileMenuToggler" aria-label="Toggle navigation">
                <i class="fas fa-grip"></i>
            </button>
        </div>
    </nav>
</header>
<!-- ======================= Header End ======================= -->
<!-- ======================= Mobile Menu Start ======================= -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

<div class="mobile-menu-panel" id="mobileMenuPanel">
    {{-- Header --}}
    <div class="mobile-menu-header">
        <div class="mobile-menu-brand">
            <img src="{{ Storage::url($settings['site_logo_header']) }}" alt="شعار المحافظة" class="mobile-logo">
            <span class="mobile-brand-text">محافظة كفر الشيخ</span>
        </div>
        <button class="mobile-menu-close" id="closeMobileMenu">
            <i class="fas fa-times"></i>
        </button>
    </div>

    {{-- User section --}}
    <div class="mobile-menu-user">
        @guest
            <div class="user-greeting">
                <i class="fas fa-user-circle"></i>
                <span>زائر كريم</span>
            </div>
            <div class="user-actions">
                <a href="{{ route('login') }}" class="btn-gold-sm">تسجيل الدخول</a>
                <a href="{{ route('register.citizen') }}" class="btn-outline-gold-sm">حساب جديد</a>
            </div>
        @else
            <div class="user-greeting">
                <i class="fas fa-user-circle"></i>
                <span>مرحباً، <span class="user-name">{{ Str::words(Auth::user()->name, 2, '') }}</span></span>
            </div>
            @if (auth()->user()->isEmployee())
                <div class="user-actions">
                    <a href="{{ route('employee.erp.index') }}" class="btn-gold-sm">
                        <i class="fas fa-briefcase"></i> ERP
                    </a>
                </div>
            @endif
        @endguest
    </div>

    {{-- Scrollable body --}}
    <div class="mobile-menu-body">
        <ul class="mobile-nav-list">
            {{-- الرئيسية --}}
            <li>
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active-mobile-link' : '' }}">
                    <i class="fas fa-home"></i> الرئيسية
                </a>
            </li>

            {{-- عن المحافظة --}}
            <li class="mobile-dropdown">
                <a href="javascript:void(0)" class="mobile-dropdown-trigger d-flex align-items-center">
                    <i class="fas fa-info-circle"></i>
                    <span>عن المحافظة</span>
                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                </a>
                <ul class="mobile-submenu">
                    <li><a href="{{ route('about') }}">عن المحافظة</a></li>
                    <li><a href="{{ route('about.governor') }}">كلمة المحافظ</a></li>
                    <li><a href="{{ route('officials.show', ['role' => 'governor']) }}">المحافظ</a></li>
                    <li><a href="{{ route('officials.show', ['role' => 'deputy-governor']) }}">نائب المحافظ</a></li>
                    <li><a href="{{ route('officials.show', ['role' => 'secretary-general']) }}">السكرتير العام</a>
                    </li>
                    <li><a href="{{ route('officials.show', ['role' => 'assistant-secretary-general']) }}">السكرتير
                            العام المساعد</a></li>
                    <li><a href="{{ route('governorate.map') }}">خريطة المحافظة</a></li>
                </ul>
            </li>

            <li class="mobile-menu-divider"></li>

            {{-- الأخبار --}}
            <li>
                <a href="{{ route('posts.index') }}"
                    class="{{ request()->routeIs('posts.index') ? 'active-mobile-link' : '' }}">
                    <i class="fas fa-newspaper"></i> الأخبار
                </a>
            </li>

            {{-- الخدمات --}}
            <li>
                <a href="{{ route('services.index') }}"
                    class="{{ request()->routeIs('services.index') ? 'active-mobile-link' : '' }}">
                    <i class="fas fa-concierge-bell"></i> الخدمات
                </a>
            </li>

            {{-- المشروعات --}}
            <li>
                <a href="{{ route('projects.index') }}"
                    class="{{ request()->routeIs('projects.index') ? 'active-mobile-link' : '' }}">
                    <i class="fas fa-project-diagram"></i> المشروعات
                </a>
            </li>

            {{-- الاستثمار --}}
            <li>
                <a href="{{ route('investments.index') }}"
                    class="{{ request()->routeIs('investments.index') ? 'active-mobile-link' : '' }}">
                    <i class="fas fa-chart-line"></i> الاستثمار
                </a>
            </li>

            {{-- السياحة --}}
            <li>
                <a href="{{ route('landmarks.index') }}"
                    class="{{ request()->routeIs('landmarks.index') ? 'active-mobile-link' : '' }}">
                    <i class="fas fa-monument"></i> السياحة
                </a>
            </li>

            <li class="mobile-menu-divider"></li>

            {{-- تواصل معنا --}}
            <li class="mobile-dropdown">
                <a href="javascript:void(0)" class="mobile-dropdown-trigger d-flex align-items-center">
                    <i class="fas fa-envelope-open-text"></i>
                    <span>تواصل معنا</span>
                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                </a>
                <ul class="mobile-submenu">
                    <li><a href="{{ route('contact.index') }}"><i class="fas fa-envelope"></i> الدعم الفني </a></li>
                    <li><a href="{{ route('requests.index') }}"><i class="fas fa-file-alt"></i> تقديم شكوى أو
                            بلاغ</a></li>
                    <li><a href="{{ route('suggestions.create') }}"><i class="fas fa-lightbulb"></i> تقديم مقترح</a>
                    </li>
                    <li><a href="{{ route('surveys.service.create') }}"><i class="fas fa-star"></i> تقييم الخدمات</a>
                    </li>
                </ul>
            </li>

            @auth
                <li class="mobile-menu-divider"></li>

                <li>
                    <a href="{{ route('citizen.dashboard') }}">
                        <i class="fas fa-columns"></i> لوحة التحكم
                    </a>
                </li>

                <li>
                    <a href="{{ route('logout') }}" class="text-danger-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                    </a>
                </li>
            @endauth
        </ul>
    </div>

    {{-- Footer --}}
    <div class="mobile-menu-footer">
        <div class="social-links">
            <a href="https://www.facebook.com/KafrelsheikhGovernorate" aria-label="Facebook"><i
                    class="fab fa-facebook-f"></i></a>
            <a href="https://x.com/kfs_gov" aria-label="X"><i class="fab fa-x-twitter"></i></a>
            <a href="https://youtube.com/@kafrelsheikhgovernorate583" aria-label="YouTube"><i
                    class="fab fa-youtube"></i></a>
            <a href="https://whatsapp.com/channel/0029VadcREoLI8YgR28sFz40" aria-label="WhatsApp"><i
                    class="fab fa-whatsapp"></i></a>
            <a href="https://www.instagram.com/kafr_elsheikh_gov" aria-label="Instagram"><i
                    class="fab fa-instagram"></i></a>
        </div>
        <div class="footer-text">بوابة محافظة كفر الشيخ</div>
    </div>
</div>
<!-- ======================= Mobile Menu End ======================= -->
{{-- ======================= Mobile Bottom Navbar ======================= --}}
<div class="mobile-bottom-nav" id="mobileBottomNav">
    <div class="bottom-nav-inner">
        <a href="{{ route('home') }}" class="bottom-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <div class="nav-icon-wrap">
                <i class="fas fa-house-chimney"></i>
            </div>
            <span class="nav-label">الرئيسية</span>
        </a>
        <a href="{{ route('posts.index') }}"
            class="bottom-nav-item {{ request()->routeIs('posts.index') ? 'active' : '' }}">
            <div class="nav-icon-wrap">
                <i class="fas fa-bullhorn"></i>
            </div>
            <span class="nav-label">الأخبار</span>
        </a>
        <a href="{{ route('services.index') }}"
            class="bottom-nav-item {{ request()->routeIs('services.index') ? 'active' : '' }}">
            <div class="nav-icon-wrap">
                <i class="fas fa-hand-holding-heart"></i>
            </div>
            <span class="nav-label">الخدمات</span>
        </a>
        <a href="{{ route('contact.index') }}"
            class="bottom-nav-item {{ request()->routeIs('contact.index') ? 'active' : '' }}">
            <div class="nav-icon-wrap">
                <i class="fas fa-headset"></i>
            </div>
            <span class="nav-label">تواصل</span>
        </a>
        @auth
            <a href="{{ route('citizen.dashboard') }}"
                class="bottom-nav-item {{ request()->routeIs('citizen.dashboard') ? 'active' : '' }}">
                <div class="nav-icon-wrap">
                    <i class="fas fa-circle-user"></i>
                </div>
                <span class="nav-label">حسابي</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="bottom-nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
                <div class="nav-icon-wrap">
                    <i class="fas fa-circle-user"></i>
                </div>
                <span class="nav-label">دخول</span>
            </a>
        @endauth
    </div>
</div>
{{-- ======================= Search Modal ======================= --}}
<div class="search-overlay" id="searchOverlay">
    <button class="close-search" id="closeSearch">&times;</button>
    <div class="search-container">
        <div class="search-header-text">
            <h2>ما الذي تبحث عنه؟</h2>
            <p>ابحث في أخبار، خدمات، ومشروعات محافظة كفر الشيخ</p>
        </div>
        <form action="{{ route('search') }}" class="search-modal-form">
            <div class="input-group-premium">
                <input type="text" name="query" placeholder="اكتب كلمة البحث هنا..." autocomplete="off"
                    id="searchInput">
                <button type="submit" class="modal-submit-btn">
                    <i class="fas fa-search"></i>
                    <span>بحث</span>
                </button>
            </div>
        </form>
        <div class="search-hints mt-4">
            <span>كلمات شائعة:</span>
            <a href="{{ route('search', ['query' => 'الخطة الاستثمارية']) }}">الخطة الاستثمارية</a>
            <a href="{{ route('search', ['query' => 'وظائف']) }}">وظائف</a>
            <a href="{{ route('search', ['query' => 'مبادرة حياة كريمة']) }}">حياة كريمة</a>
        </div>
    </div>
</div>
