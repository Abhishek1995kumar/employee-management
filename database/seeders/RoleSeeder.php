<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Carbon;

class RoleSeeder extends Seeder {
    public function run(): void {
        DB::table("roles")->truncate();
        DB::table("roles")->insert([
            array(
                "name"=> "Super Admin",
                "slug"=> "super_admin",
                "status" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => NULL,
                "deleted_at" => NULL,
                "created_by" => 1,
                "updated_by" => NULL,
                "deleted_by" => NULL
            ),
            array(
                "name"=> "Admin",
                "slug"=> "admin",
                "status" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => NULL,
                "deleted_at" => NULL,
                "created_by" => 1,
                "updated_by" => NULL,
                "deleted_by" => NULL
            ),
        ]);
    }
}
