<div class="white-section-card shadow-sm p-4 mb-5">
    <div class="d-flex align-items-center mb-3 border-bottom pb-2">
        <i class="fas fa-chart-line text-success fs-4 ms-2"></i>
        <h3 class="m-0 section-head">نشاطك — آخر 7 أيام</h3>
    </div>
    <div class="chart-container">
        <canvas id="activityChart"></canvas>
    </div>
</div>
@push('scripts')
    <script>
        var ctx = document.getElementById('activityChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['labels']) !!},
                datasets: [{
                    label: 'خدمات عامة',
                    data: {!! json_encode($chartData['services']) !!},
                    borderColor: '#1e272e',
                    backgroundColor: 'rgba(30,39,46,0.1)',
                    tension: 0.3,
                    fill: true
                }, {
                    label: 'خدمات مكانية',
                    data: {!! json_encode($chartData['gis']) !!},
                    borderColor: '#16a085',
                    backgroundColor: 'rgba(22,160,133,0.1)',
                    tension: 0.3,
                    fill: true
                }, {
                    label: 'شكاوي',
                    data: {!! json_encode($chartData['complaints']) !!},
                    borderColor: '#e1b12c',
                    backgroundColor: 'rgba(225,177,44,0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', rtl: true }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    </script>
@endpush