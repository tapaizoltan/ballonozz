<x-layouts.mail>

    <h3 class="greeting">
        Kedves {{ $user->name }}!
    </h3>

    <div class="content">
        <p>Csatlakoztál az {{ $event->dateTime }} dátumú repülésre.</p>
    </div>

</x-layouts.mail>