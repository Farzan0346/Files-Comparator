<?php

namespace App\Livewire\Org\User;

use App\Enum\PageModeEnum;
use App\Models\User;
use Livewire\Component;

class UserCreate extends Component
{
    public $user = null;
    public $mode = null;
    public function mount(User $user)
    {
        $this->user = $user;
        $this->mode = PageModeEnum::CREATE;
    }
    public function render()
    {
      return view('livewire.org.user.user-create');
    }
}
