<?php

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Enums\UserStatus;
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

    protected function afterSave(): void
    {
        $user = $this->record;

        // exemplo 1: marcar pdf como não gerado
        $user->update([
            'status' => UserStatus::ANALYZING->value,
        ]);



        // exemplo 3: chamar job
        // GerarPdfUser::dispatch($user);
    }
}
