
<div class="container-fluid">
    <div class="flex flex-row justify-center copyright w-100 items-center">
        <span class="mr-3">Copyright &copy; @php date('Y') @endphp - {{ $config->title }}, todos os direitos
            reservados. Desenvolvido Por
        </span>
        <a href="https://osvaldolaini.com.br" aria-label="Conheça o desenvolvedor">
            <picture>
                <source data-srcset="{{ url('storage/images/dev/logo-ol.png') }}" class="lazyload" />
                <source data-srcset="{{ url('storage/images/dev/logo-ol.webp') }}" class="lazyload" />
                <img data-src="{{ url('storage/images/dev/logo-ol.png') }}" class="lazyload"
                    style="width:25%" alt="osvaldo-laini-desenvolvedor-web"/>
            </picture>
        </a>
    </div>
</div>
