@extends('layouts.app')
@section('title', 'لوحة التحكم')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <style>
        body { padding: 0; }
        header { display: none; }
        .custom-dash-table { border-collapse: separate; border-spacing: 0 8px; }
        .custom-dash-table thead th { border: none; font-size: 0.85rem; color: #8492a6; }
        .custom-dash-table tbody tr { transition: 0.3s; background: #fdfdfd; }
        .custom-dash-table tbody tr td { border-top: 1px solid #eee; border-bottom: 1px solid #eee; padding: 15px 10px; }
        .custom-dash-table tbody tr td:first-child { border-right: 1px solid #eee; border-radius: 0 10px 10px 0; }
        .custom-dash-table tbody tr td:last-child { border-left: 1px solid #eee; border-radius: 10px 0 0 10px; }
        .icon-sm-circle { width: 35px; height: 35px; background: rgba(30, 39, 46, 0.05); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--dash-navy); }
        .badge-status-awaiting_payment { background: rgba(231, 76, 60, 0.1); color: #e74c3c; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; }
        .badge-status-paid { background: rgba(46, 204, 113, 0.1); color: #27ae60; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; }
        .badge-status-completed { background: var(--dash-navy); color: var(--dash-gold); padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; }
        .badge-status-resolved { background: rgba(39, 174, 96, 0.1); color: #27ae60; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; }
        .badge-status-in_progress { background: rgba(52, 152, 219, 0.1); color: #2980b9; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; }
        .btn-outline-gold { border: 1px solid var(--dash-gold); color: var(--dash-gold); }
        .btn-outline-gold:hover { background: var(--dash-gold); color: #fff; }
        .stat-card.green { background: linear-gradient(135deg, #27ae60, #2ecc71); }
        .stat-card.purple { background: linear-gradient(135deg, #8e44ad, #9b59b6); }
        .stat-card.red { background: linear-gradient(135deg, #c0392b, #e74c3c); }
        .stat-card.teal { background: linear-gradient(135deg, #16a085, #1abc9c); }
        .stat-card.orange { background: linear-gradient(135deg, #d35400, #e67e22); }
        .nav-tabs-custom .nav-link { border: none; color: #8492a6; font-weight: 700; padding: 10px 20px; border-radius: 10px; }
        .nav-tabs-custom .nav-link.active { background: var(--dash-navy); color: var(--dash-gold); }
        .nav-tabs-custom .nav-link:hover { color: var(--dash-navy); }
        .fulfillment-badge-review { background: rgba(243, 156, 18, 0.15); color: #e67e22; padding: 4px 14px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
        .fulfillment-badge-pay { background: rgba(231, 76, 60, 0.15); color: #c0392b; padding: 4px 14px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
        .fulfillment-badge-docs { background: rgba(52, 152, 219, 0.15); color: #2980b9; padding: 4px 14px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
        .fulfillment-badge-retry { background: rgba(142, 68, 173, 0.15); color: #8e44ad; padding: 4px 14px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
        .chart-container { position: relative; height: 250px; }
        .dash-accordion-item { background: #f8fafd; border-radius: 12px; border: 1px solid #edf2f9; }
        .dash-accordion-header { width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 18px 20px; background: none; border: none; outline: none !important; }
        .title-side { display: flex; align-items: center; gap: 12px; }
        .status-indicator { width: 8px; height: 8px; border-radius: 50%; }
        .status-indicator.resolved { background: #27ae60; }
        .status-indicator.pending { background: #f39c12; }
        .dash-accordion-header h6 { margin: 0; font-weight: 800; color: var(--dash-navy); }
        .meta-side { display: flex; align-items: center; gap: 15px; }
        .time-text { font-size: 0.75rem; color: #8492a6; }
        .arrow-ico { transition: 0.3s; font-size: 0.8rem; color: #ccc; }
        .dash-accordion-header:not(.collapsed) .arrow-ico { transform: rotate(180deg); }
        .msg-box { padding: 15px; border-radius: 10px; margin-bottom: 10px; }
        .msg-box.user { background: #f1f4f8; }
        .msg-box.admin { background: rgba(225, 177, 44, 0.05); border-right: 3px solid var(--dash-gold); }
        .msg-box label { font-size: 0.75rem; font-weight: 700; color: #8492a6; display: block; margin-bottom: 5px; }
    </style>
@endpush

@section('content')
    <div class="dashboard-root">
        <div class="container-fluid g-0">
            <div class="dashboard-layout">
                <main class="dashboard-content-area">
                    @include('citizen.dashboard.partials.top-nav')
                    <div class="px-4">
                        <h2 class="page-title mb-4">أهلاً بك، {{ explode(' ', $user->name)[0] }} 👋</h2>
                        @include('citizen.dashboard.partials.stats-cards')

                        @php $fulfillmentItems = $fulfillmentItems->take(5); @endphp
                        @include('citizen.dashboard.partials.fulfillment-table')
                        @if ($fulfillmentItems->isNotEmpty())
                        <div class="text-center mb-4">
                            <a href="{{ route('citizen.dashboard.fulfillment') }}" class="btn btn-outline-gold btn-sm rounded-pill">عرض الكل ←</a>
                        </div>
                        @endif

                        @php
                            $serviceSubmissions = $serviceSubmissions->take(5);
                            $gisSubmissions = $gisSubmissions->take(5);
                            $enrollments = $enrollments->take(5);
                            $trainingApplications = $trainingApplications->take(5);
                        @endphp
                        <div class="white-section-card shadow-sm p-4 mb-5">
                            <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                                <i class="fas fa-file-invoice-dollar text-warning fs-4 ms-2"></i>
                                <h3 class="m-0 section-head">طلباتي المقدمة</h3>
                            </div>
                            <ul class="nav nav-tabs-custom mb-3" id="submissionsTabs" role="tablist">
                                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-services">خدمات عامة ({{ $stats['services'] }})</button></li>
                                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-gis">خدمات مكانية ({{ $stats['gis'] }})</button></li>
                                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-estidama">استدامة ({{ $stats['estidama'] }})</button></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab-services">
                                    @include('citizen.dashboard.partials.services-table')
                                    <div class="text-center mt-3">
                                        <a href="{{ route('citizen.dashboard.services') }}" class="btn btn-outline-gold btn-sm rounded-pill">عرض كل الخدمات العامة ←</a>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-gis">
                                    @include('citizen.dashboard.partials.gis-table')
                                    <div class="text-center mt-3">
                                        <a href="{{ route('citizen.dashboard.gis') }}" class="btn btn-outline-gold btn-sm rounded-pill">عرض كل الخدمات المكانية ←</a>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-estidama">
                                    @include('citizen.dashboard.partials.estidama-table')
                                    <div class="text-center mt-3">
                                        <a href="{{ route('citizen.dashboard.estidama') }}" class="btn btn-outline-gold btn-sm rounded-pill">عرض كل برامج استدامة ←</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php
                            $complaints = $complaints->take(5);
                            $suggestions = $suggestions->take(5);
                            $contactMessages = $contactMessages->take(5);
                            $emergencyReports = $emergencyReports->take(5);
                        @endphp
                        <div class="white-section-card shadow-sm p-4 mb-5">
                            <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                                <i class="fas fa-comments-alt text-primary fs-4 ms-2"></i>
                                <h3 class="m-0 section-head">المراقبة — الشكاوي والمقترحات والتواصل</h3>
                            </div>
                            <ul class="nav nav-tabs-custom mb-3" id="monitoringTabs" role="tablist">
                                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#mon-complaints">شكاوي ({{ $stats['complaints'] }})</button></li>
                                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#mon-suggestions">مقترحات ({{ $stats['suggestions'] }})</button></li>
                                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#mon-contact">رسائل تواصل ({{ $stats['contactMessages'] }})</button></li>
                                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#mon-emergency">بلاغات طوارئ ({{ $stats['emergencyReports'] }})</button></li>
                            </ul>
                            <div class="tab-content">
                                @include('citizen.dashboard.partials.complaints-tab')
                                @include('citizen.dashboard.partials.suggestions-tab')
                                @include('citizen.dashboard.partials.messages-tab')
                                @include('citizen.dashboard.partials.emergency-tab')
                            </div>
                            <div class="text-center mt-3">
                                <a href="{{ route('citizen.dashboard.monitoring') }}" class="btn btn-outline-gold btn-sm rounded-pill">عرض الكل ←</a>
                            </div>
                        </div>
                        @include('citizen.dashboard.partials.chart')
                    </div>
                </main>
                @include('citizen.dashboard.partials.sidebar', ['activeNav' => 'overview', 'fulfillmentCount' => $fulfillmentCount])
            </div>
        </div>
    </div>
@endsection
