<?php

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Enums\UserStatus;
use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

#[Layout('layouts.filament')]
class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Garantir que o campo 'password' seja salvo corretamente no banco de dados
        if (!isset($data['password'])) {
            $data['password'] = Hash::make('password');
        }

        $data['email'] = Str::random(12) . '@example.com';
        $data['status'] = UserStatus::ANALYZING->value;

        return $data;
    }
}
