<?php

namespace App\Livewire\Org\User;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UserForm extends Component
{
    public $user;
    public $mode;


    #[Validate('required')]
    public $first_name = '';

    #[Validate('required')]
    public $last_name = '';

    #[Validate('required')]
    public $email = '';

    #[Validate('required')]
    public $password = '';

    #[Validate('required')]
    public $phone = '';

    public function mount()
    {
        if ($this->user) {
            $this->first_name = $this->user->first_name;
            $this->last_name = $this->user->last_name;
            $this->email = $this->user->email;
            $this->phone = $this->user->phone;
            $this->mode = 'edit';
        }
    }
    public function save()
    {
        $this->validate();

        User::create(
            $this->only(['first_name', 'last_name', 'email', 'password', 'phone',])
        );

        return $this->redirect(route('user'));
    }


    public function update()
    {
        $this->validate();

        $this->user->update($this->only(['first_name', 'last_name', 'email', 'password', 'phone',]));

        $this->reset();
        return $this->redirect(route('user'));
    }

    public function render()
    {
        return view('livewire.org.user.user-form');
    }
}
