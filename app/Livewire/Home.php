<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Home extends Component
{
    public function render()
    {
        return view('livewire.home');
    }
}
