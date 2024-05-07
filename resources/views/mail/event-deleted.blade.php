<x-layouts.mail>

    <h3 class="greeting">
        Kedves {{ $user->name }}!
    </h3>

    <div class="content">
        <p>A(z) {{ $event->dateTime }} dátumú repülést töröltük. A kuponja ismét felhasználható.</p>
    </div>

</x-layouts.mail>