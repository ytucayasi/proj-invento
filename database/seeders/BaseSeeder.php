<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Registramos los permisos */
        foreach (config('admin.modules') as $module) {
            foreach (config('admin.actions') as $action) {
                Permission::create(['name' => $action['ab'] . ' ' . $module['ab']]);
            }
        }

        /* Registramos los roles */
        $super_admin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $basic = Role::create(['name' => 'User']);

        /*  Acciones */
        $basic_permissions = Permission::where('name', 'like', 'listar%')->get();

        /* Asignamos los permisos a los roles */
        $admin->syncPermissions(Permission::all());
        $basic->syncPermissions($basic_permissions);

        /* Creamos los usuarios */
        $user = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.sr',
        ]);
        $user->assignRole($super_admin);

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.sr',
        ]);
        $user->assignRole($admin);

        $user = \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@ti.sr',
        ]);
        $user->assignRole($basic);
    }
}
