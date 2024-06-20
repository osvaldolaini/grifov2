<div>
    @if (request()->routeIs('login'))
        <picture class="h-24 sm:h-16">
            <source srcset="{{url('storage/logos/logo.png')}}" />
            <source srcset="{{url('storage/logos/logo.webp')}}"/>
            <img class="h-24 sm:h-16" src="{{ url('storage/logos/logo.png') }}"
            alt="grifo">
        </picture>
    @else
        <picture >
            <source srcset="{{url('storage/logos/logo.png')}}" />
            <source srcset="{{url('storage/logos/logo.webp')}}"/>
            <img class="h-12 sm:h-12" src="{{ url('storage/logos/logo.png') }}"
            alt="grifo">
        </picture>
    @endif
</div>
