<?php

namespace App\Filament\Resources\SuggestionResource\Pages;

use App\Filament\Resources\SuggestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuggestions extends ListRecords
{
    protected static string $resource = SuggestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('تصدير Excel')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    $records = $this->getFilteredTableQuery()->get();
                    return response()->streamDownload(function () use ($records) {
                        $out = fopen('php://output', 'w');
                        fwrite($out, "\xEF\xBB\xBF");
                        fputcsv($out, ['الاسم', 'رقم الهاتف', 'البريد الإلكتروني', 'الموضوع', 'نص المقترح', 'الحالة', 'الرد الإداري', 'تاريخ التقديم']);
                        foreach ($records as $r) {
                            fputcsv($out, [$r->name, $r->phone, $r->email, $r->subject, $r->message, $r->status, strip_tags($r->admin_reply ?? ''), $r->created_at]);
                        }
                        fclose($out);
                    }, 'المقترحات.xls');
                }),
        ];
    }
}
