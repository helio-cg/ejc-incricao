<?php

namespace App\Filament\Pages;

use App\Filament\Admin\Resources\Users\Schemas\UserForm;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Models\Inscrito;
use App\Models\User;
use Dom\Text;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

#[Layout('layouts.index')]
class Inscricao extends Page
{
    protected string $view = 'filament.pages.inscricao';

    protected static ?string $title = '';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $dados_pessoais = [];
    public ?array $informacoes_adicionais = [];
    public ?array $filiacao = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public function save()
    {
        $data = $this->form->getState();

        User::create($data);

        $this->redirect(route('success'));
    }
}
