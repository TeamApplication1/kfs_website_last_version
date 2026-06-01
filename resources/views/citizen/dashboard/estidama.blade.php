@extends('layouts.app')
@section('title', 'استدامة')
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
            $('#estidamaTable').DataTable({
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
                        <h2 class="page-title mb-4">برامج استدامة</h2>
                        <div class="white-section-card shadow-sm p-4 mb-5">
                            <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                                <i class="fas fa-graduation-cap text-success fs-4 ms-2"></i>
                                <h3 class="m-0 section-head">سجل البرامج التدريبية</h3>
                                <span class="badge bg-success text-white me-2">{{ $enrollments->count() + $trainingApplications->count() }}</span>
                            </div>
                            @include('citizen.dashboard.partials.estidama-table')
                        </div>
                    </div>
                </main>
                @include('citizen.dashboard.partials.sidebar', ['activeNav' => 'estidama', 'fulfillmentCount' => $fulfillmentCount ?? 0])
            </div>
        </div>
    </div>
@endsection