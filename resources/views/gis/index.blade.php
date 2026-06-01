@extends('layouts.app')
@section('title', 'بوابة الخدمات الجيومكانية')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/gis-services.css') }}">
@endpush

@section('content')
    <section class="gis-gateways">

        <header class="gateway-header text-center">
            <div class="container">
                <div class="gateway-badge">
                    <i class="fas fa-crown"></i>
                    <span>منظومة رقمية متكاملة</span>
                </div>
                <h1>منظومة <span class="highlight">الخدمات المكانية</span></h1>
                <p class="subtitle">خدمات جغرافية رقمية موثقة وآمنة — تقديم إلكتروني بالكامل دون الحاجة لزيارة المركز</p>
                <div class="gateway-stats">
                    <div class="gateway-stat">
                        <div class="number">{{ $categories->sum(fn($c) => $c->subServices->count()) }}</div>
                        <div class="label">خدمة إلكترونية</div>
                    </div>
                    <div class="gateway-stat">
                        <div class="number">{{ $categories->count() }}</div>
                        <div class="label">نوع خدمة</div>
                    </div>
                    <div class="gateway-stat">
                        <div class="number">24h</div>
                        <div class="label">متابعة مستمرة</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="video-section-container">
            <div class="section-header-modern">
                <div class="section-label">شاهد الشرح</div>
                <h4>فيديو تعريفي بمراحل الحصول على الخدمة</h4>
            </div>
            <div class="video-wrapper-modern video-thumbnail" onclick="openVideoModal()">
                <img src="{{ asset('gis.png') }}" alt="شاهد الفيديو التعريفي">
                <div class="video-play-overlay">
                    <div class="play-btn-circle">
                        <i class="fas fa-play"></i>
                    </div>
                    <span>شاهد الفيديو</span>
                </div>
                <div class="video-caption">
                    <i class="fas fa-info-circle"></i>
                    <span>فيديو يوضح خطوات التقديم من البداية حتى استلام الخدمة</span>
                </div>
            </div>
        </div>

        {{-- Video Modal --}}
        <div class="video-modal" id="videoModal" onclick="closeVideoModal(event)">
            <div class="video-modal-content" onclick="event.stopPropagation()">
                <button class="video-modal-close" onclick="closeVideoModal()">&times;</button>
                <div class="video-modal-iframe-wrapper">
                    <iframe id="videoIframe" src="" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>

        <style>
        .video-thumbnail {
            position: relative;
            cursor: pointer;
            overflow: hidden;
            border-radius: 16px;
        }
        .video-thumbnail img {
            width: 100%;
            display: block;
            border-radius: 16px;
            transition: transform 0.5s ease;
        }
        .video-thumbnail:hover img {
            transform: scale(1.03);
        }
        .video-play-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: rgba(0,0,0,0.35);
            transition: background 0.3s ease;
            border-radius: 16px;
        }
        .video-thumbnail:hover .video-play-overlay {
            background: rgba(0,0,0,0.45);
        }
        .play-btn-circle {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            background: rgba(255,0,0,0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(255,0,0,0.4);
        }
        .video-thumbnail:hover .play-btn-circle {
            transform: scale(1.1);
            background: #ff0000;
            box-shadow: 0 6px 30px rgba(255,0,0,0.5);
        }
        .play-btn-circle i {
            margin-left: 4px;
        }
        .video-play-overlay > span {
            color: #fff;
            font-weight: 700;
            font-size: 0.95rem;
            text-shadow: 0 2px 8px rgba(0,0,0,0.5);
        }
        .video-thumbnail .video-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 12px 16px;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
            border-radius: 0 0 16px 16px;
            color: #fff;
            font-size: 0.85rem;
        }
        .video-thumbnail .video-caption i {
            color: #e1b12c;
        }

        /* Video Modal */
        .video-modal {
            display: none;
            position: fixed;
            z-index: 99999;
            inset: 0;
            background: rgba(0,0,0,0.85);
            align-items: center;
            justify-content: center;
            padding: 20px;
            backdrop-filter: blur(4px);
        }
        .video-modal.active {
            display: flex;
        }
        .video-modal-content {
            position: relative;
            width: 100%;
            max-width: 800px;
            border-radius: 16px;
            overflow: hidden;
            background: #000;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        .video-modal-close {
            position: absolute;
            top: 12px;
            right: 16px;
            z-index: 10;
            background: rgba(0,0,0,0.6);
            border: none;
            color: #fff;
            font-size: 2rem;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            line-height: 1;
        }
        .video-modal-close:hover {
            background: rgba(255,0,0,0.8);
        }
        .video-modal-iframe-wrapper {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
        }
        .video-modal-iframe-wrapper iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
        }
        </style>

        @push('scripts')
        <script>
        function openVideoModal() {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('videoIframe');
            iframe.src = 'https://www.youtube.com/embed/WREUvW9NIDM?autoplay=1';
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeVideoModal(e) {
            if (e && e.target !== e.currentTarget) return;
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('videoIframe');
            modal.classList.remove('active');
            iframe.src = '';
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeVideoModal();
        });
        </script>
        @endpush

        <div class="services-selection">
            <div class="section-header-modern">
                <div class="section-label">اختر الخدمة</div>
                <h4>تصنيفات الخدمات المكانية</h4>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach ($categories as $cat)
                    <div class="col-lg-6 col-md-12">
                        <div class="service-cat-card">
                            <div class="cat-head">
                                <div class="icon-wrap">
                                    <i class="{{ $cat->icon ?? 'fas fa-map-marked-alt' }}"></i>
                                </div>
                                <h3 class="cat-title">{{ $cat->name }}</h3>
                                @if ($cat->description)
                                    <div class="cat-desc">{!! $cat->description !!}</div>
                                @endif
                            </div>
                            <div class="sub-services-list">
                                @foreach ($cat->subServices as $sub)
                                    <a href="{{ route('gis.service.show', $sub->slug) }}" class="sub-link">
                                        <span class="link-text">{{ $sub->name }}</span>
                                        <span class="link-icon">
                                            <i class="fas fa-arrow-left"></i>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </section>
@endsection
