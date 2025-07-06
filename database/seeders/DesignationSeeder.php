<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Carbon;

class DesignationSeeder extends Seeder {
    public function run(): void {
        DB::table("designations")->truncate();
        DB::table("designations")->insert([
            array(
                "department_id"=> 1,
                "name"=> "HR",
                "slug"=> "hr",
                "description"=> "human resource",
                "created_by"=> 1,
                "created_at"=> Carbon::now(),
                "updated_by"=> NULL,
                "updated_at"=> Carbon::now(),
                "deleted_by"=> NULL,
                "deleted_at"=> NULL,
            ),
            array(
                "department_id"=> 3,
                "name"=> "Manager",
                "slug"=> "manager",
                "description"=> "manager",
                "created_by"=> 1,
                "created_at"=> Carbon::now(),
                "updated_by"=> NULL,
                "updated_at"=> Carbon::now(),
                "deleted_by"=> NULL,
                "deleted_at"=> NULL,
            ),
        ]);
    }
}
