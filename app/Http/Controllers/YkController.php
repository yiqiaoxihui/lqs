<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Yktrend;
use App\Yknumber;
use App\Yktype;
use App\Yksource;
class YkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function home()
    {
        return view("welcome");
    }
    public function index()
    {
        $yktrends = Yktrend::orderBy('ydate', 'desc')
               ->take(7)
               ->get();
        return view('home/index',['yktrends'=>$yktrends]);
    }

    public function ykNumber()
    {
        $yknumbers = Yknumber::orderBy('month', 'desc')
               ->take(12)
               ->get();
        return view('home/ykNumberTrend',['yknumbers'=>$yknumbers]);
    }
    public function ykType(){
        $yktype = Yktype::orderBy('year', 'desc')
               ->take(1)
               ->get();
        $years=DB::table('yktypes')->orderBy('year', 'desc')->lists('year');
        return view('home/yktype',['yktype'=>$yktype,'years'=>$years]);
    }
    //根据年份返回游客类型记录
    public function yearOfyktype(Request $request){
        $year=$request->get('year');
        $yktype = Yktype::where('year',$year)
               ->get();
        return json_encode($yktype);
    }

    //游客客源地分析
    public function ykSource()
    {
        $year = Yksource::max('year');
        $yksources=Yksource::where('year',$year)->get();
        $years=DB::table('yksources')->orderBy('year', 'desc')->distinct()->lists('year');
        return view('home/yksource',['yksources'=>$yksources,'years'=>$years]);    
    }

    //根据年份返回游客客源地分析
    public function yearOfyksource(Request $request){
        $year=$request->get('year');
        $yktype = Yksource::where('year',$year)
               ->get();
        return json_encode($yktype);
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
