<?php

use Illuminate\Database\Seeder;

class IncomesourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('incomesources')->delete();
        $banks=array("中国银行","中国建设银行","中国工商银行","中国邮政储蓄银行","中国招商银行","支付宝","现金");
        $years=array("2010","2011","2012","2013","2014","2015");
        foreach($years as $year){
	        foreach ($banks as $bank) {
		    	$t=rand(30,100);
		        \App\Incomesource::create([
		            'year'     => $year,
		            'bank'    =>$bank,
		            'money'   =>$t
		        ]);
		    }
        }
    }
}
