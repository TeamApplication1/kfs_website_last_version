<?php
namespace App\Filament\Gis\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole([
            'super_admin', 'Admin',
            'مدير المركز', 'مدير الادارة الهندسية',
            'مهندس التنظيم', 'مدير التنظيم',
            'فني التنظيم', 'مدير الوحدة الفرعية',
            'العضو الميداني',
            'مدخل البيانات بالوحدة الفرعية',
            'محللي النظم', 'الدعم الاداري',
            'رؤوساء الاقسام',
            'مدير المتغيرات', 'عضو المتغيرات',
            'أخصائي النظم', 'مكتب المحافظ',
        ]);
    }
}
