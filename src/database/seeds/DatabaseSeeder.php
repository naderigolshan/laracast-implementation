<?php

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
        factory(\App\Thread::class, 100)->create();
//         $this->call(RoleAndPermissionSeeder::class);
    }
}
