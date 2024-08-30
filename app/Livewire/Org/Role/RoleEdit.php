<?php

namespace App\Livewire\Org\Role;
use App\Enum\PageModeEnum;
use App\Enum\Role\StatusEnum;
use Livewire\Component;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleEdit extends Component
{
    public $role = null;
    public $mode = null;

    public function mount(Role $role)
    {
        $this->role = $role;
        $this->mode = PageModeEnum::EDIT->value;
    }


    public function render()
    {
        return view('livewire.org.role.role-edit');
    }
}
