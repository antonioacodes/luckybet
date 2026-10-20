<x-filament-panels::page>
    <form wire:submit="submit">
        {{ $this->form }}

        <div class="mt-4">
            <x-filament::button
                type="button"
                color="gray"
                wire:click="syncPlayFiverGames"
                wire:loading.attr="disabled"
                wire:target="syncPlayFiverGames"
            >
                <span wire:loading.remove wire:target="syncPlayFiverGames">Sincronizar jogos PlayFiver</span>
                <span wire:loading wire:target="syncPlayFiverGames">Sincronizando...</span>
            </x-filament::button>
        </div>

        <br>
        <x-filament::button type="submit">
            Atualizar dados
        </x-filament::button>
    </form>
</x-filament-panels::page>
