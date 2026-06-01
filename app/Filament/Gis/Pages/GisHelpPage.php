<?php

namespace App\Filament\Gis\Pages;

use Filament\Pages\Page;

class GisHelpPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static string $view = 'filament.pages.help';
    protected static ?string $title = 'مركز المساعدة';
    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return auth()->check();
    }
}
