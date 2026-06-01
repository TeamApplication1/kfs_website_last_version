@extends('layouts.app')
@section('title', 'الشكاوي والمقترحات')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        body { padding: 0; }
        header { display: none; }
        .custom-dash-table { border-collapse: separate; border-spacing: 0 8px; }
        .badge-status-awaiting_payment { background: rgba(231, 76, 60, 0.1); color: #e74c3c; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; }
        .badge-status-completed { background: var(--dash-navy); color: var(--dash-gold); padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; }
        .badge-status-resolved { background: rgba(39, 174, 96, 0.1); color: #27ae60; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; }
        .badge-status-in_progress { background: rgba(52, 152, 219, 0.1); color: #2980b9; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; }
        .white-section-card { background: #fff; border-radius: 20px; border: 1px solid #edf2f9; }
        .section-head { font-weight: 900; color: var(--dash-navy); }
        .nav-tabs-custom .nav-link { border: none; color: #8492a6; font-weight: 700; padding: 10px 20px; border-radius: 10px; }
        .nav-tabs-custom .nav-link.active { background: var(--dash-navy); color: var(--dash-gold); }
        .nav-tabs-custom .nav-link:hover { color: var(--dash-navy); }
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
                        <h2 class="page-title mb-4">الشكاوي والمقترحات والتواصل</h2>
                        <div class="white-section-card shadow-sm p-4 mb-5">
                            <ul class="nav nav-tabs-custom mb-3" id="monitoringTabs" role="tablist">
                                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#mon-complaints">شكاوي ({{ $complaints->count() }})</button></li>
                                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#mon-suggestions">مقترحات ({{ $suggestions->count() }})</button></li>
                                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#mon-contact">رسائل تواصل ({{ $contactMessages->count() }})</button></li>
                                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#mon-emergency">بلاغات طوارئ ({{ $emergencyReports->count() }})</button></li>
                            </ul>
                            <div class="tab-content">
                                @include('citizen.dashboard.partials.complaints-tab')
                                @include('citizen.dashboard.partials.suggestions-tab')
                                @include('citizen.dashboard.partials.messages-tab')
                                @include('citizen.dashboard.partials.emergency-tab')
                            </div>
                        </div>
                    </div>
                </main>
                @include('citizen.dashboard.partials.sidebar', ['activeNav' => 'monitoring', 'fulfillmentCount' => $fulfillmentCount ?? 0])
            </div>
        </div>
    </div>
@endsection