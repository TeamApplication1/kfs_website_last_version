<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    {{--  ===== 1. Basic Meta Tags ===== --}}
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="google" content="notranslate" />
    <link rel="alternate" href="{{ url()->current() }}" hreflang="ar" />

    {{--  ===== 2. Dynamic SEO Meta Tags ===== --}}
    <title>@yield('title', $settings['site_name'] ?? 'محافظة كفر الشيخ - الموقع الرسمي')</title>
    <meta name="description" content="@yield('description', $settings['site_description'] ?? '  الموقع الرسمي لمحافظة كفر الشيخ، تقدم آخر الأخبار، الخدمات، والمشاريع.')" />
    
    <meta name="keywords" content="محافظة كفر الشيخ, كفر الشيخ, خدمات حكومية, أخبار كفر الشيخ, استثمار" />
    <meta name="author" content="محافظة كفر الشيخ" />

    {{--  ===== 3. Open Graph / Facebook & Twitter Card Meta Tags (for social sharing) ===== --}}
    <meta property="og:title" content="@yield('title', $settings['site_name'] ?? 'محافظة كفر الشيخ')" />
    <meta property="og:description" content="@yield('description', $settings['site_description'] ?? '...')" />
    <meta property="og:image" content="@yield('og_image', asset(Storage::url($settings['site_logo_header'] ?? '')))" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="ar_EG" />
    <meta name="twitter:card" content="summary_large_image" />

    {{--  ===== 4. Favicon Set (Professional Setup) ===== --}}
    {{-- Make sure to place your favicon images in the public/images/favicons/ directory --}}
    <link rel="icon" href="{{ asset('favicon/favicon.ico') }}" sizes="any" />
    <link rel="apple-touch-icon" href="{{ asset('favicon/apple-touch-icon.png') }}" /> {{-- 180x180 px --}}

    {{--  ===== 5. Canonical URL & Theme Color ===== --}}
    <link rel="canonical" href="{{ url()->current() }}" />
    <meta name="theme-color" content="#DAA520">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/bootstrap-5.0.2-dist') }}/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Google Fonts (Cairo + Tajawal) -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet" />
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css') }}/style.css" />
    <link rel="stylesheet" href="{{ asset('css') }}/index.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('css')
</head>

