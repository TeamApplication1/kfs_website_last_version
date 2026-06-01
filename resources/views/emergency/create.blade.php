@extends('layouts.app')
@section('title', 'تقديم بلاغ طارئ')
@push('css')
<style>
.emergency-hero {
    position: relative;
    height: 380px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
    background: linear-gradient(135deg, #1a1a2e 0%, #c0392b 50%, #1a1a2e 100%);
}
.emergency-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 700px 400px at 50% 30%, rgba(231,76,60,0.15) 0%, transparent 60%),
        radial-gradient(ellipse 500px 300px at 80% 70%, rgba(231,76,60,0.08) 0%, transparent 60%);
}
.emergency-hero .container { position: relative; z-index: 2; }
.emergency-hero .hero-icon {
    width: 90px; height: 90px; border-radius: 50%;
    background: rgba(231,76,60,0.2);
    border: 3px solid rgba(231,76,60,0.4);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px; font-size: 2.4rem; color: #fff;
    animation: pulse-border 2s infinite;
}
@keyframes pulse-border {
    0% { box-shadow: 0 0 0 0 rgba(231,76,60,0.4); }
    70% { box-shadow: 0 0 0 20px rgba(231,76,60,0); }
    100% { box-shadow: 0 0 0 0 rgba(231,76,60,0); }
}
.emergency-hero h1 { color: #fff; font-size: 2.4rem; font-weight: 900; }
.emergency-hero p { color: rgba(255,255,255,0.7); font-size: 1.05rem; margin-top: 10px; }

.emergency-body { padding: 50px 0; background: #f5f6fa; min-height: 400px; }

.form-card {
    background: #fff;
    border-radius: 20px;
    padding: 35px 40px;
    margin-bottom: 30px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.06);
    border: 1px solid #eef0f5;
    position: relative;
    overflow: hidden;
}
.form-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, #c0392b, #e74c3c, #c0392b);
}
.form-card-title {
    font-size: 1.15rem;
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f5;
    display: flex;
    align-items: center;
    gap: 10px;
}
.form-card-title i {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #c0392b, #e74c3c);
    border-radius: 10px;
    display: inline-flex; align-items: center; justify-content: center;
    color: #fff; font-size: 0.9rem;
}
.form-card .form-label { font-weight: 700; color: #2d3436; font-size: 0.9rem; margin-bottom: 6px; }
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
    border-color: #c0392b;
    box-shadow: 0 0 0 4px rgba(192,57,43,0.1);
    background: #fff;
}
.form-card .form-check-input:checked {
    background-color: #c0392b;
    border-color: #c0392b;
}

.type-toggle {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
.type-toggle .form-check {
    padding: 0;
    margin: 0;
}
.type-toggle .form-check-input {
    display: none;
}
.type-toggle .form-check-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 24px;
    border-radius: 12px;
    border: 2px solid #e8eaef;
    background: #fafbfc;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
    font-size: 0.9rem;
    color: #636e72;
}
.type-toggle .form-check-input:checked + .form-check-label {
    border-color: #c0392b;
    background: #fff5f5;
    color: #c0392b;
}
.type-toggle .form-check-input:checked + .form-check-label i {
    color: #c0392b;
}

.submit-btn {
    background: linear-gradient(135deg, #c0392b, #e74c3c);
    color: #fff;
    border: none;
    padding: 16px 60px;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 800;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}
.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 40px rgba(192,57,43,0.3);
    color: #fff;
}
.submit-btn:active { transform: translateY(0); }

.location-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 12px;
    border: 2px dashed #b2bec3;
    background: transparent;
    color: #636e72;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
}
.location-btn:hover {
    border-color: #c0392b;
    color: #c0392b;
    background: #fff5f5;
}
.location-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

