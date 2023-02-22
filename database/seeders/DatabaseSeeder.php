<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(DepartmentSeeder::class);

        \App\Models\User::factory()->create([
            'name' => 'Cut Putri',
            'email' => 'cutputri@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'admin')->first('id'),
            'Department_id' => Department::where('name', 'Non-Department')->first('id'),
            'position_id' => Position::where('name', 'Manager')->first('id'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Chandra',
            'email' => 'chandranindhito@gmail.com',
            'password' => bcrypt('cahwonogiri'),
            'role_id' => Role::where('name', 'user')->first('id'),
            'Department_id' => Department::where('name', 'Engineering')->first('id'),
            'position_id' => Position::where('name', 'staff')->first('id'),
        ]);
    }
}