<body>
    <div id="page-loader">
        <div class="loader-inner">
            <img src="{{ Storage::url($settings['site_logo_header'] ?? '') }}" alt="شعار المحافظة" class="loader-logo">
            <div class="loader-line">
                <div class="loader-line-fill"></div>
            </div>
            <div class="loader-text">
                <span class="loader-title">كفر الشيخ الرقمية</span>
                <span class="loader-sub">Kafr El Sheikh Digital</span>
            </div>
        </div>
    </div>
    <style>
        #page-loader {
            position: fixed; inset: 0; z-index: 999999;
            background: linear-gradient(135deg, #0a1628 0%, #1a2a4a 50%, #0d1f3c 100%);
            display: flex; align-items: center; justify-content: center;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }
        #page-loader.hidden { opacity: 0; visibility: hidden; pointer-events: none; }
        .loader-inner { text-align: center; }
        .loader-logo {
            width: 120px; height: auto; margin-bottom: 25px;
            animation: loaderPulse 1.5s ease-in-out infinite;
            filter: drop-shadow(0 0 20px rgba(218,165,32,0.3));
        }
        .loader-line {
            width: 200px; height: 3px; background: rgba(255,255,255,0.1);
            border-radius: 10px; margin: 0 auto 20px; overflow: hidden;
        }
        .loader-line-fill {
            height: 100%; width: 0%;
            background: linear-gradient(90deg, #DAA520, #f0d060, #DAA520);
            border-radius: 10px;
            animation: loaderProgress 2s ease-in-out infinite;
        }
        .loader-text { text-align: center; }
        .loader-title {
            display: block; font-size: 1.5rem; font-weight: 900;
            color: #DAA520; font-family: 'Tajawal', sans-serif;
            letter-spacing: 2px;
            animation: loaderFade 2s ease-in-out infinite;
        }
        .loader-sub {
            display: block; font-size: 0.8rem; color: rgba(255,255,255,0.5);
            font-family: 'Tajawal', sans-serif; margin-top: 5px;
            letter-spacing: 3px; text-transform: uppercase;
        }
        @keyframes loaderPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        @keyframes loaderProgress {
            0% { width: 0%; margin-left: 0; }
            50% { width: 100%; margin-left: 0; }
            100% { width: 0%; margin-left: 100%; }
        }
        @keyframes loaderFade {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 1; }
        }
    </style>
    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('page-loader').classList.add('hidden');
            }, 1200);
        });
    </script>
    <div id="page-wrapper">
        @include('includes.header')

        @yield('content')

        @include('includes.footer')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js') }}/script.js"></script>
    <script src="{{ asset('js') }}/index.js"></script>
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'ar',
                includedLanguages: 'ar,en,fr,de,es,zh-CN,ja,ko',
                autoDisplay: false
            }, 'google_translate_element');
            restoreLanguage();
        }

        function restoreLanguage() {
            var m = document.cookie.match(/googtrans=\/[^\/]+\/([^;]+)/);
            if (m && m[1] !== 'ar') {
                var wait = function(cnt) {
                    var sel = document.querySelector('.goog-te-combo');
                    if (sel) { sel.value = m[1]; sel.dispatchEvent(new Event('change')); }
                    else if (cnt < 10) { setTimeout(function() { wait(cnt + 1); }, 400); }
                };
                wait(0);
            }
        }

        function setLanguage(lang) {
            document.cookie = "googtrans=/ar/" + lang + "; path=/";
            var trySet = function(cnt) {
                var sel = document.querySelector('.goog-te-combo');
                if (sel) { sel.value = lang; sel.dispatchEvent(new Event('change')); }
                else if (cnt < 10) { setTimeout(function() { trySet(cnt + 1); }, 400); }
                else { location.reload(); }
            };
            trySet(0);
        }
    </script>

    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async></script>
    <script>
        function applyDirectionByLanguage() {
            const match = document.cookie.match(/googtrans=\/[^\/]+\/([^;]+)/);
            const lang = match ? match[1] : 'ar';
            const dateContainer = document.getElementById('top-bar');

            if (lang === 'ar') {
                document.documentElement.setAttribute('dir', 'rtl');
                document.documentElement.setAttribute('lang', 'ar');
                document.body.classList.add('rtl');
                document.body.classList.remove('ltr');
            } else {
                document.documentElement.setAttribute('dir', 'ltr');
                document.documentElement.setAttribute('lang', lang);
                document.body.classList.add('ltr');
                document.body.classList.remove('rtl');
            }
            dateContainer.style.display = 'block';
        }
        applyDirectionByLanguage();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.dropdown-submenu > a').forEach(function(el) {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const submenu = this.nextElementSibling;
                    submenu.classList.toggle('show');
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchTrigger = document.getElementById('searchTrigger');
            const searchOverlay = document.getElementById('searchOverlay');
            const closeSearch = document.getElementById('closeSearch');
            const searchInput = document.getElementById('searchInput');

            // فتح السيرش
            if (searchTrigger) {
                searchTrigger.addEventListener('click', () => {
                    searchOverlay.classList.add('active');
                    // تأخير الفوكس قليلاً حتى ينتهي الأنيميشن
                    setTimeout(() => {
                        searchInput.focus();
                    }, 400);
                    document.body.style.overflow = 'hidden'; // منع السكرول خلف المودال
                });
            }

            // إغلاق السيرش بالضغط على الزر
            if (closeSearch) {
                closeSearch.addEventListener('click', () => {
                    searchOverlay.classList.remove('active');
                    document.body.style.overflow = 'auto';
                });
            }

            // إغلاق السيرش بزر Esc
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
                    searchOverlay.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('header');

            // وظيفة مراقبة التمرير
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) { // إذا نزل المستخدم أكثر من 50 بيكسل
                    header.classList.add('header-scrolled');
                } else {
                    header.classList.remove('header-scrolled');
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
