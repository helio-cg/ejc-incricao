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

        if($user->informacoes_adicionais['necessidade_especial'] == 'sim') {
            $necessidade_especial = 'Sim - ' . $user->informacoes_adicionais['necessidade_especial_descricao'];
        } else {
            $necessidade_especial = 'Não';
        }

        if($user->informacoes_adicionais['restricao_alimentar'] == 'sim') {
            $restricao_alimentar = 'Sim - ' . $user->informacoes_adicionais['restricao_alimentar_descricao'];
        }else {
            $restricao_alimentar = 'Não';
        }

        if($user->informacoes_adicionais['uso_medicamentos'] == 'sim') {
            $uso_medicamentos = 'Sim - ' . $user->informacoes_adicionais['uso_medicamentos_descricao'];
        }else {
            $uso_medicamentos = 'Não';
        }

        if($user->filiacao['fez_ecc'] == 'sim') {
            $fez_ecc = 'Sim - ' . $user->filiacao['fez_ecc_aonde'];
        } else {
            $fez_ecc = 'Não';
        }

        if($user->filiacao['movimento_religioso'] == 'sim') {
            $movimento_religioso = 'Sim - ' . $user->filiacao['movimento_religioso_aonde'];
        } else {
            $movimento_religioso = 'Não';
        }

        if($user->dados_escolares['estuda'] == 'sim') {
            $estuda = 'Sim - ' . $user->dados_escolares['curso']. ' na(o) ' . $user->dados_escolares['instituicao_ensino'] . ' no período da ' . $user->dados_escolares['turno'] .', nivel ' . $user->dados_escolares['nivel'];
        } else {
            $estuda = 'Não estuda - ' . $user->dados_escolares['formacao'];
        }

        $pdf = Pdf::loadView('pdf.user_inscricao', [
            'user' => $user,
            'diaDaInscricao' => $diaDaInscricao,
            'necessidade_especial' => $necessidade_especial,
            'restricao_alimentar' => $restricao_alimentar,
            'uso_medicamentos' => $uso_medicamentos,
            'fez_ecc' => $fez_ecc,
            'movimento_religioso' => $movimento_religioso,
            'estuda' => $estuda,
        ]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'inscrilcao_usuario_' . $user->id . '.pdf'
        );

    }
}
