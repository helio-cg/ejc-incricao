<?php

namespace App\Filament\Admin\Resources\Users\Tables;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->searchable(),
                TextColumn::make('name')
                    ->label('Nome')
                    ->formatStateUsing(fn (Model $record): string => $record->full_name . ' (' . $record->name . ')')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('idade')
                    ->label('Idade')
                    ->formatStateUsing(fn (Model $record): string => $record->idade . ' anos')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')->label('Data de Inscrição')->dateTime('d/m/Y H:i')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('Gerar PDF')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                 //   ->requiresConfirmation()   // ←←← vírgula aqui no final + nada depois
                    ->action(fn (Model $record) => static::gerarPdf($record->id)),
            ])
            ->toolbarActions([
               // BulkActionGroup::make([
              //      DeleteBulkAction::make(),
               // ]),
            ]);
    }

    public static function gerarPdf($recordId)
    {
        $user = User::where('id', $recordId)->first();

        $diaDaInscricao = ucfirst($user->created_at->locale('pt_BR')->translatedFormat('j \d\e F'));

        $pdf = Pdf::loadView('pdf.user_inscricao', [
            'user' => $user,
            'diaDaInscricao' => $diaDaInscricao
        ]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'inscrilcao_usuario_' . $user->id . '.pdf'
        );

    }
}
