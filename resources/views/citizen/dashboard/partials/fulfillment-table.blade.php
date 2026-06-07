@if ($fulfillmentItems->isNotEmpty())
    <div class="white-section-card shadow-sm p-4 mb-5">
        <div class="d-flex align-items-center mb-3 border-bottom pb-2">
            <i class="fas fa-tasks text-warning fs-4 ms-2"></i>
            <h3 class="m-0 section-head">الاستيفاء — إجراءات مطلوبة منك</h3>
            <span class="badge bg-warning text-dark me-2">{{ $fulfillmentItems->count() }}</span>
        </div>
        <div class="table-responsive">
            <table id="fulfillmentTable" class="table table-hover align-middle custom-dash-table">
                <thead class="bg-light">
                    <tr>
                        <th>النظام</th>
                        <th>الخدمة</th>
                        <th>الإجراء المطلوب</th>
                        <th>تاريخ التقديم</th>
                        <th class="text-center">إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fulfillmentItems as $item)
                        <tr>
                            <td>
                                <span class="badge bg-{{ $item->source === 'خدمات مكانية' ? 'info' : 'warning' }}">
                                    {{ $item->source }}
                                </span>
                            </td>
                            <td>{{ $item->reference }}</td>
                            <td>
                                <span class="fulfillment-badge-{{ $item->fulfillment_action === 'مراجعة بيانات' ? 'review' : ($item->fulfillment_action === 'دفع رسوم' ? 'pay' : ($item->fulfillment_action === 'مستندات ناقصة' ? 'docs' : 'retry')) }}">
                                    {{ $item->fulfillment_action }}
                                </span>
                                @if (!empty($item->fulfillment_reason))
                                    <br><small class="text-muted">{{ $item->fulfillment_reason }}</small>
                                @endif
                            </td>
                            <td><span class="text-muted small">{{ $item->created_at->format('Y/m/d') }}</span></td>
                            <td class="text-center">
                                @if ($item->fulfillment_action === 'دفع رسوم')
                                    <a href="{{ $item->type === 'gis' ? route('gis.apply.success', $item->id) : '#' }}"
                                       class="btn btn-danger btn-sm rounded-pill px-3">
                                        <i class="fas fa-credit-card"></i> دفع الآن
                                    </a>
                                @elseif ($item->fulfillment_action === 'مراجعة بيانات' || $item->fulfillment_action === 'تعديل بيانات')
                                    @if ($item->type === 'service')
                                        <a href="{{ route('citizen.submissions.show', $item->id) }}"
                                           class="btn btn-warning btn-sm rounded-pill px-3">
                                            <i class="fas fa-edit"></i> تعديل البيانات
                                        </a>
                                    @else
                                        <span class="text-muted small">بانتظار مراجعة الموظف</span>
                                    @endif
                                @elseif ($item->fulfillment_action === 'مستندات ناقصة')
                                    <a href="{{ route('citizen.dashboard.gis') }}"
                                       class="btn btn-info btn-sm rounded-pill px-3">
                                        <i class="fas fa-file-upload"></i> رفع المستندات
                                    </a>
                                @elseif ($item->fulfillment_action === 'إعادة تقديم')
                                    <a href="{{ route('services.index') }}"
                                       class="btn btn-secondary btn-sm rounded-pill px-3">
                                        <i class="fas fa-redo"></i> إعادة تقديم
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
