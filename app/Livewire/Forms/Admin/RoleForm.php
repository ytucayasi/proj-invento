<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Permission;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Spatie\Permission\Models\Role;

class RoleForm extends Form
{
    public ?Role $role;
    #[Locked]
    public ?int $id = null;
    public ?string $name = '';
    public function mount()
    {
        $this->role = new Role();
    }
    public function getRole()
    {
        return $this->role;
    }
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('roles')->ignore($this->id),
            ]
        ];
    }
    public function setRole(Role $role)
    {
        $this->role = $role;
        $this->id = $role->id;
        $this->name = $role->name;
    }
    public function store()
    {
        $role = Role::create($this->all());
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
    }
    public function update()
    {
        $this->role->update($this->only('name'));
    }
    public function delete()
    {
        $this->role->delete();
    }
}
