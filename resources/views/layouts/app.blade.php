<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <title>João Monteiro - Portfólio</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Text:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
</head>
<body class="bg-blue-950">

<section>
    <article class="flex justify-center items-center default-theme mb-20 md:mb-40">
        <div>
            <h1 class="text-neutral-100 mx-auto my-4 text-base md:text-2xl">Feito com Laravel + Tailwind</h1>
        </div>
    </article>

    <main class="flex flex-wrap gap-8 md:gap-12 justify-center">
        <div class="flex flex-col items-start gap-8 md:gap-8 text-blue-100 mr-12">
            <h1 class="text-balance text-2xl md:text-5xl font-bold">João<br>Monteiro</h1>

            <div class="flex shadow-lg">
                <p class="bg-no-repeat bg-cover bg-center rounded-3xl text-balance text-base md:text-2xl text-neutral-100 default-theme px-12 py-12 w-60"
                   style="background-image: url('{{ asset('storage/svg/background.svg') }}');">
                    <span class="font-bold">Dev Full-Stack</span> com noções de <span class="font-bold">UI/UX</span>.
                </p>
            </div>

            <div class="w-60 h-full flex shadow-lg">
                <video autoplay muted loop playsinline class="rounded-3xl flex border border-white/30">
                    <source src="{{ asset('storage/videos/showcase.webm') }}" type="video/webm">
                    Seu navegador não suporta o vídeo.
                </video>
            </div>

            <div class="flex flex-wrap gap-4 mb-20">
                <a href="https://github.com/pedromontesi" target="_blank">
                    <img class="w-10 h-auto" alt="github link" src="{{ asset('storage/svg/github.svg') }}">
                </a>
                <a href="https://www.linkedin.com/in/pedromontesi/" target="_blank">
                    <img class="w-10 h-auto" alt="linkedin link" src="{{ asset('storage/svg/linkedin.svg') }}">
                </a>
            </div>
        </div>

        <div class="flex gap-8 md:gap-12 flex-col">
            @yield('content')
        </div>
    </main>
</section>

</body>
</html>
