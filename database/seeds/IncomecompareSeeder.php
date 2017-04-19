<?php

use Illuminate\Database\Seeder;

class IncomecompareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('incomecompares')->delete();
        $years=array("2010","2011","2012","2013","2014","2015");
        foreach($years as $year){
	        for ($i=1; $i < 13; $i++) {
		    	$t=rand(1000,3000);
		        \App\Incomecompare::create([
		            'year'     => $year,
		            'month'    =>$i,
		            'money'   =>$t
		        ]);
		    }
        }
    }
}
