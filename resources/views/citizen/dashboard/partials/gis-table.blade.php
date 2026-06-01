<div class="table-responsive">
    <table id="gisTable" class="table table-hover align-middle custom-dash-table">
        <thead class="bg-light">
            <tr>
                <th>#</th>
                <th>الخدمة</th>
                <th>التاريخ</th>
                <th>الحالة</th>
                <th>الدفع</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gisSubmissions as $sub)
                <tr>
                    <td><span class="fw-bold text-navy">#{{ substr($sub->id, 0, 8) }}</span></td>
                    <td>{{ $sub->subService?->name ?? 'خدمة مكانية' }}</td>
                    <td><span class="text-muted small">{{ $sub->created_at->format('Y/m/d') }}</span></td>
                    <td>
                        <span class="badge-status-{{ $sub->status }}">
                            @switch($sub->status)
                                @case('received') تم الاستلام @break
                                @case('processing') قيد المعالجة @break
                                @case('completed') مكتمل @break
                                @case('rejected') مرفوض @break
                                @default {{ $sub->status }}
                            @endswitch
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $sub->payment_status === 'paid' ? 'success' : ($sub->payment_status === 'pending' ? 'warning' : 'secondary') }} text-white px-3 py-1" style="font-size:0.7rem">
                            {{ $sub->payment_status === 'paid' ? 'مدفوع' : ($sub->payment_status === 'pending' ? 'غير مدفوع' : $sub->payment_status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="fas fa-map-marked-alt fa-2x mb-2"></i>
                        <p>لم تقم بالتقديم على خدمات مكانية بعد</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>