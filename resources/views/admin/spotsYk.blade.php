@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>景区游客统计</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>年份</th>
                    <th>景点</th>
                    <th>人数</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($spotsYks as $spotsYk)
                <tr>
                    <td >{{$spotsYk->id}}</td>
                    <td >{{$spotsYk->day}}</td>
                    <td >{{$spotsYk->spotsname}}</td>
                    <td >{{$spotsYk->number}}</td>
                    <td >
                        <button class="btn btn-default"type="button" onclick="spotYkEdit({{$spotsYk->id}})">修改</button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td ><div style="margin-top:5px;">添加:</div></td>
                    <td ><input type="text" class="form-control" id="spotsYkDate" placeholder="请输入日期" ></td>
                    <td ><input type="text" class="form-control" id="spotsname" placeholder="请输入景点"></td>
                    <td ><input type="text" class="form-control" id="number" placeholder="请输入人数"></td>
                    <td >
                        <button class="btn btn-default" type="button" onclick="addone()">添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $spotsYks->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function addone(){
        
        var day=document.getElementById('spotsYkDate').value;
        var number=document.getElementById('number').value;
        var spotsname=document.getElementById('spotsname').value;
        //console.log(year);
        $.ajax({
            type: 'post',
            url : "{{url("spots/spotsYkAdd")}}",
            data : {"day":day,"number":number,"spotsname":spotsname},
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

    function spotYkEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['300px', '500px'],
          fix: false, //不固定
          maxmin: true,
          content: 'spotsYkEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
</script>