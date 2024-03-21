<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
        @vite('resources/css/app.css')
        <title>{{ $title ?? 'Page Title' }}</title>
    </head>
    <body>
        <header>
            <ul class="py-5 flex justify-center gap-10 lg:gap-24 bg-white uppercase font-semibold">
                <li class="nav-item-selected">Kezdőlap</li>
                <li class="nav-item">Repülési helyszínek</li>
                <li class="nav-item">Jegyvásárlás</li>
                <li class="nav-item">Kapcsolat</li>
            </ul>
        </header>
        <main>
            {{ $slot }}
        </main>
        <footer class="grid bg-[#D4ECF2]">
            <div class="section grid-cols-3 w-full mt-10">
                <div class="justify-self-start flex flex-col">
                    <h3>Kapcsolat: </h3>
                    <div class="grid font-semibold text-sm">
                        <div><span>Tel: </span><a href="tel:+36207779081">+36 20 77 79 081</a></div>
                        <div><span>E-mail: </span><a href="mailto:info@ballonozz.hu">info@ballonozz.hu</a></div>
                    </div>
                </div>
                <div class="justify-self-center relative">
                    <button class="primary hover:bg-custom-secondary transition duration-300 py-4 px-10 text-lg !font-semibold rounded-3xl uppercase absolute left-1/2 top-1/2 translate-y-[-50%] translate-x-[-50%]">Jegyvásárlás</button>
                </div>
                <div class="justify-self-end grid gap-2">
                    <div class="grid justify-items-end">
                        <a href="#">Általános Szerződési Feltételek</a>
                        <a href="#">Adatkezelési tájékoztató</a>
                        <a href="#">Felelősségvállalási nyilatkozat utasok részére</a>
                    </div>
                    <div class="grid justify-items-end font-semibold text-sm">
                        <span class="font-bold">Adataink:</span>
                        <span>Alba-Ballon Repülő Egyesület Székesfehérvár</span>
                        <span>8000 Székesfehérvár Lévai út 18</span>
                        <span>Adószám: 18485608-2-07</span>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
