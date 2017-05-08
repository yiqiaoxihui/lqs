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
use App\FileRestore;
use App\FileRestoreRecord;
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
    //var $fileRestoreRecord_count=0;
    /********************************收入来源**********************************/
    public function fileInfo()
    {
        //$incomeSources=Incomesource::Orderby('year','desc')->paginate(7);
        $files=File::Orderby('overlayId','asc')->paginate(9);
        $overlays=Overlay::Orderby('id','asc')->select('id','name')->get();
        $servers=Server::select("id","name")->get();
        //$fileRestoreRecord_count=FileRestoreRecord::where('message','0')->count();
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
    public function fileRestoreInfo(){
        $fileRestores=FileRestore::Orderby('created_at','desc')->paginate(9);
        return view("admin/fileRestore",['fileRestores'=>$fileRestores]);
    }
    public function fileRestore(Request $request){
        $info['status']=1;
        $this->validate($request, [
            'id' => 'required',
        ]);
        $file=File::find($request->get('id'));
        $file->restore=1;
        $fileRestore=new FileRestore;
        $fileRestore->fileId=$request->get('id');
        if($file->isModified==1){
            $fileRestore->restoreReason=1;
        }
        if($file->lost==1){
            $fileRestore->restoreReason=2;
        }
        if($file->isModified==1 && $file->lost==1){
            $fileRestore->restoreReason=3;
        }
        $fileRestore->restoreStatus=0;
        if($file->save() && $fileRestore->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors('fileRestore failed!');
        }
        
    }
    public function fileRestoreCancel(Request $request){
        $info['status']=1;
        $this->validate($request, [
            'id' => 'required',
        ]);
        $file=File::find($request->get('id'));
        $file->restore=0;
        FileRestore::destroy($file->fileRestore->id);
        //$fileRestore=FileRestore::where("fileId",$file->id)
        if($file->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors('fileRestoreCancel failed!');
        }
    }
    public function fileReset(Request $request){
        $info['status']=1;
        $this->validate($request, [
            'id' => 'required',
        ]);
        $file=File::find($request->get('id'));
        $file->restore=0;
        $file->isModified=0;
        $file->lost=0;
        //$fileRestore=FileRestore::where("fileId",$file->id)
        if($file->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors('fileReset failed!');
        }
    }
    public function fileRestoreRecord()
    {
        $fileRestoreRecords=fileRestoreRecord::Orderby('created_at','desc')->paginate(9);
        return view("admin/fileRestoreRecord",['fileRestoreRecords'=>$fileRestoreRecords]);
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
