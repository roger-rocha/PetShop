<?php

namespace App\Filament\Super\Pages;

use App\Models\Releases;
use Filament\Pages\Page;

class ReleasePublic extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.release-public';

    public $model;

    protected static ?string $title = 'Releases';

    public function mount()
    {
        $this->model = Releases::get();
    }


}
