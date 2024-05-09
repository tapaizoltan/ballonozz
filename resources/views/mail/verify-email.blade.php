<x-mail::message>
    <h3 class="greeting">
        Kedves {{ $user->name }}!
    </h3>
    <div class="content">
        <p>Kérjük kattintson az alábbi gombra az e-mail címe megerősítéséhez.</p>
        <div align="center" style="text-align: center;">
            <a href="{{ $url }}" class="btn accent">
                <span style="font-size: 18px; line-height: 28px;" class="text-shadow">E-MAIL&nbsp;MEGERŐSÍTÉSE</span>
            </a>
        </div>
        <p>Ha nem Ön hozta létre ezt a fiókot, akkor nincs további teendője.</p>
    </div>
    <hr>
    <div class="description">
        <p>
            Ha problémákba ütközik a "E-mail megerősítése" gombra kattintáskor, másolja be az allábi hivatkozást a böngészőjébe: 
            <span style="overflow-wrap: break-word;"><a class="link" href="{{ $url }}">{{ $url }}</a></span>
        </p>
    </div>
</x-mail::message>