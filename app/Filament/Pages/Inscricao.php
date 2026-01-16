<?php

namespace App\Filament\Pages;

use Dom\Text;
use App\Models\User;
use App\Models\Inscrito;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Livewire\Attributes\Layout;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Wizard\Step;

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
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Dados Pessoais')
                        ->columns(2)
                        ->schema([
                            TextInput::make('dados_pessoais.nome')
                                ->label('Nome Completo')
                                ->required()
                                ->placeholder('Digite seu nome completo')
                                ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null),
                            TextInput::make('dados_pessoais.nome_usual')
                                ->label('Nome Usual / Apelido')
                                ->required()
                                ->placeholder('Conhecido(a) por')
                                ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null),
                            DatePicker::make('dados_pessoais.data_nascimento')
                                ->label('Data de Nascimento')
                                ->required()
                                ->placeholder('Selecione sua data de nascimento')
                                ->live() // ou reactive() nas versões mais antigas (< v3.2)
                                ->afterStateUpdated(function ($state, $set) {
                                    if (!$state) {
                                        $set('dados_pessoais.idade', null);
                                        return;
                                    }

                                    $nascimento = \Carbon\Carbon::parse($state);
                                    $dataEvento = \Carbon\Carbon::create(2026, 5, 16);

                                    // Arredonda para baixo automaticamente
                                    $idade = $dataEvento->diffInYears($nascimento, true);

                                    $set('dados_pessoais.idade', (int) $idade);
                                }),
                            TextInput::make('dados_pessoais.idade')
                                ->label('Idade')
                                ->required()
                                ->disabled()
                                ->placeholder('Digite sua idade')
                                ->numeric(),

                            TextInput::make('dados_pessoais.email')
                                ->label('E-mail')
                                ->required()
                                ->email()
                                ->placeholder('Digite seu e-mail'),
                            TextInput::make('dados_pessoais.telefone')
                                ->label('Telefone')
                                ->required()
                                ->placeholder('Digite seu telefone'),
                            TextInput::make('dados_pessoais.cep')
                                ->label('CEP'),
                            TextInput::make('dados_pessoais.endereco')
                                ->label('Endereço completo com número')
                                ->required(),
                            TextInput::make('dados_pessoais.bairro')
                                ->label('Bairro')
                                ->required(),
                            TextInput::make('dados_pessoais.ponto_referencia')
                                ->label('Ponto de Referência'),
                            Radio::make('dados_pessoais.sexo')
                                ->label('Sexo')
                                ->required()
                                ->options([
                                    'masculino' => 'Masculino',
                                    'feminino' => 'Feminino'
                                ]),
                        ]),
                    Step::make('Informações Adicionais')
                        ->schema([
                            Radio::make('informacoes_adicionais.tem_filhos')
                                ->label('Tem filhos?')
                                ->required()
                                ->options([
                                    'sim' => 'Sim',
                                    'nao' => 'Não',
                                ]),
                            Radio::make('informacoes_adicionais.necessidade_especial')
                                ->label('Possui alguma necessidade especial?')
                                ->required()
                                ->options([
                                    'sim' => 'Sim',
                                    'nao' => 'Não',
                                ])
                                ->live() // ou ->reactive() em versões mais antigas
                                // Opcional: limpa o campo quando muda para "Não"
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state === 'nao') {
                                        $set('informacoes_adicionais.necessidade_especial_descricao', null);
                                    }
                                }),
                            Textarea::make('informacoes_adicionais.necessidade_especial_descricao')
                                ->label('Descreva a necessidade especial')
                                ->visible(fn (callable $get): bool => $get('informacoes_adicionais.necessidade_especial') === 'sim')
                                ->required(fn (callable $get): bool => $get('informacoes_adicionais.necessidade_especial') === 'sim'),

                            Radio::make('informacoes_adicionais.restricao_alimentar')
                                ->label('Tem alguma restrição alimentar?')
                                ->required()
                                ->options([
                                    'sim' => 'Sim',
                                    'nao' => 'Não',
                                ])
                                ->live() // ou ->reactive() em versões mais antigas
                                // Opcional: limpa o campo quando muda para "Não"
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state === 'nao') {
                                        $set('informacoes_adicionais.restricao_alimentar_descricao', null);
                                    }
                                }),
                            Textarea::make('informacoes_adicionais.restricao_alimentar_descricao')
                                ->label('Descreva a restrição alimentar')
                                ->visible(fn (callable $get): bool => $get('informacoes_adicionais.restricao_alimentar') === 'sim')
                                ->required(fn (callable $get): bool => $get('informacoes_adicionais.restricao_alimentar') === 'sim'),

                            Radio::make('informacoes_adicionais.uso_medicamentos')
                                ->label('Faz uso de algum medicamentos?')
                                ->required()
                                ->options([
                                    'sim' => 'Sim',
                                    'nao' => 'Não',
                                ])
                                ->live() // ou ->reactive() em versões mais antigas
                                // Opcional: limpa o campo quando muda para "Não"
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state === 'nao') {
                                        $set('informacoes_adicionais.uso_medicamentos_descricao', null);
                                    }
                                }),
                            Textarea::make('informacoes_adicionais.uso_medicamentos_descricao')
                                ->label('Descreva o uso de medicamentos')
                                ->visible(fn (callable $get): bool => $get('informacoes_adicionais.uso_medicamentos') === 'sim')
                                ->required(fn (callable $get): bool => $get('informacoes_adicionais.uso_medicamentos') === 'sim'),
                        ]),
                    Step::make('Filiação')
                        ->schema([
                            TextInput::make('filiacao.pai')
                                ->label('Nome do Pai')
                                ->placeholder('Digite o nome do pai')
                                ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null),
                            TextInput::make('filiacao.mae')
                                ->label('Nome da Mãe')
                                ->placeholder('Digite o nome da mãe')
                                ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null),
                            Radio::make('filiacao.fez_ecc')
                                ->label('Seus pais já fizeram o Encontro de Casais com Cristo?')
                                ->required()
                                ->options([
                                    'sim' => 'Sim',
                                    'nao' => 'Não',
                                ])
                                ->live() // ou ->reactive() em versões mais antigas
                                // Opcional: limpa o campo quando muda para "Não"
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state === 'nao') {
                                        $set('filiacao.fez_ecc_aonde', null);
                                    }
                                }),
                            TextInput::make('filiacao.fez_ecc_aonde')
                                ->label('Aonde fizeram o ECC?')
                                ->placeholder('Digite o nome da paróquia')
                                ->visible(fn (callable $get): bool => $get('filiacao.fez_ecc') === 'sim')
                                ->required(fn (callable $get): bool => $get('filiacao.fez_ecc') === 'sim'),
                            Radio::make('filiacao.movimento_religioso')
                                ->label('Seus pais participam de algum movimento religioso?')
                                ->required()
                                ->options([
                                    'sim' => 'Sim',
                                    'nao' => 'Não',
                                ])
                                ->live() // ou ->reactive() em versões mais antigas
                                // Opcional: limpa o campo quando muda para "Não"
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state === 'nao') {
                                        $set('filiacao.movimento_religioso_aonde', null);
                                    }
                                }),
                            TextInput::make('filiacao.movimento_religioso_aonde')
                                ->label('Aonde participam?')
                                ->placeholder('Digite o nome da paróquia e o movimento, pastoral, etc.')
                                ->visible(fn (callable $get): bool => $get('filiacao.movimento_religioso') === 'sim')
                                ->required(fn (callable $get): bool => $get('filiacao.movimento_religioso') === 'sim'),
                        ]),
                    Step::make('Dados Escolares')
                        ->schema([
                            // ...
                        ]),
                    Step::make('Dados Profissionais')
                        ->schema([
                            // ...
                        ]),
                    Step::make('Dados Gerais')
                        ->schema([
                            // Convidados por e telefone fica aqui neste passo
                        ]),

]),

            ]);
    }

    public function save()
    {
        $data = $this->form->getState();

        User::create($data);

        $this->redirect(route('success'));
    }
}
