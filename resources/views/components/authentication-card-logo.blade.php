<a href="/">
    <div>
        @if (request()->routeIs('login'))
            <picture class="h-30 sm:h-20" {{ $attributes }}>
                <source srcset="{{url('storage/logos/logo.png')}}" />
                <source srcset="{{url('storage/logos/logo.webp')}}"/>
                <img class="h-30 sm:h-20" src="{{ url('storage/logos/logo.png') }}"
                alt="grifo">
            </picture>
        @else
            <picture class="h-30 sm:h-20" {{ $attributes }}>
                <source srcset="{{url('storage/logos/logo.png')}}" />
                <source srcset="{{url('storage/logos/logo.webp')}}"/>
                <img class="h-30 sm:h-20" src="{{ url('storage/logos/logo.png') }}"
                alt="grifo">
            </picture>
        @endif
    </div>
</a>
