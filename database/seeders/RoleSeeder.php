<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(["name" => "crud full access"]);
        Permission::create(["name" => "purchase product"]);

        Role::create(["name" => "admin"])
            ->givePermissionTo(["crud full access", "purchase product"]);
        Role::create(["name" => "user"])
            ->givePermissionTo("purchase product");
    }
}
