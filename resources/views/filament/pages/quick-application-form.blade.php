<x-filament-panels::page>
    <x-filament::section>
        <form wire:submit="save">
            {{ $this->form }}

            <div class="mt-4">
                <x-filament::button type="submit">
                    {{ __('Save Application') }}
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</x-filament-panels::page>