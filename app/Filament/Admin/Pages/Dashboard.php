<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use Livewire\Attributes\Layout;

#[Layout('layouts.filament')]
class Dashboard extends Page
{
    protected string $view = 'filament.admin.pages.dashboard';
}
