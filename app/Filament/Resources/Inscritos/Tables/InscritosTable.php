<?php

namespace App\Filament\Resources\Inscritos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InscritosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->searchable(),
                TextColumn::make('dados_pessoais.nome')->label('Nome Completo')->sortable()->searchable(),
                TextColumn::make('dados_pessoais.email')->label('E-mail')->sortable()->searchable(),
                TextColumn::make('dados_pessoais.telefone')->label('Telefone')->sortable()->searchable(),
                TextColumn::make('created_at')->label('Data de Inscrição')->dateTime('d/m/Y H:i')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
