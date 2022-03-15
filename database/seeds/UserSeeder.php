<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $user = [
            ['role_id' => '1',
            'name' => 'Super Admin',
            'hotel_name'=>'Mayur International',
            'email' => 'superadmin@quytech.com',
            'mobile' => '7488110913',
            'password' => Hash::make('12345678'),
            'address'=> 'Gurugaon',
            'is_verified' =>'1',
            'profile_image' => 'profile.png',
            'is_active' => '1'],

            ['role_id' => '2',
            'name' => 'Admin',
            'hotel_name'=>'Trident International',
            'email' => 'admin@quytech.com',
            'mobile' => '9875514525',
            'password' => Hash::make('12345678'),
            'address'=> 'Gurugaon',
            'is_verified' =>'1',
            'profile_image'=> 'avatar.png',
            'is_active' => '0'],

        ];
        foreach ($user as $key => $value) {
            $User_added = User::where(['email' => $value['email']])->first();
            if(empty($User_added)){
                User::create($value);
            }
        }
    }
}
