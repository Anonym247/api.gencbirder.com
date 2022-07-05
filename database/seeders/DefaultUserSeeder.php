<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('users')->count()) {
            User::query()->create([
                'role_id' => Role::SUPERADMIN,
                'email' => 'admin@gencbirder.com',
                'email_verified_at' => now(),
                'firstname' => 'Admin',
                'lastname' => '',
                'password' => bcrypt('gencbirder.49'),
            ]);
        }
    }
}
