<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $roles = [
            [
                'role' => 'admin'
            ],
            [
                'role' => 'user'
            ]
        ];
        
        foreach ($roles as $key => $value) {
            Role::create($value);
        }
    }
}
