@extends('layouts.app')
@section('title', 'الاستيفاء والمتابعة')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        body { padding: 0; }
        header { display: none; }
        .custom-dash-table { border-collapse: separate; border-spacing: 0 8px; }
        .custom-dash-table thead th { border: none; font-size: 0.85rem; color: #8492a6; }
        .custom-dash-table tbody tr { transition: 0.3s; background: #fdfdfd; }
        .custom-dash-table tbody tr td { border-top: 1px solid #eee; border-bottom: 1px solid #eee; padding: 15px 10px; }
        .custom-dash-table tbody tr td:first-child { border-right: 1px solid #eee; border-radius: 0 10px 10px 0; }
        .custom-dash-table tbody tr td:last-child { border-left: 1px solid #eee; border-radius: 10px 0 0 10px; }
        .fulfillment-badge-review { background: rgba(243, 156, 18, 0.15); color: #e67e22; padding: 4px 14px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
        .fulfillment-badge-pay { background: rgba(231, 76, 60, 0.15); color: #c0392b; padding: 4px 14px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
        .fulfillment-badge-docs { background: rgba(52, 152, 219, 0.15); color: #2980b9; padding: 4px 14px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
        .fulfillment-badge-retry { background: rgba(142, 68, 173, 0.15); color: #8e44ad; padding: 4px 14px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
        .white-section-card { background: #fff; border-radius: 20px; border: 1px solid #edf2f9; }
        .section-head { font-weight: 900; color: var(--dash-navy); }
        div.dataTables_wrapper { direction: rtl; }
        div.dataTables_wrapper .dataTables_filter { float: left; text-align: left; }
        div.dataTables_wrapper .dataTables_filter input { margin-right: 8px; }
        div.dataTables_wrapper .dataTables_paginate { float: left; }
        div.dataTables_wrapper .dataTables_length { float: right; }
    </style>
@endpush
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#fulfillmentTable').DataTable({
                language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json' },
                order: [[3, 'desc']],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'الكل']]
            });
        });
    </script>
@endpush
@section('content')
    <div class="dashboard-root">
        <div class="container-fluid g-0">
            <div class="dashboard-layout">
                <main class="dashboard-content-area">
                    @include('citizen.dashboard.partials.top-nav')
                    <div class="px-4">
                        <h2 class="page-title mb-4">الاستيفاء — إجراءات مطلوبة</h2>
                        @if ($fulfillmentItems->isNotEmpty())
                            <div class="white-section-card shadow-sm p-4 mb-5">
                                <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                                    <i class="fas fa-tasks text-warning fs-4 ms-2"></i>
                                    <h3 class="m-0 section-head">الطلبات التي تحتاج متابعة</h3>
                                    <span class="badge bg-warning text-dark me-2">{{ $fulfillmentItems->count() }}</span>
                                </div>
                                @include('citizen.dashboard.partials.fulfillment-table')
                            </div>
                        @else
                            <div class="white-section-card shadow-sm p-4 mb-5 text-center py-5">
                                <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                                <h5 class="text-muted">لا توجد إجراءات مطلوبة حالياً</h5>
                                <p class="text-muted">جميع طلباتك محدثة ولا تحتاج لمتابعة</p>
                            </div>
                        @endif
                    </div>
                </main>
                @include('citizen.dashboard.partials.sidebar', ['activeNav' => 'fulfillment', 'fulfillmentCount' => $fulfillmentItems->count()])
            </div>
        </div>
    </div>
@endsection