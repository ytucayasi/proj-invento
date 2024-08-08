<?php

namespace App\Livewire\Tables;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class UserTable extends PowerGridComponent
{
    use WithExport;
    public string $tableName = 'UserTable';
    public string $moduleName = 'Usuarios';
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput()->includeViewOnTop('components.datatable.header-top'),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return User::query()->whereNotIn('name', ['Super Admin']);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('email');
    }

    public function columns(): array
    {
        return [
            Column::make('id', 'id'),
            Column::make('usuario', 'name')
                ->sortable()
                ->searchable(),
            Column::make('correo', 'email')
                ->sortable()
                ->searchable(),
            Column::action('Acciones')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }
    public function editUser($id)
    {
        $this->dispatch('editUser', ['user' => User::findOrFail($id)]);
    }
    public function open()
    {
        $this->dispatch('createUser');
    }
    public function deleteUser($id)
    {
        $this->dispatch('deleteUser', ['user' => User::findOrFail($id)]);
    }
    public function actions(User $user): array
    {
        return [
            Button::add('edit')
                ->render(function ($user) {
                    return Blade::render(<<<HTML
                        <x-mini-button rounded icon="pencil" flat gray interaction="positive" wire:click="editUser('$user->id')" />
                    HTML);
                }),
            Button::add('delete')
                ->render(function ($user) {
                    return Blade::render(<<<HTML
                        <x-mini-button rounded icon="trash" flat gray interaction="negative" wire:click="deleteUser('$user->id')" />
                    HTML);
                }),
        ];
    }

    public function actionRules($row): array
    {
        return [
            Rule::button('edit')
                ->when(fn($row) => $row->id === 2)
                ->hide(),
            Rule::button('delete')
                ->when(fn($row) => $row->id === 2)
                ->hide(),
        ];
    }
}
