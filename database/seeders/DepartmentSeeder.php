<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder {
    public function run(): void {
        DB::table('departments')->truncate();
        DB::table('departments')->insert([
            array('name' => 'Human Resources', 'slug' => 'human_resources', 'description' => 'Handles employee relations and benefits.'),
            array('name' => 'Finance', 'slug' => 'finance', 'description' => 'Manages financial records and budgets.'),
            array('name' => 'IT', 'slug' => 'it', 'description' => 'Responsible for technology and systems.'),
            array('name' => 'Marketing', 'slug' => 'marketing', 'description' => 'Oversees marketing strategies and campaigns.'),
            array('name' => 'Sales', 'slug' => 'sales', 'description' => 'Handles sales and customer relationships.')
        ]);
    }
}
