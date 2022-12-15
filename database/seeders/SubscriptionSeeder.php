<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = ['Basic','Standart','Premium'];
        $prices = ['0','5','10'];
        $data = array('Basic'=>'0','Standart'=>'5','Premium'=>'10');
        
        foreach($data as $article=>$price){
            Subscription::create(['article'=>$article,'price'=>$price]);
        }
    }
}
