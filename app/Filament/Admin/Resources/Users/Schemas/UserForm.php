<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Dados Pessoais')
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                        'xl' => 3,
                    ])
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('full_name')
                                ->label('Nome Completo')
                                ->required()
                                ->placeholder('Digite seu nome completo')
                                ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null),
                            TextInput::make('name')
                                ->label('Nome Usual / Apelido')
                                ->required()
                                ->placeholder('Conhecido(a) por')
                                ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null),
                        ])->columnSpanFull(),

                            DatePicker::make('dados_pessoais.data_nascimento')
                                ->label('Data de Nascimento')
                                ->required()
                                ->placeholder('Selecione sua data de nascimento')
                                ->live() // ou reactive() nas versões mais antigas (< v3.2)
                                ->afterStateUpdated(function ($state, $set) {
                                    if (!$state) {
                                        $set('idade', null);
                                        return;
                                    }

                                    $nascimento = \Carbon\Carbon::parse($state);
                                    $dataEvento = \Carbon\Carbon::create(2026, 5, 16);

                                    // Arredonda para baixo automaticamente
                                    $idade = $dataEvento->diffInYears($nascimento, true);

                                    $set('idade', (int) $idade);
                                }),


                            TextInput::make('idade')
                                ->label('Idade')
                                ->required()
                                ->readOnly()
                                ->numeric(),

                            TextInput::make('dados_pessoais.telefone')
                                ->label('Telefone')
                                ->required()
                                ->placeholder('Digite seu telefone'),

                            TextInput::make('email')
                                ->label('E-mail')
                                ->required()
                                ->email()
                                ->placeholder('Digite seu e-mail'),

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
                                ->inline()
                                ->options([
                                    'masculino' => 'Masculino',
                                    'feminino' => 'Feminino'
                                ]),
                    ])->columnSpanFull(),

                Fieldset::make('Informações Adicionais')
                    ->columns(1)
                    ->schema([
                        Grid::make(2)->schema([
                            Radio::make('informacoes_adicionais.necessidade_especial')
                                ->label('Possui alguma necessidade especial?')
                                ->inline()
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
                        ])->columnSpanFull(),

                        Grid::make(2)->schema([
                            Radio::make('informacoes_adicionais.restricao_alimentar')
                                ->label('Tem alguma restrição alimentar?')
                                ->inline()
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
                        ])->columnSpanFull(),

                        Grid::make(2)->schema([
                            Radio::make('informacoes_adicionais.uso_medicamentos')
                                ->label('Faz uso de algum medicamentos?')
                                ->inline()
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
                        ])->columnSpanFull(),

                        Radio::make('informacoes_adicionais.tem_filhos')
                            ->label('Tem filhos?')
                            ->inline()
                            ->required()
                            ->options([
                                'sim' => 'Sim',
                                'nao' => 'Não',
                            ]),

                    ])->columnSpanFull(),

                    Fieldset::make('Filiação')
                    ->columns(1)
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('filiacao.pai')
                                ->label('Nome do Pai')
                                ->placeholder('Digite o nome do pai')
                                ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null),
                            TextInput::make('filiacao.mae')
                                ->label('Nome da Mãe')
                                ->placeholder('Digite o nome da mãe')
                                ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null),
                        ])->columnSpanFull(),

                        Grid::make(2)->schema([
                            Radio::make('filiacao.fez_ecc')
                                ->label('Seus pais já fizeram o Encontro de Casais com Cristo?')
                                ->inline()
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
                            TextArea::make('filiacao.fez_ecc_aonde')
                                ->label('Aonde fizeram o ECC?')
                                ->placeholder('Digite o nome da paróquia')
                                ->visible(fn (callable $get): bool => $get('filiacao.fez_ecc') === 'sim')
                                ->required(fn (callable $get): bool => $get('filiacao.fez_ecc') === 'sim'),
                        ])->columnSpanFull(),

                        Grid::make(2)->schema([
                            Radio::make('filiacao.movimento_religioso')
                                ->label('Seus pais participam de algum movimento religioso?')
                                ->inline()
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
                            TextArea::make('filiacao.movimento_religioso_aonde')
                                ->label('Aonde participam?')
                                ->placeholder('Digite o nome da paróquia e o movimento, pastoral, etc.')
                                ->visible(fn (callable $get): bool => $get('filiacao.movimento_religioso') === 'sim')
                                ->required(fn (callable $get): bool => $get('filiacao.movimento_religioso') === 'sim'),
                        ])->columnSpanFull(),

                    ])->columnSpanFull(),

                    Fieldset::make('Dados Escolares')
                        ->columns(1)
                        ->schema([
                            Radio::make('dados_escolares.estuda')
                                ->label('Ainda estuda?')
                                ->required()
                                ->inline()
                                ->live()                       // ← IMPORTANTE!
                                ->options([
                                    'sim' => 'Sim',
                                    'nao' => 'Não',
                                ]),

                            // ── Campos que aparecem APENAS quando estuda = 'sim' ────────────────────────────────
                            TextInput::make('dados_escolares.instituicao_ensino')
                                ->label('Nome da Instituição de Ensino')
                                ->visible(fn (Get $get): bool => $get('dados_escolares.estuda') === 'sim')
                                ->required(fn (Get $get): bool => $get('dados_escolares.estuda') === 'sim'),

                            Grid::make(4)->schema([
                                TextInput::make('dados_escolares.curso')
                                    ->label('Curso')
                                    ->required(fn (Get $get): bool => $get('dados_escolares.estuda') === 'sim'),

                                TextInput::make('dados_escolares.serie')
                                    ->label('Série')
                                    ->required(fn (Get $get): bool => $get('dados_escolares.estuda') === 'sim'),

                                TextInput::make('dados_escolares.nivel')
                                    ->label('Nível')
                                    ->required(fn (Get $get): bool => $get('dados_escolares.estuda') === 'sim'),

                                Select::make('dados_escolares.turno')
                                    ->label('Turno')
                                    ->required(fn (Get $get): bool => $get('dados_escolares.estuda') === 'sim')
                                    ->options([
                                        'manha' => 'Manhã',
                                        'tarde' => 'Tarde',
                                        'noite' => 'Noite',
                                        'integral' => 'Integral',
                                    ]),
                            ])->visible(fn (Get $get): bool => $get('dados_escolares.estuda') === 'sim')
                                ->columnSpanFull(),



                            // ── Campo que aparece APENAS quando estuda = 'nao' ────────────────────────────────
                            Select::make('dados_escolares.formacao')   // ← note que mudei para .formacao (sem ç)
                                ->label('Formação')
                                ->visible(fn (Get $get): bool => $get('dados_escolares.estuda') === 'nao')
                                ->required(fn (Get $get): bool => $get('dados_escolares.estuda') === 'nao')
                                ->options([
                                    'fundamental_incompleto' => 'Fundamental Incompleto',
                                    'fundamental_completo' => 'Fundamental Completo',
                                    'ensino_medio_incompleto' => 'Ensino Médio Incompleto',
                                    'ensino_medio_completo' => 'Ensino Médio Completo',
                                    'superior_incompleto' => 'Superior Incompleto',
                                    'superior_completo' => 'Superior Completo',
                                ]),

                        ])->columnSpanFull(),

                    Fieldset::make('Dados Profissionais')
                        ->columns(1)
                        ->schema([
                            Radio::make('dados_profissionais.trabalha')
                                ->label('Trabalha?')
                                ->required()
                                ->inline()
                                ->live()                       // ← IMPORTANTE!
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state === 'nao') {
                                        $set('dados_profissionais.empresa', null);
                                        $set('dados_profissionais.horario', null);
                                    }
                                })
                                ->options([
                                    'sim' => 'Sim',
                                    'nao' => 'Não',
                                ]),

                            Grid::make(2)->schema([
                                TextInput::make('dados_profissionais.empresa')
                                    ->label('Nome da Empresa')
                                    ->required(fn (Get $get): bool => $get('dados_profissionais.trabalha') === 'sim'),

                                TextInput::make('dados_profissionais.horario')
                                    ->label('Horário')
                                    ->required(fn (Get $get): bool => $get('dados_profissionais.trabalha') === 'sim'),

                            ])->visible(fn (Get $get): bool => $get('dados_profissionais.trabalha') === 'sim')
                                ->columnSpanFull(),
                        ])->columnSpanFull(),

                    Fieldset::make('Dados Gerais')
                    ->columns(1)
                    ->schema([
                        Radio::make('dados_gerais.participa_grupo_jovens')
                            ->label('Participa de algum grupo/movimento de jovens?')
                            ->required()
                            ->inline()
                            ->live()                       // ← IMPORTANTE!
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'nao') {
                                    $set('dados_gerais.horaroio_participacao', null);
                                    $set('dados_gerais.nome_do_grupo', null);
                                    $set('dados_gerais.religiao', null);
                                }
                            })
                            ->options([
                                'sim' => 'Sim',
                                'nao' => 'Não',
                            ]),
                        Grid::make(3)->schema([
                            TextInput::make('dados_gerais.nome_do_grupo')
                                ->label('Nome do Grupo/Movimento')
                                ->required(fn (Get $get): bool => $get('dados_gerais.participa_grupo_jovens') === 'sim'),

                            Select::make('dados_gerais.horaroio_participacao')
                                ->label('Horário?')
                                ->required(fn (Get $get): bool => $get('dados_gerais.participa_grupo_jovens') === 'sim')
                                ->options([
                                    'manhã' => 'Manhã',
                                    'tarde' => 'Tarde',
                                    'noite' => 'Noite'
                                ]),
                            Select::make('dados_gerais.religiao')
                                ->label('Religião')
                                ->required(fn (Get $get): bool => $get('dados_gerais.participa_grupo_jovens') === 'sim')
                                ->options([
                                    'católico' => 'Católico',
                                    'evangélico' => 'Evangélico',
                                    'outro' => 'Outro'

                                ]),
                        ])->visible(fn (Get $get): bool => $get('dados_gerais.participa_grupo_jovens') === 'sim')->columnSpanFull(),

                        Radio::make('dados_gerais.tem_irmaos')
                            ->label('Tem irmãos?')
                            ->required()
                            ->inline()
                            ->live()                       // ← IMPORTANTE!
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'nao') {
                                   $set('dados_gerais.quantidade_irmaos', null);

                                }
                            })
                            ->options([
                                'sim' => 'Sim',
                                'nao' => 'Não',
                            ]),
                        TextInput::make('dados_gerais.quantidade_irmaos')
                            ->label('Quantidade de irmãos')
                            ->numeric()
                            ->visible(fn (Get $get): bool => $get('dados_gerais.tem_irmaos') === 'sim')
                            ->required(fn (Get $get): bool => $get('dados_gerais.tem_irmaos') === 'sim'),

                        Radio::make('dados_gerais.tem_irmaos_inscritos')
                            ->label('Tem algum irmão ou parente inscrito no EJC?')
                            ->required()
                            ->inline()
                            ->live()                       // ← IMPORTANTE!
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'nao') {
                                  $set('dados_gerais.nome_irmaos_inscritos', null);
                                }
                            })
                            ->options([
                                'sim' => 'Sim',
                                'nao' => 'Não',
                            ]),
                        TextInput::make('dados_gerais.nome_irmaos_inscritos')
                            ->label('Nome dos irmãos ou parentes inscritos')
                            ->visible(fn (Get $get): bool => $get('dados_gerais.tem_irmaos_inscritos') === 'sim')
                            ->required(fn (Get $get): bool => $get('dados_gerais.tem_irmaos_inscritos') === 'sim'),
                    ])->columnSpanFull(),


            ]);
    }
}
