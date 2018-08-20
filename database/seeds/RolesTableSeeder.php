<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin'
        ]);
        
        Role::create([
            'name' => 'manager'
        ]);
        
        factory(App\Role::class, 5)->create();
    }
}
