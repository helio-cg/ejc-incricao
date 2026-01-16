<?php

namespace App\Filament\Admin\Resources\Users\Pages;

use Illuminate\Support\Facades\Hash;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\Users\UserResource;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Garantir que o campo 'password' seja salvo corretamente no banco de dados
        if (!isset($data['password'])) {
            $data['password'] = Hash::make('password');
        }

        return $data;
    }
}
