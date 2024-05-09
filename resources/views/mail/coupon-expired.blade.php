<x-mail::message>
    <h3 class="greeting">
        Kedves {{ $user->name }}!
    </h3>
    <div class="content">
        <p>A(z) {{ $coupon->coupon_code }} kódú kuponod lejárt ekkor: {{ Carbon\Carbon::parse($coupon->expiration_at)->translatedFormat('Y F d') }}</p>
    </div>
</x-mail::message>