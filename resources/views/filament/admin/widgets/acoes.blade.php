<x-filament-widgets::widget>
    <div class="text-lg font-bold text-gray-800 mb-4">Ações</div>
    <x-filament::section>
        <button class="m-2 p-2 min-w-40 h-30 flex flex-col items-center justify-center bg-gray-50  hover:bg-primary-600 text-primary-500 hover:text-white border-2 border-primary-100  rounded-md disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                wire:click="fichaIscricaoExterna"
                wire:loading.attr="disabled">
                <!-- Ícone Play (Some quando estiver carregando) -->
                <svg wire:loading.remove.delay.shorter wire:target="fichaIscricaoExterna" class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"></path>
                </svg>
                <!-- Ícone de Loading (Mostrado apenas no botão clicado) -->
                <svg wire:loading wire:target="fichaIscricaoExterna" class="w-10 h-10 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-width="4" class="opacity-25"></circle>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M4 12a8 8 0 018-8"></path>
                </svg>
                <!-- Texto abaixo do Ícone -->
                <span class="text-sm mt-1 font-semibold">Ficha de Inscrição Externa</span>
            </button>
    </x-filament::section>
</x-filament-widgets::widget>
