<x-layouts.mail>

    <h3 class="greeting">
        Kedves {{ $user->name }}!
    </h3>

    <div class="content">
        <p>Ön résztvesz egy repülésen aminek időpontja {{ $event->dateTime }}, ezzel a kuponnal: {{ $coupon->coupon_code }}.</p>
    </div>

</x-layouts.mail>