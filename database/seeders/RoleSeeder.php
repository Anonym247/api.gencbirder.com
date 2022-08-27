<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => Role::SUPERADMIN,
                'name' => 'SUPERADMIN',
            ],
            [
                'id' => Role::VOLUNTEER,
                'name' => 'VOLUNTEER',
            ],
        ];

        foreach ($roles as $role) {
            Role::query()->updateOrCreate(
                [
                    'id' => $role['id']
                ],
                $role
            );
        }
    }
}
