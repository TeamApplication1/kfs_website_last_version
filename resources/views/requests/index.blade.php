@extends('layouts.app')
@section('title', 'تقديم طلب')
@push('css')
<style>
.request-hero {
    position: relative;
    height: 320px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
    background: linear-gradient(135deg, #1e272e 0%, #2c3e50 50%, #1e272e 100%);
}
.request-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 600px 300px at 30% 40%, rgba(225,177,44,0.06) 0%, transparent 60%),
        radial-gradient(ellipse 400px 200px at 70% 60%, rgba(225,177,44,0.04) 0%, transparent 60%);
}
.request-hero .container { position: relative; z-index: 2; }
.request-hero h1 { color: #fff; font-size: 2.6rem; font-weight: 900; }
.request-hero p { color: rgba(255,255,255,0.6); font-size: 1.1rem; max-width: 500px; margin: 10px auto 0; }

.request-cards {
    padding: 60px 0;
}
.request-card {
    display: block;
    border-radius: 24px;
    padding: 50px 40px;
    text-align: center;
    text-decoration: none !important;
    height: 100%;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}
.request-card-complaint {
    background: linear-gradient(135deg, #1e272e 0%, #2c3e50 100%);
    color: #fff;
}
.request-card-emergency {
    background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
    color: #fff;
}
.request-card-icon {
    width: 90px;
    height: 90px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.4rem;
    margin: 0 auto 25px;
    background: rgba(255,255,255,0.12);
    transition: all 0.4s ease;
}
.request-card h3 {
    font-size: 1.6rem;
    font-weight: 800;
    margin-bottom: 12px;
}
.request-card p {
    opacity: 0.8;
    font-size: 0.95rem;
    line-height: 1.7;
    max-width: 340px;
    margin: 0 auto;
}
.request-card-arrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 25px;
    font-weight: 700;
    font-size: 0.9rem;
    padding: 10px 24px;
    border-radius: 50px;
    background: rgba(255,255,255,0.12);
    transition: all 0.3s ease;
}
.request-card:hover { transform: translateY(-10px); box-shadow: 0 25px 60px rgba(0,0,0,0.15); }
.request-card:hover .request-card-icon { transform: scale(1.1) rotate(5deg); }
.request-card:hover .request-card-arrow { background: rgba(255,255,255,0.25); gap: 14px; }

@media (max-width: 767px) {
    .request-hero { height: 250px; }
    .request-hero h1 { font-size: 1.8rem; }
    .request-card { padding: 35px 25px; }
}
</style>
@endpush
@section('content')
    <main class="main-content">
        <section class="request-hero">
            <div class="container">
                <h1>كيف يمكننا مساعدتك؟</h1>
                <p>اختر نوع الطلب الذي تريد تقديمه وسيتم توجيهك إلى النموذج المناسب</p>
            </div>
        </section>
        <div class="container">
            <div class="request-cards">
                <div class="row g-4 justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <a href="{{ route('complaints.create') }}" class="request-card request-card-complaint">
                            <div class="request-card-icon"><i class="fas fa-edit"></i></div>
                            <h3>تقديم شكوى</h3>
                            <p>إذا كنت تواجه مشكلة مع إحدى الخدمات أو لديك استفسار حول معاملة رسمية</p>
                            <span class="request-card-arrow">
                                ابدأ الآن <i class="fas fa-arrow-left"></i>
                            </span>
                        </a>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <a href="{{ route('emergency.create') }}" class="request-card request-card-emergency">
                            <div class="request-card-icon"><i class="fas fa-exclamation-triangle"></i></div>
                            <h3>بلاغ عاجل</h3>
                            <p>للإبلاغ عن حالات طارئة أو مخالفات أو مشكلات تحتاج إلى تدخل فوري</p>
                            <span class="request-card-arrow">
                                ابدأ الآن <i class="fas fa-arrow-left"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
