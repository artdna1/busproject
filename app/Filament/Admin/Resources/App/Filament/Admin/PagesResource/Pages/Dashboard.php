<?php

namespace App\Filament\Admin\Resources\App\Filament\Admin\PagesResource\Pages;

use App\Filament\Admin\Resources\App\Filament\Admin\PagesResource;
use Filament\Resources\Pages\Page;

class Dashboard extends Page
{
    protected static string $resource = PagesResource::class;

    protected static string $view = 'filament.admin.resources.app.filament.admin.pages-resource.pages.dashboard';
}
