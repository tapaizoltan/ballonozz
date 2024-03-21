<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{
    public function login()
    {
        return redirect()->route('filament.admin.auth.login');
    }

    public function render()
    {
        return view('livewire.home')->title(env('APP_NAME'));
    }
}
