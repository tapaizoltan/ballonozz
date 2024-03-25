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
            @forelse ($this->dates as $date)
                @php
                    $checked = $date->isChecked($this->coupon->id)
                @endphp
                @if ($loop->first)
                    @php
                        $fly_at = $date->date;
                    @endphp
                    <div class="grid grid-flow-col gap-2">
                        <div><div class="card max-h-min">
                        
                    <div class="pb-2">{{ Carbon\Carbon::parse($fly_at)->translatedFormat('Y F d.') }}</div>
                @elseif($fly_at != $date->date && $fly_at != null)
                    @php
                        $fly_at = $date->date;
                    @endphp
                    </div></div></div><div class="grid grid-flow-col gap-2">
                        <div>
                        <div class="card max-h-min">
                    <div class="pb-2">{{ Carbon\Carbon::parse($fly_at)->translatedFormat('Y F d.') }}</div>
                @endif

                <div class="card mb-4 grid gap-2 min-w-max border-2  @if($checked) border-green-500/80 @else dark:border-white/20 @endif">
                    
                    <div class="pt-1.5">{{ Carbon\Carbon::parse($date->time)->format('H:i') }}</div>
                    
                    <div class="flex gap-2">
                        <x-heroicon-c-map-pin class="w-6 text-red-500"/>
                        <span>{{ $date->location->name }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="text-blue-400">@svg($date->aircraft->type->getIcon())</span>
                        <span>{{ $date->aircraft->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex text-zinc-400 justify-self-center">
                            <x-heroicon-m-users class="w-5"/>
                            <span class="ps-1 pt-2 text-sm font-semibold">{{ $date->coupons->sum('adult') + $date->coupons->sum('children') }}</span>
                        </div>
                        <div>
                            @if(!$checked)
                                <x-filament::button wire:click="checkIn({{ $date->id }})">Jelentkezem</x-filament::button>
                            @else
                                <x-filament::button class="!bg-red-600" wire:click="checkOut({{ $date->id }})">Lejelentkezem</x-filament::button>
                            @endif
                        </div>
                    </div>
                </div>
                
            @empty
                <div class="card w-full">
                    <div class="flex justify-center">
                        <x-heroicon-o-x-circle class="w-8 justify-self-end"/>
                        <span class="text-lg ps-2 pt-0.5 justify-self-start">Jelenleg nincs kuponod. Nézz vissza később!</span>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    @endif
</x-filament-panels::page>
