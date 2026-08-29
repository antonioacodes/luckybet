{{-- resources/views/filament/admin/widgets/whitelabel-payment-widget.blade.php --}}

<x-filament-widgets::widget>
    @if($visible ?? false)
        <x-filament::section heading="Aviso de vencimento Whitelabel">
            @php
                $color = match($status ?? 'info') {
                    'warning' => 'warning',
                    'danger' => 'danger',
                    default => 'info',
                };
            @endphp

            <x-filament::badge :color="$color">
                {{ $message }}
            </x-filament::badge>

            <p class="mt-2 text-sm text-gray-500">
                Ao chegar na data de vencimento + tolerância, o sistema entrará em modo manutenção
                e o cassino ficará fora do ar até o pagamento ser confirmado com o token.
            </p>

            <p class="mt-1 text-xs text-gray-400">
                Vencimento: <strong>{{ $due->format('d/m/Y H:i') }}</strong> |
                Tolerância até: <strong>{{ $limit->format('d/m/Y H:i') }}</strong>
            </p>

            {{-- Botão "Já paguei" --}}
            <div class="mt-4">
                <x-filament::button
                    color="primary"
                    x-data="{}"
                    x-on:click="$dispatch('open-modal', { id: 'whitelabel-payment-modal' })"
                >
                    Já paguei
                </x-filament::button>
            </div>

            {{-- Modal para inserir o token --}}
            <x-filament::modal id="whitelabel-payment-modal" width="md">
                <x-slot name="heading">
                    Confirmar pagamento
                </x-slot>

                <form wire:submit.prevent="confirmToken">
                    <x-filament::input
                        type="password"
                        wire:model.defer="token"
                        placeholder="Informe o token atual"
                    />

                    <div class="mt-4 flex justify-end gap-2">
                        <x-filament::button type="submit" color="primary">
                            Confirmar
                        </x-filament::button>
                    </div>
                </form>
            </x-filament::modal>
        </x-filament::section>
    @endif
</x-filament-widgets::widget>