<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //send by model + add value to created_at & updated_at
        User::create([
            'name'=>'Yousef Elmadawy',
            'email'=>'yousef@admin.com',
            'password'=>Hash::make('password'),
            'phone_number'=>'0100090111',
        ]);

        //send by query bulider in case i have table without model didnt add value to created_at & updated_at
        DB::table('users')->insert([
            'name'=>'Ali ',
            'email'=>'Ali@admin.com',
            'password'=>Hash::make('123456789'),
            'phone_number'=>'0100090112',

        ]);
    }
}
