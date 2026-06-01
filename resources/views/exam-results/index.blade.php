@extends('layouts.app')
@section('title', 'الاستعلام عن نتيجة تالتة إعدادي')
@push('css')
<style>
.result-hero {
    position: relative;
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
    background: linear-gradient(135deg, #0f161c 0%, #1a2744 40%, #2c3e50 100%);
}
.result-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 700px 400px at 30% 30%, rgba(225,177,44,0.07) 0%, transparent 60%),
        radial-gradient(ellipse 500px 300px at 70% 60%, rgba(225,177,44,0.04) 0%, transparent 60%);
}
.result-hero .container { position: relative; z-index: 2; }
.result-hero-icon {
    width: 100px; height: 100px; border-radius: 50%;
    background: linear-gradient(135deg, rgba(225,177,44,0.2), rgba(225,177,44,0.05));
    border: 3px solid rgba(225,177,44,0.3);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px; font-size: 2.6rem; color: #e1b12c;
}
.result-hero h1 { color: #fff; font-size: 2.4rem; font-weight: 900; }
.result-hero p { color: rgba(255,255,255,0.65); font-size: 1.05rem; margin-top: 10px; }

.result-body { padding: 50px 0; background: #f5f6fa; min-height: 400px; }

.search-card {
    background: #fff;
    border-radius: 20px;
    padding: 45px 40px;
    box-shadow: 0 2px 30px rgba(0,0,0,0.06);
    border: 1px solid #eef0f5;
    max-width: 560px;
    margin: 0 auto;
}
.search-card-title {
    font-size: 1.2rem;
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f5;
    text-align: center;
}
.search-input-group {
    display: flex;
    gap: 12px;
}
.search-input-group input {
    flex: 1;
    border-radius: 14px;
    border: 2px solid #e8eaef;
    padding: 14px 18px;
    font-size: 1.1rem;
    text-align: center;
    letter-spacing: 2px;
    transition: all 0.3s ease;
    background: #fafbfc;
    direction: ltr;
}
.search-input-group input:focus {
    border-color: #e1b12c;
    box-shadow: 0 0 0 4px rgba(225,177,44,0.12);
    background: #fff;
}
.search-input-group input::placeholder {
    letter-spacing: normal;
}
.search-btn {
    background: linear-gradient(135deg, #1e272e, #2c3e50);
    color: #e1b12c;
    border: none;
    padding: 14px 36px;
    border-radius: 14px;
    font-weight: 800;
    font-size: 1rem;
    transition: all 0.4s ease;
    white-space: nowrap;
}
.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    color: #e1b12c;
}
.search-btn:disabled {
    opacity: 0.6;
    transform: none;
}

/* Result card */
.result-card {
    max-width: 700px;
    margin: 30px auto 0;
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 2px 30px rgba(0,0,0,0.08);
    border: 1px solid #eef0f5;
    animation: fadeInUp 0.4s ease;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.result-header {
    padding: 30px 35px 20px;
    background: linear-gradient(135deg, #0f161c, #1a2744);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.result-header-info h2 { font-size: 1.4rem; font-weight: 800; }
.result-header-info .seat { color: rgba(255,255,255,0.5); font-size: 0.85rem; margin-top: 5px; }
.result-badge {
    padding: 10px 28px;
    border-radius: 50px;
    font-weight: 800;
    font-size: 1.1rem;
}
.result-badge.pass { background: rgba(46,204,113,0.2); color: #2ecc71; border: 2px solid rgba(46,204,113,0.3); }
.result-badge.fail { background: rgba(231,76,60,0.2); color: #e74c3c; border: 2px solid rgba(231,76,60,0.3); }
.result-body-inner { padding: 30px 35px; }
.result-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 25px; }
.result-meta-item { padding: 12px 16px; background: #f8f9fb; border-radius: 12px; }
.result-meta-item label { display: block; font-size: 0.8rem; color: #999; font-weight: 600; margin-bottom: 3px; }
.result-meta-item span { font-weight: 700; color: #1e272e; font-size: 0.95rem; }
.subjects-table { width: 100%; border-collapse: collapse; }
.subjects-table th {
    text-align: right; padding: 10px 14px;
    background: #f0f1f5; font-size: 0.85rem; font-weight: 700; color: #555;
}
.subjects-table td { padding: 10px 14px; border-bottom: 1px solid #f0f0f0; font-size: 0.95rem; }
.subjects-table tr:last-child td { border-bottom: none; }
.total-row td { font-weight: 800; font-size: 1.05rem; color: #1e272e; border-top: 2px solid #e1b12c !important; }

.result-search-again {
    text-align: center; padding: 20px 35px;
    border-top: 1px solid #f0f0f0;
}
.result-search-again a { color: #e1b12c; font-weight: 700; text-decoration: none; }

#resultContainer { display: none; }

@media (max-width: 767px) {
    .result-hero { height: 280px; }
    .result-hero h1 { font-size: 1.6rem; }
    .result-hero-icon { width: 70px; height: 70px; font-size: 1.8rem; }
    .search-card { padding: 30px 20px; }
    .search-input-group { flex-direction: column; }
    .search-btn { width: 100%; }
    .result-header { flex-direction: column; text-align: center; gap: 15px; }
    .result-meta { grid-template-columns: 1fr; }
    .result-body-inner { padding: 20px; }
}
</style>
@endpush
@section('content')
    <main class="main-content">
        <section class="result-hero">
            <div class="container">
                <div class="result-hero-icon"><i class="fas fa-graduation-cap"></i></div>
                <h1>الاستعلام عن نتيجة تالتة إعدادي</h1>
                <p>أدخل رقم الجلوس للاستعلام عن النتيجة — البيانات محدثة ومعتمدة من المديرية</p>
            </div>
        </section>
        <section class="result-body">
            <div class="container">
                @if (session('error'))
                    <div class="text-center mb-4">
                        <div class="alert alert-danger d-inline-block rounded-pill px-4" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        </div>
                    </div>
                @endif

                <div class="search-card" id="searchCard">
                    <div class="search-card-title">
                        <i class="fas fa-search me-2"></i> أدخل رقم الجلوس
                    </div>
                    <form id="resultForm" autocomplete="off">
                        @csrf
                        <div class="search-input-group">
                            <input type="text" name="seat_number" id="seat_number" class="form-control"
                                placeholder="مثال: 123456" inputmode="numeric" pattern="[0-9]+" maxlength="10" required
                                autofocus>
                            <button type="submit" class="search-btn" id="searchBtn">
                                <i class="fas fa-search"></i> بحث
                            </button>
                        </div>
                    </form>
                </div>

                <div id="resultContainer"></div>
            </div>
        </section>
    </main>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('resultForm');
    const searchBtn = document.getElementById('searchBtn');
    const seatInput = document.getElementById('seat_number');
    const resultContainer = document.getElementById('resultContainer');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const seat = seatInput.value.trim();
        if (!seat) return;

        searchBtn.disabled = true;
        searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري البحث...';
        resultContainer.style.display = 'none';

        fetch('{{ route("exam-results.lookup") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ seat_number: seat })
        })
        .then(res => res.json())
        .then(data => {
            if (data.not_found) {
                resultContainer.innerHTML = `
                    <div class="text-center mt-4">
                        <div class="alert alert-warning d-inline-block rounded-pill px-4">
                            <i class="fas fa-exclamation-triangle me-2"></i> ${data.message}
                        </div>
                    </div>`;
                resultContainer.style.display = 'block';
                return;
            }

            const isPass = data.status === 'pass';
            const badgeClass = isPass ? 'pass' : 'fail';
            const badgeText = isPass ? 'ناجح' : 'راسب';

            let subjectsHtml = '';
            if (data.subjects && data.subjects.length) {
                subjectsHtml = `
                <table class="subjects-table">
                    <thead><tr><th>المادة</th><th style="width:120px;text-align:center">الدرجة</th></tr></thead>
                    <tbody>
                        ${data.subjects.map(s => `
                            <tr><td>${s.name}</td><td style="text-align:center">${s.grade}</td></tr>
                        `).join('')}
                        <tr class="total-row"><td>المجموع الكلي</td><td style="text-align:center">${data.total_grade}</td></tr>
                    </tbody>
                </table>`;
            } else {
                subjectsHtml = `<p class="text-muted text-center">المجموع الكلي: <strong>${data.total_grade}</strong></p>`;
            }

            resultContainer.innerHTML = `
                <div class="result-card">
                    <div class="result-header">
                        <div class="result-header-info">
                            <h2>${data.student_name}</h2>
                            <div class="seat">رقم الجلوس: ${data.seat_number}</div>
                        </div>
                        <div class="result-badge ${badgeClass}">${badgeText}</div>
                    </div>
                    <div class="result-body-inner">
                        <div class="result-meta">
                            <div class="result-meta-item">
                                <label>المدرسة</label>
                                <span>${data.school || '—'}</span>
                            </div>
                            <div class="result-meta-item">
                                <label>العام الدراسي</label>
                                <span>${data.academic_year || '—'}</span>
                            </div>
                        </div>
                        ${subjectsHtml}
                    </div>
                    <div class="result-search-again">
                        <a href="#" onclick="resetSearch(); return false;">
                            <i class="fas fa-redo me-1"></i> استعلام عن نتيجة أخرى
                        </a>
                    </div>
                </div>`;
            resultContainer.style.display = 'block';
            resultContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        })
        .catch(() => {
            resultContainer.innerHTML = `
                <div class="text-center mt-4">
                    <div class="alert alert-danger d-inline-block rounded-pill px-4">
                        <i class="fas fa-times-circle me-2"></i> حدث خطأ في الاتصال، حاول مرة أخرى
                    </div>
                </div>`;
            resultContainer.style.display = 'block';
        })
        .finally(() => {
            searchBtn.disabled = false;
            searchBtn.innerHTML = '<i class="fas fa-search"></i> بحث';
        });
    });

    window.resetSearch = function() {
        resultContainer.style.display = 'none';
        resultContainer.innerHTML = '';
        seatInput.value = '';
        seatInput.focus();
    };
});
</script>
@endpush