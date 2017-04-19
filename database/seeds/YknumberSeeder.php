<?php

use Illuminate\Database\Seeder;

class YknumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('yknumbers')->delete();

	    for ($i=1; $i < 13; $i++) {
	    	$n=rand(23,1000);
	    	$t=rand(23,1000);
	    	$j=rand(100,1000);
	        \App\Yknumber::create([
	            'month'     => "2016-".$i."-1",
	            'number'    =>$n,
	            'team'      =>$t,
	            'individual'=> $j,
	        ]);
	    }
    }
}
