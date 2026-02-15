<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Inscrição EJC - Paróquia do Prado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-900 via-blue-800 to-indigo-700 text-white">

<!-- HERO / TELA CHEIA -->
<section class="relative min-h-screen flex items-center justify-center px-6">

    <!-- Overlay decorativo -->
    <div class="absolute inset-0 bg-black/30"></div>

    <!-- Conteúdo principal -->
    <div class="relative z-10 max-w-5xl w-full grid md:grid-cols-2 gap-12 items-center">

        <!-- TEXTO -->
        <div class="space-y-6">
            <span class="inline-block bg-white/10 px-4 py-2 rounded-full text-sm tracking-wide">
                EJC • Paróquia do Prado • Iguatu
            </span>

            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">
                Encontro de<br>
                <span class="text-yellow-300">Jovens com Cristo</span>
            </h1>

            <p class="text-lg text-blue-100 leading-relaxed">
                Um momento único de fé, partilha, amizade e renovação espiritual.
                Viva dias intensos de reflexão, alegria e proximidade com Deus,
                junto a jovens da nossa comunidade.
            </p>

            <!-- DATA -->
            <div class="bg-white/10 backdrop-blur px-6 py-4 rounded-2xl inline-block">
                <p class="text-sm uppercase tracking-wider text-blue-200">
                    Data do Encontro
                </p>
                <p class="text-xl font-bold text-yellow-300">
                    14 a 16 de maio de 2026
                </p>
            </div>

            <!-- CTA -->
            <div class="pt-4">
            {{--
                <a href="{{ route('inscricao') }}"
                   class="inline-flex items-center gap-3 bg-gradient-to-r from-yellow-400 to-yellow-500
                          hover:from-yellow-500 hover:to-yellow-600
                          text-gray-900 font-extrabold text-lg
                          px-10 py-4 rounded-full shadow-2xl
                          transition transform hover:-translate-y-1">
                    Quero me inscrever
                    <span class="text-2xl">→</span>
                </a>
                 --}}
            </div>
        </div>

        <!-- CARD DE RESTRIÇÕES -->
        <div class="bg-white text-gray-800 rounded-3xl shadow-2xl p-8 space-y-6">

            <h2 class="text-2xl font-extrabold text-center text-indigo-700">
                Requisitos para Participação
            </h2>

            <ul class="space-y-4">
                <li class="flex items-center gap-4 bg-gray-50 p-4 rounded-xl border">
                    <span class="text-green-600 text-xl">✔</span>
                    <span class="text-md">
                        Ter entre <strong>16 e 29 anos</strong>
                    </span>
                </li>
                <li class="flex items-center gap-4 bg-gray-50 p-4 rounded-xl border">
                    <span class="text-green-600 text-xl">✔</span>
                    <span class="text-md">
                        Fazer parte da <strong>Paróquia do Prado – Iguatu</strong>
                    </span>
                </li>
                <li class="flex items-center gap-4 bg-gray-50 p-4 rounded-xl border">
                    <span class="text-red-500 text-xl">❌</span>
                    <span class="text-md">
                        Não possuir filhos
                    </span>
                </li>
            </ul>

            <p class="text-sm text-center text-gray-500 pt-4">
                As vagas são limitadas.<br> Faça sua pré-inscrição agora e aproveite!
            </p>
        </div>

    </div>

</section>


</body>
</html>
