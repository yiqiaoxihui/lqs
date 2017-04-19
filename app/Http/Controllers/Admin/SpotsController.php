<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Spotsyk;
class SpotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
/***********************************景区游客统计******************************************/
    public function spotsYk()
    {
        $spotsYks = Spotsyk::orderBy('day', 'desc')->paginate(6);
        return view('admin/spotsYk',['spotsYks'=>$spotsYks]);
    }

    public function spotsYkAdd(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'day' => 'required',
            'spotsname' => 'required',
            'number' => 'required'
        ]);
        $spotsYk = new Spotsyk;
        $spotsYk->day = $request->get('day');
        $spotsYk->spotsname = $request->get('spotsname');
        $spotsYk->number = $request->get('number');

        if ($spotsYk->save()) {
            return json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！!!');
        }    
    }
    public function spotsYkEdit($id)
    {
        $spotsYk = Spotsyk::find($id);

        return view('admin/spotsYkEdit',['spotsYk'=>$spotsYk]);
    }
    public function spotsYkEditOk(Request $request)
    {
        $this->validate($request, [
            'day' => 'required',
            'spotsname' => 'required',
            'number' => 'required'
        ]);
        $info['status']=1;
        $spotsYk = Spotsyk::find($request->get('id'));
        $spotsYk->day = $request->get('day');
        $spotsYk->spotsname = $request->get('spotsname');
        $spotsYk->number = $request->get('number');
        if ($spotsYk->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('修改失败!!!');
        }
        
    }
    public function index()
    {
        //
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
