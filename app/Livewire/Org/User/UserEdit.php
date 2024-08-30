<?php

namespace App\Livewire\Org\User;

use App\Enum\PageModeEnum;
use App\Models\User;
use Livewire\Component;

class UserEdit extends Component
{

    public $user = null;
    public $mode = null;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->mode = PageModeEnum::EDIT->value;
    }

    public function render(User $user)
    {
        return view('livewire.org.user.user-edit');
    }
}
