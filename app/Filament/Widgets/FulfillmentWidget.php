<?php

namespace App\Filament\Widgets;

use App\Models\ServiceSubmission;
use App\Models\GisSubmission;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Collection;

class FulfillmentWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'الاستيفاء — طلبات تحتاج متابعة';

    public function table(Table $table): Table
    {
        $items = $this->getPendingFulfillments();

        return $table
            ->query(function () use ($items) {
                return $items;
            })
            ->columns([
                Tables\Columns\TextColumn::make('source')
                    ->label('النظام')
                    ->badge()
                    ->color(fn($state) => $state === 'GIS' ? 'info' : 'warning'),
                Tables\Columns\TextColumn::make('reference')
                    ->label('المرجع')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user')
                    ->label('المتقدم'),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'pending', 'received' => 'warning',
                        'in_progress', 'processing' => 'info',
                        'completed', 'تم التنفيذ' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('الدفع')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'paid', 'مسدد' => 'success',
                        'pending', 'pending_payment' => 'warning',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('fulfillment_action')
                    ->label('الإجراء المطلوب')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'مراجعة بيانات' => 'warning',
                        'دفع رسوم' => 'danger',
                        'مستندات ناقصة' => 'info',
                        'مكتمل' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التقديم')
                    ->date('Y-m-d')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false)
            ->queryStringIdentifier('fulfillment');
    }

    private function getPendingFulfillments(): Collection
    {
        $items = collect();

        $pendingStatuses = ['pending', 'received', 'in_progress', 'processing'];

        // Service submissions needing attention
        ServiceSubmission::whereIn('status', $pendingStatuses)
            ->with('service', 'user')
            ->latest()
            ->take(10)
            ->get()
            ->each(function ($item) use ($items) {
                $action = match ($item->status) {
                    'pending' => 'مراجعة بيانات',
                    'in_progress' => $item->paid_at ? 'مستندات ناقصة' : 'دفع رسوم',
                    default => 'مراجعة',
                };
                $items->push((object) [
                    'source' => 'خدمة عامة',
                    'reference' => $item->service?->name ?? '#' . $item->id,
                    'user' => $item->user?->name ?? $item->user_id,
                    'status' => $item->status,
                    'payment_status' => $item->paid_at ? 'paid' : 'pending',
                    'fulfillment_action' => $action,
                    'created_at' => $item->created_at,
                ]);
            });

        // GIS submissions needing attention
        GisSubmission::whereIn('status', $pendingStatuses)
            ->with('subService', 'user')
            ->latest()
            ->take(10)
            ->get()
            ->each(function ($item) use ($items) {
                $action = match ($item->status) {
                    'received' => 'مراجعة بيانات',
                    'processing' => $item->payment_status === 'paid' ? 'مستندات ناقصة' : 'دفع رسوم',
                    default => 'مراجعة',
                };
                $items->push((object) [
                    'source' => 'GIS',
                    'reference' => $item->subService?->name ?? '#' . $item->id,
                    'user' => $item->user?->name ?? $item->user_id,
                    'status' => $item->status,
                    'payment_status' => $item->payment_status ?? 'pending',
                    'fulfillment_action' => $action,
                    'created_at' => $item->created_at,
                ]);
            });

        return $items->sortByDesc('created_at')->take(10);
    }
}
