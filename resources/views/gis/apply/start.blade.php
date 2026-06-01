@extends('layouts.app')
@section('title', 'تقديم طلب - ' . $service->name)
@push('css')
    <link rel="stylesheet" href="{{ asset('css/gis-services.css') }}">
<style>
/* GIS Apply Page - Modern Redesign */
.gis-apply-page { background: #f5f7fb; min-height: 100vh; font-family: 'Cairo', sans-serif; padding: 0; }

/* Hero */
.gis-hero {
    background: linear-gradient(135deg, #0f1724 0%, #1a2740 50%, #0f1724 100%);
    padding: 60px 0 50px;
    color: #fff;
    position: relative;
    overflow: hidden;
}
.gis-hero::before {
    content: '';
    position: absolute;
    top: -50%; right: -20%;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(212,168,67,0.08) 0%, transparent 70%);
    border-radius: 50%;
}
.gis-hero::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 6px;
    background: linear-gradient(90deg, #d4a843, #f5d88f, #d4a843);
}
.gis-hero .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(212,168,67,0.15);
    border: 1px solid rgba(212,168,67,0.3);
    color: #d4a843;
    padding: 6px 18px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    margin-bottom: 18px;
}
.gis-hero h1 {
    font-size: 2.2rem;
    font-weight: 900;
    margin-bottom: 12px;
    line-height: 1.3;
}
.gis-hero .hero-desc {
    font-size: 1.05rem;
    color: rgba(255,255,255,0.7);
    max-width: 650px;
    line-height: 1.7;
    margin-bottom: 24px;
}
.gis-hero .hero-stats {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}
.gis-hero .hero-stat {
    display: flex;
    align-items: center;
    gap: 10px;
    color: rgba(255,255,255,0.6);
    font-size: 0.85rem;
    font-weight: 600;
}
.gis-hero .hero-stat i {
    width: 32px; height: 32px;
    background: rgba(212,168,67,0.15);
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #d4a843;
    font-size: 0.85rem;
}

/* Content area */
.gis-content { padding: 40px 0 60px; }

/* Steps header */
.steps-bar {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 40px;
    position: relative;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}
