@extends('layout')
@section('content')
<h1>Kuponok</h1>

<div class="Container">
    <form action="{{ route('coupons.search') }}" method="GET">
        <input type="text" name="search" style="width:200px; height:20px; background-color:white; border: 1px solid lightgray; border-radius:4px; padding:3px;" placeholder="Adja meg a kuponkódot..." required/>
        <button type="submit" class="button">Ellenőrzés</button>
    </form>
</div>
<div class="articlesContainer">
@if (count($coupons) > 0)
    <ul>
        @foreach ($coupons as $coupon)

            @if ($coupon->source == 'Meglepkék')
            <p style="color:gray;">{{ $coupon->source }}</p>
            <p style="color:gray;">{{ $coupon->adult }} fő felnőtt</p>
            <p style="color:gray;">{{ $coupon->children }} fő gyerek</p>
            @endif

            @if ($coupon->source != 'Meglepkék')
            <p style="color:gray;">{{ $coupon->source }}</p>
            <p style="color:gray;">{{ $coupon->adult }} fő felnőtt</p>
            <p style="color:gray;">{{ $coupon->children }} fő gyerek</p>
            <p style="color:gray;">{{ $coupon->vip }} VIP</p>
            <p style="color:gray;">{{ $coupon->private }} Privát</p>
            @endif

        @endforeach
    </ul>
@else
    <p style="margin-left:10px;">Nincs találat.</p>
@endif
</div>
@endsection