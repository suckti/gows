<?php

namespace App\Livewire;

use App\Models\Challenge;
use Livewire\Component;
use Livewire\Attributes\Layout;

class ChallengeList extends Component
{
    public function render()
    {
        $challenges = Challenge::all();
        return view('livewire.challenge-list',['challenges' => $challenges]);
    }
}
