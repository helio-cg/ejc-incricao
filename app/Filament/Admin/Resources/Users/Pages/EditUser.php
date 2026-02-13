<?php

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Livewire\Attributes\Layout;

#[Layout('layouts.filament')]
class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //DeleteAction::make(),
            Action::make('pdf')
                ->label('Gerar PDF'),
            Action::make('nova_inscricao')
                ->label('Nova Inscrição'),
        ];
    }
}
