<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <x-app-favicons width="w-56"></x-app-favicons>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="antialiased">
        <div class="drawer">
            <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content flex flex-col">
              <!-- Navbar -->
              <div class="w-full navbar bg-gray-900">
                <div class="flex-none lg:hidden">
                  <label for="my-drawer-3" class="btn btn-square btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                  </label>
                </div>

                <div class="flex-1 px-2 mx-2">
                    <x-app-logo-grifo width="w-14"></x-app-logo-grifo>
                </div>

                <div class="flex-none hidden lg:block">
                    @if (Route::has('login'))
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                        @auth
                            <a href="{{ url('/admin') }}" class="font-semibold text-gray-100 hover:text-gray-300 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                        @else
                            <a href="/admin" class="font-semibold text-gray-100 hover:text-gray-300 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Entrar</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-100 hover:text-gray-300 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Registrar</a>
                            @endif
                        @endauth
                    </div>
                @endif
                </div>
              </div>
              <!-- Page content here -->
              <section class="flex items-center h-full p-10 dark:bg-gray-900 dark:text-gray-100">
                <div class="container flex flex-col items-center justify-center px-5 mx-auto my-8">
                    <div class="max-w-md text-center">
                        <h2 class="mb-8 font-extrabold text-9xl dark:text-gray-600 text-center">
                            <x-app-logo-grifo width="w-56"></x-app-logo-grifo>
                        </h2>
                        <p class="text-2xl font-semibold md:text-3xl">Bem vindo ao sistema GRIFO.</p>
                        <p class="mt-4 mb-8 dark:text-gray-400">Faça seu cadastro de acesso e aguarde a liberação do administrador.</p>
                        <a rel="noopener noreferrer" href="/admin" class="px-8 py-3 font-semibold rounded dark:bg-violet-400 dark:text-gray-900">Ir para pagina inicial</a>
                    </div>
                </div>
            </section>
            </div>
            <div class="drawer-side">
              <label for="my-drawer-3" class="drawer-overlay"></label>
              <ul class="menu p-4 w-80 bg-base-100">
                <!-- Sidebar content here -->
                <li><a href="/admin" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Entrar</a></li>
                <li><a href="/admin" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Registrar</a></li>

              </ul>
            </div>
          </div>
          @stack('modals')

          @livewireScripts
    </body>
</html>
