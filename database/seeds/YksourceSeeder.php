<?php

use Illuminate\Database\Seeder;

class YksourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('yksources')->delete();
    	$province=array("上海市","河北省","山西省","辽宁省","吉林省","黑龙江省","江苏省","浙江省","安徽省","福建省","江西省");
        
        $years=array("2010","2011","2012","2013","2014","2015");
        foreach($years as $year){
	        for ($i=1; $i < 11; $i++) {
		    	$t=rand(23,1000);
		        \App\Yksource::create([
		            'year'     => $year,
		            'province'    =>$province[$i],
		            'number'      =>$t
		        ]);
		    }
        }

    }
}
