<?php

use Illuminate\Database\Seeder;

class YkcompareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ykcompares')->delete();
        $years=array("2010","2011","2012","2013","2014","2015");
        foreach($years as $year){
	        for ($i=1; $i < 13; $i++) {
		    	$t=rand(8000,29000);
		        \App\Ykcompare::create([
		            'year'     => $year,
		            'month'    =>$i,
		            'number'   =>$t
		        ]);
		    }
        }
    }
}
