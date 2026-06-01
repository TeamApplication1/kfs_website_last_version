@extends('layouts.app')
@section('title', 'الخدمات المكانية')
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
        .badge-status-received { background: rgba(52, 152, 219, 0.1); color: #2980b9; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; }
        .badge-status-processing { background: rgba(243, 156, 18, 0.1); color: #f39c12; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; }
        .badge-status-completed { background: var(--dash-navy); color: var(--dash-gold); padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; }
        .badge-status-rejected { background: rgba(231, 76, 60, 0.1); color: #e74c3c; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; }
        .btn-outline-gold { border: 1px solid var(--dash-gold); color: var(--dash-gold); }
        .btn-outline-gold:hover { background: var(--dash-gold); color: #fff; }
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
            $('#gisTable').DataTable({
                language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json' },
                order: [[2, 'desc']],
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
                        <h2 class="page-title mb-4">الخدمات المكانية</h2>
                        <div class="white-section-card shadow-sm p-4 mb-5">
                            <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                                <i class="fas fa-map-marked-alt text-info fs-4 ms-2"></i>
                                <h3 class="m-0 section-head">سجل طلبات الخدمات المكانية</h3>
                                <span class="badge bg-info text-white me-2">{{ $gisSubmissions->count() }}</span>
                            </div>
                            @include('citizen.dashboard.partials.gis-table')
                        </div>
                    </div>
                </main>
                @include('citizen.dashboard.partials.sidebar', ['activeNav' => 'gis', 'fulfillmentCount' => $fulfillmentCount ?? 0])
            </div>
        </div>
    </div>
@endsection