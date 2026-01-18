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

        .header-box {
            width: 100%;
            border: 1.5px solid #000;
            padding: 10px;
            margin-bottom: 25px;
        }

        .header-text {
            font-family: "Roboto", sans-serif;
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.4;
        }


    </style>
</head>
<body>
    <div class="header-box">
        <div class="header-text">
            ENCONTRO DE JOVENS COM CRISTO<br>
            ARTICULAÇÃO DIOCESANA
        </div>
    </div>
    <p style="text-align: center; font-size: 20px; font-weight: 700;">Paróquia N. Sra. do Perpétuo Socorro - Iguatu - CE</p>
    <p style="text-align: center; font-weight: 600;">_____, de __________________ de 2026 - Ficha de Inscrição Nº _____</p>
    <p style="text-align: center; margin-bottom: 6px;"><span style="font-weight: bold; text-size: 10px; color: red;">ATENÇÃO: PREENCHIMENTO EXCLUSIVO DO EJC – PASTA FICHAS</span></p>
    <p style="text-align: center;">Azul [__] Verde [__] Amarelo [__] Vermelho [__] Rosa [__] Branco [__]</p>
    <fieldset>
        <legend>Dados Pessoais</legend>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <!-- Foto à esquerda -->
                <td style="width: 160px; vertical-align: top; padding-right: 20px;">
                    <img
                        src="{{ public_path('images/profile-casal-avatar.jpg') }}"
                        alt="Foto do inscrito"
                        style="width: 140px; height: 180px; object-fit: cover; border: 1px solid #333; border-radius: 2px;"
                    >
                </td>

                <!-- Nome (e futuros campos) à direita -->
                <td style="vertical-align: top;">
                    <div class="form-group" style="max-width: 400px;">
                        <label style="font-size: 0.85em; font-weight: bold; margin-bottom: 4px; display: block;">
                            Nome Completo:
                        </label>
                        <span class="info" style="font-size: 0.9em; padding: 8px; display: block;">
                            Nome Completo da Silva (Apelido)
                        </span>
                    </div>

                    <!-- Pode adicionar mais campos aqui depois, ficando todos alinhados à direita -->
                    <!-- Exemplo:
                    <div class="form-group" style="margin-top: 12px;">
                        <label>Data de Nascimento:</label>
                        <span class="info">15/03/2000</span>
                    </div>
                    -->
                </td>
            </tr>
        </table>
    </fieldset>
</body>
</html>