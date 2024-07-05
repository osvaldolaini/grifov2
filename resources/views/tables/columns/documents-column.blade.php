<div>
    @foreach ($getRecord()->identificacao as $key => $value)
        <div class="mr-1 text-xs">
            {{ $key }} - {{ $value }}
        </div>
    @endforeach
</div>
