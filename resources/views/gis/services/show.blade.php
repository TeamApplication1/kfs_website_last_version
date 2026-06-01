@extends('layouts.app')
@section('title', $service->name)
@push('css')
    <link rel="stylesheet" href="{{ asset('css/gis-services.css') }}">
<style>
/* ===== GIS Service Detail - Redesigned ===== */
.gis-detail-page {
    background: #f5f7fb;
    min-height: 100vh;
    font-family: 'Cairo', sans-serif;
}

/* Hero Header */
.service-hero {
    position: relative;
    background: linear-gradient(135deg, #0f1724 0%, #1e2d42 50%, #0f1724 100%);
    padding: 80px 0 100px;
    overflow: hidden;
    isolation: isolate;
}
.service-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 70% 50% at 30% 20%, rgba(212,168,67,0.07) 0%, transparent 60%),
        radial-gradient(ellipse 50% 40% at 80% 80%, rgba(212,168,67,0.05) 0%, transparent 60%);
    z-index: 0;
}
.service-hero::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 6px;
    background: linear-gradient(90deg, transparent, #d4a843, #f0d68a, #d4a843, transparent);
    z-index: 1;
}
.service-hero .container { position: relative; z-index: 2; }

.service-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
    font-size: 0.85rem;
}
.service-breadcrumb a { color: rgba(255,255,255,0.5); text-decoration: none; transition: color 0.2s; }
.service-breadcrumb a:hover { color: #d4a843; }
.service-breadcrumb .sep { color: rgba(255,255,255,0.3); }
.service-breadcrumb .current { color: #d4a843; font-weight: 700; }

.service-hero h1 {
    color: #fff;
    font-size: 2.8rem;
    font-weight: 900;
    margin-bottom: 12px;
    line-height: 1.2;
}
.service-hero .subtitle {
    color: rgba(255,255,255,0.6);
    font-size: 1.05rem;
    max-width: 600px;
    line-height: 1.7;
}

/* Price Card */
.price-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 40px rgba(15,23,36,0.12);
    border: 1px solid rgba(212,168,67,0.1);
}
.price-body { padding: 24px 28px 12px; }
.price-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f5;
    font-size: 0.92rem;
}
.price-row:last-of-type { border-bottom: none; }
.price-row .label { color: #636e72; font-weight: 600; }
.price-row .label.small { font-size: 0.82rem; }
.price-row .value { color: #0f1724; font-weight: 800; }

.price-total {
    padding: 18px 28px;
    background: linear-gradient(135deg, #d4a843, #f0d68a);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.price-total .total-label { color: #0f1724; font-weight: 700; font-size: 0.9rem; }
.price-total .total-label small { display: block; font-weight: 400; opacity: 0.6; font-size: 0.75rem; }
.price-total .total-amount { color: #0f1724; font-weight: 900; font-size: 1.5rem; }
.price-total .total-amount .currency { font-size: 0.85rem; font-weight: 700; margin-left: 4px; }

/* Tabs */
.tabs-wrap {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.04);
    overflow: hidden;
}
.tabs-nav {
    display: flex;
    gap: 4px;
    padding: 16px 20px 0;
    border-bottom: 1px solid #f0f0f5;
    background: #fafbfc;
    flex-wrap: wrap;
}
.tabs-nav button {
    padding: 12px 22px;
    border: none;
    background: transparent;
    font-weight: 700;
    font-size: 0.9rem;
    color: #7f8c9b;
    border-radius: 12px 12px 0 0;
    transition: all 0.3s ease;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border-bottom: 3px solid transparent;
    margin-bottom: -1px;
}
.tabs-nav button:hover { color: #0f1724; background: rgba(15,23,36,0.03); }
.tabs-nav button.active { color: #0f1724; border-bottom-color: #d4a843; background: #fff; }

.tab-panel { padding: 30px; display: none; }
.tab-panel.active { display: block; }
.tab-panel p, .tab-panel li { line-height: 1.9; color: #4a5568; }

/* Agreement Box */
.agree-box {
    background: #fff;
    border-radius: 20px;
    padding: 35px 40px;
    text-align: center;
    border: 2px dashed rgba(212,168,67,0.3);
    box-shadow: 0 2px 20px rgba(0,0,0,0.04);
}
.agree-box h5 { font-weight: 800; color: #0f1724; margin-bottom: 8px; }
.agree-box p.text-muted { font-size: 0.88rem; max-width: 500px; margin: 0 auto 20px; }
.agree-box .form-check-input:checked { background-color: #d4a843; border-color: #d4a843; }

.btn-gis-primary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #0f1724, #1e2d42);
    color: #d4a843;
    border: none;
    padding: 16px 40px;
    border-radius: 50px;
    font-weight: 800;
    font-size: 1.05rem;
    transition: all 0.4s ease;
    text-decoration: none;
}
.btn-gis-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 40px rgba(15,23,36,0.2);
    color: #d4a843;
}

/* Sidebar */
.track-widget {
    background: #fff;
    border-radius: 20px;
    padding: 30px 25px;
    text-align: center;
    border: 1px solid rgba(0,0,0,0.04);
    box-shadow: 0 2px 20px rgba(0,0,0,0.04);
}
.track-widget i { font-size: 2.5rem; color: #d4a843; margin-bottom: 12px; }
.track-widget h5 { font-weight: 800; color: #0f1724; }
.track-widget p { font-size: 0.88rem; color: #7f8c9b; }
.track-widget .form-control {
    border-radius: 12px;
    border: 2px solid #e8eaef;
    padding: 12px;
    text-align: center;
    font-weight: 700;
    transition: all 0.3s;
}
.track-widget .form-control:focus { border-color: #d4a843; box-shadow: 0 0 0 4px rgba(212,168,67,0.1); }
.btn-navy {
    background: #0f1724;
    color: #d4a843;
    border: none;
    padding: 12px;
    border-radius: 50px;
    font-weight: 700;
    transition: all 0.3s;
}
.btn-navy:hover { background: #1e2d42; color: #d4a843; }

@media (max-width: 991px) {
    .service-hero { padding: 60px 0 80px; }
    .service-hero h1 { font-size: 2rem; }
    .price-card { margin-top: 24px; }
}
@media (max-width: 767px) {
    .service-hero h1 { font-size: 1.5rem; }
    .tabs-nav button { font-size: 0.82rem; padding: 10px 14px; }
    .tab-panel { padding: 20px 16px; }
    .agree-box { padding: 25px 20px; }
}
</style>
@endpush

@php
    $basePrice = (float) $service->base_price;
    $pricingType = $service->pricing_type ?? 'fixed';
    $settings = $service->pricing_settings ?? [];
    $vatRate = 0.14;
    $martyrStamp = 5.0;
    $smsFee = 10.0;

    switch ($pricingType) {
        case 'fixed':
            $vat = $basePrice * $vatRate;
            $totalAmount = $basePrice + $vat + $martyrStamp + $smsFee;
            $priceLabel = 'المقابل الفني';
            break;
        case 'formula':
            $vat = $basePrice * $vatRate;
            $totalAmount = $basePrice + $vat + $martyrStamp + $smsFee;
            $priceLabel = 'المقابل الفني (بدون المساحة)';
            break;
        case 'tiered':
            $vat = $basePrice * $vatRate;
            $totalAmount = $basePrice + $vat + $martyrStamp + $smsFee;
            $priceLabel = 'الرسوم الثابتة';
            break;
        default:
            $vat = $basePrice * $vatRate;
            $totalAmount = $basePrice + $vat + $martyrStamp + $smsFee;
            $priceLabel = 'المقابل الفني';
    }
@endphp

@section('content')
    <main class="gis-detail-page">
        {{-- Hero --}}
        <section class="service-hero">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <nav class="service-breadcrumb">
                            <a href="/">الرئيسية</a>
                            <span class="sep">/</span>
                            <a href="{{ route('gis.index') }}">الخدمات المكانية</a>
                            <span class="sep">/</span>
                            <span class="current">{{ $service->serviceType->name }}</span>
                        </nav>
                        <h1>{{ $service->name }}</h1>
                        <p class="subtitle">خدمة رقمية موثقة بالكامل — تقديم إلكتروني دون الحاجة لزيارة المركز</p>
                    </div>
                    <div class="col-lg-5">
                        <div class="price-card">
                            <div class="price-body">
                                @if ($pricingType === 'fixed')
                                    <div class="price-row">
                                        <span class="label">{{ $priceLabel }}</span>
                                        <span class="value">{{ number_format($basePrice, 2) }} ج.م</span>
                                    </div>
                                @elseif ($pricingType === 'formula')
                                    <div class="price-row" style="border-bottom:none;flex-direction:column;align-items:stretch;gap:8px">
                                        <span class="label" style="font-size:0.85rem">سعر المتر المربع</span>
                                        <span class="value" style="font-size:1.1rem">{{ number_format((float)($settings['multiplier'] ?? 0), 2) }} ج.م / م²</span>
                                    </div>
                                    <div class="price-row">
                                        <span class="label small">{{ $priceLabel }}</span>
                                        <span class="value">{{ number_format($basePrice, 2) }} ج.م</span>
                                    </div>
                                @elseif ($pricingType === 'tiered')
                                    @php $tiers = $settings['tiers'] ?? []; @endphp
                                    <div class="price-row" style="border-bottom:none;flex-direction:column;align-items:stretch;gap:6px;padding-bottom:4px">
                                        <span class="label" style="font-size:0.85rem">جدول الشرائح</span>
                                        @foreach ($tiers as $tier)
                                            <div style="display:flex;justify-content:space-between;font-size:0.85rem;padding:3px 0">
                                                <span style="color:#636e72">حتى {{ number_format($tier['max']) }} م²</span>
                                                <span style="font-weight:700;color:#0f1724">{{ number_format((float)($tier['price'] ?? 0), 2) }} ج.م</span>
                                            </div>
                                        @endforeach
                                        @if (empty($tiers))
                                            <span style="color:#999;font-size:0.82rem">لم يتم تحديد شرائح بعد</span>
                                        @endif
                                    </div>
                                    <div class="price-row" style="margin-top:4px">
                                        <span class="label">{{ $priceLabel }}</span>
                                        <span class="value">{{ number_format($basePrice, 2) }} ج.م</span>
                                    </div>
                                @endif
                                <div class="price-row">
                                    <span class="label small">ضريبة القيمة المضافة (14%)</span>
                                    <span class="value">+ {{ number_format($vat, 2) }} ج.م</span>
                                </div>
                                <div class="price-row">
                                    <span class="label">دمغة الشهداء</span>
                                    <span class="value">5.00 ج.م</span>
                                </div>
                                <div class="price-row">
                                    <span class="label">مقابل المتابعة (SMS)</span>
                                    <span class="value">10.00 ج.م</span>
                                </div>
                            </div>
                            <div class="price-total">
                                <div class="total-label">الإجمالي <small>المطالبة الرقمية المعتمدة</small></div>
                                <div class="total-amount"><span class="currency">ج.م</span>{{ number_format($totalAmount, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Content --}}
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-8">
                    {{-- Tabs --}}
                    <div class="tabs-wrap">
                        <div class="tabs-nav" role="tablist">
                            <button class="active" data-tab="definition">
                                <i class="fas fa-info-circle"></i> التعريف بالخدمة
                            </button>
                            <button data-tab="requirements">
                                <i class="fas fa-file-alt"></i> المستندات المطلوبة
                            </button>
                            <button data-tab="terms">
                                <i class="fas fa-gavel"></i> الشروط والأحكام
                            </button>
                        </div>
                        <div class="tab-panel active" id="panel-definition" role="tabpanel">
                            {!! $service->description !!}
                        </div>
                        <div class="tab-panel" id="panel-requirements" role="tabpanel">
                            {!! $service->requirements !!}
                        </div>
                        <div class="tab-panel" id="panel-terms" role="tabpanel">
                            {!! $service->terms_conditions !!}
                        </div>
                    </div>

                    {{-- Agreement --}}
                    <div class="agree-box mt-4">
                        <h5>جاهز للبدء في تقديم الطلب؟</h5>
                        <p class="text-muted">يقر مقدم الطلب باطلاعه على الشروط والأحكام الفنية السابقة وصحة البيانات التي سيدلي بها.</p>
                        <form action="{{ route('gis.apply.start', $service->slug) }}" method="GET">
                            <div class="form-check d-inline-block mb-3 text-start" style="padding-inline-start:2rem">
                                <input class="form-check-input" type="checkbox" id="agreeCheck" required style="width:1.2rem;height:1.2rem;margin-inline-start:-2rem;margin-top:0.15rem;cursor:pointer">
                                <label class="form-check-label" for="agreeCheck" style="cursor:pointer;font-weight:700">أوافق على جميع الشروط والأحكام</label>
                            </div>
                            <br>
                            <button type="submit" class="btn-gis-primary">
                                انتقل لصفحة التسجيل <i class="fas fa-chevron-left"></i>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    <div class="track-widget">
                        <i class="fas fa-search-location"></i>
                        <h5>تتبع حالة طلبك</h5>
                        <p>هل قمت بتقديم طلب سابق؟ أدخل كود المعاملة</p>
                        <form action="{{ route('gis.tracking') }}" method="GET">
                            <input type="text" name="ticket" class="form-control mb-3" placeholder="كود الشهادة / الطلب">
                            <button class="btn-navy w-100">تتبع الطلب <i class="fas fa-arrow-left" style="font-size:0.8rem"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.tabs-nav button').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.tabs-nav button').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('panel-' + this.dataset.tab).classList.add('active');
    });
});
</script>
@endpush