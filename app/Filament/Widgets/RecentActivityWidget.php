<?php

namespace App\Filament\Widgets;

use App\Models\GisSubmission;
use App\Models\ServiceSubmission;
use App\Models\Enrollment;
use App\Models\TrainingApplication;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Collection;

class RecentActivityWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $activities = $this->getRecentActivities();

        return $table
            ->query(function () use ($activities) {
                return $activities;
            })
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'GIS' => 'info',
                        'خدمة' => 'warning',
                        'استدامة' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->limit(40)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('Y-m-d h:i A')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false)
            ->queryStringIdentifier('recent');
    }

    private function getRecentActivities(): Collection
    {
        $items = collect();

        GisSubmission::latest()->take(5)->get()->each(function ($item) use ($items) {
            $items->push((object) [
                'type' => 'GIS',
                'title' => 'طلب #' . ($item->serial_number ?? $item->id),
                'status' => $item->status,
                'created_at' => $item->created_at,
            ]);
        });

        ServiceSubmission::with('service')->latest()->take(5)->get()->each(function ($item) use ($items) {
            $items->push((object) [
                'type' => 'خدمة',
                'title' => $item->service?->name ?? 'خدمة',
                'status' => $item->status ?? 'جديد',
                'created_at' => $item->created_at,
            ]);
        });

        Enrollment::with('trainingProgram')->latest()->take(5)->get()->each(function ($item) use ($items) {
            $items->push((object) [
                'type' => 'استدامة',
                'title' => $item->trainingProgram?->title ?? 'برنامج تدريبي',
                'status' => 'مسجل',
                'created_at' => $item->enrolled_at ?? $item->created_at,
            ]);
        });

        TrainingApplication::with('trainingProgram')->latest()->take(5)->get()->each(function ($item) use ($items) {
            $items->push((object) [
                'type' => 'استدامة',
                'title' => $item->trainingProgram?->title ?? 'برنامج تدريبي',
                'status' => $item->status ?? 'متقدم',
                'created_at' => $item->created_at,
            ]);
        });

        return $items->sortByDesc('created_at')->take(10);
    }
}
