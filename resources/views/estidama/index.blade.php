@extends('layouts.app')
@section('title', 'استدامة للتدريب والتطوير')
@push('css')
    <link rel="stylesheet" href="{{ asset('css') }}/estidama.css">
@endpush
@section('content')
    <main class="main-content estidama-page">

        {{-- 1. Hero — بدون صورة --}}
        <section class="est-hero">
            <div class="est-hero-bg"></div>
            <div class="est-hero-content">
                @if (!empty($settings['estidama_logo_white']))
                    <img src="{{ Storage::url($settings['estidama_logo_white']) }}" alt="شعار استدامة" class="est-hero-logo">
                @endif
                <h1 class="est-hero-title">{!! $settings['estidama_hero_title'] ?? 'استدامة للتدريب والتطوير' !!}</h1>
            </div>
        </section>

        <div class="container py-5">

            {{-- 2. About Section --}}
            <section class="est-about">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <div class="est-about-image">
                            <img src="{{ asset('estidama/الرؤية والرسالة والقيم.jpg') }}" alt="الرؤية والرسالة والقيم">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <span class="est-badge">عن المركز</span>
                        <h2 class="est-about-title">مركز استدامة للتدريب والتطوير</h2>
                        <div class="est-about-features">
                            {!! $settings['estidama_infrastructure'] !!}
                        </div>
                    </div>
                </div>
            </section>

            {{-- 3. Gallery — Vision / Mission / Values --}}
            <section class="est-gallery">
                <div class="text-center mb-5">
                    <span class="est-badge">استدامة</span>
                    <h2 class="est-section-title">رؤيتنا، رسالتنا، وقيمنا الأساسية</h2>
                    <p class="est-section-sub">صور تحكي قصة استدامة للتدريب والتطوير</p>
                </div>
                <div class="est-gallery-grid">
                    <div class="est-gallery-card">
                        <img src="{{ asset('estidama/رؤيتنا للمستقبل.jpg') }}" alt="رؤيتنا للمستقبل">
                        <div class="est-gallery-tag">رؤيتنا للمستقبل</div>
                    </div>
                    <div class="est-gallery-card">
                        <img src="{{ asset('estidama/رسالتنا.jpg') }}" alt="رسالتنا">
                        <div class="est-gallery-tag">رسالتنا</div>
                    </div>
                    <div class="est-gallery-card">
                        <img src="{{ asset('estidama/القيم الاساسية التي تحركنا.jpg') }}" alt="القيم الأساسية">
                        <div class="est-gallery-tag">قيمنا الأساسية</div>
                    </div>
                    <div class="est-gallery-card">
                        <img src="{{ asset('estidama/التصميم المكاني.jpg') }}" alt="التصميم المكاني">
                        <div class="est-gallery-tag">التصميم المكاني</div>
                    </div>
                </div>
            </section>

            {{-- 4. Programs --}}
            @if ($trainingPrograms->isNotEmpty())
                <section class="est-section" id="programs">
                    <div class="text-center mb-5">
                        <span class="est-badge">برامجنا</span>
                        <h2 class="est-section-title">أحدث البرامج التدريبية</h2>
                        <p class="est-section-sub">اختر برنامجك التدريبي المفضل وسجل الآن</p>
                    </div>
                    <div class="row g-4">
                        @foreach ($trainingPrograms as $program)
                            <div class="col-lg-4 col-md-6">
                                <div class="est-program-card">
                                    <div class="est-program-img">
                                        <img src="{{ Storage::url($program->image) }}" alt="{{ $program->title }}">
                                    </div>
                                    <div class="est-program-body">
                                        <span class="est-program-center">{{ $program->trainingCenter->name ?? '' }}</span>
                                        <h4 class="est-program-title">{{ $program->title }}</h4>
                                        <p class="est-program-desc">{{ \Illuminate\Support\Str::limit(strip_tags($program->description), 80) }}</p>
                                        <a href="{{ route('estidama.apply', $program) }}" class="est-btn est-btn-gold">التسجيل في البرنامج</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('estidama.programs') }}" class="est-btn est-btn-outline">عرض كل البرامج</a>
                    </div>
                </section>
            @endif

            {{-- 5. Stats --}}
            <section class="est-stats">
                <div class="row justify-content-center g-4">
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="est-stat-card">
                            <span class="est-stat-num">{{ $programsCount }}</span>
                            <p class="est-stat-label">برنامج تدريبي</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="est-stat-card">
                            <span class="est-stat-num">{{ $traineesCount }}</span>
                            <p class="est-stat-label">متدرب</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="est-stat-card">
                            <span class="est-stat-num">165</span>
                            <p class="est-stat-label">الطاقة الاستيعابية</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- 6. Events --}}
            @if ($events->isNotEmpty())
                <section class="est-section" id="events">
                    <div class="text-center mb-5">
                        <span class="est-badge">أحداث</span>
                        <h2 class="est-section-title">أهم الأحداث بمركز استدامة</h2>
                    </div>
                    <div class="swiper est-events-slider px-3">
                        <div class="swiper-wrapper">
                            @foreach ($events as $event)
                                <div class="swiper-slide">
                                    <div class="est-event-card">
                                        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}">
                                        <div class="est-event-caption">{{ $event->title }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </section>
            @endif

        </div>
    </main>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (document.querySelector('.est-events-slider')) {
                new Swiper('.est-events-slider', {
                    loop: true,
                    slidesPerView: 1,
                    spaceBetween: 20,
                    pagination: { el: '.swiper-pagination', clickable: true },
                    breakpoints: {
                        768: { slidesPerView: 2 },
                        992: { slidesPerView: 3 }
                    }
                });
            }
        });
    </script>
@endpush
