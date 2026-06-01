<?php

namespace App\Filament\Gis\Resources;

use App\Filament\Gis\Resources\RemovalOrderResource\Pages;
use App\Models\RemovalOrder;
use App\Models\GisMarkaz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;

class RemovalOrderResource extends Resource
{
    protected static ?string $model = RemovalOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'حوكمة قرارات الإزالة';
    protected static ?string $navigationLabel = 'كل القرارات';
    protected static ?string $modelLabel = 'قرار إزالة';
    protected static ?string $pluralModelLabel = 'قرارات الإزالة';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('نوع المخالفة')
                    ->schema([
                        Forms\Components\Select::make('violation_type')
                            ->label('نوع المخالفة')
                            ->options([
                                'new_violation' => 'مخالفة بناء بدون ترخيص',
                                'licensed_violation' => 'مخالفة شروط ترخيص',
                            ])->required()->live(),
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('license_number')->label('رقم الترخيص')->visible(fn(Get $get) => $get('violation_type') === 'licensed_violation'),
                            Forms\Components\DatePicker::make('license_date')->label('تاريخ الترخيص')->visible(fn(Get $get) => $get('violation_type') === 'licensed_violation'),
                        ]),
                    ]),
                Forms\Components\Section::make('الموقع والمالك')
                    ->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\Select::make('center')->label('المركز')->options(GisMarkaz::pluck('name', 'name'))->required(),
                            Forms\Components\TextInput::make('local_unit')->label('الوحدة المحلية')->required(),
                            Forms\Components\TextInput::make('street')->label('الشارع')->required(),
                        ]),
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('owner_name')->label('اسم المالك')->required(),
                            Forms\Components\TextInput::make('owner_national_id')->label('الرقم القومي')->length(14),
                            Forms\Components\TextInput::make('owner_governorate')->label('المحافظة')->default('كفر الشيخ'),
                        ]),
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('engineer_name')->label('المهندس المسؤول'),
                            Forms\Components\TextInput::make('engineer_national_id')->label('الرقم القومي للمهندس'),
                            Forms\Components\TextInput::make('contractor_name')->label('اسم المقاول'),
                        ]),
                        Forms\Components\TextInput::make('contractor_national_id')->label('الرقم القومي للمقاول'),
                    ]),
                Forms\Components\Section::make('تفاصيل المخالفة')
                    ->schema([
                        Forms\Components\RichEditor::make('violation_works')->label('وصف الأعمال المخالفة')->required(),
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('violation_plot')->label('رقم القطعة'),
                            Forms\Components\TextInput::make('violation_dimensions')->label('المساحة والأبعاد'),
                            Forms\Components\TextInput::make('violation_cost')->label('التكلفة المقدرة')->numeric(),
                        ]),
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('violation_report_number')->label('رقم محضر المخالفة'),
                            Forms\Components\DatePicker::make('report_date')->label('تاريخ المحضر'),
                        ]),
                    ]),
                Forms\Components\Section::make('القرارات والمرفقات')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('stop_order_number')->label('رقم قرار الإيقاف'),
                            Forms\Components\DatePicker::make('stop_order_date')->label('تاريخ قرار الإيقاف'),
                        ]),
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\DatePicker::make('announcement_date')->label('تاريخ الإعلان'),
                            Forms\Components\Select::make('status')
                                ->label('الحالة')
                                ->options([
                                    'قيد الإعداد' => 'قيد الإعداد',
                                    'قيد المراجعة' => 'قيد المراجعة',
                                    'تم التنفيذ' => 'تم التنفيذ',
                                ])->required(),
                        ]),
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\FileUpload::make('sketch_file')->label('ملف الكروكي'),
                            Forms\Components\FileUpload::make('photo_file')->label('صورة المخالفة')->image(),
                        ]),
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('owner_center')->label('مركز المالك'),
                            Forms\Components\TextInput::make('owner_unit')->label('الوحدة المحلية للمالك'),
                            Forms\Components\TextInput::make('owner_street')->label('شارع المالك'),
                        ]),
                        Forms\Components\TextInput::make('owner_district')->label('حي المالك'),
                        Forms\Components\TextInput::make('district')->label('الحي'),
                        Forms\Components\Textarea::make('licensed_works')->label('الأعمال المرخصة'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('stop_order_number')->label('رقم القرار')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('owner_name')->label('اسم المالك')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('center')->label('المركز')->badge()->color('info'),
                Tables\Columns\TextColumn::make('violation_type')->label('النوع')->badge()
                    ->formatStateUsing(fn($state) => $state === 'new_violation' ? 'بدون ترخيص' : 'مخالفة ترخيص')
                    ->color(fn($state) => $state === 'new_violation' ? 'danger' : 'warning'),
                Tables\Columns\TextColumn::make('status')->label('الحالة')->badge()
                    ->color(fn($state) => match ($state) {
                        'قيد الإعداد' => 'gray',
                        'قيد المراجعة' => 'warning',
                        'تم التنفيذ' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الإنشاء')->date()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make()->label('عرض'),
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRemovalOrders::route('/'),
            'create' => Pages\CreateRemovalOrder::route('/create'),
            'view' => Pages\ViewRemovalOrder::route('/{record}'),
            'edit' => Pages\EditRemovalOrder::route('/{record}/edit'),
        ];
    }
}
