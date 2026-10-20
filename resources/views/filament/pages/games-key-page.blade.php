<x-filament-panels::page>
    <form wire:submit="submit">
        {{ $this->form }}

        <br>
        <div class="flex flex-wrap gap-3">
            <x-filament::button type="submit">
                Atualizar dados
            </x-filament::button>
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
    </form>
</x-filament-panels::page>
