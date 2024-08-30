<?php

namespace App\Livewire\Org\Role;

use App\Enum\PageModeEnum;
use App\Enum\Role\StatusEnum;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;


class RoleForm extends Component
{

    public $role, $mode;

    public $roles, $statuses ;

    public $name, $module, $permissions = [], $all = false;

    public $assing_permission = [];


    public function mount()
    {
        $this->permissions = Permission::latest()->get();

        if ($this->mode == PageModeEnum::EDIT) {
            $this->name = $this->role->name;
            $this->permissions = Permission::all();

        } else {

        }
    }
  public function render()
    {
        return view('livewire.org.role.role-form');
    }


}
