<x-filament-panels::page>
    <form id="form-incricao" wire:submit="save" class="rounded-2xl shadow-lg p-8 border border-indigo-100  bg-gray-50">

        <div class="space-y-6 ">
            <div class="text-center">
                <h2 class="text-4xl font-extrabold text-indigo-600 flex items-center justify-center gap-2">
                    Pré-inscrição para EJC 2026
                </h2>
                <p class="text-gray-500 mt-1 text-sm">
                    Não deixe pra depois. Faça sua pré-inscrição agora e venha descobrir o quanto Deus sonha com você!<br>
                    Você deverá comparecer ao <b>Centro Pastoral</b> com a documentação necessária para confirmar sua inscrição.
                </p>
            </div>

            {{ $this->form }}

            <x-filament::button
                type="submit"
                size="lg"
                icon="heroicon-m-shopping-bag"
                class="w-full px-8 py-4 text-lg font-bold shadow-md hover:scale-105 transition-transform duration-200"
            >
                Cadastrar
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
