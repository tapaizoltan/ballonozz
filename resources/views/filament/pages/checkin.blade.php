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
                <div class="grid justify-center p-10">
                    <div class="fi-ta-empty-state-icon-ctn mb-4 rounded-full bg-gray-100 p-3 dark:bg-gray-500/20 max-w-min justify-self-center">
                        <svg class="fi-ta-empty-state-icon h-6 w-6 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <span class="fi-ta-empty-state-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">Nincs megjeleníthető kupon. Nézz vissza később!</span>
                </div>
            </div>
        @endforelse
    </div>

    @if ($this->events !== false)
        <div class="flex">
            <h1 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">{{ $this->coupon->coupon_code }}</h1>
            <span class="pl-2 pt-1.5 sm:pt-2.5">{{ $this->coupon->source }} kupon</span>
        </div>
        <div class="flex gap-5 w-full p-2 overflow-x-auto">
            @foreach ($this->events as $event)
                @php
                    $selected = $event->isChecked($this->coupon->id);
                    $finalized = $event->status == App\Enums\AircraftLocationPilotStatus::Finalized;
                    $checked = $event->coupons()->find($this->coupon)?->pivot->status == 1;
                @endphp
                @if ($loop->first)
                    @php
                        $fly_at = $event->date;
                    @endphp
                    <div class="grid grid-flow-col gap-2">
                        <div><div class="card max-h-min !py-2">
                        
                    <div class="pb-2">{{ Carbon\Carbon::parse($fly_at)->translatedFormat('Y F d.') }}</div>
                @elseif($fly_at != $event->date && $fly_at != null)
                    @php
                        $fly_at = $event->date;
                    @endphp
                    </div></div></div><div class="grid grid-flow-col gap-2">
                        <div>
                        <div class="card max-h-min !py-2">
                    <div class="pb-2">{{ Carbon\Carbon::parse($fly_at)->translatedFormat('Y F d.') }}</div>
                @endif

                <div class="card mb-4 grid gap-2 min-w-max border-2 @if($selected && !$finalized && !$this->coupon->is_used || $finalized && $selected && $checked) border-green-500/80 @else dark:border-white/20 @endif @if($selected && $finalized && $checked) bg-green-600/10 dark:bg-[#4ade80]/10 @elseif($finalized) bg-zinc-200/20 text-zinc-400 @endif">
                    <div class="flex justify-between">
                        <div>{{ Carbon\Carbon::parse($event->time)->format('H:i') }}</div>
                        @if ($finalized)
                            <div class="@if($selected && $finalized && $checked) text-green-600 @elseif($finalized) text-zinc-400 @endif">@svg('tabler-flag-check')</div>
                        @endif
                    </div>
                    
                    <div class="flex gap-2">
                        <div class="@if($selected && !$finalized || $finalized && $selected && $checked || !$selected && !$finalized) text-red-500 @else text-red-500/50 @endif"">
                            <x-heroicon-c-map-pin class="w-6"/>
                        </div>
                        <span>{{ $event->location->name }}</span>
                    </div>

                    <div class="flex gap-2">
                        <span class="@if($selected && !$finalized || $finalized && $selected && $checked || !$selected && !$finalized) text-blue-400 @else text-blue-400/50 @endif">@svg($event->aircraft->type->getIcon())</span>
                        <span>{{ $event->aircraft->name }}</span>
                    </div>

                    <div class="flex justify-between">
                        <div class="flex text-zinc-400 justify-self-center">
                            <x-heroicon-m-users class="w-5"/>
                            <span class="ps-1 py-2 text-sm font-semibold">{{ $event->coupons->sum('adult') + $event->coupons->sum('children') }}</span>
                        </div>
                        <div>
                            @if($selected && $finalized && $checked) 
                                <div class="text-green-600 dark:text-green-400/80 font-semibold p-1.5">Résztveszek</div>
                            @elseif($finalized) 
                                <div class="text-zinc-400 font-semibold p-1.5">Lezárva</div>
                            @elseif(!$selected && !$this->coupon->is_used)
                                <x-filament::button wire:click="checkIn({{ $event->id }})">Jelentkezem</x-filament::button>
                            @elseif($selected && !$this->coupon->is_used)
                                <x-filament::button class="!bg-red-600 hover:!bg-red-700" wire:click="checkOut({{ $event->id }})">Lejelentkezem</x-filament::button>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        
            @if (!$this->events->count())
                <div class="card w-full">
                    <div class="grid justify-center p-10">
                        <div class="fi-ta-empty-state-icon-ctn mb-4 rounded-full bg-gray-100 p-3 dark:bg-gray-500/20 max-w-min justify-self-center">
                            <svg class="fi-ta-empty-state-icon h-6 w-6 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path>
                              </svg>
                        </div>
                        <span class="fi-ta-empty-state-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">Nincs megjeleníthető esemény. Nézz vissza később!</span>
                    </div>
                </div>    
            @else
                </div>
            @endif
        </div>
    @endif
</x-filament-panels::page>
