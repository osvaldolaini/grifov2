<div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const logo = document.getElementById('logoPng');
            const timestamp = new Date().getTime();
            logo.src = 'logo.png?v=' + timestamp;

            const logoW = document.getElementById('logoWebp');
            const timestampw = new Date().getTime();
            logow.src = 'logo.webp?v=' + timestampw;
        });
    </script>
    @if (request()->routeIs('login'))
        <picture class="h-12 sm:h-12">
            <source srcset="{{url('storage/logos/logo.png')}}" id="logoPng"/>
            <source srcset="{{url('storage/logos/logo.webp')}}" id="logoWebp"/>
            <img class="h-12 sm:h-12" src="{{ url('storage/logos/logo.png') }}" id="logoPng"
            alt="grifo">
        </picture>
    @else
        <picture >
            <source srcset="{{url('storage/logos/logo.png')}}" id="logoPng"/>
            <source srcset="{{url('storage/logos/logo.webp')}}" id="logoWebp"/>
            <img class="h-12 sm:h-12" src="{{ url('storage/logos/logo.png') }}" id="logoPng"
            alt="grifo">
        </picture>
    @endif
</div>
