<div class="grid">
    @if ($this->registered === false)
        <form method="POST" wire:submit="registration" class="grid md:grid-cols-2 w-full justify-items-center gap-5">
            @csrf
            <div class="card grid grid-cols-2 bg-[#D4ECF2] md:order-1">
                <label for="name" class="">Teljes név</label>
                <input type="text" id="name" wire:model="name">
                @error('name')
                    <div class="text-red-600 text-sm p-2 col-span-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="card grid grid-cols-2 bg-[#D4ECF2] md:order-3">
                <label for="email">E-mail</label>
                <input type="email" id="email" wire:model="email">
                @error('email')
                    <div class="text-red-600 text-sm p-2 col-span-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="card grid grid-cols-2 bg-[#D4ECF2] md:order-5">
                <label for="phone">Telefon</label>
                <input type="phone" id="phone" wire:model="phone">
                @error('phone')
                    <div class="text-red-600 text-sm p-2 col-span-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="card grid grid-cols-2 bg-[#D4ECF2] md:order-2">
                <label for="password">Jelszó</label>
                <input type="password" id="password" wire:model="password">
                @error('password')
                    <div class="text-red-600 text-sm p-2 col-span-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="card grid grid-cols-2 bg-[#D4ECF2] md:order-4 max-h-[60px]">
                <label for="password-confirmation">Jelszó megerősítése</label>
                <input type="password" id="password-confirmation" wire:model="password_confirmation">
            </div>

            <div class="relative min-h-10 md:order-6">
                <button type="submit" class="btn primary hover:bg-custom-secondary transition duration-300 absolute left-1/2 top-1/2 translate-y-[-50%] translate-x-[-50%]"><span class="text-shadow text-lg">Regisztrál!</span></button>
            </div>
        </form>
    @else
        <div class="card bg-[#D4ECF2] max-w-[600px] grid text-center justify-self-center">
            <h3>Sikeres regisztráció</h3>
            <h4>Erősítsd meg az email címed</h4>
            <span>Küldtünk egy emailt a(z) {{ $this->email }} címre, amely tartalmazza az email címed ellenőrzésére vonatkozó utasításokat.</span>
        </div>
    @endif
</div>
