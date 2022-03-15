<?php

use Illuminate\Database\Seeder;

class PriceSetting extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('price_settings')->count() < 1 ){
            DB::table('price_settings')->insert([
                ['price_type' => '1', 'rang'=>'0-50', 'price_extension'=>'20','created_at'=> date('Y-m-d H:i:s')],
                ['price_type' => '1', 'rang'=>'51-100', 'price_extension'=>'30','created_at'=> date('Y-m-d H:i:s')],
                ['price_type' => '1', 'rang'=>'101-150', 'price_extension'=>'40','created_at'=> date('Y-m-d H:i:s')],

                ['price_type' => '2', 'rang'=>'0-50', 'price_extension'=>'50','created_at'=> date('Y-m-d H:i:s')],
                ['price_type' => '2', 'rang'=>'51-100', 'price_extension'=>'60','created_at'=> date('Y-m-d H:i:s')],
                ['price_type' => '2', 'rang'=>'101-150', 'price_extension'=>'70','created_at'=> date('Y-m-d H:i:s')],

                ['price_type' => '3', 'rang'=>'0-50', 'price_extension'=>'80','created_at'=> date('Y-m-d H:i:s')],
                ['price_type' => '3', 'rang'=>'51-100', 'price_extension'=>'90','created_at'=> date('Y-m-d H:i:s')],
                ['price_type' => '3', 'rang'=>'101-150', 'price_extension'=>'100','created_at'=> date('Y-m-d H:i:s')],

                
            ],);
        }
    }
}
