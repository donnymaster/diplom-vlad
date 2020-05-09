<?php

use App\UserRole;
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
        UserRole::create([
            'role_name' => 'user'
        ]);

        UserRole::create([
            'role_name' => 'admin'
        ]);
    }
}
