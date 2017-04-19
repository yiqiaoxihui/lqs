<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Incomesource;
use App\Incomeaccumulate;
use App\Incomesum;
class IncomeAnalyzeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function incomeSource()
    {
        $year = Incomesource::max('year');
        $incomesources=Incomesource::where('year',$year)->get();
        $years=DB::table('incomesources')->orderBy('year', 'desc')->distinct()->lists('year');
        return view('home/incomeSource',['incomesources'=>$incomesources,'years'=>$years]); 
    }
    public function yearOfIncomeSource(Request $request){
        $year=$request->get('year');
        $incomesources = Incomesource::where('year',$year)
               ->get();
        return json_encode($incomesources);
    }
    public function incomeSum()
    {
        $lastY=array();
        $thisY=array();
        $years = Incomesum::orderBy('year', 'desc')->lists('year');
        if(count($years)>1){
            $lastYear=$years['1'];
            $thisYear=$years['0'];
        }else if(count($years)==1){
            $lastYear=$years['0'];
            $thisYear=$years['0'];            
        }else{
            return view('home/incomeSum',['lastY'=>$lastY,'thisY'=>$thisY]);
        }
        $lastY=Incomesum::where('year',$lastYear)->get();
        $thisY=Incomesum::where('year',$thisYear)->get();        
        return view('home/incomeSum',['lastY'=>$lastY,'thisY'=>$thisY]);
    }
    public function incomeAccumulate()
    {
        $incomeAccumulate=Incomeaccumulate::find(1);
        return view('home/incomeAccumulate',['incomeAccumulate'=>$incomeAccumulate]);
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
