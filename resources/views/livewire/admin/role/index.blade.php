<?php

use App\Livewire\Forms\Admin\RoleForm;
use Livewire\Attributes\On;
use Livewire\Volt\Component;
use Spatie\Permission\Models\Role;

new class extends Component {
    public RoleForm $roleForm;
    public string $modelName = 'Rol';
    public bool $modal = false;
    public bool $modalDelete = false;

    /* Abrir modal */
    #[On('createRole')]
    public function open()
    {
        $this->resetForm();
        $this->modal = true;
    }

    /* Obtener Rol */
    public function role()
    {
        return $this->roleForm->getRole();
    }

    /* Setear modelos de Usuario y Persona */
    #[On('editRole')]
    public function setRole(Role $role)
    {
        $this->resetForm();
        $this->roleForm->setRole($role);
        $this->modal = true;
    }

    /* Eliminar usuario */
    #[On('deleteRole')]
    public function removeRole(Role $role)
    {
        $this->roleForm->setRole($role);
        $this->modalDelete = true;
    }

    public function delete()
    {
        $this->roleForm->delete();
        /* Refrescar la tabla de usuarios */
        $this->dispatch('pg:eventRefresh-RoleTable');
        $this->modalDelete = false;
    }

    /* Limpiar formulario */
    public function clear()
    {
        $this->resetForm();
    }

    /* Realizar acción de actualizar o registrar */
    public function save()
    {
        $this->roleForm->id
            ? $this->update()
            : $this->store();
    }

    /* Validación de los campos */
    public function validateForm()
    {
        $this->roleForm->validate();
    }

    /* Regsitrar Usuario General */
    public function store()
    {
        /* Validación deel formulario */
        $this->validateForm();

        /* Registrar Usuario */
        $this->roleForm->store();

        /* Resetear formulario */
        $this->resetForm();

        /* Refrescar la tabla de usuarios */
        $this->dispatch('pg:eventRefresh-RoleTable');

        /* Cerrar modal */
        $this->modal = false;
    }

    /* Actualizar Usuario General */
    public function update()
    {
        // Validación del formulario
        $this->validateForm();

        // Actualizar persona
        $this->roleForm->update();

        /* Refrescar la tabla de usuarios */
        $this->dispatch('pg:eventRefresh-RoleTable');

        /* Cerrar modal */
        $this->modal = false;
    }

    /* Resetear formulario y validaciones */
    public function resetForm()
    {
        $this->roleForm->resetValidation();
        $this->roleForm->reset();
    }
}; ?>
<div>
    <livewire:tables.role-table />
    <x-modal wire:model="modalDelete" width="sm">
        <x-card>
            <div class="flex flex-col justify-center items-center gap-4">
                <div class="bg-warning-400 dark:border-4 dark rounded-full p-4">
                    <x-phosphor.icons::regular.warning class="text-white w-16 h-16" />
                </div>
                <span class="text-center font-semibold text-xl">¿Desea eliminar el rol?</span>
                <span class="text-center">Recuerde que se eliminará definitivamente</span>
                <div class="flex gap-2">
                    <x-button flat label="Cancelar" x-on:click="close" />
                    <x-button flat negative label="Eliminar" wire:click="delete" />
                </div>
            </div>
        </x-card>
    </x-modal>
    <x-modal-card title="{{($roleForm->id ? 'Editar' : 'Registrar') . ' ' . $modelName}}" wire:model="modal" width="sm">
        <div class="grid grid-cols-1 gap-4">

            <!-- Nombre -->
            <x-input label="Nombre" placeholder="Ingresar" wire:model="roleForm.name" />
        </div>
        <x-slot name="footer" class="flex justify-between items-center gap-x-4">

            <!-- Botón de Eliminar -->
            <x-mini-button flat negative rounded icon="trash" wire:click="clear" />
            <div class="flex gap-x-2">

                <!-- Botón de Cancelar -->
                <x-button flat label="Cancelar" x-on:click="close" />

                <!-- Botón de Guardar -->
                <x-button flat positive label="Guardar" wire:click="save" />
            </div>
        </x-slot>
    </x-modal-card>
</div>