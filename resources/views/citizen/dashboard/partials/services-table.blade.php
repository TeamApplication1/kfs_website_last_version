<div class="table-responsive">
    <table id="servicesTable" class="table table-hover align-middle custom-dash-table">
        <thead class="bg-light">
            <tr>
                <th>#</th>
                <th>الخدمة</th>
                <th>التاريخ</th>
                <th>الحالة</th>
                <th class="text-center">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($serviceSubmissions as $sub)
                <tr>
                    <td><span class="fw-bold text-navy">#{{ $sub->id }}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="icon-sm-circle ms-2"><i class="{{ $sub->service?->icon ?? 'fas fa-cog' }}"></i></div>
                            <span>{{ $sub->service?->title ?? 'خدمة' }}</span>
                        </div>
                    </td>
                    <td><span class="text-muted small">{{ $sub->created_at->format('Y/m/d') }}</span></td>
                    <td>
                        <span class="badge-status-{{ $sub->status }}">
                            @switch($sub->status)
                                @case('pending') قيد المراجعة @break
                                @case('awaiting_payment') بانتظار الدفع @break
                                @case('paid') تم الدفع @break
                                @case('completed') تم التنفيذ @break
                                @case('rejected') مرفوض @break
                                @default {{ $sub->status }}
                            @endswitch
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('citizen.submissions.show', $sub->id) }}" class="btn btn-outline-gold btn-sm rounded-pill">
                            <span>التفاصيل</span>
                            <i class="fas fa-eye fa-xs ms-2"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <p>لم تقم بالتقديم على خدمات عامة بعد</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>