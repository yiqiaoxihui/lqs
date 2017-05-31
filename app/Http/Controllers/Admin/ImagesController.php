<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ykcompare;
use App\Incomecompare;
use App\BaseImage;
use App\Server;
use App\Overlay;
use App\FileScanRecord;
use DB;
class ImagesController extends Controller
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
    /********************************游客同期比******************************************/
    public function base()
    {
        //$ykcompares = Ykcompare::Orderby('year','desc')->Orderby('month','asc')->paginate(6);
        $baseImages=BaseImage::Orderby('created_at','asc')->paginate(5);
        //echo $baseImages[0]->server->name;
        $servers=Server::Orderby('id','desc')->get();
        return view('admin/base',['baseImages'=>$baseImages,'servers'=>$servers]);
    }
    public function baseAdd(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'name' => 'required|max:255',
            'absPath' => 'required|max:255',
        ]);
        $baseImage = new BaseImage;
        $baseImage->name = $request->get('name');
        $baseImage->absPath = $request->get('absPath');
        $baseImage->server_id = $request->get('server_id');

        if ($baseImage->save()) {
            return json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！!!');
        }
    }
    public function baseEdit($id)
    {
        $baseImage = BaseImage::find($id);
        $servers=Server::select('name','id')->get();
        return view('admin/baseEdit',['baseImage'=>$baseImage,'servers'=>$servers]);
    }

    public function baseEditOk(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'absPath' => 'required|max:255',
        ]);
        $info['status']=1;
        $baseImage = BaseImage::find($request->get('id'));
        $baseImage->name = $request->get('name');
        $baseImage->absPath = $request->get('absPath');
        $baseImage->server_id = $request->get('server_id');
        $baseImage->status=0;
        if ($baseImage->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('修改失败!!!');
        }
        
    }
    public function baseDelete(Request $request){
        $info['status']=1;
        BaseImage::destroy($request->get('id'));
        
        //echo $status;
        return json_encode($info);
    }
    public function baseStart(Request $request){
        $info['status']=1;
        $baseImage=BaseImage::find($request->get('id'));
        $baseImage->status=1;
        if($baseImage->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors("server start failed!");
        }
    }
    public function baseStop(Request $request){
        $info['status']=1;
        $baseImage=BaseImage::find($request->get('id'));
        $baseImage->status=0;
        if($baseImage->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors("server start failed!");
        }
    }
/********************************收入同期比******************************************/
    public function overlayChoose($base_id)
    {
        //echo $base_id;
        $id=$base_id;
        //echo $id;
        // $overlays=DB::table('overlays')->join('baseImages', function ($join) {
        //     $join->on('baseImages.id', '=', 'overlays.baseImageId')
        //          ->where('baseImages.id','$id');
        // })->paginate(9);
/*        $overlays=DB::table('overlays')->join('baseImages','overlays.baseImageId','=','baseImages.id')->where('baseImages.id',$id)->paginate(9);*/
        $overlays=\App\Overlay::where('baseImageId',$id)->paginate(9);
        $baseimages=\App\BaseImage::Orderby('id','desc')->get();
        $servers=Server::select('name','id')->get();
        return view('admin/overlayInfo',['overlays'=>$overlays,'baseimages'=>$baseimages,'servers'=>$servers]);
    }
    public function overlay()
    {
        //$incomecompares = Incomecompare::Orderby('year','desc')->Orderby('month','asc')->paginate(12);
        $overlays=Overlay::Orderby('id','asc')->paginate(9);
        $baseimages=\App\BaseImage::Orderby('id','desc')->get();
        $servers=Server::select('name','id')->get();
        return view('admin/overlayInfo',['overlays'=>$overlays,'baseimages'=>$baseimages,'servers'=>$servers]);
    }
    public function getBaseimageByServer(Request $request){
        $server=Server::find($request->get('server_id'));
        $baseimages=$server->baseImages;
        return json_decode($baseimages);
    }
    public function overlayAdd(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'name' => 'required|max:255',
            'absPath' => 'required|max:255',
            'baseImageId' => 'required'
        ]);

        $overlay = new Overlay;
        $overlay->name = $request->get('name');
        $overlay->absPath = $request->get('absPath');
        $overlay->baseImageId = $request->get('baseImageId');
        
        if ($overlay->save()) {
            return json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！!!');
        }
    }
    public function overlayEdit($id)
    {
        $overlay = Overlay::find($id);
        $servers=Server::select('name','id')->get();
        return view('admin/overlayEdit',['overlay'=>$overlay,'servers'=>$servers]);
    }

    public function overlayEditOk(Request $request)
    {
        $this->validate($request, [
            'id'=>'required',
            'name' => 'required|max:255',
            'absPath' => 'required|max:255',
            'baseImageId' => 'required'
        ]);
        $info['status']=1;
        $overlay = Overlay::find($request->get('id'));
        $overlay->name = $request->get('name');
        $overlay->absPath = $request->get('absPath');
        $overlay->baseImageId = $request->get('baseImageId');

        if ($overlay->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('修改失败!!!');
        }
        
    }    
    public function overlayDelete(Request $request){
        $info['status']=1;
        Overlay::destroy($request->get('id'));

        //echo $status;
        return json_encode($info);
    }
    public function overlayStart(Request $request){
        $info['status']=1;
        $overlay=Overlay::find($request->get('id'));
        $overlay->status=1;
        if($overlay->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors("server start failed!");
        }
    }
    public function overlayStop(Request $request){
        $info['status']=1;
        $overlay=Overlay::find($request->get('id'));
        $overlay->status=0;
        if($overlay->save()){
            return json_encode($info);
        }else{
            return Redirect::back()->withInput()->withErrors("server start failed!");
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
