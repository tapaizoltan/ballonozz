<x-layouts.mail>
    <h3 class="greeting">
        Kedves {{ $user->name }}!
    </h3>
    <div class="content">
        <p>Azért kapja ezt az üzenetet, mert a fiókjára jelszó helyreállítási kérés érkezett.</p>
        <div align="center" style="text-align: center;">
            <a href="{{ $url }}" style="
            text-decoration: none;
            border-radius: 9999px;
            padding-top: 6px;
            padding-bottom: 6px;
            padding-left: 16px;
            padding-right: 16px;
            background-color: #F4AC45;
            color: #FFFFFF;
            font-weight: 700;
            ">
                <span style="font-size: 18px; line-height: 28px;" class="text-shadow">JELSZÓ&nbsp;HELYREÁLLÍTÁS</span>
            </a>
        </div>
        <p>Ez a jelszó helyreállító hivatkozás 60 perc múlva le fog járni.</p>
        <p>Ha nem kezdeményzett jelszó helyreállítást, nincs további teendője.</p>
    </div>
    <hr>
    <div class="description">
        <p>
            Ha problémákba ütközik a "Jelszó helyreállítás" gombra kattintáskor, másolja be az allábi hivatkozást a böngészőjébe: 
            <span style="overflow-wrap: break-word;"><a class="link" href="{{ $url }}">{{ $url }}</a></span>
        </p>
    </div>
</x-layouts.mail>