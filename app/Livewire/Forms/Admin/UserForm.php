<?php

namespace App\Livewire\Forms\Admin;

use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user;
    #[Locked]
    public ?int $id = null;
    public ?string $nombre = '';
    public ?string $apellido_paterno = '';
    public ?string $apellido_materno = '';
    public ?string $fecha_nacimiento = '';
    public ?int $genero = 0;
    public ?int $dni = 0;
    public ?int $tipo_persona = 0;
    public ?int $area_id = 0;
    public $name = '';
    public $email = '';
    public $password = '';
    public function boot()
    {
        $this->user = new User();
    }
    public function getUser()
    {
        return $this->user;
    }
    public function rules()
    {
        return [
            'dni' => 'required|integer|min:10000000',
            'nombre' => 'required|string|min:2|max:30|alpha',
            'apellido_paterno' => 'required|string|min:3|max:30|alpha',
            'apellido_materno' => 'required|string|min:3|max:30|alpha',
            'fecha_nacimiento' => 'required|date|before:today',
            'genero' => 'required|integer|min:1|max:1',
            'tipo_persona' => 'required|integer|min:1|max:1',
            'area_id' => 'required|integer|min:1',
            'name' => [
                'required',
                Rule::unique('users')->ignore($this->user),
            ],
            'email' => [
                'required',
                Rule::unique('users')->ignore($this->user),
            ],
            'password' => 'required|min:6',
        ];
    }
    public function setUser(User $user)
    {
        $this->user = $user;
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = $user->password;
    }
    public function store()
    {
        $this->validate();
        User::create($this->all());
        $this->reset();
    }
    public function update()
    {
        $this->validate();
        $this->user->update($this->all());
        $this->reset();
    }
}