<?php

namespace App\Filament\Resources\ComplaintResource\Pages;

use App\Filament\Resources\ComplaintResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComplaints extends ListRecords
{
    protected static string $resource = ComplaintResource::class;

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
                        fputcsv($out, ['الاسم', 'رقم الهاتف', 'البريد الإلكتروني', 'الرقم القومي', 'الموضوع', 'نص الشكوى', 'الحالة', 'الرد الإداري', 'تاريخ الاستلام']);
                        foreach ($records as $r) {
                            fputcsv($out, [$r->name, $r->phone, $r->email, $r->national_id, $r->subject, $r->message, $r->status, strip_tags($r->admin_reply ?? ''), $r->created_at]);
                        }
                        fclose($out);
                    }, 'الشكاوى.xls');
                }),
        ];
    }
}
