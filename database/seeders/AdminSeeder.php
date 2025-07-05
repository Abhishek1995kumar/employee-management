<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder {
    public function run(): void {
        DB::table("users")->truncate();
        DB::table("users")->insert([
            array(
                "role_id"=> 1,
                "department_id"=> 1,
                "designation_id"=> 1,
                "name" => "Abhishek",
                "username" => "abhishekkumar007",
                "email"=> "super.admin@gmail.com",
                "password"=> Hash::make("admin"),
                "phone"=> "9415058209",
                "address"=> "New Delhi",
                "created_by"=> 1,
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
