<div>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="keywords" content="{{ $tags ?? '' }}">

    <!--SMO FACEBOOK-->
    <!--IDIOMA-->
    <meta property="og:locale" content="pt_BR">
    <!--URL DO SITE-->
    <meta property="og:url" content="{{ url('') }}">
    <!--TITULO-->
    <meta property="og:title" content="{{ $title ?? '' }}">
    <meta property="og:site_name" content="{{ $title ?? '' }}">
    <!--DESCRIÇÃO NÃO MAIOR QUE 200-->
    <meta property="og:description" content="{{ $description ?? '' }}">
    <!--TAG NÃO MAIOR QUE 80-->
    <meta property="og:keywords" content="{{ $tags ?? '' }}">

    <!--IMAGEM-->
    <meta property="og:image" content="{{ url('storage/images/site/logo_big.jpg') }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="800"> <!-- PIXELS -->
    <meta property="og:image:height" content="600"> <!-- PIXELS -->
    <!--TIPO DO SITE OU DA PÁGINA-->
    @if (isset($dataPage))
        <!-- CASO SEJA UM ARTIGO -->
        <meta property="og:type" content="{{ $dataPage->title }}">
        <meta property="article:author" content="{{ $dataPage->autor }}">
        <meta property="article:section" content="{{ $dataPage->category }}">
        <meta property="article:tag" content="{{ $dataPage->tags }}">
        <meta property="article:published_time" content="{{ $dataPage->published_at }}">
    @else
        <!-- CASO SEJA UM SITE NORMAL -->
        <meta property="og:type" content="website">
    @endif

    <meta name="description" content="{{ $description ?? '' }}">
    <!--SMO TWITTER-->
    <!--TIPO DO SITE OU DA PÁGINA
        photo (para imagens), player (para vídeos) e Summary (para todo o resto).-->
    <meta name="twitter:card " content="summary">
    <!--URLs DA PAGINA-->
    <meta name="twitter:domain" content="{{ url('') }}">

    @if (isset($dataPage))
        <!--TITULO-->
        <meta name="twitter:title" content="{{ $dataPage->title }}">
        <!--DESCRIÇÃO NÃO MAIOR QUE 200-->
        <meta name="twitter:description" content="{{ $dataPage->title }}">
        <!--IMAGEM menores que 1 MB de tamanho de arquivo, > 60px por 60px e < 120px por 120px serão automaticamente redimensionadas.-->
        <meta name="twitter:image" content="{{ url('storage/images/courses/' . $dataPage->id . '/list.jpg') }}">
        <meta name="twitter:url" content="{{ url($urlPage) }}">
    @else
        <!--TITULO-->
        <meta name="twitter:title" content="{{ $title ?? '' }}">
        <!--DESCRIÇÃO NÃO MAIOR QUE 200-->
        <meta name="twitter:description" content="{{ $description ?? '' }}">
        <!--IMAGEM menores que 1 MB de tamanho de arquivo, > 60px por 60px e < 120px por 120px serão automaticamente redimensionadas.-->
        <meta name="twitter:image" content="{{ url('storage/images/logos/favicon.jpg') }}">

        <meta name="twitter:url" content="{{ url('') }}">
    @endif
    @if (config('app.configs')->google_verification)
        <!--google-->
        {!! config('app.configs')->google_verification !!}
    @endif
    {{-- @livewire('livewire.site.layout.google') --}}
