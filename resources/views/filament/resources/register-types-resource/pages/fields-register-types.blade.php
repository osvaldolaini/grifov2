<x-filament::page>
    <style>
        /* Estilos para o Toggle Switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 42px;
            height: 22px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-switch .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .toggle-switch .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #031299;
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }

        .checked-bg {
            background-color: #0059fd !important; /* bg-green-200 */
            /* color: #000; */
        }

        .unchecked-bg {
            background-color: #333232 !important; /* bg-red-200 */
            /* color:black; */
        }
    </style>
{{-- <form wire:submit.prevent="save" class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 ">
            @foreach($fields as $column)
                <div class="flex flex-col items-center p-4 space-x-2
                 @if(in_array($column, $selectedColumns)) bg-blue-300 @endif
                border border-gray-300 rounded-lg">
                    <label for="{{ $column }}" class="py-2">
                        {{ strtoupper($column) }}
                    </label>
                    <input type="checkbox" class="p-4 space-x-2 rounded-lg"
                    wire:click="toggleField('{{ $column }}')"
                    @if(in_array($column, $selectedColumns)) checked @endif>

                </div>
            @endforeach
        </form> --}}
        <form wire:submit.prevent="save" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($fields as $column)
                <div class="flex items-center space-x-2 p-4 rounded-lg shadow-md @if(in_array($column, $selectedColumns)) checked-bg @else unchecked-bg @endif">
                    <label for="{{ $column }}" class="flex items-center cursor-pointer">
                        <!-- Toggle Switch -->
                        <div class="toggle-switch" >
                            <input type="checkbox" id="{{ $column }}"
                            wire:click="toggleField('{{ $column }}')" @if(in_array($column, $selectedColumns)) checked @endif>
                            <span class="slider"></span>
                        </div>
                        <div class="ml-4 px-4 text-xs">{{ strtoupper($column) }}</div>
                    </label>
                </div>
            @endforeach
        </form>
</x-filament::page>



