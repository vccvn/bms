<?php

use Illuminate\Database\Seeder;

use App\Repositories\Users\UserRepository;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rep = new UserRepository();
        $faker = Faker\Factory::create();
        // admin
        $a = $rep->save([
            'name'        => 'admin', 
            'username'    => 'admin', 
            'email'       => 'doanln16@gmail.com', 
            'password'    => 'Doan.1992'
        ]);
        $b = [];
        // random
        for($i = 0; $i < 10; $i++){
            $faker = Faker\Factory::create();
            $name = $faker->name;
            $username = str_slug($name,'.');
            $email = $faker->email;
            $password = '123456';
            $b[] = $rep->save(compact('name','username','email','password'));
        }

        
    }
}
