<x-filament-panels::page>
    <div class="flex gap-5 p-2 overflow-x-auto">
        @forelse ($coupons as $coupon)
            @if ($coupon->isActive)
                <div class="clickable card grid justify-between min-w-max @if ($coupon->id === $coupon_id) selected @endif"
                    wire:click="$set('coupon_id', {{ $coupon->id }})">
                    <div class="font-semibold">{{ $coupon->coupon_code }}</div>
                    <div class="grid">
                        <div>{{ $coupon->source }} kupon</div>
                        <div class="description">{{ $coupon->ticketType?->name_stored_at_source ?? null }}</div>
                        <div class="grid grid-cols-2 relative">
                            
                            <div class="flex flex-col justify-self-start">
                                <div class="flex">
                                    <span class="quantity">{{ $coupon->adult }} </span>
                                    <span class="quantity-description">felnőtt</span>
                                </div>
                                <div class="flex">
                                    <span class="quantity">{{ $coupon->children }} </span>
                                    <span class="quantity-description">gyerek</span>
                                </div>
                            </div>
                            <div class="flex flex-col justify-self-end absolute top-1/2 translate-y-[-50%]">
                                @if($coupon->private->value)    
                                    @svg($coupon->private->getIcon())                             
                                @endif
                                @if ($coupon->vip->value)
                                    @svg($coupon->vip->getIcon())
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="card w-full">
                <div class="flex justify-center">
                    <x-heroicon-o-x-circle class="w-8 justify-self-end"/>
                    <span class="text-lg ps-2 pt-0.5 justify-self-start">Jelenleg nincs kuponod. Nézz vissza később!</span>
                </div>
            </div>
        @endforelse
    </div>

    @if ($this->dates !== false)
        <div class="flex">
            <h1 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">{{ $this->coupon->coupon_code }}</h1>
            <span class="pl-2 pt-1.5 sm:pt-2.5">{{ $this->coupon->source }} kupon</span>
        </div>
        <div class="flex gap-5 w-full p-2 overflow-x-auto">
            @foreach ($this->dates as $date)
                @php
                    $selected = $date->isChecked($this->coupon->id);
                    $finalized = $date->status == App\Enums\AircraftLocationPilotStatus::Finalized;
                    $checked = $date->coupons()->find($this->coupon)?->pivot->status == 1;
                @endphp
                @if ($loop->first)
                    @php
                        $fly_at = $date->date;
                    @endphp
                    <div class="grid grid-flow-col gap-2">
                        <div><div class="card max-h-min !py-2">
                        
                    <div class="pb-2">{{ Carbon\Carbon::parse($fly_at)->translatedFormat('Y F d.') }}</div>
                @elseif($fly_at != $date->date && $fly_at != null)
                    @php
                        $fly_at = $date->date;
                    @endphp
                    </div></div></div><div class="grid grid-flow-col gap-2">
                        <div>
                        <div class="card max-h-min !py-2">
                    <div class="pb-2">{{ Carbon\Carbon::parse($fly_at)->translatedFormat('Y F d.') }}</div>
                @endif

                <div class="card mb-4 grid gap-2 min-w-max border-2 @if($selected && !$finalized && !$this->coupon->is_used || $finalized && $selected && $checked) border-green-500/80 @else dark:border-white/20 @endif @if($selected && $finalized && $checked) bg-green-600/10 dark:bg-[#4ade80]/10 @elseif($finalized) bg-zinc-200/20 text-zinc-400 @endif">
                    <div class="flex justify-between">
                        <div>{{ Carbon\Carbon::parse($date->time)->format('H:i') }}</div>
                        @if ($date->status == App\Enums\AircraftLocationPilotStatus::Finalized)
                            <div class="@if($selected && $finalized && $checked) text-green-600 @elseif($finalized) text-zinc-400 @endif">@svg('tabler-flag-check')</div>
                        @endif
                    </div>
                    
                    <div class="flex gap-2">
                        <div class="@if($selected && !$finalized || $finalized && $selected && $checked || !$selected && !$finalized) text-red-500 @else text-red-500/50 @endif"">
                            <x-heroicon-c-map-pin class="w-6"/>
                        </div>
                        <span>{{ $date->location->name }}</span>
                    </div>

                    <div class="flex gap-2">
                        <span class="@if($selected && !$finalized || $finalized && $selected && $checked || !$selected && !$finalized) text-blue-400 @else text-blue-400/50 @endif">@svg($date->aircraft->type->getIcon())</span>
                        <span>{{ $date->aircraft->name }}</span>
                    </div>

                    <div class="flex justify-between">
                        <div class="flex text-zinc-400 justify-self-center">
                            <x-heroicon-m-users class="w-5"/>
                            <span class="ps-1 py-2 text-sm font-semibold">{{ $date->coupons->sum('adult') + $date->coupons->sum('children') }}</span>
                        </div>
                        <div>
                            @if($selected && $finalized && $checked) 
                                <div class="text-green-600 dark:text-green-400/80 font-semibold p-1.5">Résztveszek</div>
                            @elseif($finalized) 
                                <div class="text-zinc-400 font-semibold p-1.5">Lezárva</div>
                            @elseif(!$selected && !$this->coupon->is_used)
                                <x-filament::button wire:click="checkIn({{ $date->id }})">Jelentkezem</x-filament::button>
                            @elseif($selected && !$this->coupon->is_used)
                                <x-filament::button class="!bg-red-600 hover:!bg-red-700" wire:click="checkOut({{ $date->id }})">Lejelentkezem</x-filament::button>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        
            @if (!$this->dates->count())
                <div class="card w-full">
                    <div class="flex justify-center">
                        <x-heroicon-o-x-circle class="w-8 justify-self-end"/>
                        <span class="text-lg ps-2 pt-0.5 justify-self-start">Jelenleg nincs kuponod. Nézz vissza később!</span>
                    </div>
                </div>
            @else
                </div>
            @endif
        </div>
    @endif
</x-filament-panels::page>
