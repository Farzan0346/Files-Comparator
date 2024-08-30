<?php

namespace App\Livewire\Org\Role;

use App\Enum\PageModeEnum;
use App\Enum\Role\StatusEnum;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;

class RoleList extends Component
{
    public $role, $mode;

    public $roles, $statuses;

    public $name = [];


    public function mount()
    {
        $this->roles = ModelsRole::latest()->get();

        if ($this->mode == PageModeEnum::VIEW) {
            $this->name = $this->role->name;
        } else {

        }
    }

    public function render()
    {
        $permissions = Permission::all()->groupBy('module', true);
        $this->statuses = StatusEnum::cases();

        return view('livewire.org.role.role-list');
    }
}
