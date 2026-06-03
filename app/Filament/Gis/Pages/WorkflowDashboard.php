<?php

namespace App\Filament\Gis\Pages;

use App\Models\RemovalOrder;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Filament\Forms;

class WorkflowDashboard extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
    protected static ?string $navigationLabel = 'مسار اعتماد القرارات';
    protected static ?string $navigationGroup = 'حوكمة قرارات الإزالة';
    protected static ?int $navigationSort = 0;
    protected static string $view = 'filament.pages.workflow-dashboard';

    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && $user->hasAnyRole([
            'super_admin', 'Admin',
            'مدير المركز', 'مدير الادارة الهندسية',
            'مهندس التنظيم', 'مدير التنظيم',
            'فني التنظيم',
            'مدير المتغيرات', 'عضو المتغيرات',
            'أخصائي النظم', 'مكتب المحافظ',
            'مدير الوحدة الفرعية',
        ]);
    }

    public function getTitle(): string
    {
        return 'مسار اعتماد القرارات';
    }

    public function table(Table $table): Table
    {
        $user = auth()->user();

        return $table
            ->query($this->buildQuery($user))
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('owner_name')->label('المالك')->searchable()->limit(20),
                TextColumn::make('center')->label('المركز')->searchable(),
                TextColumn::make('street')->label('الشارع')->searchable()->limit(20),
                TextColumn::make('violation_type')->label('نوع المخالفة')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state === 'new_violation' ? 'بدون ترخيص' : 'مرخص')
                    ->color(fn($state) => $state === 'new_violation' ? 'danger' : 'warning'),
                TextColumn::make('stage')->label('المرحلة')
                    ->badge()
                    ->formatStateUsing(fn($state) => RemovalOrder::stages()[$state] ?? $state)
                    ->color(fn($state) => match($state) {
                        RemovalOrder::STAGE_CREATED => 'gray',
                        RemovalOrder::STAGE_ENGINEERING_REVIEW => 'warning',
                        RemovalOrder::STAGE_SPATIAL_PENDING => 'info',
                        RemovalOrder::STAGE_SPATIAL_DIMENSIONED => 'primary',
                        RemovalOrder::STAGE_PDF_READY => 'secondary',
                        RemovalOrder::STAGE_VISA_PENDING => 'indigo',
                        RemovalOrder::STAGE_COMPLETED => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')->label('تاريخ الإنشاء')->dateTime()->sortable(),
            ])
            ->filters([])
            ->actions(
                array_filter([$this->getWorkflowAction($user)])
            )
            ->defaultSort('created_at', 'desc');
    }

    private function buildQuery(User $user): Builder
    {
        if ($user->hasAnyRole(['super_admin', 'Admin', 'مدير المركز', 'رؤوساء الاقسام'])) {
            return RemovalOrder::query();
        }

        if ($user->hasRole('مدير الادارة الهندسية')) {
            return RemovalOrder::query();
        }

        if ($user->hasRole('فني التنظيم')) {
            return RemovalOrder::where('stage', RemovalOrder::STAGE_CREATED)
                ->orWhere('created_by', $user->id);
        }

        if ($user->hasRole('مهندس التنظيم')) {
            return RemovalOrder::query();
        }

        if ($user->hasRole('مدير المتغيرات')) {
            return RemovalOrder::where('stage', RemovalOrder::STAGE_SPATIAL_PENDING);
        }

        if ($user->hasRole('عضو المتغيرات')) {
            return RemovalOrder::where('spatial_member_id', $user->id)
                ->where('stage', RemovalOrder::STAGE_SPATIAL_PENDING);
        }

        if ($user->hasRole('أخصائي النظم')) {
            return RemovalOrder::where('stage', RemovalOrder::STAGE_SPATIAL_DIMENSIONED);
        }

        if ($user->hasRole('مكتب المحافظ')) {
            return RemovalOrder::where('stage', RemovalOrder::STAGE_PDF_READY);
        }

        if ($user->hasRole('مدير الوحدة الفرعية')) {
            return RemovalOrder::query();
        }

        // باقي الأدوار: only assigned items
        return RemovalOrder::where('assigned_to', $user->id);
    }

    private function getWorkflowAction(User $user): ?Action
    {
        if ($user->hasRole('فني التنظيم')) {
            return Action::make('start_engineering')
                ->label('بدء المراجعة الهندسية')
                ->action(function (RemovalOrder $record) use ($user) {
                    $record->update([
                        'stage' => RemovalOrder::STAGE_ENGINEERING_REVIEW,
                        'engineering_engineer_id' => $user->id,
                    ]);
                    Notification::make()->success()->title('تم بدء المراجعة الهندسية')->send();
                })
                ->color('warning')
                ->visible(fn(RemovalOrder $record) => $record->stage === RemovalOrder::STAGE_CREATED);
        }

        if ($user->hasRole('مهندس التنظيم')) {
            return Action::make('to_spatial')
                ->label('تحويل للكشف المساحي')
                ->requiresConfirmation()
                ->form([
                    Forms\Components\Select::make('spatial_manager_id')
                        ->label('مدير المتغيرات')
                        ->options(User::role('مدير المتغيرات')->pluck('name', 'id'))
                        ->required(),
                    Forms\Components\Textarea::make('review_notes')->label('ملاحظات المراجعة'),
                ])
                ->action(function (array $data, RemovalOrder $record) {
                    $record->update([
                        'stage' => RemovalOrder::STAGE_SPATIAL_PENDING,
                        'spatial_manager_id' => $data['spatial_manager_id'],
                        'review_notes' => $data['review_notes'] ?? $record->review_notes,
                    ]);
                    Notification::make()->success()->title('تم التحويل للكشف المساحي')->send();
                })
                ->color('info')
                ->visible(fn(RemovalOrder $record) => $record->stage === RemovalOrder::STAGE_ENGINEERING_REVIEW
                    && $record->engineering_engineer_id === $user->id);
        }

        if ($user->hasRole('مدير المتغيرات')) {
            return Action::make('assign_spatial')
                ->label('تعيين عضو متغيرات')
                ->requiresConfirmation()
                ->form([
                    Forms\Components\Select::make('spatial_member_id')
                        ->label('عضو المتغيرات')
                        ->options(User::role('عضو المتغيرات')->pluck('name', 'id'))
                        ->required(),
                ])
                ->action(function (array $data, RemovalOrder $record) {
                    $record->update([
                        'spatial_member_id' => $data['spatial_member_id'],
                    ]);
                    Notification::make()->success()->title('تم تعيين عضو المتغيرات')->send();
                })
                ->color('primary')
                ->visible(fn(RemovalOrder $record) => $record->stage === RemovalOrder::STAGE_SPATIAL_PENDING);
        }

        if ($user->hasRole('عضو المتغيرات')) {
            return Action::make('add_spatial')
                ->label('إضافة الكشف المساحي')
                ->requiresConfirmation()
                ->form([
                    Forms\Components\TextInput::make('latitude')->label('خط العرض')->numeric()->required(),
                    Forms\Components\TextInput::make('longitude')->label('خط الطول')->numeric()->required(),
                    Forms\Components\Textarea::make('spatial_notes')->label('ملاحظات مكانية'),
                ])
                ->action(function (array $data, RemovalOrder $record) {
                    $record->update([
                        'stage' => RemovalOrder::STAGE_SPATIAL_DIMENSIONED,
                        'spatial_data' => $data,
                    ]);
                    Notification::make()->success()->title('تم إضافة الكشف المساحي')->send();
                })
                ->color('success')
                ->visible(fn(RemovalOrder $record) => $record->stage === RemovalOrder::STAGE_SPATIAL_PENDING
                    && $record->spatial_member_id === $user->id);
        }

        if ($user->hasRole('أخصائي النظم')) {
            return Action::make('upload_pdf')
                ->label('اعتماد القرار')
                ->form([
                    Forms\Components\FileUpload::make('pdf_file')
                        ->label('ملف القرار PDF')
                        ->acceptedFileTypes(['application/pdf'])
                        ->required(),
                ])
                ->action(function (array $data, RemovalOrder $record) {
                    $record->update([
                        'stage' => RemovalOrder::STAGE_PDF_READY,
                        'pdf_file' => $data['pdf_file'],
                    ]);
                    Notification::make()->success()->title('تم اعتماد القرار')->send();
                })
                ->color('warning')
                ->visible(fn(RemovalOrder $record) => $record->stage === RemovalOrder::STAGE_SPATIAL_DIMENSIONED);
        }

        if ($user->hasRole('مكتب المحافظ')) {
            return Action::make('upload_visa')
                ->label('التصديق النهائي')
                ->form([
                    Forms\Components\FileUpload::make('visa_file')
                        ->label('ملف التصديق النهائي PDF')
                        ->acceptedFileTypes(['application/pdf'])
                        ->required(),
                ])
                ->action(function (array $data, RemovalOrder $record) {
                    $record->update([
                        'stage' => RemovalOrder::STAGE_COMPLETED,
                        'visa_file' => $data['visa_file'],
                    ]);
                    Notification::make()->success()->title('تم رفع التأشيرة وإكمال القرار')->send();
                })
                ->color('success')
                ->visible(fn(RemovalOrder $record) => $record->stage === RemovalOrder::STAGE_PDF_READY);
        }

        if ($user->hasRole('مدير الادارة الهندسية')) {
            return Action::make('assign_engineer')
                ->label('تعيين مهندس/فني')
                ->requiresConfirmation()
                ->form([
                    Forms\Components\Select::make('engineering_engineer_id')
                        ->label('مهندس التنظيم')
                        ->options(User::role('مهندس التنظيم')->pluck('name', 'id'))
                        ->nullable(),
                    Forms\Components\Select::make('assigned_to')
                        ->label('فني التنظيم')
                        ->options(User::role('فني التنظيم')->pluck('name', 'id'))
                        ->nullable(),
                ])
                ->action(function (array $data, RemovalOrder $record) {
                    $record->update($data);
                    Notification::make()->success()->title('تم التعيين')->send();
                })
                ->color('primary')
                ->visible(fn(RemovalOrder $record) => $record->stage === RemovalOrder::STAGE_CREATED);
        }

        if ($user->hasRole('مدير الوحدة الفرعية')) {
            return Action::make('assign_engineer_sub')
                ->label('تعيين مهندس/فني')
                ->requiresConfirmation()
                ->form([
                    Forms\Components\Select::make('engineering_engineer_id')
                        ->label('مهندس التنظيم')
                        ->options(User::role('مهندس التنظيم')->pluck('name', 'id'))
                        ->nullable(),
                    Forms\Components\Select::make('assigned_to')
                        ->label('فني التنظيم')
                        ->options(User::role('فني التنظيم')->pluck('name', 'id'))
                        ->nullable(),
                ])
                ->action(function (array $data, RemovalOrder $record) {
                    $record->update($data);
                    Notification::make()->success()->title('تم التعيين')->send();
                })
                ->color('primary')
                ->visible(fn(RemovalOrder $record) => $record->stage === RemovalOrder::STAGE_CREATED);
        }

        return null;
    }
}
