@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>游客客源地统计</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>年份</th>
                    <th>省份</th>
                    <th>人数</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($yksources as $yksource)
                <tr>
                    <td >{{$yksource->id}}</td>
                    <td >{{$yksource->year}}</td>
                    <td >{{$yksource->province}}</td>
                    <td >{{$yksource->number}}</td>
                    <td >
                        <button class="btn btn-default"type="button" onclick="ykSourceEdit({{$yksource->id}})">修改</button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td ><div style="margin-top:5px;">添加:</div></td>
                    <td ><input type="text" class="form-control" id="year" placeholder="请输入年份" ></td>
                    <td ><input type="text" class="form-control" id="province" placeholder="请输入省份"></td>
                    <td ><input type="text" class="form-control" id="number" placeholder="请输入人数"></td>
                    <td >
                        <button class="btn btn-default" type="button" onclick="addone()">添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $yksources->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    // var myDate = new Date();
    // var nowdate=myDate.getFullYear()+'-'+(myDate.getMonth()+1)+'-'+myDate.getDate();
    // console.log(nowdate);
    // document.getElementById("datetimepicker").value=nowdate;
    function addone(){
        var year=document.getElementById('year').value;
        var number=document.getElementById('number').value;
        var province=document.getElementById('province').value;
        console.log(year);
        $.ajax({
            type: 'post',
            url : "{{url("admin/ykSourceAdd")}}",
            data : {"year":year,"number":number,"province":province},
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

    function ykSourceEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['300px', '500px'],
          fix: false, //不固定
          maxmin: true,
          content: 'ykSourceEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
</script>