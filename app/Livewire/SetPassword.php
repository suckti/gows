<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

class SetPassword extends Component
{
    public $password = '';
    public $password_confirmation = '';

    #[Layout('components.layouts.password')]
    public function render()
    {
        //get authenticated user
        $user = Auth::user();
        return view('livewire.set-password', compact('user'));
    }

    public function save()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($this->password);
        $user->save();

        return redirect('/dashboard');
    }
}
