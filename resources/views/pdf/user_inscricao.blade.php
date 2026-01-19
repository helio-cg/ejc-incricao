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
        }

        fieldset {
            border: 1px solid #ccc;
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
            font-size: 0.7em;
        }

        .info {
            display: block;
            padding: 7px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            font-size: 0.8em;
            border-radius: 4px;
        }




    </style>
</head>
<body>
    <table style="width: 100%;">
        <tr>
            <td style="text-align: center; border: 1.5px solid #000; padding: 5px; font-weight: 700;">
                ENCONTRO DE JOVENS COM CRISTO<br>
            ARTICULAÇÃO DIOCESANA
            </td>
        </tr>
    </table>
    <p style="text-align: center; font-size: 20px; font-weight: 700;">Paróquia N. Sra. do Perpétuo Socorro - Iguatu - CE</p>
    <p style="text-align: center; font-weight: 600;">_____, de __________________ de 2026 - Ficha de Inscrição Nº _____</p>
    <p style="text-align: center; margin-bottom: 2px;"><span style="font-weight: bold; font-size: 10px; color: red;">ATENÇÃO: PREENCHIMENTO EXCLUSIVO DO EJC – PASTA FICHAS</span></p>
    <p style="text-align: center;">Azul [__] Verde [__] Amarelo [__] Vermelho [__] Rosa [__] Branco [__]</p>

    <!-- Espaçamento -->
    <div style="margin-top: 10px;"></div>
<fieldset>
    <legend>Dados Pessoais</legend>
    <table style="width: 100%;">
        <tr>
            <td style="width: 140px;">
                <img
                    src="{{ public_path('images/profile-casal-avatar.jpg') }}"
                    alt="Foto do inscrito"
                    style="width: 140px; height: 180px; object-fit: cover; border: 1px solid #333; border-radius: 4px;"
                >
            </td>
            <td style="width: 450px;">
                <table style="width: 100%; ">
                    <tr>
                        <td style="width: 70%;">
                            <div class="form-group">
                                <label>Nome Completo:</label>
                                <span class="info">Nome Completo da Silva (Apelido)</span>
                            </div>
                        </td>
                        <td style="width: 30%;">
                            <div class="form-group">
                                <label>Telefone</label>
                                <span class="info">(88) 98888-7654</span>
                            </div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; ">
                    <tr>
                        <td style="width: 20%;">
                            <div class="form-group">
                                <label>Data Nascimento:</label>
                                <span class="info">01/01/2000</span>
                            </div>
                        </td>
                        <td style="width: 15%;">
                            <div class="form-group">
                                <label>Idade:</label>
                                <span class="info">16 anos</span>
                            </div>
                        </td>
                        <td style="width: 15%;">
                            <div class="form-group">
                                <label>Sexo:</label>
                                <span class="info">Feminino</span>
                            </div>
                        </td>
                        <td style="width: 50%;">
                            <div class="form-group">
                                <label>E-Mail:</label>
                                <span class="info">nomdecompleto@email.com</span>
                            </div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; ">
                    <tr>
                        <td style="width: 50%;">
                            <div class="form-group">
                                <label>Endereço:</label>
                                <span class="info">Rua Juarez Távora, 82</span>
                            </div>
                        </td>
                        <td style="width: 30%;">
                            <div class="form-group">
                                <label>Bairro:</label>
                                <span class="info">Centro</span>
                            </div>
                        </td>
                        <td style="width: 20%;">
                            <div class="form-group">
                                <label>CEP:</label>
                                <span class="info">63.200-000</span>
                            </div>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; ">
                    <tr>
                        <td style="width: 100%;">
                            <div class="form-group">
                                <label>Porto de referência:</label>
                                <span class="info">Próximo a faculdade na Daraio Rabelo</span>
                            </div>
                        </td>
                    </tr>
                </table>
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
            <td>
                <div class="form-group" style="margin-top: 4px;">
                    <label>Possui alguma necessidade especial?</label>
                    <span class="info">Se sim, descreva se não exibe não possui</span>
                </div>
            </td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td>
                <div class="form-group" style="margin-top: 6px;">
                    <label>Tem alguma restrição alimentar?</label>
                    <span class="info">Se sim, descreva se não exibe Sem restrições alimetares</span>
                </div>
            </td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td>
                <div class="form-group" style="margin-top: 6px;">
                    <label>Faz uso de algum medicamentos?</label>
                    <span class="info">Se sim, descreva se não exibe não faz uso de medicamentos</span>
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
                    <span class="info">José Pereira da Silva</span>
                </div>
            </td>
            <td style="width: 50%;">
                    <div class="form-group">
                    <label>Nome da Mãe:</label>
                    <span class="info">Maria Antonia Pereira da Silva</span>
                </div>
            </td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td>
                <div class="form-group">
                    <label>Seus pais já fizeram o Encontro de Casais com Cristo?</label>
                    <span class="info">Se sim e onde, descreva se não exibe Não fizera o ECC</span>
                </div>
            </td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td>
                <div class="form-group">
                    <label>Seus pais participam de algum movimento religioso?</label>
                    <span class="info">Se sim e onde, descreva se não exibe Não participam</span>
                </div>
            </td>
        </tr>
    </table>

</fieldset>

<!-- Quebra de página -->
<div style="display: block; page-break-before: always; height: 0px; margin: 0; padding: 0; overflow: hidden;"></div>

<fieldset>
    <legend>Escolaridade</legend>
    <table style="width: 100%;">
        <tr>
            <td>
                <div class="form-group">
                    <label>Estuda?</label>
                    <span class="info">Se sim e onde, descreva se não exibe Não faz mostra a formação</span>
                </div>
            </td>
        </tr>
    </table>
</fieldset>

<!-- Espaçamento -->
<div style="margin-top: 10px;"></div>
<fieldset>
    <legend>Dados Profissionais</legend>
    <table style="width: 100%;">
        <tr>
            <td>
                <div class="form-group">
                    <label>Trabalha?</label>
                    <span class="info">Se sim e onde e horario, descreva se não exibe Não trabalha no momento</span>
                </div>
            </td>
        </tr>
    </table>
</fieldset>

<!-- Espaçamento -->
<div style="margin-top: 10px;"></div>
<fieldset>
    <legend>Dados Gerais</legend>
    <table style="width: 100%;">
        <tr>
            <td>
                <div class="form-group">
                    <label>Participa de algum grupo/movimento de jovens?</label>
                    <span class="info">Se sim e onde e horario, descreva se não ...</span>
                </div>
            </td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td>
                <div class="form-group">
                    <label>Tem irmãos?</label>
                    <span class="info">Se sim e onde e horario, descreva se não...</span>
                </div>
            </td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td>
                <div class="form-group">
                    <label>Tem algum irmão ou parente inscrito no EJC?</label>
                    <span class="info">Se sim e onde e horario, descreva se não...</span>
                </div>
            </td>
        </tr>
    </table>
</fieldset>

<br>
<p style="text-align: center; font-size: 20px; font-weight: 700;">Dados do Encontro</p>
<p>
    Convidado por: _____________________________________  Telefone: __________________
</p>
<p>
    Eu, ________________________________________, autorizo meu(minha) filho(a) a participar do Encontro de Jovens com Cristo, promovido pela Paróquia N. Sra. do Perpétuo Socorro.
</p>
<p style="text-align: right;">
    Iguatu, _____ de ____________________ de 2026. <br><br>
</p>
<table style="width: 100%; margin-top: 40px;">
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
</body>
</html>