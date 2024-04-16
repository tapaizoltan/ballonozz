<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{
    public function mount()
    {
        if (auth()->user()?->email_verified_at ?? null) {
            return redirect()->route('filament.admin.pages.dashboard');
        }
    }

    public function login()
    {
        return redirect()->route('filament.admin.auth.login');
    }

    public function render()
    {
        return view('livewire.home')->title(env('APP_NAME'));
    }
}
