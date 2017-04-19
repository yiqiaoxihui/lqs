@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>收入来源统计</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>年份</th>
                    <th>支付方式</th>
                    <th>金额</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($incomeSources as $incomeSource)
                <tr>
                    <td >{{$incomeSource->id}}</td>
                    <td >{{$incomeSource->year}}年</td>
                    <td >{{$incomeSource->bank}}</td>
                    <td >{{$incomeSource->money}}万元</td>
                    <td >
                        <button class="btn btn-default"type="button" onclick="incomeSourceEdit({{$incomeSource->id}})">修改</button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td ><div style="margin-top:5px;">添加:</div></td>
                    <td ><input type="text" class="form-control" id="year" placeholder="请输入年份" ></td>
                    <td ><input type="text" class="form-control" id="bank" placeholder="请输入支付方式"></td>
                    <td ><input type="text" class="form-control" id="money" placeholder="请输入金额"></td>
                    <td >
                        <button class="btn btn-default" type="button" onclick="addone()">添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $incomeSources->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function addone(){
        var year=document.getElementById('year').value;
        var bank=document.getElementById('bank').value;
        var money=document.getElementById('money').value;
        console.log(year);
        $.ajax({
            type: 'post',
            url : "{{url("incomeAnalyze/incomeSourceAdd")}}",
            data : {"year":year,"bank":bank,"money":money},
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    layer.msg("添加成功！");
                    location.reload(true);
               }
            },
            error : function(err) {
                layer.msg('请按要求输入！');
            }
        });
    }

    function incomeSourceEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['400px', '500px'],
          fix: false, //不固定
          maxmin: true,
          content: 'incomeSourceEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
</script>