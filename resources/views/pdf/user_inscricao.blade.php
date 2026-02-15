<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Inscrição EJC</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-size: 0.9em;
        }

        fieldset {
            border: 1px solid #656464;
            border-radius: 5px;
            padding: 7px;
            margin-top: 10px;
        }

        legend {
            font-weight: bold;
            font-size: 0.9em;
        }

        .form-group {
            margin-bottom: 2px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 3px;
            font-size: 0.75em;
        }

        .info {
            display: block;
            padding: 7px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            font-size: 0.9em;
            border-radius: 4px;
        }




    </style>
</head>
<body>
    <table style="width: 100%;">
        <tr>
            <td style="text-align: center; border: 1.5px solid #000; padding: 5px; font-weight: 700; font-size: 20px;">
                ENCONTRO DE JOVENS COM CRISTO<br>
                ARTICULAÇÃO DIOCESANA<br>
                DIOCESE DE IGUATU - RNE I
            </td>
        </tr>
    </table>
    <p style="text-align: center; font-size: 20px; font-weight: 700;">Paróquia N. Sra. do Perpétuo Socorro - Iguatu - CE</p>
    <p style="text-align: center; font-weight: 600;">IV EJC - {{ $diaDaInscricao }} de 2026 - Ficha de Inscrição Nº {{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</p>
    <p style="text-align: center; margin-bottom: 2px;"><span style="font-weight: bold; font-size: 10px; color: red;">ATENÇÃO: PREENCHIMENTO EXCLUSIVO DO EJC – PASTA FICHAS</span></p>
    <p style="text-align: center;">Azul [__] Verde [__] Amarelo [__] Vermelho [__] Rosa [__] Branco [__]</p>

    <!-- Espaçamento -->
    <div style="margin-top: 10px;"></div>
<fieldset>
    <legend>Dados Pessoais</legend>
    <table style="width: 100%;">
        <tr>
            <td style="width: 140px; text-align: center; vertical-align: top;">
                <img
                    src="{{ public_path('images/profile-casal-avatar.jpg') }}"
                    alt="Foto do inscrito"
                    style="width: 128px; height: 160px; object-fit: cover; border: 1px solid #ccc; border-radius: 4px;"
                >
            </td>
            <td style="width: 480px;">
                <table style="width: 100%; ">
                    <tr>
                        <td style="width: 70%;">
                            <div class="form-group">
                                <label>Nome Completo:</label>
                                <span class="info">{{ $user->dados_pessoais['full_name'] }} ({{ $user->dados_pessoais['conhecido_como'] ?? '' }})</span>
                            </div>
                        </td>
                        <td style="width: 30%;">
                            <div class="form-group">
                                <label>Telefone</label>
                                <span class="info">{{ $user->dados_pessoais['telefone'] }}</span>
                            </div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; ">
                    <tr>
                        <td style="width: 20%;">
                            <div class="form-group">
                                <label>Data Nascimento:</label>
                                <span class="info">{{ date('d/m/Y', strtotime($user->dados_pessoais['data_nascimento'])) }}</span>
                            </div>
                        </td>
                        <td style="width: 15%;">
                            <div class="form-group">
                                <label>Idade:</label>
                                <span class="info">{{ $user->idade }} anos</span>
                            </div>
                        </td>
                        <td style="width: 15%;">
                            <div class="form-group">
                                <label>Sexo:</label>
                                <span class="info">{{ $user->dados_pessoais['sexo'] }}</span>
                            </div>
                        </td>
                        <td style="width: 50%;">
                            <div class="form-group">
                                <label>Estuda:</label>
                                <span class="info">{{ $estuda }}</span>
                            </div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; ">
                    <tr>
                        <td style="width: 40%;">
                            <div class="form-group">
                                <label>Endereço:</label>
                                <span class="info">{{ $user->dados_pessoais['endereco'] }}</span>
                            </div>
                        </td>
                        <td style="width: 10%;">
                            <div class="form-group">
                                <label>Número:</label>
                                <span class="info">{{ $user->dados_pessoais['endereco_numero'] }}</span>
                            </div>
                        </td>
                        <td style="width: 50%;">
                            <div class="form-group">
                                <label>Bairro:</label>
                                <span class="info">{{ $user->dados_pessoais['bairro'] }}</span>
                            </div>
                        </td>

                    </tr>
                </table>


            </td>
        </tr>
    </table>

    <table style="width: 100%; ">
        <tr>
            <td style="width: 60%;">
                <div class="form-group">
                    <label>Ponto de referência:</label>
                    <span class="info">{{ $user->dados_pessoais['ponto_referencia'] }}</span>
                </div>
            </td>
            <td style="width: 30%;">
                <div class="form-group">
                    <label>Mora com:</label>
                    <span class="info">{{ $mora_com }}</span>
                </div>
            </td>
            <td style="width: 10%;">
                <div class="form-group">
                    <label>Tem filhos:</label>
                    <span class="info">{{ $user->informacoes_adicionais['tem_filhos']}}</span>
                </div>
            </td>
        </tr>
    </table>
</fieldset>

<!-- Espaçamento -->
<div style="margin-top: 10px;"></div>

<fieldset>
    <legend>Outras Informações</legend>
    <table style="width: 100%;">
        <tr>
            <td style="width: 60%;">
                <div class="form-group">
                    <label>Trabalha?</label>
                    <span class="info">{{ $trabalha }}</span>
                </div>
            </td>
            <td style="width: 40%;">
                <div class="form-group">
                    <label>Declaração de Ausência:</label>
                    <span class="info">{{ $oficio }}</span>
                </div>
            </td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td style="width: 20%;">
                <div class="form-group">
                    <label>Critão católico?</label>
                    <span class="info">{{ $user->informacoes_adicionais['cristao'] }}</span>
                </div>
            </td>
            <td style="width: 40%;">
                <div class="form-group">
                    <label>Já recebeu algum sacramento?</label>
                    <span class="info">{{ $sacramentos }}</span>
                </div>
            </td>
            <td style="width: 40%;">
                <div class="form-group">
                    <label>Você já viveu pré-natalmente ou já foi casado?</label>
                    <span class="info">{{ $user->informacoes_adicionais['foi_casado'] }}</span>
                </div>
            </td>
        </tr>
    </table>
</fieldset>


<!-- Espaçamento -->
<div style="margin-top: 10px;"></div>
<fieldset>
    <legend>Filiação</legend>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <div class="form-group">
                    <label>Nome do Pai:</label>
                    <span class="info">{{ $user->filiacao['pai'] }} {{ $user->filiacao['telefone_pai']}}</span>
                </div>
            </td>
            <td style="width: 50%;">
                    <div class="form-group">
                    <label>Nome da Mãe:</label>
                    <span class="info">{{ $user->filiacao['mae'] }} {{ $user->filiacao['telefone_mae']}}</span>
                </div>
            </td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td>
                <div class="form-group">
                    <label>Seus pais já fizeram o ECC?</label>
                    <span class="info">{{ $user->filiacao['ecc'] }}</span>
                </div>
            </td>
        </tr>
    </table>
</fieldset>



<!-- Quebra de página -->
<div style="display: block; page-break-before: always; height: 0px; margin: 0; padding: 0; overflow: hidden;"></div>




<!-- Espaçamento -->


<br>

<p>
    Declaro para os devidos fins que as informações prestadas nesta ficha de inscrição são verdadeiras e que estou ciente das condições de participação no Encontro de Jovens com Cristo (EJC). Comprometo-me a cumprir as normas estabelecidas pela organização do evento e a participar ativamente durante os três dias do encontro, caso minha inscrição seja aceita. Estou ciente de que a participação no EJC é uma oportunidade de crescimento espiritual e pessoal, e estou disposto(a) a vivenciar essa experiência com responsabilidade e respeito.
</p>
<p style="text-align: right;">
    Iguatu, _____ de ____________________ de 2026. <br><br>
</p>
<table style="width: 100%; margin-top: 40px; ">
    <tr>
        <td style="width: 50%; text-align: center;">
            _______________________________________<br>
            Assinatura do(a) Inscrito(a)<br><br>
        </td>
        <td style="width: 50%; text-align: center;">
            _______________________________________<br>
            Assinatura do Responsável<br><br>
        </td>
    </tr>
    <tr>
        <td style="width: 50%; text-align: center;">
            _______________________________________<br>
            Representante da Pasta Ficha EJC<br>
        </td>
        <td style="width: 50%; text-align: center;">
            _______________________________________<br>
            Diretor Espiritual<br>
        </td>
    </tr>
</table>
{{--
<br>
<p style="text-align: center; font-size: 20px; font-weight: 700;">Observações</p>
<p style="border-bottom: 1px solid black; width: 100%; margin: 20px 0 20px 0; padding-bottom: 4px;"></p>
<p style="border-bottom: 1px solid black; width: 100%; margin: 20px 0 20px 0; padding-bottom: 4px;"></p>
<p style="border-bottom: 1px solid black; width: 100%; margin: 20px 0 20px 0; padding-bottom: 4px;"></p>
<p style="border-bottom: 1px solid black; width: 100%; margin: 20px 0 20px 0; padding-bottom: 4px;"></p>

<p style="text-align: center; font-size: 10px;">
<b>ATENÇÃO!</b><br>
CRITÉRIOS que devem ser observados ao se visitar os jovens para participar do EJC:<br>
Idade entre 16 (dezesseis) e 29 (vinte e quatro anos) anos;<br>
Morar nas localidades da Paróquia;<br>
A ficha deverá ser devolvida totalmente preenchida, incluindo as assinaturas do participante e de seu responsável legal;<br>
É obrigatória a presença do jovem participante durante os três dias do Encontro. <br>
*Esta ficha de inscrição não garante a sua participação no Encontro.
</p>
 --}}
</body>
</html>