<div>
        <div class="flex flex-wrap items-center text-sm">
            {{ $getRecord()->assunto}}
        </div>
        <div class="flex flex-row items-center">
            @switch($getRecord()->status)
                @case('INTERNO')
                    <x-filament::badge size="sm" color="gray">
                        {{ $getRecord()->status }}
                    </x-filament::badge>
                    @break
                @case('RECEBIDO')
                    <x-filament::badge size="sm" color="warning">
                        {{ $getRecord()->status }}
                    </x-filament::badge>
                    @break
                @case('EXPEDIDO')
                    <x-filament::badge size="sm" color="success">
                        {{ $getRecord()->status }}
                    </x-filament::badge>
                        @break
            @endswitch
            <div class="px-1 text-xs">
                {{ $getRecord()->number}}
            </div>
        </div>

</div>
