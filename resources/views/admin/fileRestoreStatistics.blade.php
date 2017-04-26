@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>游客数量走势图</h2>
    <div class="table-outline">
        <table class="table table-hover">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>日期</th>
                    <th>团队</th>
                    <th>个人</th>
                    <th>管理操作</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($yknumbers as $yknumber)
                <tr>
                    <td >{{$yknumber->id}}</td>
                    <td >{{$yknumber->month}}</td>
                    <td >{{$yknumber->team}}人</td>
                    <td >{{$yknumber->individual}}人</td>
                    <td >
                        <button class="btn btn-default"type="button" onclick="ykNumberTrendEdit({{$yknumber->id}})">修改</button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td >添加</td>
                    <td ><input type="text" id="ykNumberDate" placeholder="请输入日期" ></td>
                    <td ><input type="text" class="form-control" id="team" placeholder="请输入当月团体人数"></td>
                    <td ><input type="text" class="form-control" id="individual" placeholder="请输入当月个人人数"></td>
                    <td >
                        <button class="btn btn-default" type="button" onclick="addone()"id="pid" >添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $yknumbers->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    // var myDate = new Date();
    // var nowdate=myDate.getFullYear()+'-'+(myDate.getMonth()+1)+'-'+myDate.getDate();
    // console.log(nowdate);
    // document.getElementById("datetimepicker").value=nowdate;
    function addone(){
        var month=document.getElementById('ykNumberDate').value;
        var team=document.getElementById('team').value;
        var individual=document.getElementById('individual').value;
        console.log(month);
        $.ajax({
            type: 'post',
            url : "ykNumberAdd",
            data : {"month":month,"team":team,"individual":individual},
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
    function ykNumberTrendEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['300px', '500px'],
          fix: false, //不固定
          maxmin: true,
          content: 'ykNumberEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });
    }
</script>