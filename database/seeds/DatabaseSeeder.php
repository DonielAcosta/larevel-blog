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
        // $this->call(UsersTableSeeder::class);
        App\User::create([
          'name' => 'Doniel Acosta',
          'email' => 'donielacosta1995@gmail.com',
          'password' => bcrypt('12345')
        ]);

        factory(App\Post::class,24)->create();
    }
}
