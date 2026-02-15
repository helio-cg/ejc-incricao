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
                TextColumn::make('dados_pessoais.full_name')
                    ->label('Nome')
                    ->formatStateUsing(fn ($record) =>
                        $record->dados_pessoais['full_name'] .
                        ' (' . ($record->dados_pessoais['conhecido_como'] ?? '') . ')'
                    )
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where(function ($q) use ($search) {
                            $q->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(dados_pessoais, '$.full_name'))) LIKE ?", ["%" . strtolower($search) . "%"])
                            ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(dados_pessoais, '$.conhecido_como'))) LIKE ?", ["%" . strtolower($search) . "%"]);
                        });
                    }),
                TextColumn::make('dados_pessoais.idade')
                    ->label('Idade')
                    ->formatStateUsing(fn (Model $record): string => $record->dados_pessoais['idade'] . ' anos')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')->label('Data de Inscrição')->dateTime('d/m/Y H:i')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([

            ])
            ->recordActions([
                Action::make('Gerar PDF')
                    ->label('Gerar PDF')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                 //   ->requiresConfirmation()   // ←←← vírgula aqui no final + nada depois
               //     ->action(fn (Model $record) => static::gerarPdf($record->id)),
            ])
            ->toolbarActions([
             /*   BulkActionGroup::make([
                    //
                ]),*/
            ]);
    }
}
