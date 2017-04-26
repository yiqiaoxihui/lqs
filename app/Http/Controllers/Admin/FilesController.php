<?php

namespace App\Http\Controllers\Admin;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Incomesource;
use App\Incomeaccumulate;
use App\Incomesum;
use App\File;
use App\Overlay;
use App\Server;
use App\BaseImage;
class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
    /********************************收入来源**********************************/
    public function fileInfo()
    {
        //$incomeSources=Incomesource::Orderby('year','desc')->paginate(7);
        $files=File::Orderby('overlayId','asc')->paginate(9);
        $overlays=Overlay::Orderby('id','asc')->select('id','name')->get();
        $servers=Server::select("id","name")->get();
        return view('admin/fileInfo',['files'=>$files,'overlays'=>$overlays,'servers'=>$servers]);
    }
    public function getBaseimageByServer(Request $request){
        $server=Server::find($request->get('server_id'));
        $baseimages=$server->baseImages;
        return json_decode($baseimages);
    }
    public function getOverlayByBase(Request $request){
        $baseImage=BaseImage::find($request->get('base_id'));
        $overlays=$baseImage->overlays;
        return json_decode($overlays);
    }
    public function fileStart(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'id' => 'required',
        ]);
        $file=File::find($request->get('id'));
        $file->status=1;
        if($file->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors('boot failed!');
        }
    }
    
    public function fileStop(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'id' => 'required',
        ]);
        $file=File::find($request->get('id'));
        $file->status=0;
        if($file->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors('stop failed!');
        }
    }
    public function fileAdd(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'absPath' => 'required|max:255',
            'overlayId' => 'required',
        ]);

        $file = new File;
        $file->absPath = $request->get('absPath');
        $file->overlayId = $request->get('overlayId');

        if ($file->save()) {
            return json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！!!');
        }
    }
    public function fileDelete(Request $request){
        $info['status']=1;
        File::destroy($request->get('id'));
        return json_encode($info);
    }
    public function fileEdit($id)
    {
        $file = File::find($id);
        $servers=Server::select("id","name")->get();
        $baseImages=baseImage::select("id","name")->get();
        $overlays=Overlay::select("id","name")->get();
        return view('admin/fileEdit',['file'=>$file,"servers"=>$servers]);
    }
    public function fileEditOk(Request $request)
    {
        $this->validate($request, [
            'id'=>'required',
            'absPath' => 'required|max:255',
            'overlayId' => 'required',
        ]);
        $info['status']=1;
        $file = File::find($request->get('id'));
        $file->absPath = $request->get('absPath');
        $file->overlayId = $request->get('overlayId');

        if ($file->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('修改失败!!!');
        }
        
    }
    /********************************fileRstore**********************************/
    public function fileRestore()
    {
        //TODO
        //$incomeSums=Incomesum::Orderby('year','desc')->paginate(7);
        //return view('admin/fileRestore',['incomeSums'=>$incomeSums]);
    }
    public function incomeSumAdd(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'year' => 'required',
            'team' => 'required',
            'individual' => 'required',
        ]);

        $incomeSum = new Incomesum;
        $incomeSum->year = $request->get('year');
        $incomeSum->team = $request->get('team');
        $incomeSum->individual = $request->get('individual');

        if ($incomeSum->save()) {
            return json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！!!');
        }
    }
    public function incomeSumEdit($id)
    {
        $incomeSum = Incomesum::find($id);

        return view('admin/incomeSumEdit',['incomeSum'=>$incomeSum]);
    }
    public function incomeSumEditOk(Request $request)
    {
        $this->validate($request, [
            'year' => 'required',
            'team' => 'required',
            'individual' => 'required',
        ]);
        $info['status']=1;
        $incomeSum = Incomesum::find($request->get('id'));
        $incomeSum->year = $request->get('year');
        $incomeSum->team = $request->get('team');
        $incomeSum->individual = $request->get('individual');

        if ($incomeSum->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('修改失败!!!');
        }
        
    }
    public function fileRestoreRecord()
    {
        //$incomeAccumulate=Incomeaccumulate::find(1);
        //return view('admin/incomeAccumulate',['incomeAccumulate'=>$incomeAccumulate]);
    }
    public function incomeAccumulateUpdate(Request $request)
    {
        // $this->validate($request, [
        //     'other' => 'required',
        //     'team' => 'required',
        //     'individual' => 'required'
        // ]);
        $info['status']=1;
        $incomeAccumulate = Incomeaccumulate::find($request->get('id'));
        $incomeAccumulate->other = $request->get('other');
        $incomeAccumulate->team = $request->get('team');
        $incomeAccumulate->individual = $request->get('individual');

        if ($incomeAccumulate->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('更新失败!!!');
        }   
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
