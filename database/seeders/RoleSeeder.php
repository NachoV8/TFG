<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleA = Role::create(['name' => 'admin']);
        $roleP = Role::create(['name' => 'profesor']);

        Permission::create(['name' => 'admin.pistas.index'])->syncRoles([$roleA]);
        Permission::create(['name' => 'admin.pistas.create'])->syncRoles([$roleA]);
        Permission::create(['name' => 'admin.pistas.edit'])->syncRoles([$roleA]);
        Permission::create(['name' => 'admin.pistas.destroy'])->syncRoles([$roleA]);

        Permission::create(['name' => 'admin.torneos.index'])->syncRoles([$roleA]);
        Permission::create(['name' => 'admin.torneos.create'])->syncRoles([$roleA]);
        Permission::create(['name' => 'admin.torneos.edit'])->syncRoles([$roleA]);
        Permission::create(['name' => 'admin.torneos.destroy'])->syncRoles([$roleA]);

        Permission::create(['name' => 'admin.clases.index'])->syncRoles([$roleA,$roleP]);
        Permission::create(['name' => 'admin.clases.create'])->syncRoles([$roleA,$roleP]);
        Permission::create(['name' => 'admin.clases.edit'])->syncRoles([$roleA,$roleP]);
        Permission::create(['name' => 'admin.clases.destroy'])->syncRoles([$roleA,$roleP]);

        Permission::create(['name' => 'admin.productos.index'])->syncRoles([$roleA]);
        Permission::create(['name' => 'admin.productos.create'])->syncRoles([$roleA]);
        Permission::create(['name' => 'admin.productos.edit'])->syncRoles([$roleA]);
        Permission::create(['name' => 'admin.productos.destroy'])->syncRoles([$roleA]);

        Permission::create(['name' => 'admin.usuers.index'])->syncRoles([$roleA]);
        Permission::create(['name' => 'admin.usuers.create'])->syncRoles([$roleA]);
        Permission::create(['name' => 'admin.usuers.edit'])->syncRoles([$roleA]);
        Permission::create(['name' => 'admin.usuers.destroy'])->syncRoles([$roleA]);



    }
}
