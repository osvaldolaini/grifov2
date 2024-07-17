<x-filament-widgets::widget>
    <x-filament::section>
        <div
            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 [&amp;:not(:has(.fi-ac-action:focus))]:focus-within:ring-2 ring-gray-950/10 dark:ring-white/20 [&amp;:not(:has(.fi-ac-action:focus))]:focus-within:ring-primary-600 dark:[&amp;:not(:has(.fi-ac-action:focus))]:focus-within:ring-primary-500">
            <div class="flex items-center gap-x-3 ps-3 pe-2">
                <svg style=";" wire:loading.remove.delay.default="1" wire:target="search"
                    class="w-5 h-5 text-gray-400 fi-input-wrp-icon dark:text-gray-500" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                    <path fill-rule="evenodd"
                        d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z"
                        clip-rule="evenodd"></path>
                </svg>
                <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 text-gray-400 animate-spin fi-input-wrp-icon dark:text-gray-500"
                    wire:loading.delay.default="" wire:target="search">
                    <path clip-rule="evenodd"
                        d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                        fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
                    <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <input
                    class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-0 pe-3"
                    autocomplete="off" placeholder="Pesquisar" type="search" wire:key="global-search.field.input"
                    x-bind:id="$id('input')"
                    x-on:keydown.down.prevent.stop="$dispatch('focus-first-global-search-result')"
                    x-data="{}" wire:model.live.debounce.750ms="search" id="input-1">
            </div>
        </div>
        @if (count($results['registers']) > 0)
            <p style="margin-top: 10px;">
            <div class="px-8 py-2 mx-5 bg-gray-500 border-t border-b border-r border-gray-500 rounded-md text-gray-50">
                <div class="container flex items-center justify-start px-2 mx-auto my-2">
                    <span>Cadastros </span>
                </div>
            </div>
            <ul class="py-2 border-l border-r list-group border-x">
                @foreach ($results['registers'] as $result)
                    <li class="py-1 border-b border-gray-500 list-group-item">
                        <div class="flex">
                            @if ($result->type)
                                <div style="
                                    background-color: rgb(
                                    {{ $result->type->rgb_color[0] }},
                                    {{ $result->type->rgb_color[1] }},
                                    {{ $result->type->rgb_color[2] }},
                                    {{ $result->type->rgb_color[3] }}
                                    );
                                    border-color:rgb(
                                    {{ $result->type->rgb_color[0] }},
                                    {{ $result->type->rgb_color[1] }},
                                    {{ $result->type->rgb_color[2] }}
                                    );

                                    /* color:rgb(
                                    {{ $result->type->rgb_color[0] }},
                                    {{ $result->type->rgb_color[1] }},
                                    {{ $result->type->rgb_color[2] }}
                                    ); */
                                    "
                                    class="p-1 text-xs border rounded-md">
                                    {{ $result->type->nome }}
                                </div>
                            @endif
                            <a href="{{ url('admin/registers/' . $result->id . '/edit') }}" target="_blank"
                                rel="noopener noreferrer">
                                <strong>&nbsp;{{ $result->nome }} </strong>
                            </a>

                        </div>
                        @if ($result->identificacao)
                            @foreach ($result->identificacao as $key => $value)
                                <div class="mr-1 text-xs">
                                    {{ $key }} - {{ $value }}
                                </div>
                            @endforeach
                        @endif
                        <p class="flex p"><x-filament::badge size="sm" color="gray" class="my-5">
                                Fatos e documentos:
                            </x-filament::badge>
                            @if ($result->documents)
                                @foreach ($result->documents as $key => $value)
                                    <div class="mr-1 text-xs">
                                        <ul class="list-decimal">
                                            <li>
                                                <a href="{{ url('admin/' . $key . '/edit') }}" target="_blank"
                                                    rel="noopener noreferrer">
                                                    <strong>&nbsp;{{ $value }} </strong>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endforeach
                            @endif
                        </p>
                    </li>
                @endforeach
            </ul>
        @else
            @if ($search)
                <p>
                <div class="px-8 py-2 text-gray-50 ">
                    <div class="container flex items-center justify-start py-2 mx-auto">
                        <div>
                            <span class="flex">
                                <x-filament::badge size="sm" color="warning" class="my-5">
                                    Nenhum cadastro encontrado
                                </x-filament::badge>
                            </span>
                        </div>

                    </div>
                </div>
                </p>
            @endif
        @endif
        @if (count($results['facts']) > 0)
            <p style="margin-top: 10px;">
            <div class="px-8 py-2 mx-5 bg-gray-500 border-t border-b border-r border-gray-500 rounded-md text-gray-50">
                <div class="container flex items-center justify-start px-2 mx-auto my-2">
                    <span>Fatos</span>
                </div>
            </div>
            <ul class="py-2 border-l border-r list-group border-x">
                @foreach ($results['facts'] as $fact)
                    <li class="py-1 border-b border-gray-500 list-group-item">
                        <div class="flex">
                            <a href="{{ url('admin/facts/' . $fact->id . '/edit') }}" target="_blank"
                                rel="noopener noreferrer">
                                <strong>&nbsp;{{ $fact->number }} </strong>
                            </a>
                        </div>
                        <p>Participantes:</p>
                        @if ($fact->vinculos)
                            @foreach ($fact->vinculos as $key => $value)
                                <div class="mr-1 text-xs">
                                    <ol class="list-decimal">
                                        <li>
                                            <a href="{{ url('admin/registers/' . $key . '/edit') }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <strong>&nbsp;{{ $value }} </strong>
                                            </a>
                                        </li>
                                    </ol>
                                </div>
                            @endforeach
                        @endif

                        {{-- {{ $result->content }} --}}
                    </li>
                @endforeach
            </ul>
            </p>
        @else
            @if ($search)
                <p>
                <div class="px-8 py-2 text-gray-50 ">
                    <div class="container flex items-center justify-start py-2 mx-auto">
                        <div>
                            <span class="flex">
                                <x-filament::badge size="sm" color="warning" class="my-5">
                                    Nenhum fato encontrado
                                </x-filament::badge>
                            </span>
                        </div>

                    </div>
                </div>
                </p>
            @endif
        @endif
        @if (count($results['documents']) > 0)
            <p style="margin-top: 10px;">
            <div class="px-8 py-2 mx-5 bg-gray-500 border-t border-b border-r border-gray-500 rounded-md text-gray-50">
                <div class="container flex items-center justify-start px-2 mx-auto my-2">
                    <span>Documentos</span>
                </div>
            </div>
            <ul class="py-2 border-l border-r list-group border-x">
                @foreach ($results['documents'] as $document)
                    <li class="py-1 border-b border-gray-500 list-group-item">
                        <div class="flex">
                            <div class="flex flex-row items-center">
                                @switch($document->status)
                                    @case('INTERNO')
                                        <x-filament::badge size="sm" color="gray">
                                            {{ $document->status }}
                                        </x-filament::badge>
                                    @break

                                    @case('RECEBIDO')
                                        <x-filament::badge size="sm" color="warning">
                                            {{ $document->status }}
                                        </x-filament::badge>
                                    @break

                                    @case('EXPEDIDO')
                                        <x-filament::badge size="sm" color="success">
                                            {{ $document->status }}
                                        </x-filament::badge>
                                    @break
                                @endswitch
                            </div>
                            <a href="{{ url('admin/documents/' . $document->id . '/edit') }}" target="_blank"
                                rel="noopener noreferrer">
                                <strong>&nbsp;{{ $document->number }} </strong>
                            </a>
                        </div>
                        <p>Participantes:</p>
                        @if ($document->vinculos)
                            @foreach ($document->vinculos as $key => $value)
                                <div class="mr-1 text-xs">
                                    <ol class="list-decimal">
                                        <li>
                                            <a href="{{ url('admin/registers/' . $key . '/edit') }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <strong>&nbsp;{{ $value }} </strong>
                                            </a>
                                        </li>
                                    </ol>
                                </div>
                            @endforeach
                        @endif
                    </li>
                @endforeach
            </ul>
            </p>
        @else
            @if ($search)
                <p>
                <div class="px-8 py-2 text-gray-50 ">
                    <div class="container flex items-center justify-start py-2 mx-auto">
                        <div>
                            <span class="flex">
                                <x-filament::badge size="sm" color="warning" class="my-5">
                                    Nenhum documento encontrado
                                </x-filament::badge>
                            </span>
                        </div>
                    </div>
                </div>
                </p>
            @endif
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