.steps-bar::before {
    content: '';
    position: absolute;
    top: 22px;
    left: 80px;
    right: 80px;
    height: 3px;
    background: #e0e0e0;
    z-index: 0;
    border-radius: 2px;
}
.step-item {
    text-align: center;
    z-index: 1;
    flex: 1;
}
.step-circle {
    width: 46px; height: 46px;
    border-radius: 50%;
    background: #e0e0e0;
    color: #999;
    display: flex;
    align-items: center; justify-content: center;
    font-weight: 900; font-size: 1.1rem;
    margin: 0 auto 8px;
    transition: all 0.4s ease;
    position: relative;
}
.step-item.active .step-circle {
    background: linear-gradient(135deg, #0f1724, #1e2d42);
    color: #d4a843;
    box-shadow: 0 4px 15px rgba(15,23,36,0.2);
    transform: scale(1.05);
}
.step-item.done .step-circle {
    background: #27ae60;
    color: #fff;
}
.step-item .step-label {
    font-size: 0.78rem;
    font-weight: 700;
    color: #999;
    transition: color 0.3s;
}
.step-item.active .step-label { color: #0f1724; }
.step-item.done .step-label { color: #27ae60; }

/* Form Card */
.form-card {
    background: #fff;
    border-radius: 20px;
    padding: 40px 45px;
    box-shadow: 0 2px 30px rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.04);
}
.form-card h4 {
    font-weight: 800;
    color: #0f1724;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f5;
    display: flex;
    align-items: center;
    gap: 10px;
}
.form-card h4 i {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #0f1724, #1e2d42);
    border-radius: 10px;
    display: inline-flex; align-items: center; justify-content: center;
    color: #d4a843; font-size: 0.9rem;
}
.form-card .form-label { font-weight: 700; color: #2d3436; font-size: 0.88rem; margin-bottom: 6px; }
.form-card .form-control,
.form-card .form-select {
    border-radius: 12px;
    border: 2px solid #e8eaef;
    padding: 12px 16px;
    transition: all 0.3s ease;
    font-size: 0.95rem;
    background: #fafbfc;
}
.form-card .form-control:focus,
.form-card .form-select:focus {
    border-color: #d4a843;
    box-shadow: 0 0 0 4px rgba(212,168,67,0.1);
    background: #fff;
}
.form-card .form-control.is-invalid,
.form-card .form-select.is-invalid {
    border-color: #e74c3c;
    box-shadow: 0 0 0 4px rgba(231,76,60,0.1);
    background: #fff8f8;
}

/* Pricing summary */
.pricing-summary {
    background: linear-gradient(135deg, #0f1724, #1e2d42);
    border-radius: 16px;
    padding: 25px 30px;
    color: #fff;
    margin-top: 25px;
}
.pricing-summary .ps-title {
    font-size: 0.8rem;
    color: rgba(255,255,255,0.5);
    font-weight: 600;
    margin-bottom: 8px;
}
.pricing-summary .ps-amount {
    font-size: 2.2rem;
    font-weight: 900;
    color: #d4a843;
}
.pricing-summary .ps-amount small {
    font-size: 1rem;
    font-weight: 700;
    margin-left: 6px;
}
.pricing-summary .ps-breakdown {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid rgba(255,255,255,0.1);
}
.pricing-summary .ps-breakdown span {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.6);
    background: rgba(255,255,255,0.06);
    padding: 4px 12px;
    border-radius: 20px;
}

/* Buttons */
.btn-nav {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 32px;
    border-radius: 50px;
    font-weight: 800;
    font-size: 0.95rem;
    border: none;
    transition: all 0.3s ease;
    cursor: pointer;
}
.btn-nav-prev {
    background: #f0f0f5;
    color: #636e72;
}
.btn-nav-prev:hover { background: #e0e0e8; }
.btn-nav-next {
    background: linear-gradient(135deg, #0f1724, #1e2d42);
    color: #d4a843;
}
.btn-nav-next:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(15,23,36,0.15);
}
.btn-nav-submit {
    background: linear-gradient(135deg, #27ae60, #2ecc71);
    color: #fff;
}
.btn-nav-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(39,174,96,0.3);
    color: #fff;
}

/* Agent section */
.agent-box {
    background: #fff8e1;
    border-radius: 14px;
    padding: 20px 24px;
    border: 1px solid rgba(212,168,67,0.2);
    margin-top: 15px;
}

/* Checkbox fix */
.agree-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
    background: #f8f9fb;
    border-radius: 14px;
    border: 1px solid #eef0f5;
    cursor: pointer;
    transition: all 0.2s;
}
.agree-item:hover { border-color: #d4a843; }
.agree-item input[type="checkbox"] {
    width: 22px; height: 22px;
    accent-color: #d4a843;
    cursor: pointer;
    flex-shrink: 0;
}
.agree-item label {
    font-weight: 700;
    font-size: 0.9rem;
    color: #2d3436;
    cursor: pointer;
    margin: 0;
}

/* Sections */
.wizard-step { display: none; }
.wizard-step.active { display: block; animation: fadeUp 0.35s ease; }
@keyframes fadeUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

@media (max-width: 767px) {
    .gis-apply-page { padding: 25px 0; }
    .form-card { padding: 25px 20px; }
    .steps-bar { gap: 5px; }
    .steps-bar::before { left: 40px; right: 40px; }
    .step-circle { width: 38px; height: 38px; font-size: 0.9rem; }
    .pricing-summary { padding: 20px; }
    .pricing-summary .ps-amount { font-size: 1.6rem; }
}
</style>
@endpush

@section('content')
    @php
        $pricingType = $service->pricing_type ?? 'fixed';
        $settings = $service->pricing_settings ?? [];
        $basePrice = (float) $service->base_price;
        $hasVat = $service->has_vat ?? false;
        $martyrFee = (float) ($service->martyr_stamp_fee ?? 5.0);
        $smsFee = (float) ($service->sms_fee ?? 10.0);
        $fixedFees = $martyrFee + $smsFee;
    @endphp

    <main class="gis-apply-page">
        {{-- Hero Section --}}
        <div class="gis-hero">
            <div class="container">
                <div class="hero-badge"><i class="fas fa-layer-group"></i> {{ $service->serviceType->name ?? 'خدمة GIS' }}</div>
                <h1>{{ $service->name }}</h1>
                @if($service->description)
                    <div class="hero-desc">{!! $service->description !!}</div>
                @endif
                <div class="hero-stats">
                    <div class="hero-stat"><i class="fas fa-tag"></i> السعر الأساسي: {{ number_format($basePrice, 2) }} ج.م</div>
                    @if($pricingType === 'formula')
                        <div class="hero-stat"><i class="fas fa-calculator"></i> سعر المتر: {{ $settings['multiplier'] ?? 0 }} ج.م</div>
                    @endif
                    @if($pricingType === 'tiered')
                        <div class="hero-stat"><i class="fas fa-layer-group"></i> تسعير شرائح</div>
                    @endif
                    @if($service->requirements)
                        <div class="hero-stat"><i class="fas fa-file-invoice"></i> مستندات مطلوبة</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="gis-content">
        <div class="container">
            {{-- Steps --}}
            <div class="steps-bar">
                <div class="step-item active" data-step="1">
                    <div class="step-circle">1</div>
                    <div class="step-label">البيانات الشخصية</div>
                </div>
                <div class="step-item" data-step="2">
                    <div class="step-circle">2</div>
                    <div class="step-label">موقع العقار</div>
                </div>
                <div class="step-item" data-step="3">
                    <div class="step-circle">3</div>
                    <div class="step-label">تفاصيل الطلب</div>
                </div>
                <div class="step-item" data-step="4">
                    <div class="step-circle">4</div>
                    <div class="step-label">المراجعة والدفع</div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form action="{{ route('gis.apply.submit', $service->slug) }}" method="POST" enctype="multipart/form-data" id="applyForm">
                        @csrf

                        {{-- Step 1: Personal Data --}}
                        <div class="wizard-step active" id="step1">
                            <div class="form-card">
                                <h4><i class="fas fa-user"></i> بيانات مقدم الطلب</h4>
                                @if ($errors->any())
                                    <div class="alert alert-danger rounded-3">
                                        <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                                    </div>
                                @endif
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">اسم المالك</label>
                                        <input type="text" class="form-control bg-light" value="{{ auth()->user()->name }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">صفة مقدم الطلب <span class="text-danger">*</span></label>
                                        <select name="applicant_type" id="applicant_type" class="form-select" required onchange="toggleAgent(this.value)">
                                            <option value="owner">المالك الأصيل</option>
                                            <option value="agent">وكيل بموجب توكيل</option>
                                            <option value="other">أخرى</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">إرفاق صورة بطاقة الرقم القومي للمالك <span class="text-danger">*</span></label>
                                        <input type="file" name="owner_id_card" class="form-control" required>
                                    </div>
                                </div>
                                <div id="agentSection" class="agent-box" style="display:none">
                                    <h6 class="fw-bold mb-3" style="color:#d4a843"><i class="fas fa-file-signature ms-2"></i>بيانات الوكالة</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">اسم الوكيل رباعي</label>
                                            <input type="text" name="agent_name" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">صورة التوكيل الرسمي</label>
                                            <input type="file" name="proxy_doc" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 d-flex justify-content-between">
                                    <div></div>
                                    <button type="button" class="btn-nav btn-nav-next" onclick="goStep(2)">التالي <i class="fas fa-arrow-left"></i></button>
                                </div>
                            </div>
                        </div>

                        {{-- Step 2: Location --}}
                        <div class="wizard-step" id="step2">
                            <div class="form-card">
                                <h4><i class="fas fa-map-marker-alt"></i> الموقع الجغرافي للعقار</h4>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">المركز <span class="text-danger">*</span></label>
                                        <select name="markaz_id" id="markaz_select" class="form-select" onchange="loadUnits(this.value)" required>
                                            <option value="">-- اختر المركز --</option>
                                            @foreach ($markazs as $m)
                                                <option value="{{ $m->id }}">{{ $m->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">الوحدة المحلية <span class="text-danger">*</span></label>
                                        <select name="shiakha_id" id="unit_select" class="form-select" onchange="loadVillages(this.value)" required>
                                            <option value="">بانتظار المركز...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">القرية / العزبة <span class="text-danger">*</span></label>
                                        <select name="village_id" id="village_select" class="form-select" required>
                                            <option value="">بانتظار الوحدة...</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">تفاصيل العنوان</label>
                                        <textarea name="address" class="form-control" rows="2" placeholder="الشارع — المعالم المميزة"></textarea>
                                    </div>
                                </div>
                                <div class="mt-4 d-flex justify-content-between">
                                    <button type="button" class="btn-nav btn-nav-prev" onclick="goStep(1)"><i class="fas fa-arrow-right"></i> السابق</button>
                                    <button type="button" class="btn-nav btn-nav-next" onclick="goStep(3)">التالي <i class="fas fa-arrow-left"></i></button>
                                </div>
                            </div>
                        </div>

                        {{-- Step 3: Service Details --}}
                        <div class="wizard-step" id="step3">
                            <div class="form-card">
                                <h4><i class="fas fa-file-alt"></i> بيانات وتفاصيل الخدمة</h4>
                                <div class="mb-4 p-3 bg-light rounded-3">
                                    <label class="form-label fw-bold mb-2">بيان الخدمة <span class="text-danger">*</span></label>
                                    <select name="request_type" id="request_type" class="form-select" required onchange="toggleRequestType(this.value)">
                                        <option value="new">تسجيل جديد</option>
                                        <option value="restudy">إعادة دراسة</option>
                                        <option value="duplicate">استخراج بدل فاقد</option>
                                    </select>
                                </div>

                                {{-- New request dynamic fields --}}
                                <div id="newRequestFields">
                                    <div class="row g-3">
                                        @foreach ($service->dynamic_fields ?? [] as $field)
                                            <div class="col-md-6 mb-2">
                                                <label class="form-label">{{ $field['label'] }} @if ($field['is_required'] ?? false)<span class="text-danger">*</span>@endif</label>
                                                @if (($field['type'] ?? 'text') === 'text')
                                                    <input type="text" name="form_data[{{ $field['name'] }}]" class="form-control dynamic-input" data-name="{{ $field['name'] }}" {{ $field['is_required'] ?? false ? 'required' : '' }}>
                                                @elseif ($field['type'] === 'number')
                                                    <input type="number" step="any" name="form_data[{{ $field['name'] }}]" class="form-control dynamic-input" data-name="{{ $field['name'] }}" {{ $field['is_required'] ?? false ? 'required' : '' }}>
                                                @elseif ($field['type'] === 'select')
                                                    <select name="form_data[{{ $field['name'] }}]" class="form-select dynamic-input" data-name="{{ $field['name'] }}" {{ $field['is_required'] ?? false ? 'required' : '' }}>
                                                        <option value="">-- اختر --</option>
                                                        @foreach (explode("\n", $field['options'] ?? '') as $opt)
                                                            <option value="{{ trim($opt) }}">{{ trim($opt) }}</option>
                                                        @endforeach
                                                    </select>
                                                @elseif ($field['type'] === 'file')
                                                    <input type="file" name="form_data[{{ $field['name'] }}]" class="form-control" {{ $field['is_required'] ?? false ? 'required' : '' }}>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Restudy fields --}}
                                <div id="restudyFields" style="display:none">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">كود الشهادة السابقة <span class="text-danger">*</span></label>
                                            <input type="text" name="prev_code" class="form-control">
                                        </div>
                                        <div class="col-md-6" id="restudyReasonCol">
                                            <label class="form-label">سبب طلب إعادة الدراسة</label>
                                            <select name="reason_id" class="form-select">
                                                <option value="">-- اختر السبب --</option>
                                                @foreach ($reasons as $r)
                                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Live pricing --}}
                                <div class="pricing-summary" id="pricingSummary">
                                    <div class="ps-title">إجمالي المطلوب سداده</div>
                                    <div class="ps-amount"><small>ج.م</small><span id="totalDisplay">{{ number_format($basePrice + ($hasVat ? $basePrice * 0.14 : 0) + $fixedFees, 2) }}</span></div>
                                    <div class="ps-breakdown" id="priceBreakdown"></div>
                                </div>

                                <div class="mt-4 d-flex justify-content-between">
                                    <button type="button" class="btn-nav btn-nav-prev" onclick="goStep(2)"><i class="fas fa-arrow-right"></i> السابق</button>
                                    <button type="button" class="btn-nav btn-nav-next" onclick="goStep(4)">المراجعة النهائية <i class="fas fa-arrow-left"></i></button>
                                </div>
                            </div>
                        </div>

        {{-- Step 4: Review & Submit --}}
                        <div class="wizard-step" id="step4">
                            <div class="form-card">
                                <h4><i class="fas fa-check-circle"></i> مراجعة الطلب وتأكيد الدفع</h4>
                                <p class="text-muted mb-4">يرجى مراجعة بيانات الطلب قبل الإرسال. بعد التأكيد ستتم إحالتك إلى بوابة الدفع الإلكتروني.</p>
                                <div class="agree-item mb-3" onclick="document.getElementById('agreePayment').click()">
                                    <input type="checkbox" id="agreePayment" required>
                                    <label for="agreePayment">أوافق على <a href="#" onclick="event.stopPropagation(); showTermsModal('payment'); return false;">شروط السداد الإلكتروني</a></label>
                                </div>
                                <div class="agree-item mb-4" onclick="document.getElementById('agreeService').click()">
                                    <input type="checkbox" id="agreeService" required>
                                    <label for="agreeService">أقر باطلاعي على <a href="#" onclick="event.stopPropagation(); showTermsModal('service'); return false;">شروط الخدمة والضوابط الفنية</a></label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn-nav btn-nav-prev" onclick="goStep(3)"><i class="fas fa-arrow-right"></i> تعديل البيانات</button>
                                    <button type="submit" class="btn-nav btn-nav-submit"><i class="fas fa-lock ms-2"></i> تأكيد وإحالة للدفع</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>{{-- /container --}}
        </div>{{-- /gis-content --}}

        {{-- Terms Modal --}}
        <div class="modal fade" id="termsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content" style="border-radius: 16px; border: none;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #0f1724, #1e2d42); color: #d4a843; border-radius: 16px 16px 0 0;">
                        <h5 class="modal-title fw-bold"><i class="fas fa-file-contract ms-2"></i> <span id="termsModalTitle">الشروط والأحكام</span></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4" id="termsModalBody" style="line-height: 1.8; font-size: 0.95rem; color: #2d3436;">
                    </div>
                    <div class="modal-footer border-0 pt-0 px-4 pb-4">
                        <div class="agree-item w-100 mb-3" onclick="event.stopPropagation(); document.getElementById('termsAgreeCheck').click()">
                            <input type="checkbox" id="termsAgreeCheck">
                            <label for="termsAgreeCheck">لقد اطلعت على جميع الشروط والأحكام وأوافق عليها</label>
                        </div>
                        <button type="button" class="btn-nav btn-nav-next w-100 justify-content-center" id="termsConfirmBtn" disabled onclick="confirmTerms()">
                            <i class="fas fa-check ms-2"></i> تأكيد الموافقة
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('scripts')
<div id="termsServiceData" style="display:none;">
    @if($service->terms_conditions)
        <h6 class="fw-bold mb-3" style="color: #0f1724;">الشروط والضوابط الفنية للخدمة</h6>
        <div style="line-height:2;">{!! nl2br(e($service->terms_conditions)) !!}</div>
    @else
        <p class="text-muted">لا توجد شروط إضافية لهذه الخدمة.</p>
    @endif
</div>
<script>
const pricing = {
    type: '{{ $pricingType }}',
    basePrice: {{ $basePrice }},
    settings: @json($settings),
    hasVat: {{ $hasVat ? 'true' : 'false' }},
    fixedFees: {{ $fixedFees }},
    martyrFee: {{ $martyrFee }},
    smsFee: {{ $smsFee }},
};

function calcPrice() {
    let core = pricing.basePrice;
    const areaInput = document.querySelector('.dynamic-input[data-name="area_m2"]');
    const pointsInput = document.querySelector('.dynamic-input[data-name="points_count"]');
    const areaVal = areaInput ? parseFloat(areaInput.value) || 0 : 0;
    const pointsVal = pointsInput ? parseFloat(pointsInput.value) || 0 : 0;

    if (pricing.type === 'formula') {
        const multiplier = parseFloat(pricing.settings.multiplier) || 0;
        core = (areaVal * multiplier) + pricing.basePrice;
    } else if (pricing.type === 'tiered') {
        const tiers = pricing.settings.tiers || [];
        if (tiers.length) {
            const sorted = [...tiers].sort((a,b) => a.max - b.max);
            let found = false;
            for (const t of sorted) {
                if (areaVal <= t.max) { core = parseFloat(t.price); found = true; break; }
            }
            if (!found) core = parseFloat(sorted[sorted.length - 1].price);
        }
        if (pricing.settings.has_overflow && areaVal > (pricing.settings.overflow_threshold || 0)) {
            const unit = pricing.settings.overflow_unit_size || 4200;
            const extra = Math.ceil((areaVal - pricing.settings.overflow_threshold) / unit);
            core += extra * parseFloat(pricing.settings.overflow_price || 0);
        }
        if (pricing.settings.point_threshold && pointsVal > pricing.settings.point_threshold) {
            core += (pointsVal - pricing.settings.point_threshold) * parseFloat(pricing.settings.point_extra || 0);
        }
    }

    const vat = pricing.hasVat ? core * 0.14 : 0;
    const total = core + vat + pricing.fixedFees;
    document.getElementById('totalDisplay').textContent = total.toFixed(2);

    const bd = document.getElementById('priceBreakdown');
    bd.innerHTML = `<span>الرسوم: ${core.toFixed(2)} ج.م</span>` +
        (pricing.hasVat ? `<span>ضريبة 14%: ${vat.toFixed(2)} ج.م</span>` : '') +
        `<span>دمغة شهداء: ${pricing.martyrFee.toFixed(2)} ج.م</span>` +
        `<span>رسوم رسائل: ${pricing.smsFee.toFixed(2)} ج.م</span>`;
}

function toggleAgent(val) {
    document.getElementById('agentSection').style.display = val === 'agent' ? 'block' : 'none';
}

function toggleRequestType(val) {
    document.getElementById('newRequestFields').style.display = val === 'new' ? 'block' : 'none';
    document.getElementById('restudyFields').style.display = val !== 'new' ? 'block' : 'none';
    if (val !== 'new') calcPrice();
}

function goStep(n) {
    const current = document.querySelector('.wizard-step.active');
    const currentId = current ? parseInt(current.id.replace('step', '')) : 1;

    if (n > currentId) {
        if (!validateStep(currentId)) return;
    }

    document.querySelectorAll('.wizard-step').forEach(el => el.classList.remove('active'));
    document.getElementById('step' + n).classList.add('active');
    document.querySelectorAll('.step-item').forEach(el => el.classList.remove('active'));
    document.querySelector(`.step-item[data-step="${n}"]`).classList.add('active');

    for (let i = 1; i < n; i++) {
        document.querySelector(`.step-item[data-step="${i}"]`).classList.add('done');
    }

    window.scrollTo(0, 0);
    calcPrice();
}

function validateStep(step) {
    const container = document.getElementById('step' + step);
    const required = container.querySelectorAll('input[required], select[required], textarea[required]');
    let valid = true;
    let firstInvalid = null;

    container.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

    required.forEach(el => {
        if (el.closest('#agentSection') && document.getElementById('agentSection').style.display === 'none') return;
        if (el.closest('#restudyFields') && document.getElementById('restudyFields').style.display === 'none') return;

        let value = '';
        if (el.type === 'file') value = el.files.length > 0 ? 'filled' : '';
        else if (el.type === 'checkbox') value = el.checked ? 'checked' : '';
        else value = el.value.trim();

        if (!value) {
            el.classList.add('is-invalid');
            valid = false;
            if (!firstInvalid) firstInvalid = el;
        }
    });

    if (!valid) {
        (toastr?.error || alert)('يرجى تعبئة جميع الحقول المطلوبة قبل الانتقال للخطوة التالية', 'حقول ناقصة');
        if (firstInvalid) { firstInvalid.focus(); firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
        return false;
    }
    return true;
}

// Terms modal
const termsContent = {
    payment: {
        title: 'شروط السداد الإلكتروني',
        body: `<h6 class="fw-bold mb-3" style="color: #0f1724;">شروط وأحكام السداد الإلكتروني عبر بوابة e-finance</h6>
<ul class="list-unstyled">
    <li class="mb-2"><i class="fas fa-check-circle ms-2" style="color: #27ae60;"></i> يتم السداد عبر بوابة الدفع الإلكتروني الحكومية (e-finance).</li>
    <li class="mb-2"><i class="fas fa-check-circle ms-2" style="color: #27ae60;"></i> المبلغ المسدد هو إجمالي قيمة الخدمة شاملاً الرسوم والضرائب المقررة.</li>
    <li class="mb-2"><i class="fas fa-check-circle ms-2" style="color: #27ae60;"></i> في حالة فشل عملية الدفع، يمكنك المحاولة مرة أخرى من خلال متابعة الطلب.</li>
    <li class="mb-2"><i class="fas fa-check-circle ms-2" style="color: #27ae60;"></i> المبالغ المدفوعة غير قابلة للاسترداد إلا في الحالات التي تحددها اللوائح.</li>
    <li class="mb-2"><i class="fas fa-check-circle ms-2" style="color: #27ae60;"></i> يجب الاحتفاظ برقم المعاملة للاستعلام عن حالة الطلب لاحقاً.</li>
</ul>`,
    },
    service: {
        title: 'شروط الخدمة والضوابط الفنية',
        body: document.getElementById('termsServiceData').innerHTML,
    },
};

function showTermsModal(type) {
    const content = termsContent[type];
    if (!content) return;
    document.getElementById('termsModalTitle').textContent = content.title;
    document.getElementById('termsModalBody').innerHTML = content.body;
    document.getElementById('termsAgreeCheck').checked = false;
    document.getElementById('termsConfirmBtn').disabled = true;
    document.getElementById('termsModal').setAttribute('data-terms-type', type);
    new bootstrap.Modal(document.getElementById('termsModal')).show();
}

document.getElementById('termsAgreeCheck').addEventListener('change', function() {
    document.getElementById('termsConfirmBtn').disabled = !this.checked;
});

function confirmTerms() {
    const type = document.getElementById('termsModal').getAttribute('data-terms-type');
    if (type === 'payment') {
        document.getElementById('agreePayment').checked = true;
    } else if (type === 'service') {
        document.getElementById('agreeService').checked = true;
    }
    bootstrap.Modal.getInstance(document.getElementById('termsModal')).hide();
}

document.getElementById('applyForm').addEventListener('submit', function(e) {
    // Validate all steps
    for (let s = 1; s <= 3; s++) {
        if (!validateStep(s)) {
            e.preventDefault();
            goStep(s);
            (toastr?.error || alert)('يوجد حقول ناقصة في الخطوة ' + s + '. يرجى مراجعتها.', 'بيانات ناقصة');
            return;
        }
    }
    const paymentChecked = document.getElementById('agreePayment').checked;
    const serviceChecked = document.getElementById('agreeService').checked;
    if (!paymentChecked || !serviceChecked) {
        e.preventDefault();
        (toastr?.error || alert)('يرجى الاطلاع على الشروط والموافقة عليها قبل الإرسال', 'شروط غير موافق عليها');
        if (!paymentChecked) document.getElementById('agreePayment').focus();
        else document.getElementById('agreeService').focus();
    }
});

// Live price on input
document.getElementById('applyForm').addEventListener('input', function(e) {
    if (e.target.classList.contains('dynamic-input')) calcPrice();
});
document.getElementById('request_type').addEventListener('change', calcPrice);

// Dependent dropdowns
async function loadUnits(id) {
    const res = await fetch(`/gis-portal/api/markaz/${id}/units`);
    const data = await res.json();
    document.getElementById('unit_select').innerHTML = '<option value="">-- اختر الوحدة --</option>' + data.map(i => `<option value="${i.id}">${i.name}</option>`).join('');
}
async function loadVillages(id) {
    const res = await fetch(`/gis-portal/api/unit/${id}/villages`);
    const data = await res.json();
    document.getElementById('village_select').innerHTML = '<option value="">-- اختر القرية --</option>' + data.map(i => `<option value="${i.id}">${i.name}${i.is_ezba ? ' (عزبة)' : ''}</option>`).join('');
}

calcPrice();
</script>
@endpush