@media (max-width: 767px) {
    .emergency-hero { height: 280px; }
    .emergency-hero h1 { font-size: 1.6rem; }
    .emergency-hero .hero-icon { width: 65px; height: 65px; font-size: 1.6rem; }
    .form-card { padding: 25px 20px; }
    .type-toggle .form-check-label { padding: 8px 16px; font-size: 0.85rem; }
}
</style>
@endpush
@section('content')
    <main class="main-content">
        <section class="emergency-hero">
            <div class="container">
                <div class="hero-icon"><i class="fas fa-exclamation-triangle"></i></div>
                <h1>مركز سيطرة الشبكة الوطنية للطوارئ</h1>
                <p>نظام الإبلاغ الموحد للحالات الطارئة — يتم تحويل بلاغك فورًا إلى الجهة المختصة</p>
            </div>
        </section>
        <section class="emergency-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <form action="{{ route('emergency.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">

                            {{-- Card 1: Personal Info --}}
                            <div class="form-card">
                                <h4 class="form-card-title"><i class="fas fa-user"></i> بيانات مقدم البلاغ</h4>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="reporter_name" class="form-label">الاسم بالكامل <span class="text-danger">*</span></label>
                                        <input type="text" id="reporter_name" name="reporter_name" class="form-control"
                                            value="{{ old('reporter_name') }}" required placeholder="أدخل الاسم">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="reporter_phone" class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                                        <input type="tel" id="reporter_phone" name="reporter_phone" class="form-control"
                                            value="{{ old('reporter_phone') }}" required placeholder="01XXXXXXXXX">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="reporter_national_id" class="form-label">الرقم القومي <span class="text-danger">*</span></label>
                                        <input type="text" id="reporter_national_id" name="reporter_national_id"
                                            class="form-control" pattern="\d{14}" title="يجب إدخال 14 رقمًا"
                                            value="{{ old('reporter_national_id') }}" required placeholder="14 رقم">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="report_type" class="form-label">نوع البلاغ <span class="text-danger">*</span></label>
                                        <select class="form-select" id="report_type" name="report_type" required>
                                            <option value="" disabled selected>-- اختر نوع البلاغ --</option>
                                            @foreach ($reportTypes as $type)
                                                <option value="{{ $type }}" {{ old('report_type') == $type ? 'selected' : '' }}>
                                                    {{ $type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Card 2: Location Info --}}
                            <div class="form-card">
                                <h4 class="form-card-title"><i class="fas fa-map-marker-alt"></i> موقع الحادث</h4>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label">نوع المكان <span class="text-danger">*</span></label>
                                        <div class="type-toggle">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="location_type"
                                                    id="loc_type_city" value="مدينة"
                                                    {{ old('location_type', 'مدينة') == 'مدينة' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="loc_type_city">
                                                    <i class="fas fa-city"></i> مدينة
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="location_type"
                                                    id="loc_type_village" value="قرية"
                                                    {{ old('location_type') == 'قرية' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="loc_type_village">
                                                    <i class="fas fa-home"></i> قرية
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="center" class="form-label">المركز <span class="text-danger">*</span></label>
                                        <select class="form-select" id="center" name="center" required>
                                            <option value="" disabled selected>-- اختر المركز --</option>
                                            @foreach ($centers as $center)
                                                <option value="{{ $center->name }}" data-id="{{ $center->id }}"
                                                    {{ old('center') == $center->name ? 'selected' : '' }}>
                                                    {{ $center->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="area" class="form-label">القرية / المدينة <span class="text-danger">*</span></label>
                                        <select class="form-select" id="area" name="area" required>
                                            <option value="" disabled selected>-- اختر المركز أولاً --</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="location_description" class="form-label">وصف تفصيلي للموقع <span class="text-danger">*</span></label>
                                        <textarea id="location_description" name="location_description" class="form-control" rows="3"
                                            placeholder="مثال: بجوار مدرسة X، خلف مستشفى Y..." required>{{ old('location_description') }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" id="getLocationBtn" class="location-btn">
                                            <i class="fas fa-map-marker-alt"></i> تحديد موقعي الحالي تلقائيًا
                                        </button>
                                        <small class="d-block text-muted mt-2">
                                            <i class="fas fa-info-circle"></i> سيتم إرفاق إحداثيات الموقع لمساعدة فرق الطوارئ
                                        </small>
                                    </div>
                                </div>
                            </div>

                            {{-- Card 3: Details --}}
                            <div class="form-card">
                                <h4 class="form-card-title"><i class="fas fa-file-alt"></i> تفاصيل البلاغ</h4>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label for="details" class="form-label">بيان تفصيلي للبلاغ</label>
                                        <textarea name="details" id="details" class="form-control" rows="5"
                                            placeholder="اشرح تفاصيل الحادث بشكل دقيق...">{{ old('details') }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label for="attachments" class="form-label">مرفقات (صور، فيديو، مستندات)</label>
                                        <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
                                        <small class="text-muted">الحد الأقصى 10MB لكل ملف — صيغ JPG, PNG, PDF, MP4</small>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="submit-btn">
                                    <i class="fas fa-paper-plane"></i> إرسال البلاغ فورًا
                                </button>
                                <p class="text-muted mt-3 mb-0">
                                    <i class="fas fa-shield-alt"></i> جميع البيانات مؤمنة ويتم التعامل معها بسرية تامة
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const centerSelect = document.getElementById('center');
    const areaSelect = document.getElementById('area');
    const getLocationBtn = document.getElementById('getLocationBtn');
    const latInput = document.getElementById('latitude');
    const lonInput = document.getElementById('longitude');

    // --- Dependent dropdown: Villages by Center ---
    centerSelect.addEventListener('change', function() {
        const centerId = this.options[this.selectedIndex]?.dataset?.id;
        if (!centerId) {
            areaSelect.innerHTML = '<option value="" disabled selected>-- اختر المركز أولاً --</option>';
            return;
        }

        areaSelect.innerHTML = '<option value="" disabled selected>جاري التحميل...</option>';

        fetch(`/emergency-report/villages/${centerId}`)
            .then(res => res.json())
            .then(data => {
                if (!data.length) {
                    areaSelect.innerHTML = '<option value="" disabled selected>-- لا توجد قرى مضافه --</option>';
                    return;
                }
                let html = '<option value="" disabled selected>-- اختر القرية / المدينة --</option>';
                data.forEach(v => {
                    const label = v.type === 'city' ? '🏙️ ' : '🏡 ';
                    html += `<option value="${v.name}">${label}${v.name}</option>`;
                });
                areaSelect.innerHTML = html;
            })
            .catch(() => {
                areaSelect.innerHTML = '<option value="" disabled selected>فشل التحميل</option>';
            });
    });

    // Trigger on page load if old center is selected (after validation error)
    if (centerSelect.value) {
        centerSelect.dispatchEvent(new Event('change'));
    }

    // --- Geolocation ---
    if (getLocationBtn && navigator.geolocation) {
        getLocationBtn.addEventListener('click', () => {
            getLocationBtn.disabled = true;
            getLocationBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري تحديد الموقع...';

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    latInput.value = position.coords.latitude;
                    lonInput.value = position.coords.longitude;

                    getLocationBtn.innerHTML = '<i class="fas fa-check-circle" style="color:#27ae60"></i> تم تحديد الموقع بنجاح!';
                    getLocationBtn.style.borderColor = '#27ae60';
                    getLocationBtn.style.color = '#27ae60';
                },
                () => {
                    Swal.fire({
                        icon: 'warning',
                        title: 'تعذر الوصول للموقع',
                        text: 'يرجى التأكد من تفعيل خدمات الموقع في متصفحك',
                        confirmButtonText: 'حسناً',
                        confirmButtonColor: '#c0392b'
                    });
                    getLocationBtn.disabled = false;
                    getLocationBtn.innerHTML = '<i class="fas fa-map-marker-alt"></i> تحديد موقعي الحالي تلقائيًا';
                    getLocationBtn.style.borderColor = '#b2bec3';
                    getLocationBtn.style.color = '#636e72';
                }
            );
        });
    }
});
</script>
@endpush