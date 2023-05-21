<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::factory()->createMany([
            ["name" => "Engineering"],
            ["name" => "Acrylic & Laser Cut"],
            ["name" => "Fabrication & Procurement"],
            ["name" => "Non-Department"]
        ]);
    }
}
