<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Operation;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

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
                    ->statePath('dados_pessoais')
                    ->schema([
                        Grid::make(4)->schema([
                            TextInput::make('full_name')
                                ->label('Nome Completo')
                                ->required()
                                ->placeholder('Digite seu nome completo')
                                ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null)
                                ->columnSpan(2),
                            TextInput::make('conhecido_como')
                                ->label('Nome Usual / Apelido')
                                ->required()
                                ->placeholder('Conhecido(a) por')
                                ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null),
                            ToggleButtons::make('sexo')
                                ->label('Sexo')
                                ->required()
                                ->inline()
                                ->grouped()
                                ->options([
                                    'masculino' => 'Masculino',
                                    'feminino' => 'Feminino'
                                ])
                                ->icons([
                                    'masculino' => Heroicon::User,
                                    'feminino' => Heroicon::Heart,
                                ]),
                        ])->columnSpanFull(),
                        Grid::make(3)->schema([
                            DatePicker::make('data_nascimento')
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
                            TextInput::make('telefone')
                                ->label('Telefone')
                                ->required()
                                ->placeholder('Digite seu telefone'),
                        ])->columnSpanFull(),
                        Grid::make(6)->schema([
                            TextInput::make('endereco')
                                ->label('Endereço')
                                ->columnSpan(3)
                                ->required(),
                            TextInput::make('endereco_numero')
                                ->label('Número')
                                ->columnSpan(1)
                                ->required(),
                            TextInput::make('bairro')
                                ->label('Bairro')
                                ->columnSpan(2)
                                ->required(),

                        ])->columnSpanFull(), // Espaço vazio para separar visualmente os grupos

                        TextInput::make('ponto_referencia')
                            ->label('Ponto de Referência')
                            ->columnSpanFull(),

                        Grid::make(6)->schema([
                            ToggleButtons::make('estuda')
                                ->label('Ainda estuda?')
                                ->required()
                                ->inline()
                                ->grouped()
                                ->live()                       // ← IMPORTANTE!
                                ->options([
                                    'sim' => 'Sim',
                                    'nao' => 'Não',
                                ])
                                ->columnSpan(1),

                            // ── Campos que aparecem APENAS quando estuda = 'sim' ────────────────────────────────
                            Select::make('nivel')
                                ->label('Nível')
                                ->options([
                                    'Fundamental' => 'Fundamental',
                                    'Médio' => 'Médio',
                                    'Superior' => 'Superior',
                                    'Técnico' => 'Técnico',
                                    'Pós-graduação' => 'Pós-graduação',
                                ])
                                ->columnSpan(5)
                                ->visible(fn (Get $get): bool => $get('estuda') === 'sim')
                                ->required(fn (Get $get): bool => $get('estuda') === 'sim'),

                            // ── Campo que aparece APENAS quando estuda = 'nao' ────────────────────────────────
                            Select::make('formacao')   // ← note que mudei para .formacao (sem ç)
                                ->label('Formação')
                                ->visible(fn (Get $get): bool => $get('estuda') === 'nao')
                                ->required(fn (Get $get): bool => $get('estuda') === 'nao')
                                ->options([
                                    'Fundamental Incompleto' => 'Fundamental Incompleto',
                                    'Fundamental Completo' => 'Fundamental Completo',
                                    'Ensino Médio Incompleto' => 'Ensino Médio Incompleto',
                                    'Ensino Médio Completo' => 'Ensino Médio Completo',
                                    'Superior Incompleto' => 'Superior Incompleto',
                                    'Superior Completo' => 'Superior Completo',
                                ])
                                ->columnSpan(5),

                        ])->columnSpanFull(),

                        Grid::make(6)->schema([
                        ToggleButtons::make('trabalha')
                            ->label('Trabalha?')
                            ->required()
                            ->inline()
                            ->grouped()
                            ->live()                       // ← IMPORTANTE!
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'nao') {
                                    $set('empresa', null);
                                    $set('declaracao_de_ausencia', null);
                                }
                            })
                            ->options([
                                'sim' => 'Sim',
                                'nao' => 'Não',
                            ]),
                        TextInput::make('empresa')
                            ->label('Profissão / Empresa')
                            ->columnSpan(3)
                            ->visible(fn (Get $get): bool => $get('trabalha') === 'sim')
                            ->required(fn (Get $get): bool => $get('trabalha') === 'sim'),

                        ToggleButtons::make('declaracao_de_ausencia')
                            ->label('Necessita de declaração para ausência no trabalho?')
                            ->inline()
                            ->grouped()
                            ->options([
                                'sim' => 'Sim',
                                'nao' => 'Não',
                            ])
                            ->columnSpan(2)
                            ->visible(fn (Get $get): bool => $get('trabalha') === 'sim')
                            ->required(fn (Get $get): bool => $get('trabalha') === 'sim'),


                    ])->columnSpanFull(),

                    ])->columnSpanFull(),

                Fieldset::make('Filiação')
                    ->statePath('filiacao')
                    ->schema([
                        Grid::make(6)->schema([
                            TextInput::make('pai')
                                ->label('Nome do Pai')
                                ->placeholder('Digite o nome do pai')
                                ->columnSpan(2)
                                ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null),
                            TextInput::make('telefone_pai')
                                ->label('Telefone do Pai')
                                ->columnSpan(1)
                                ->placeholder('(00) 00000-0000'),
                            TextInput::make('mae')
                                ->label('Nome da Mãe')
                                ->placeholder('Digite o nome da mãe')
                                ->columnSpan(2)
                                ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null),
                            TextInput::make('telefone_mae')
                                ->label('Telefone da Mãe')
                                ->columnSpan(1)
                                ->placeholder('(00) 00000-0000'),
                        ])->columnSpanFull(),

                        ToggleButtons::make('ecc')
                            ->label('Seus pais já fizeram o ECC?')
                            ->inline()
                            ->required()
                            ->grouped()
                            ->options([
                                'sim' => 'Sim',
                                'nao' => 'Não',
                            ]),
                    ])->columnSpanFull(),

                Fieldset::make('Informações Adicionais')
                    ->statePath('informacoes_adicionais')
                    ->schema([
                        Grid::make(3)->schema([
                            ToggleButtons::make('mora_com')
                                ->label('Mora com?')
                                ->inline()
                                ->required()
                                ->grouped()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state === 'nao') {
                                        $set('mora_com_outros', null);
                                        $set('mora_com_outros_contato', null);
                                    }
                                })
                                ->options([
                                    'pais' => 'Pais',
                                    'familiares' => 'Familiares',
                                    'amigos' => 'Amigos',
                                    'sozinho' => 'Sozinho',
                                    'outros' => 'Outros',
                                ]),
                            TextInput::make('mora_com_outros')
                                ->label('Com quem mora?')
                                ->placeholder('Descreva com quem mora')
                                ->visible(fn (callable $get): bool => $get('mora_com') === 'outros')
                                ->required(fn (callable $get): bool => $get('mora_com') === 'outros'),
                            TextInput::make('mora_com_outros_contato')
                                ->label('Telefone do contato')
                                ->placeholder('(00) 00000-0000')
                                ->visible(fn (callable $get): bool => $get('mora_com') === 'outros'),
                        ])->columnSpanFull(), // Espaço vazio para separar visualmente os grupos
                        ToggleButtons::make('cristao')
                            ->label('Você é cristão católico?')
                            ->inline()
                            ->required()
                            ->grouped()
                            ->options([
                                'sim' => 'Sim',
                                'nao' => 'Não',
                                'outro' => 'Outro',
                            ]),
                        ToggleButtons::make('sacramentos')
                            ->label('Você já fez os sacramentos da Iniciação Cristã?')
                            ->inline()
                            ->required()
                            ->multiple()
                            ->grouped()
                            ->options([
                                'batismo' => 'Batismo',
                                'eucaristia' => 'Eucaristia',
                                'crisma' => 'Crisma',
                            ]),
                        ToggleButtons::make('foi_casado')
                            ->label('Você já viveu pré-natalmente ou já foi casado?')
                            ->inline()
                            ->required()
                            ->grouped()
                            ->options([
                                'sim' => 'Sim',
                                'nao' => 'Não',
                            ]),

                        ToggleButtons::make('tem_filhos')
                            ->label('Tem filhos?')
                            ->inline()
                            ->required()
                            ->grouped()
                            ->options([
                                'sim' => 'Sim',
                                'nao' => 'Não',
                            ]),
                    Grid::make(2)->schema([
                        ToggleButtons::make('participa_grupo_jovens')
                            ->label('Participa de alguma pastoral, movimento ou serviço da igreja?')
                            ->required()
                            ->inline()
                            ->grouped()
                            ->live()                       // ← IMPORTANTE!
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'nao') {
                                    $set('nome_do_grupo', null);
                                }
                            })
                            ->options([
                                'sim' => 'Sim',
                                'nao' => 'Não',
                            ]),

                        TextInput::make('nome_do_grupo')
                            ->label('Nome do Grupo/Movimento')
                            ->required(fn (Get $get): bool => $get('participa_grupo_jovens') === 'sim')
                            ->visible(fn (Get $get): bool => $get('participa_grupo_jovens') === 'sim'),
                    ])->columnSpanFull(),

                    Grid::make(2)->schema([
                        ToggleButtons::make('aptidao_musical')
                            ->label('Tem alguma aptidão musical ou artistica?')
                            ->required()
                            ->inline()
                            ->grouped()
                            ->live()                       // ← IMPORTANTE!
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'nao') {
                                    $set('aptidao_musical_qual', null);
                                }
                            })
                            ->options([
                                'sim' => 'Sim',
                                'nao' => 'Não',
                            ]),

                        TextInput::make('aptidao_musical_qual')
                            ->label('Qual aptidão musical ou artística?')
                            ->required(fn (Get $get): string => $get('aptidao_musical') == 'sim')
                            ->visible(fn (Get $get): string => $get('aptidao_musical') == 'sim'),
                    ])->columnSpanFull(),
                    Grid::make(5)->schema([
                        ToggleButtons::make('incrito_antes')
                            ->label('Já foi incrito no EJC antes?')
                            ->inline()
                            ->required()
                            ->grouped()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'nao') {
                                    $set('incrito_antes_quando', null);
                                    $set('incrito_antes_paroquia', null);
                                }
                            })
                            ->options([
                                'sim' => 'Sim',
                                'nao' => 'Não',
                            ]),
                        TextInput::make('incrito_antes_quando')
                            ->label('Quando foi incrito?')
                            ->required(fn (Get $get): bool => $get('incrito_antes') === 'sim')
                            ->visible(fn (Get $get): bool => $get('incrito_antes') === 'sim')
                            ->columnSpan(2),
                        TextInput::make('incrito_antes_paroquia')
                            ->label('Qual paróquia foi incrito?')
                            ->required(fn (Get $get): bool => $get('incrito_antes') === 'sim')
                            ->visible(fn (Get $get): bool => $get('incrito_antes') === 'sim')
                            ->columnSpan(2),
                    ])->columnSpanFull(),

                    Grid::make(2)->schema([
                        ToggleButtons::make('indicado_por_alguem')
                            ->label('Você foi indicado por alguém do EJC?')
                            ->required()
                            ->inline()
                            ->grouped()
                            ->live()                       // ← IMPORTANTE!
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'nao') {
                                    $set('indicado_por_alguem_quem', null);
                                }
                            })
                            ->options([
                                'sim' => 'Sim',
                                'nao' => 'Não',
                            ]),

                        TextInput::make('indicado_por_alguem_quem')
                            ->label('Quem indicou você?')
                            ->required(fn (Get $get): bool => $get('indicado_por_alguem') === 'sim')
                            ->visible(fn (Get $get): bool => $get('indicado_por_alguem') === 'sim'),
                    ])->columnSpanFull(),

                    Grid::make(2)->schema([
                        ToggleButtons::make('inscrito_irmao_amigo_parente')
                            ->label('Tem algum irmão, parente ou namorado(a) inscritos nesta edição do EJC?')
                            ->required()
                            ->inline()
                            ->grouped()
                            ->live()                       // ← IMPORTANTE!
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'nao') {
                                    $set('inscrito_irmao_amigo_parente_quem', null);
                                }
                            })
                            ->options([
                                'sim' => 'Sim',
                                'nao' => 'Não',
                            ]),

                        TextInput::make('inscrito_irmao_amigo_parente_quem')
                            ->label('Nomes dos inscritos?')
                            ->required(fn (Get $get): bool => $get('inscrito_irmao_amigo_parente') === 'sim')
                            ->visible(fn (Get $get): bool => $get('inscrito_irmao_amigo_parente') === 'sim'),
                    ])->columnSpanFull(),

                    TextInput::make('horario_para_encontrar')
                        ->label('Qual melhor horário pra você ser encontrado em casa?')
                        ->required()->columnSpanFull(),

                ])->columnSpanFull(),

                Section::make()
                    ->schema([
                        Select::make('circulo')
                            ->label('Cor do Círculo')
                            ->options([
                                'azul' => 'Azul',
                                'amarelo' => 'Amarelo',
                                'laranja' => 'Laranja',
                                'rosa' => 'Rosa',
                                'verde' => 'Verde',
                                'vermelho' => 'Vermelho',
                            ])
                            ->visibleOn(Operation::Edit)
                ])->columnSpanFull(),
            ]);
    }
}
