<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $user = [
            ['name' => 'Super Admin'],
            ['name' => 'Admin'],
            ['name' => 'Guest']
        ];
  
        foreach ($user as $key => $value) {
            $Role_added = Role::where(['name' => $value['name']])->first();
            if(empty($Role_added)){
                Role::create($value);
            }
        }
    }
}
