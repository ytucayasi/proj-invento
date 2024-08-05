<?php
use App\Livewire\Forms\Admin\UserForm;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {

    public UserForm $form;
    public string $modelName = 'Usuario';
    public string $areaName = 'default';
    public bool $modal = true;

    public function open()
    {
        $this->form->resetValidation();
        $this->form->reset();
        $this->modal = true;
    }

    public function user()
    {
        return $this->form->user();
    }

    #[On('editUser')]
    public function setUser(User $user)
    {
        $this->form->resetValidation();
        $this->form->reset();
        $this->form->setUser($user);
        $this->modal = true;
    }

    public function clear()
    {
        $this->form->resetValidation();
        $this->form->reset();
    }

    public function save()
    {
        $this->form->id ? $this->form->update() : $this->form->store();
    }

    public function getArea(?int $id): ?array
    {
        $areas = config('admin.areas');
        foreach ($areas as $area) {
            if ($area['id'] === $id) {
                return $area;
            }
        }
        return null;
    }

    public function createUser(string $nombre = null, string $apellido_paterno = null, int $tipo_campo)
    {
        $nombre = trim(strtolower($nombre ?? ''));
        $apellido_paterno = trim(strtolower($apellido_paterno ?? ''));
        if ($nombre || $apellido_paterno) {
            $variacion = $tipo_campo == 1 ? '.' : ' ';
            return $tipo_campo == 2
                ? (mb_convert_case($nombre, MB_CASE_TITLE, 'UTF-8') . $variacion . mb_convert_case($apellido_paterno, MB_CASE_TITLE, 'UTF-8'))
                : (mb_convert_case($nombre, MB_CASE_LOWER, 'UTF-8') . $variacion . mb_convert_case($apellido_paterno, MB_CASE_LOWER, 'UTF-8'));
        } else {
            return '';
        }
    }

    public function updating($property, $value)
    {
        if ($property === 'form.area_id') {
            $this->areaName = $this->getArea($value) ? $this->getArea($value)['name'] : 'default';
        } else if ($property === 'form.nombre') {
            $this->form->email = $this->createUser($value, $this->form->apellido_paterno, 1);
            $this->form->name = $this->createUser($value, $this->form->apellido_paterno, 2);
        } else if ($property === 'form.apellido_paterno') {
            $this->form->email = $this->createUser($this->form->nombre, $value, 1);
            $this->form->name = $this->createUser($this->form->nombre, $value, 2);
        }
    }
}; ?>
<div>
    <x-button primary label="Primary" wire:click="open" />
    <livewire:tables.user-table />
    <x-modal-card title="{{($form->id ? 'Editar' : 'Registrar') . ' ' . $modelName}}" wire:model="modal" width="xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- DNI -->
            <x-maskable label="DNI" placeholder="DNI" wire:model="form.dni" mask="########" />

            <!-- Nombre -->
            <x-input label="Nombre" placeholder="Nombre" wire:model.live="form.nombre"
                description="Recuerde (sin espacios)" />

            <!-- Apellido Paterno -->
            <x-input label="Apellido Paterno" placeholder="Apellido Paterno" wire:model.live="form.apellido_paterno"
                description="Recuerde (sin espacios)" />

            <!-- Apellido Materno -->
            <x-input label="Apellido Materno" placeholder="Apellido Materno" wire:model="form.apellido_materno"
                description="Recuerde (sin espacios)" />
            <!-- Fecha de Nacimiento -->

            <x-datetime-picker only label="Fecha de Nacimiento" placeholder="Fecha de Nacimiento"
                wire:model="form.fecha_nacimiento" />

            <!-- Género -->
            <x-select label="Género" placeholder="Género" :options="[['name' => 'Masculino', 'id' => 1], ['name' => 'Femenino', 'id' => 2]]" option-label="name" option-value="id" wire:model="form.genero" />

            <!-- Linea -->
            <hr class="md:col-span-2 my-2 border-slate-300 dark:border-slate-600" />

            <!-- Tipo de Persona -->
            <x-select class="gap-0" label="Tipo de Persona" placeholder="Tipo de Persona" :options="[['name' => 'Persona Natural', 'id' => 2], ['name' => 'Peronas Jurídica', 'id' => 1],]" option-label="name" option-value="id"
                wire:model="form.tipo_persona" />

            <!-- Area -->
            <x-select class="gap-0" label="Área" placeholder="Área" :options="config('admin.areas')" option-label="name"
                option-value="id" wire:model.live="form.area_id" />

            <!-- Linea -->
            <hr class="md:col-span-2 my-2 border-slate-300 dark:border-slate-600" />

            <!-- Usuario -->
            <x-input class="md:col-span-2" disabled label="Usuario" placeholder="Usuario" wire:model="form.name" />

            <!-- Email -->
            <x-input disabled label="Correo" placeholder="Correo" suffix="{{'@' . $areaName . '.sr' }}"
                wire:model="form.email" class="md:col-span-2" />

            <!-- Password -->
            <x-password class="md:col-span-2" label="Contraseña" placeholder="Ingrese una contraseña"
                wire:model="form.password" />
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