<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SetPassword extends Component
{
    public function render()
    {
        //get authenticated user
        $user = Auth::user();

        return view('livewire.set-password', compact('user'));
    }
}
