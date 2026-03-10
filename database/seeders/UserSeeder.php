<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserType;
use Carbon\Carbon;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = new User();

        $user->name = 'Admin';
        $user->email = 'admin@example.com';
        $user->password = Hash::make('password');
        $user->nickname = 'Admin';
        $user->gender = 'male';
        $user->birthday = Carbon::now();
        $user->best_friend_name = 'Admin';
        $user->is_admin = true;
        $user->user_type_id = UserType::query()->inRandomOrder()->first()->id;

        $user->save();
    }
}
