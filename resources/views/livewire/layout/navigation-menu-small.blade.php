<div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:flex">
    <div class="flex flex-col h-full mt-0 sm:mt-4 bg-black">
        <!-- Navigation Rail -->
        <div class="relative h-screen lg:block w-80 pb-3 ">
            <div class="h-full bg-orange-primary py-2">
                <nav class="mt-5 w-full">
                    <div class="text-center w-full">
                        <picture >
                            <source srcset="{{ url('storage/logos/' . config('app.configs')->logo_path . '.png') }}" />
                            <source srcset="{{ url('storage/logos/' . config('app.configs')->logo_path . '.webp') }}" />
                            <img
                            class="flex mx-auto justify-center h-16 w-auto transition-all duration-300 pb-2 "
                             src="{{ url('storage/logos/' . config('app.configs')->logo_path . '.png') }}"
                                alt="{{ config('app.configs')->slug }}">
                        </picture>
                        <div class="border-t border-gray-200 pt-10 w-full"></div>
                        <a href="{{ route('home') }}" aria-label="Vá para home" title="Home"
                            class="flex items-center justify-center w-full px-4 py-2 my-1
                        font-thin uppercase transition-colors duration-200
                        {{ Request::is('/')
                            ? ' bg-gradient-to-r from-white to-blue-100
                            dark:from-gray-700 dark:to-gray-200 text-orange-primary border-r-4 border-orange-secondary'
                            : 'dark:text-gray-200 text-white' }}">
                            <span class="mx-4 text-md font-normal f-bebas">
                                Home
                            </span>
                        </a>
                        <a href="{{ route('about') }}" aria-label="Ir para Sobre"
                            class="flex items-center justify-center w-full px-4 py-2 my-1
                        font-thin uppercase transition-colors duration-200
                        {{ Request::is('/conheça')
                            ? ' bg-gradient-to-r from-white to-blue-100
                            dark:from-gray-700 dark:to-gray-200 text-orange-primary border-r-4 border-orange-secondary'
                            : 'dark:text-gray-200 text-white' }}">
                            <span class="mx-4 text-md font-normal f-bebas">
                                Sobre
                            </span>
                        </a>
                        <a href="{{ route('contact') }}" aria-label="Ir para área de contatos"
                            class="flex items-center justify-center w-full px-4 py-2 my-1
                        font-thin uppercase transition-colors duration-200
                        {{ Request::is('/fale-com-nossa-equipe')
                            ? ' bg-gradient-to-r from-white to-blue-100
                            dark:from-gray-700 dark:to-gray-200 text-orange-primary border-r-4 border-orange-secondary'
                            : 'dark:text-gray-200 text-white' }}">
                            <span class="mx-4 text-md font-normal f-bebas">
                                Fale conosco
                            </span>
                        </a>
                        <a href="{{ route('site.courses') }}" aria-label="Conhecer os cursos"
                            class="flex items-center justify-center w-full px-4 py-2 my-1
                        font-thin uppercase transition-colors duration-200
                        {{ Request::is('/nossos-cursos')
                            ? ' bg-gradient-to-r from-white to-blue-100
                            dark:from-gray-700 dark:to-gray-200 text-orange-primary border-r-4 border-orange-secondary'
                            : 'dark:text-gray-200 text-white' }}">
                            <span class="mx-4 text-md font-normal f-bebas">
                                Cursos
                            </span>
                        </a>
                        <a href="{{ route('site.free') }}" aria-label="Material grátis para o aluno"
                            class="flex items-center justify-center w-full px-4 py-2 my-1
                        font-thin uppercase transition-colors duration-200
                        {{ Request::is('/material-gratis')
                            ? ' bg-gradient-to-r from-white to-blue-100
                            dark:from-gray-700 dark:to-gray-200 text-orange-primary border-r-4 border-orange-secondary'
                            : 'dark:text-gray-200 text-white' }}">
                            <span class="mx-4 text-md font-normal f-bebas">
                                Material
                            </span>
                        </a>
                        <a href="https://atratorconcursos.online" aria-label="Ir para o sistema"
                            class="flex items-center justify-center w-full px-4 py-2 my-1
                        font-thin uppercase transition-colors duration-200
                        {{ Request::is('/material-gratis')
                            ? ' bg-gradient-to-r from-white to-blue-100
                            dark:from-gray-700 dark:to-gray-200 text-orange-primary border-r-4 border-orange-secondary'
                            : 'dark:text-gray-200 text-white' }}">
                            <span class="mx-4 text-md font-normal f-bebas">
                                Entrar
                            </span>
                        </a>
                        <p class="flex items-center mt-12 text-[#F3FB04]">
                            <div
                                class="pt-2 border-t px-5
                                    border-gray-200 max-w-xs mx-auto
                                    items-center justify-between">
                                <h2
                                    class="f-bebas w-full text-center
                                        text-md uppercase mb-2 text-[#F3FB04]">
                                    Siga-nos nas rede sociais
                                </h2>
                                <div
                                    class="flex max-w-xs mx-auto
                                        items-center justify-between text-[#F3FB04]">
                                    @if (isset($socialMedias))
                                        @foreach ($socialMedias as $socialMedia)
                                            <a aria-label="Ir para rede social {{ $socialMedia->media }}"
                                                class="btn btn-circle btn-outline border-[#F3FB04] text-[#F3FB04]" href="{{ $socialMedia->link }}"
                                                target="_blank">
                                                <x-laiguz-social-media media="{{ $socialMedia->media }}"
                                                    width="8" class='text-[#F3FB04]'></x-laiguz-social-media>
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            </p>

                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
