<?php

namespace App\Http\Controllers\Admin;
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
        
    }
    /********************************收入来源**********************************/
    public function incomeSource()
    {
        $incomeSources=Incomesource::Orderby('year','desc')->paginate(7);
        return view('admin/incomeSource',['incomeSources'=>$incomeSources]);
    }
    public function incomeSourceAdd(Request $request)
    {
        $info['status']=1;
        $this->validate($request, [
            'year' => 'required',
            'bank' => 'required',
            'money' => 'required',
        ]);

        $incomeSource = new Incomesource;
        $incomeSource->year = $request->get('year');
        $incomeSource->bank = $request->get('bank');
        $incomeSource->money = $request->get('money');

        if ($incomeSource->save()) {
            return json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('保存失败！!!');
        }
    }
    public function incomeSourceEdit($id)
    {
        $incomeSource = Incomesource::find($id);

        return view('admin/incomeSourceEdit',['incomeSource'=>$incomeSource]);
    }
    public function incomeSourceEditOk(Request $request)
    {
        $this->validate($request, [
            'year' => 'required',
            'bank' => 'required',
            'money' => 'required',
        ]);
        $info['status']=1;
        $incomeSource = Incomesource::find($request->get('id'));
        $incomeSource->year = $request->get('year');
        $incomeSource->bank = $request->get('bank');
        $incomeSource->money = $request->get('money');

        if ($incomeSource->save()) {
            return  json_encode($info);
        } else {
            return Redirect::back()->withInput()->withErrors('修改失败!!!');
        }
        
    }
    /********************************收入总计**********************************/
    public function incomeSum()
    {
        $incomeSums=Incomesum::Orderby('year','desc')->paginate(7);
        return view('admin/incomeSum',['incomeSums'=>$incomeSums]);
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
    public function incomeAccumulate()
    {
        $incomeAccumulate=Incomeaccumulate::find(1);
        return view('admin/incomeAccumulate',['incomeAccumulate'=>$incomeAccumulate]);
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
