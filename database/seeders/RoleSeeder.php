<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadminRole = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web'
        ]);
        $fullAccessPermission = Permission::firstOrCreate([
            'name' => 'full_access',
            'guard_name' => 'web'
        ]);
        $superadminRole->permissions()->sync($fullAccessPermission->id);
    }
}
