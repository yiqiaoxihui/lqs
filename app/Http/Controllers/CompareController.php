<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Ykcompare;
use App\Incomecompare;
class CompareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }
    public function pepCompare()
    {
        $lastY=array();
        $thisY=array();
        $goodyears=array();
        $years = Ykcompare::orderBy('year', 'desc')->distinct()->lists('year');

        for($i=0;$i<count($years)-1;$i++){
            $goodyears[$i]=$years[$i];
        }
        if(count($years)>1){
            $lastYear=$years['1'];
            $thisYear=$years['0'];
        }else if(count($years)==1){
            $lastYear=$years['0'];
            $thisYear=$years['0'];            
        }else{
            return view('home/ykCompare',['lastY'=>$lastY,'thisY'=>$thisY]);
        }
        $years = Ykcompare::orderBy('year', 'desc')->distinct()->lists('year');
        //按月份升序排列
        $lastY=Ykcompare::where('year',$lastYear)->orderBy('month','asc')->get();
        $thisY=Ykcompare::where('year',$thisYear)->orderBy('month','asc')->get();        
        return view('home/ykCompare',['lastY'=>$lastY,'thisY'=>$thisY,'years'=>$goodyears]);
    }
    public function yearOfYkCompare(Request $request){
        //$miniyear=Ykcompare::min('year');
        $thisYear=$request->get('year');
        $lastYear=$thisYear-1;
        $lastY=array();
        $thisY=array();
        $twoYear=array();
        $lastY=Ykcompare::where('year',$lastYear)->orderBy('month','asc')->get();
        $thisY=Ykcompare::where('year',$thisYear)->orderBy('month','asc')->get();  
        $twoYear['lastY']=$lastY;
        $twoYear['thisY']=$thisY;  
        return json_encode($twoYear);
    }
    public function incomeCompare()
    {
        $lastY=array();
        $thisY=array();
        $goodyears=array();
        $years = Incomecompare::orderBy('year', 'desc')->distinct()->lists('year');

        for($i=0;$i<count($years)-1;$i++){
            $goodyears[$i]=$years[$i];
        }
        if(count($years)>1){
            $lastYear=$years['0'];
            $thisYear=$years['1'];
        }else if(count($years)==1){
            $lastYear=$years['0'];
            $thisYear=$years['0'];            
        }else{
            return view('home/incomeCompare',['lastY'=>$lastY,'thisY'=>$thisY]);
        }
        $lastY=Incomecompare::where('year',$lastYear)->orderBy('month','asc')->get();
        $thisY=Incomecompare::where('year',$thisYear)->orderBy('month','asc')->get();        
        return view('home/incomeCompare',['lastY'=>$lastY,'thisY'=>$thisY,'years'=>$goodyears]);
    }
    public function yearOfIncomeCompare(Request $request){
        $thisYear=$request->get('year');
        $lastYear=$thisYear-1;
        $lastY=array();
        $thisY=array();
        $twoYear=array();
        $lastY=Incomecompare::where('year',$lastYear)->orderBy('month','asc')->get();
        $thisY=Incomecompare::where('year',$thisYear)->orderBy('month','asc')->get();  
        $twoYear['lastY']=$lastY;
        $twoYear['thisY']=$thisY;  
        return json_encode($twoYear);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
