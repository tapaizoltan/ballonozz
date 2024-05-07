<x-layouts.mail>
    
    <h3 class="greeting">
        Kedves {{ $user->name }}!
    </h3>

    <div class="content">
        <p>Sajnáljuk, de mégsem tudunk elvinni a(z) {{ $event->dateTime }} dátumú repülésre.</p>
    </div>

</x-layouts.mail>