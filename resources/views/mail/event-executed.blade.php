<x-layouts.mail>

    <h3 class="greeting">
        Kedves {{ $user->name }}!
    </h3>

    <div class="content">
        <p>A(z) {{ $event->dateTime }} dátumú repülés végrehajtódott. A kuponját érvénytelenítettük.</p>
    </div>

</x-layouts.mail>