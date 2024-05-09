<x-mail::message>
    <h3 class="greeting">
        Kedves {{ $user->name }}!
    </h3>
    <div class="content">
        <p>Lejelentkeztél az {{ $event->dateTime }} dátumú repülésről.</p>
    </div>
</x-mail::message>