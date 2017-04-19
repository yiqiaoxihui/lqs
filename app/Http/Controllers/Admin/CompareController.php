<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ykcompare;
use App\Incomecompare;
use App\BaseImage;
use App\Server;
//use App\Overlay;
class CompareController extends Controller
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
    public function ykCompare()
    {
        //$ykcompares = Ykcompare::Orderby('year','desc')->Orderby('month','asc')->paginate(6);
        $baseImages=BaseImage::Orderby('created_at','asc')->paginate(5);
        $servers=Server::Orderby('id','desc')->get();
        return view('admin/ykCompare',['baseImages'=>$baseImages,'servers'=>$servers]);
    }
    public function ykCompareAdd(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'year' => 'required',
            'month' => 'required',
            'number' => 'required',
        ]);

        $ykcompare = new Ykcompare;
        $ykcompare->year = $request->get('year');
        $ykcompare->month = $request->get('month');
        $ykcompare->number = $request->get('number');

        if ($ykcompare->save()) {
            return json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！!!');
        }
    }
    public function ykCompareEdit($id)
    {
        $ykcompare = Ykcompare::find($id);

        return view('admin/ykCompareEdit',['ykcompare'=>$ykcompare]);
    }

    public function ykCompareEditOk(Request $request)
    {
        $this->validate($request, [
            'year' => 'required',
            'month' => 'required',
            'number' => 'required',
        ]);
        $info['status']=1;
        $ykcompare = Ykcompare::find($request->get('id'));
        $ykcompare->year = $request->get('year');
        $ykcompare->month = $request->get('month');
        $ykcompare->number = $request->get('number');

        if ($ykcompare->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('修改失败!!!');
        }
        
    }
/********************************收入同期比******************************************/
    public function incomeCompare()
    {
        //$incomecompares = Incomecompare::Orderby('year','desc')->Orderby('month','asc')->paginate(12);
        $overlays=\App\Overlay::Orderby('id','asc')->paginate(5);
        $baseimages=\App\BaseImage::Orderby('id','desc')->get();
        return view('admin/incomeCompare',['overlays'=>$overlays,'baseimages'=>$baseimages]);
    }
    public function incomeCompareAdd(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'year' => 'required',
            'month' => 'required',
            'money' => 'required'
        ]);

        $incomecompare = new Incomecompare;
        $incomecompare->year = $request->get('year');
        $incomecompare->month = $request->get('month');
        $incomecompare->money = $request->get('money');

        if ($incomecompare->save()) {
            return json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！!!');
        }
    }
    public function incomeCompareEdit($id)
    {
        $incomecompare = Incomecompare::find($id);

        return view('admin/incomeCompareEdit',['incomecompare'=>$incomecompare]);
    }

    public function incomeCompareEditOk(Request $request)
    {
        $this->validate($request, [
            'year' => 'required',
            'month' => 'required',
            'money' => 'required',
        ]);
        $info['status']=1;
        $incomecompare = Incomecompare::find($request->get('id'));
        $incomecompare->year = $request->get('year');
        $incomecompare->month = $request->get('month');
        $incomecompare->money = $request->get('money');

        if ($incomecompare->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('修改失败!!!');
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
