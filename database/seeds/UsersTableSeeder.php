<?php

use App\Model\DB\Users as DB_Users;
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
        $user = new DB_Users();
        $user->ResetAdmin();
    }
}
