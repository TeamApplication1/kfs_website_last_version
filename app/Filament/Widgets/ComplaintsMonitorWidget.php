<?php

namespace App\Filament\Widgets;

use App\Models\Complaint;
use App\Models\Suggestion;
use App\Models\ContactMessage;
use App\Models\EmergencyReport;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Collection;

class ComplaintsMonitorWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'مراقبة فورية — الشكاوي والمقترحات والتواصل';

    public function table(Table $table): Table
    {
        $items = $this->getUnreadItems();

        return $table
            ->query(function () use ($items) {
                return $items;
            })
            ->columns([
                Tables\Columns\TextColumn::make('source')
                    ->label('المصدر')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'شكوى' => 'danger',
                        'مقترح' => 'warning',
                        'رسالة' => 'info',
                        'بلاغ' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('الموضوع')
                    ->limit(40)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('Y-m-d h:i A')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false)
            ->queryStringIdentifier('complaints');
    }

    private function getUnreadItems(): Collection
    {
        $items = collect();

        Complaint::where('status', '!=', 'replied')->orWhereNull('status')->latest()->take(5)->get()
            ->each(function ($item) use ($items) {
                $items->push((object) [
                    'source' => 'شكوى',
                    'name' => $item->name,
                    'subject' => $item->subject,
                    'created_at' => $item->created_at,
                ]);
            });

        Suggestion::latest()->take(5)->get()
            ->each(function ($item) use ($items) {
                $items->push((object) [
                    'source' => 'مقترح',
                    'name' => $item->name,
                    'subject' => $item->subject,
                    'created_at' => $item->created_at,
                ]);
            });

        ContactMessage::where('is_read', false)->latest()->take(5)->get()
            ->each(function ($item) use ($items) {
                $items->push((object) [
                    'source' => 'رسالة',
                    'name' => $item->name,
                    'subject' => $item->subject,
                    'created_at' => $item->created_at,
                ]);
            });

        EmergencyReport::latest()->take(5)->get()
            ->each(function ($item) use ($items) {
                $items->push((object) [
                    'source' => 'بلاغ',
                    'name' => $item->reporter_name,
                    'subject' => $item->report_type,
                    'created_at' => $item->created_at,
                ]);
            });

        return $items->sortByDesc('created_at')->take(10);
    }
}
