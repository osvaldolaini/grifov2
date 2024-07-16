<div>
    <header class="fi-simple-header">

        <h1 class="py-8 text-2xl font-bold tracking-tight fi-header-heading text-gray-950 dark:text-white sm:text-3xl">
            Perfil do usuário
        </h1>
    </header>
    <x-filament-panels::form id="form" wire:submit="save">
        {{ $this->form }}

        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" alignment="right" />
    </x-filament-panels::form>
</div>
