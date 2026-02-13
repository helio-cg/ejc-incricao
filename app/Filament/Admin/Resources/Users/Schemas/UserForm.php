<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pré Inscrição')
                    ->description('Cadastro de jovens para o Encontro de Jovens com Cristo 2026')
                    ->schema([
                        Fieldset::make('Dados Pessoais')
                            ->columns([
                                'default' => 1,
                                'md' => 2,
                                'xl' => 3,
                            ])
                            ->schema([
                                Grid::make(4)->schema([
                                    TextInput::make('full_name')
                                        ->label('Nome Completo')
                                        ->required()
                                        ->placeholder('Digite seu nome completo')
                                        ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null)
                                        ->columnSpan(2),
                                    TextInput::make('name')
                                        ->label('Nome Usual / Apelido')
                                        ->required()
                                        ->placeholder('Conhecido(a) por')
                                        ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null),
                                    ToggleButtons::make('dados_pessoais.sexo')
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
                                ])->columnSpanFull(),
                                Grid::make(6)->schema([
                                    TextInput::make('dados_pessoais.endereco')
                                        ->label('Endereço')
                                        ->columnSpan(3)
                                        ->required(),
                                    TextInput::make('dados_pessoais.endereco_numero')
                                        ->label('Número')
                                        ->columnSpan(1)
                                        ->required(),
                                    TextInput::make('dados_pessoais.bairro')
                                        ->label('Bairro')
                                        ->columnSpan(2)
                                        ->required(),

                                ])->columnSpanFull(), // Espaço vazio para separar visualmente os grupos

                                TextInput::make('dados_pessoais.ponto_referencia')
                                    ->label('Ponto de Referência')
                                    ->columnSpanFull(),

                                Grid::make(6)->schema([
                                    ToggleButtons::make('dados_escolares.estuda')
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
                                    Select::make('dados_escolares.nivel')
                                        ->label('Nível')
                                        ->options([
                                            'Fundamental' => 'Fundamental',
                                            'Médio' => 'Médio',
                                            'Superior' => 'Superior',
                                            'Técnico' => 'Técnico',
                                            'Pós-graduação' => 'Pós-graduação',
                                        ])
                                        ->columnSpan(5)
                                        ->visible(fn (Get $get): bool => $get('dados_escolares.estuda') === 'sim')
                                        ->required(fn (Get $get): bool => $get('dados_escolares.estuda') === 'sim'),

                                    // ── Campo que aparece APENAS quando estuda = 'nao' ────────────────────────────────
                                    Select::make('dados_escolares.formacao')   // ← note que mudei para .formacao (sem ç)
                                        ->label('Formação')
                                        ->visible(fn (Get $get): bool => $get('dados_escolares.estuda') === 'nao')
                                        ->required(fn (Get $get): bool => $get('dados_escolares.estuda') === 'nao')
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
                                ToggleButtons::make('dados_profissionais.trabalha')
                                    ->label('Trabalha?')
                                    ->required()
                                    ->inline()
                                    ->grouped()
                                    ->live()                       // ← IMPORTANTE!
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state === 'nao') {
                                            $set('dados_profissionais.empresa', null);
                                            $set('dados_profissionais.declaracao_de_ausencia', null);
                                        }
                                    })
                                    ->options([
                                        'sim' => 'Sim',
                                        'nao' => 'Não',
                                    ]),
                                TextInput::make('dados_profissionais.empresa')
                                    ->label('Profissão / Empresa')
                                    ->columnSpan(3)
                                    ->visible(fn (Get $get): bool => $get('dados_profissionais.trabalha') === 'sim')
                                    ->required(fn (Get $get): bool => $get('dados_profissionais.trabalha') === 'sim'),

                                ToggleButtons::make('dados_profissionais.declaracao_de_ausencia')
                                    ->label('Necessita de declaração para ausência no trabalho?')
                                    ->inline()
                                    ->grouped()
                                    ->options([
                                        'sim' => 'Sim',
                                        'nao' => 'Não',
                                    ])
                                    ->columnSpan(2)
                                    ->visible(fn (Get $get): bool => $get('dados_profissionais.trabalha') === 'sim')
                                    ->required(fn (Get $get): bool => $get('dados_profissionais.trabalha') === 'sim'),


                            ])->columnSpanFull(),

                            ])->columnSpanFull(),

                        Fieldset::make('Filiação')
                            ->columns(1)
                            ->schema([
                                Grid::make(6)->schema([
                                    TextInput::make('filiacao.pai')
                                        ->label('Nome do Pai')
                                        ->placeholder('Digite o nome do pai')
                                        ->columnSpan(2)
                                        ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null),
                                    TextInput::make('filiacao.telefone_pai')
                                        ->label('Telefone do Pai')
                                        ->columnSpan(1)
                                        ->placeholder('(00) 00000-0000'),
                                    TextInput::make('filiacao.mae')
                                        ->label('Nome da Mãe')
                                        ->placeholder('Digite o nome da mãe')
                                        ->columnSpan(2)
                                        ->dehydrateStateUsing(fn (?string $state) => $state ? Str::ucwords(mb_strtolower($state)) : null),
                                    TextInput::make('filiacao.telefone_mae')
                                        ->label('Telefone da Mãe')
                                        ->columnSpan(1)
                                        ->placeholder('(00) 00000-0000'),
                                ])->columnSpanFull(),

                                Grid::make(3)->schema([
                                    ToggleButtons::make('filiacao.mora_com')
                                        ->label('Mora com?')
                                        ->inline()
                                        ->required()
                                        ->grouped()
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            if ($state === 'nao') {
                                                $set('filiacao.mora_com_outros', null);
                                                $set('filiacao.mora_com_outros_contato', null);
                                            }
                                        })
                                        ->options([
                                            'pais' => 'Pais',
                                            'familiares' => 'Familiares',
                                            'amigos' => 'Amigos',
                                            'sozinho' => 'Sozinho',
                                            'outros' => 'Outros',
                                        ]),
                                    TextInput::make('filiacao.mora_com_outros')
                                        ->label('Com quem mora?')
                                        ->placeholder('Descreva com quem mora')
                                        ->visible(fn (callable $get): bool => $get('filiacao.mora_com') === 'outros')
                                        ->required(fn (callable $get): bool => $get('filiacao.mora_com') === 'outros'),
                                    TextInput::make('filiacao.mora_com_outros_contato')
                                        ->label('Telefone do contato')
                                        ->placeholder('(00) 00000-0000')
                                        ->visible(fn (callable $get): bool => $get('filiacao.mora_com') === 'outros'),
                                            //->required(fn (callable $get): bool => $get('filiacao.mora_com') === 'outros'),
                                ])->columnSpanFull(), // Espaço vazio para separar visualmente os grupos

                            /*  Grid::make(2)->schema([
                                    Radio::make('filiacao.fez_ecc')
                                        ->label('Seus pais já fizeram o Encontro de Casais com Cristo?')
                                        ->inline()
                                        ->required()
                                        ->live()
                                        ->options([
                                            'sim' => 'Sim',
                                            'nao' => 'Não',
                                        ]),
                                    TextArea::make('filiacao.fez_ecc_aonde')
                                        ->label('Aonde fizeram o ECC?')
                                        ->placeholder('Digite o nome da paróquia')
                                        ->visible(fn (callable $get): bool => $get('filiacao.fez_ecc') === 'sim')
                                        ->required(fn (callable $get): bool => $get('filiacao.fez_ecc') === 'sim'),
                                ]),*/

                            ])->columnSpanFull(),

                        Fieldset::make('Informações Adicionais')
                            //->columns(1)
                            ->schema([
                                ToggleButtons::make('informacoes_adicionais.cristao')
                                    ->label('Você é cristão católico?')
                                    ->inline()
                                    ->required()
                                    ->grouped()
                                    ->options([
                                        'sim' => 'Sim',
                                        'nao' => 'Não',
                                        'outro' => 'Outro',
                                    ]),
                                ToggleButtons::make('informacoes_adicionais.sacramentos')
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
                                ToggleButtons::make('informacoes_adicionais.foi_casado')
                                    ->label('Você já viveu pré-natalmente ou já foi casado?')
                                    ->inline()
                                    ->required()
                                    ->grouped()
                                    ->options([
                                        'sim' => 'Sim',
                                        'nao' => 'Não',
                                    ]),

                                ToggleButtons::make('informacoes_adicionais.tem_filhos')
                                    ->label('Tem filhos?')
                                    ->inline()
                                    ->required()
                                    ->grouped()
                                    ->options([
                                        'sim' => 'Sim',
                                        'nao' => 'Não',
                                    ]),
                            Grid::make(2)->schema([
                                ToggleButtons::make('dados_gerais.participa_grupo_jovens')
                                    ->label('Participa de alguma pastoral, movimento ou serviço da igreja?')
                                    ->required()
                                    ->inline()
                                    ->grouped()
                                    ->live()                       // ← IMPORTANTE!
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state === 'nao') {
                                            $set('dados_gerais.nome_do_grupo', null);
                                        }
                                    })
                                    ->options([
                                        'sim' => 'Sim',
                                        'nao' => 'Não',
                                    ]),

                                TextInput::make('dados_gerais.nome_do_grupo')
                                    ->label('Nome do Grupo/Movimento')
                                    ->required(fn (Get $get): bool => $get('dados_gerais.participa_grupo_jovens') === 'sim')
                                    ->visible(fn (Get $get): bool => $get('dados_gerais.participa_grupo_jovens') === 'sim'),
                            ])->columnSpanFull(),


                            ToggleButtons::make('dados_gerais.aptidao_musical')
                                ->label('Tem alguma aptidão musical ou artistica?')
                                ->required()
                                ->inline()
                                ->grouped()
                                ->live()                       // ← IMPORTANTE!
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state === 'nao') {
                                        $set('dados_gerais.aptidao_musical_qual', null);
                                    }
                                })
                                ->options([
                                    'sim' => 'Sim',
                                    'nao' => 'Não',
                                ]),

                            TextInput::make('dados_gerais.aptidao_musical_qual')
                                ->label('Qual aptidão musical ou artística?')
                                ->required(fn (Get $get): bool => $get('dados_gerais.aptidao_musical') === 'sim')
                                ->visible(fn (Get $get): bool => $get('dados_gerais.aptidao_musical') === 'sim'),

                            Grid::make(5)->schema([
                                ToggleButtons::make('informacoes_adicionais.incrito_antes')
                                    ->label('Já foi incrito no EJC antes?')
                                    ->inline()
                                    ->required()
                                    ->grouped()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state === 'nao') {
                                            $set('dados_gerais.incrito_antes_quando', null);
                                            $set('dados_gerais.incrito_antes_paroquia', null);
                                        }
                                    })
                                    ->options([
                                        'sim' => 'Sim',
                                        'nao' => 'Não',
                                    ]),
                                TextInput::make('dados_gerais.incrito_antes_quando')
                                    ->label('Quando foi incrito?')
                                    ->required(fn (Get $get): bool => $get('informacoes_adicionais.incrito_antes') === 'sim')
                                    ->visible(fn (Get $get): bool => $get('informacoes_adicionais.incrito_antes') === 'sim')
                                    ->columnSpan(2),
                                TextInput::make('dados_gerais.incrito_antes_paroquia')
                                    ->label('Qual paróquia foi incrito?')
                                    ->required(fn (Get $get): bool => $get('informacoes_adicionais.incrito_antes') === 'sim')
                                    ->visible(fn (Get $get): bool => $get('informacoes_adicionais.incrito_antes') === 'sim')
                                    ->columnSpan(2),
                            ])->columnSpanFull(),

                            Grid::make(2)->schema([
                                ToggleButtons::make('dados_gerais.indicado_por_alguem')
                                    ->label('Você foi indicado por alguém do EJC?')
                                    ->required()
                                    ->inline()
                                    ->grouped()
                                    ->live()                       // ← IMPORTANTE!
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state === 'nao') {
                                            $set('dados_gerais.indicado_por_alguem_quem', null);
                                        }
                                    })
                                    ->options([
                                        'sim' => 'Sim',
                                        'nao' => 'Não',
                                    ]),

                                TextInput::make('dados_gerais.indicado_por_alguem_quem')
                                    ->label('Quem indicou você?')
                                    ->required(fn (Get $get): bool => $get('dados_gerais.indicado_por_alguem') === 'sim')
                                    ->visible(fn (Get $get): bool => $get('dados_gerais.indicado_por_alguem') === 'sim'),
                            ])->columnSpanFull(),

                            Grid::make(2)->schema([
                                ToggleButtons::make('dados_gerais.inscrito_irmao_amigo_parente')
                                    ->label('Tem algum irmão, parente ou namorado(a) inscritos nesta edição do EJC?')
                                    ->required()
                                    ->inline()
                                    ->grouped()
                                    ->live()                       // ← IMPORTANTE!
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state === 'nao') {
                                            $set('dados_gerais.inscrito_irmao_amigo_parente_quem', null);
                                        }
                                    })
                                    ->options([
                                        'sim' => 'Sim',
                                        'nao' => 'Não',
                                    ]),

                                TextInput::make('dados_gerais.inscrito_irmao_amigo_parente_quem')
                                    ->label('Nomes dos inscritos?')
                                    ->required(fn (Get $get): bool => $get('dados_gerais.inscrito_irmao_amigo_parente') === 'sim')
                                    ->visible(fn (Get $get): bool => $get('dados_gerais.inscrito_irmao_amigo_parente') === 'sim'),
                            ])->columnSpanFull(),

                            TextInput::make('dados_gerais.horaio_para_encontrar')
                                ->label('Qual melhor horário pra você ser encontrado em casa?')
                                ->required()->columnSpanFull(),

        /*
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

        */

                            ]),
                    ])->columnSpanFull(),
        /*        Fieldset::make('Filiação')
                    ->columns(1)
                    ->schema([

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


*/

/*
                Fieldset::make('Dados Gerais')
                    ->columns(1)
                    ->schema([


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
*/

            ]);
    }
}
