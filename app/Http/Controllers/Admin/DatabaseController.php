<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DataBase;
class DatabaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataBase()
    {
        $dataBases=DataBase::all();
        return view('admin/database',['dataBases'=>$dataBases]);
    }
    public function dataBaseEdit($id)
    {
        $dataBase = DataBase::find($id);

        return view('admin/databaseEdit',['dataBase'=>$dataBase]);
    }
    public function dataBaseEditOk(Request $request){
        $info['status']=1;
        $this->validate($request, [
            'id' => 'required',
            'username' => 'required',
            'password' => 'required',
            'url' => 'required'
        ]);
        $dataBase = DataBase::find($request->get('id'));
        $dataBase->username = $request->get('username');
        if($request->get('password')=="null"){
            $dataBase->password = "";
        }else{
            $dataBase->password = $request->get('password');
        }
        $dataBase->url = $request->get('url');

        if ($dataBase->save()) {
            return json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！!!');
        }  
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
