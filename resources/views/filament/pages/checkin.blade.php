<x-filament-panels::page>
    <div class="flex flex-wrap gap-5 w-full">
        @foreach ($coupons as $coupon)
            <div class="clickable card @if ($coupon->id === $coupon_id) selected @endif"
                wire:click="$set('coupon_id', {{ $coupon->id }})">
                <div class="font-semibold">{{ $coupon->coupon_code }}</div>
                <div>
                    <div>{{ $coupon->source }} kupon</div>
                    <div>
                        <div>
                            <div>
                                <span class="quantity">{{ $coupon->adult }} </span>
                                <span class="quantity-description">felnőtt</span>
                            </div>
                            <div>
                                <span class="quantity">{{ $coupon->children }} </span>
                                <span class="quantity-description">gyerek</span>
                            </div>
                        </div>
                        <div>
                            <!-- TODO SVG -->
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($this->dates !== false)
        <div class="card grid">
            @forelse ($this->dates as $date)
                <span>{{ $date->date }} {{ $date->time }}</span>
            @empty
                <span>Egyenlőre nincs kiírt repülés a(z) "{{ $this->coupon->coupon_code }}" kuponkódhoz. Nézz vissza később!</span>
            @endforelse
        </div>
    @endif
</x-filament-panels::page>
