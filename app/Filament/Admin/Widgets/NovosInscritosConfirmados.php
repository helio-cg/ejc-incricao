<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use Dom\Text;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NovosInscritosConfirmados extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => User::where('pdf_gerado', 0))
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->searchable(),
                TextColumn::make('name')
                    ->label('Nome')
                    ->formatStateUsing(fn (User $record): string => $record->full_name . ' (' . $record->name . ')')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('idade')
                    ->label('Idade')
                    ->formatStateUsing(fn (User $record): string => $record->idade . '  anos')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([

            ])
            ->recordActions([
                Action::make('Gerar PDF')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                 //   ->requiresConfirmation()   // ←←← vírgula aqui no final + nada depois
                    ->action(fn (Model $record) => static::gerarPdf($record->id)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
