<div>
<!-- Footer Section Begin -->
<footer class="footer-section set-bg jarallax" style="background-size:cover;"
data-setbg="{{url('storage/images/site/footer-bg-green-1.jpg')}}">
    <div class="container">
        <div class="footer-text">
            <div class="grid grid-col-1 sm:grid-cols-12">
                <div id="whatsapp">
                    <a href="https://wa.me/55{{trim(preg_replace('/[^A-Za-z0-9]/','',$config->whatsapp))}}" target="_blank" aria-label="direcionar para whatsapp">
                        <img src="{{url('storage/images/site/whatsapp.png')}}" alt="atrator-concursos-whatsapp">
                    </a>
                </div>
                <div class="col-span-1 sm:col-span-3">
                    <div class="footer-logo text-center p-4" id="newsletterForm">
                        <div class="logo" data-aos="zoom-out"
                        data-aos-easing="linear"
                        data-aos-duration="800">
                            <a href="{{ url('/') }}" aria-label="Vá para home" title="Home">
                                <picture class="lazyload img-fluid">
                                    <source srcset="{{url('storage/images/site/logo/logo-footer.png')}}" />
                                    <source srcset="{{url('storage/images/site/logo/logo-footer.webp')}}"/>
                                    <img alt="{{ $config->slug }}" class="lazyload img-fluid" src="{{url('storage/images/site/logo/logo-footer.png')}}" />
                                </picture>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-span-1 sm:col-span-4 ">
                    <div class="footer-widget">
                        <h4 class="text-center">Mapa do site</h4>
                        <ul class="w-1/4">
                            <li><i class="fa fa-caret-right"></i> <a href="{{ url('/') }}" aria-label="Vá para a página principal">Home</a></li>
                            <li><i class="fa fa-caret-right"></i> <a href="{{ url('conheça') }}" aria-label="Vá para a página que apresenta sobre o atrator concursos">Sobre</a></li>
                            <li><i class="fa fa-caret-right"></i> <a href="{{ url('nossos-cursos') }}" aria-label="Vá para a página de cursos">Cursos</a></li>
                            {{-- <li><i class="fa fa-caret-right"></i> <a href="{{ url('blog') }}">Artigos</a></li> --}}
                        </ul>
                        <ul>
                            <li><i class="fa fa-caret-right"></i> <a href="{{ url('fale-com-nossa-equipe') }}" aria-label="Entre em contato com nossa equipe">Contato</a></li>
                            <li><i class="fa fa-caret-right"></i> <a href="{{ url('material-gratis') }}" aria-label="Veja nosso material">Materia</a></li>
                            <li><i class="fa fa-caret-right"></i> <a href="{{ url('termo-de-uso') }}" aria-label="Conheça nossos termos de uso">Termo de uso</a></li>
                            <li><i class="fa fa-caret-right"></i> <a href="{{ url('politica-de-privacidade') }}" aria-label="Conheça nossa política de privacidade">Política de privacidade</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-span-1 sm:col-span-2">
                    <div class="footer-widget w-full" >
                        <h4 class="text-center">Social</h4>
                        <ul class="text-center flex justify-center w-full mx-auto">
                            @if (isset($socialMedias))
                                @foreach ($socialMedias as $socialMedia)
                                    <li class="flex mx-auto">
                                        <a class="text-white hover:text-[#F3FB04]" href="{{ $socialMedia->link }}" target="_blank"
                                            aria-label="Conheça nossas página no(a) {{ $socialMedia->title }}">
                                             <x-laiguz-social-media media="{{ $socialMedia->media }}" width="8"></x-laiguz-social-media>
                                        </a>

                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-span-1 sm:col-span-3">
                    <div class="footer-widget" >
                        <p class="newslatter-text">Quer receber as nossas novidades?
                            Inscreva-se para receber todas essas informações.</p>
                            <form method="post" class="newslatter-form" id="newsletterFooter">
                                <div class="d-flex flex-row align-items-start justify-content-start">
                                    <input type="email"  name="email"
                                        placeholder="Insira seu email" required="required">
                                    <button class="newsletter_button" aria-label="Newsletter button">
                                        <i class="far fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                            <div id="newsletterFooter-message-warning" class="mt-4"></div>
                            <div id="newsletterFooter-message-success">
                                <p>Assinatura concluída, obrigado!</p>
                            </div>
                        {{-- <h4>Fale conosco</h4>
                        <ul class="contact-option">
                            <li><i class="fa fa-map-marker"></i>{{ $config->address }}, {{ $config->city }}/{{ $config->state }}</li>
                            <li><i class="fa fa-phone-alt"></i> {{ $config->phone }}</li>
                            <li><i class="fa fa-envelope"></i> {{ $config->email }}</li>
                        </ul> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->


    @livewire('layout.copyright')
    @section('scripts')
        @if (config('app.configs')->scripts)
            {!! config('app.configs')->scripts !!}
        @endif
    @endsection
</div>
