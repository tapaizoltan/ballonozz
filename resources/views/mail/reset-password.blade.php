<x-layouts.mail>
    <h3 class="greeting">
        Kedves {{ $user->name }}!
    </h3>
    <div class="content">
        <p>Azért kapja ezt az üzenetet, mert a fiókjára jelszó helyreállítási kérés érkezett.</p>
        <div style="display: flex; align-items: center; justify-content: center; text-align: center;">
            <a href="{{ $url }}" class="btn accent hover:bg-custom-secondary transition duration-300 absolute left-1/2 top-1/2 translate-y-[-50%] translate-x-[-50%]">
                <span style="font-size: 1.125rem; line-height: 1.75rem;" class="text-shadow">Jelszó helyreállítás</span>
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