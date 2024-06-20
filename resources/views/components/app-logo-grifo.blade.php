<div>
    @props(['width'])
    <picture class="{{ $width }} ">
        <source srcset="{{url('storage/logos/logo.png')}}" />
        <source srcset="{{url('storage/logos/logo.webp')}}"/>
        <img class="{{ $width }}" src="{{ url('storage/logos/logo.png') }}"
        alt="grifo-v2">
    </picture>
</div>
