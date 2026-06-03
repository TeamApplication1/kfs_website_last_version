<?php

namespace App\Filament\Gis\Resources\RemovalOrderResource\Pages;

use App\Filament\Gis\Resources\RemovalOrderResource;
use App\Models\RemovalOrder;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListRemovalOrders extends ListRecords
{
    protected static string $resource = RemovalOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('إضافة قرار إزالة جديد'),
        ];
    }

    public function getTabs(): array
    {
        $counts = cache()->remember('removal_order_tab_counts', 60, fn() =>
            RemovalOrder::selectRaw("COALESCE(SUM(status = 'قيد الإعداد'), 0) as new_count")
                ->selectRaw("COALESCE(SUM(status = 'قيد المراجعة'), 0) as pending_count")
                ->selectRaw("COALESCE(SUM(status = 'تم التنفيذ'), 0) as completed_count")
                ->first()
        );

        return [
            'all' => Tab::make('كافة القرارات'),
            'new' => Tab::make('الوارد الجديد')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'قيد الإعداد'))
                ->badge($counts->new_count),
            'pending' => Tab::make('قيد المراجعة')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'قيد المراجعة'))
                ->badge($counts->pending_count)
                ->badgeColor('info'),
            'completed' => Tab::make('تم التنفيذ')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'تم التنفيذ'))
                ->badge($counts->completed_count)
                ->badgeColor('success'),
        ];
    }
}
