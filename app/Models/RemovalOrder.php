<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RemovalOrder extends Model
{
    protected $fillable = [
        'violation_type', 'license_number', 'license_date', 'licensed_works',
        'center', 'local_unit', 'street', 'violation_area', 'district',
        'owner_name', 'owner_national_id', 'owner_center', 'owner_unit',
        'owner_street', 'owner_district', 'owner_governorate',
        'engineer_name', 'engineer_national_id', 'contractor_name', 'contractor_national_id',
        'violation_plot', 'violation_dimensions', 'violation_cost', 'violation_works',
        'stop_order_number', 'stop_order_date', 'stop_order_file',
        'violation_report_number', 'report_date', 'violation_report_file',
        'announcement_date', 'status', 'sketch_file', 'photo_file',
        'created_by', 'assigned_to', 'assigned_by', 'stage',
        'spatial_data', 'pdf_file', 'visa_file', 'review_notes',
        'engineering_engineer_id', 'spatial_manager_id', 'spatial_member_id',
        'systems_specialist_id', 'governor_office_id',
    ];

    protected $casts = [
        'license_date' => 'date',
        'stop_order_date' => 'date',
        'report_date' => 'date',
        'announcement_date' => 'date',
        'violation_cost' => 'decimal:2',
        'spatial_data' => 'array',
        'borders' => 'array',
    ];

    // ── Workflow Stages ──
    const STAGE_CREATED              = 'created';
    const STAGE_ENGINEERING_REVIEW   = 'engineering_review';
    const STAGE_SPATIAL_PENDING      = 'spatial_pending';
    const STAGE_SPATIAL_DIMENSIONED  = 'spatial_dimensioned';
    const STAGE_PDF_READY            = 'pdf_ready';
    const STAGE_VISA_PENDING         = 'visa_pending';
    const STAGE_COMPLETED            = 'completed';

    public static function stages(): array
    {
        return [
            self::STAGE_CREATED              => 'تم إنشاء المحضر',
            self::STAGE_ENGINEERING_REVIEW   => 'تحت المراجعة الهندسية',
            self::STAGE_SPATIAL_PENDING      => 'بإنتظار الكشف المساحي',
            self::STAGE_SPATIAL_DIMENSIONED  => 'تم الكشف المساحي',
            self::STAGE_PDF_READY            => 'بإنتظار اعتماد القرار',
            self::STAGE_VISA_PENDING         => 'بإنتظار التصديق النهائي',
            self::STAGE_COMPLETED            => 'تم تنفيذ القرار',
        ];
    }

    // ── Relations ──
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function engineeringEngineer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'engineering_engineer_id');
    }

    public function spatialManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'spatial_manager_id');
    }

    public function spatialMember(): BelongsTo
    {
        return $this->belongsTo(User::class, 'spatial_member_id');
    }

    public function systemsSpecialist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'systems_specialist_id');
    }

    public function governorOffice(): BelongsTo
    {
        return $this->belongsTo(User::class, 'governor_office_id');
    }
}
