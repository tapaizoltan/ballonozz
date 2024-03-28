<div class="flex flex-col h-[calc(100vh-64px)] gap-y-8 py-8">
        <header>
            <div>
                <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">{{ Carbon\Carbon::parse($record->date . ' ' . $record->time)->translatedFormat('Y F d. H:i') }}</h1>
                <h2 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-2xl">{{ $record->aircraft->name }}, {{ $record->location->name }}</h2>
            </div>
        </header>
        <div class="flex gap-5 justify-end">
    
            @php
                $bodiesWeight = 0;
                $membersCount = 0;

                foreach ($record->coupons()->withSum('passengers', 'body_weight')->whereIn('coupon_id', $selectedCoupons)->get() as $coupon) {
    
                    $bodiesWeight += $coupon->passengers_sum_body_weight;
                    $membersCount += $coupon->membersCount;
                }
            @endphp
            <div class="flex gap-5">
                <div class="@if($membersCount <= $record->aircraft->number_of_person) badge-success @else badge-danger @endif">Létszám: {{ $membersCount }} / {{ $record->aircraft->number_of_person }}</div>
                <div class="@if($bodiesWeight <= $record->aircraft->payload_capacity) badge-success @else badge-danger @endif">Súly: {{ $bodiesWeight }} / {{ $record->aircraft->payload_capacity }} kg</div>
            </div>
            <x-filament::button class="justify-self-end" wire:click="save()">Véglegesít</x-filament::button>
        </div>
        <div class="grid grid-cols-[3.5rem_auto_auto_auto_auto] overflow-auto custom-table rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">

            <div class="thead"></div>
            <div class="thead">Kupon kód</div>
            <div class="thead">Jelentkezett ekkor</div>
            <div class="thead">fő</div>
            <div class="thead">súly</div>

            @foreach ($record->coupons()->withSum('passengers', 'body_weight')->get() as $coupon)
                @php
                    $isCheckedAlready = in_array($coupon->id, $alreadyCheckedCoupons);
                @endphp
                <label id="checkbox" class="tbody @if($isCheckedAlready) bg-zinc-100 text-zinc-400 dark:bg-white/10 @endif">
                    <input id="coupon-{{ $coupon->id }}" class="checkbox ms-2" type="checkbox" @disabled($isCheckedAlready) wire:model.live="selectedCoupons" value="{{ $coupon->id }}">
                </label>
                <label for="coupon-{{ $coupon->id }}" class="tbody min-w-1 @if($isCheckedAlready) bg-zinc-100 text-zinc-400 dark:bg-white/10 @endif">{{ $coupon->coupon_code }}</label>
                <label for="coupon-{{ $coupon->id }}" class="tbody min-w-1 @if($isCheckedAlready) bg-zinc-100 text-zinc-400 dark:bg-white/10 @endif">{{ Carbon\Carbon::parse($coupon->pivot->created_at)->translatedFormat('Y F d. H:i') }}</label>
                <label for="coupon-{{ $coupon->id }}" class="tbody min-w-1 @if($isCheckedAlready) bg-zinc-100 text-zinc-400 dark:bg-white/10 @endif">{{ $coupon->membersCount }}</label>
                <label for="coupon-{{ $coupon->id }}" class="tbody min-w-1 @if($isCheckedAlready) bg-zinc-100 text-zinc-400 dark:bg-white/10 @endif">{{ $coupon->passengers_sum_body_weight }} kg</label>
            @endforeach
        </div>

    
</div>
