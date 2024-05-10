<x-mail::message>
    <h3 class="greeting">
        Kedves {{ $passenger->fullname }}!
    </h3>
    <div class="content">
        <p>A(z) {{ $event->dateTime }} dátumú repülés végrehajtódott. A kuponját érvénytelenítettük.</p>
    </div>
</x-mail::message>