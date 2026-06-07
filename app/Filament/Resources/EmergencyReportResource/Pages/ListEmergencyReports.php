<?php

namespace App\Filament\Resources\EmergencyReportResource\Pages;

use App\Filament\Resources\EmergencyReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmergencyReports extends ListRecords
{
    protected static string $resource = EmergencyReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export')
                ->label('تصدير Excel')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    $records = $this->getFilteredTableQuery()->get();
                    return response()->streamDownload(function () use ($records) {
                        $out = fopen('php://output', 'w');
                        fwrite($out, "\xEF\xBB\xBF");
                        fputcsv($out, ['المُبلغ', 'الرقم القومي', 'رقم الهاتف', 'نوع البلاغ', 'المركز', 'المنطقة', 'وصف الموقع', 'تفاصيل البلاغ', 'الحالة', 'تاريخ البلاغ']);
                        foreach ($records as $r) {
                            fputcsv($out, [$r->reporter_name, $r->reporter_national_id, $r->reporter_phone, $r->report_type, $r->center, $r->area, $r->location_description, $r->details, $r->status, $r->created_at]);
                        }
                        fclose($out);
                    }, 'بلاغات_الطوارئ.xls');
                }),
        ];
    }
}
