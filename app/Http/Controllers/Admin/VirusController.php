<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Virus;
use App\VirusKill;
class VirusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function virus()
    {
        $viruses=Virus::orderBy('id','asc')->paginate(9);
        return view('admin/virus',['viruses'=>$viruses]);
    }
    public function virusAdd(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
            'hash' => 'required'
        ]);
        $virus = new Virus;
        $virus->code = $request->get('code');
        $virus->name = $request->get('name');
        $virus->hash = $request->get('hash');

        if ($virus->save()) {
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
    public function virusEdit($id)
    {
        $virus = Virus::find($id);

        return view('admin/virusEdit',['virus'=>$virus]);
    }
    public function virusEditOk(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'code' => 'required',
            'name' => 'required',
            'hash' => 'required'
        ]);
        $info['status']=1;
        $virus = Virus::find($request->get('id'));
        $virus->code = $request->get('code');
        $virus->name = $request->get('name');
        $virus->hash = $request->get('hash');
        if ($virus->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('修改失败!!!');
        }
        
    }
    public function virusDelete(Request $request){
        $info['status']=1;
        Virus::destroy($request->get('id'));
        return json_encode($info);
    }
    public function virusRecord()
    {
        $virusRecords=virusKill::orderBy('id','asc')->paginate(9);
        return view('admin/virusRecord',['virusRecords'=>$virusRecords]);
    }
    public function virusRecordDelete(Request $request){
        $info['status']=1;
        VirusKill::destroy($request->get('id'));
        return json_encode($info);
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
