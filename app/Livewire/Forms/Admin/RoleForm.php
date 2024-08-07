<?php

namespace App\Livewire\Forms\Admin;

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
            'name' => 'required|max:30',
        ];
    }
    public function setRole(Role $role)
    {
        $this->role = $role;
        $this->name = $role->name;
    }
    public function store()
    {
        Role::create($this->all());
    }
    public function update()
    {
        $this->role->update($this->all());
    }
    public function delete()
    {
        $this->role->delete();
    }
}
