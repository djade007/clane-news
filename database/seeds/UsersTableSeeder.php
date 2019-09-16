<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(User::query()->count() > 1) {
            // don't create any user if any is already existing
            return;
        }

        User::query()->create([
            'name' => 'Kazeem Olanipekun',
            'email' => 'kazeem@test.com',
            'password' => bcrypt('password')
        ]);
    }
}
