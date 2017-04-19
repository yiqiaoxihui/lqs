@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>总收入统计</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>年份</th>
                    <th>团队</th>
                    <th>散客</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($incomeSums as $incomeSum)
                <tr>
                    <td >{{$incomeSum->id}}</td>
                    <td >{{$incomeSum->year}}年</td>
                    <td >{{$incomeSum->team}}</td>
                    <td >{{$incomeSum->individual}}</td>
                    <td >
                        <button class="btn btn-default"type="button" onclick="incomeSumEdit({{$incomeSum->id}})">修改</button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td ><div style="margin-top:5px;">添加:</div></td>
                    <td ><input type="text" class="form-control" id="year" placeholder="请输入年份" ></td>
                    <td ><input type="text" class="form-control" id="team" placeholder="请输入团队销售额"></td>
                    <td ><input type="text" class="form-control" id="individual" placeholder="请输入散客销售额"></td>
                    <td >
                        <button class="btn btn-default" type="button" onclick="addone()">添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $incomeSums->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function addone(){
        var year=document.getElementById('year').value;
        var team=document.getElementById('team').value;
        var individual=document.getElementById('individual').value;
        console.log(year);
        $.ajax({
            type: 'post',
            url : "{{url("incomeAnalyze/incomeSumAdd")}}",
            data : {"year":year,"team":team,"individual":individual},
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

    function incomeSumEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['400px', '600px'],
          fix: false, //不固定
          maxmin: true,
          content: 'incomeSumEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
</script>