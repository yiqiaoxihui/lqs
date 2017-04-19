@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>当前监控节点</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>节点名称</th>
                    <th>服务器编号</th>
                    <th>IP</th>
                    <th>URL</th>
                    <th>监控时间</th>
                    <th>虚拟机数量</th>
                    <th>增量虚拟机数量</th>
                    <th>监控状态</th>
                    <th>管理操作</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($servers as $server)
                <tr>
                    <td >{{$server->id}}</td>
                    <td>{{$server->name}}</td>
                    <td>{{$server->serverNumber}}</td>
                    <td>{{$server->IP}}</td>
                    <td>{{$server->address}}</td>
                    <td >{{$server->created_at}}</td>
                    <td >{{count($server->baseImages)}}</td>
                    <td >{{count($server->overlays)}}</td>
                    <td>
                    @if($server->status===1)
                    监控中
                    @elseif($server->status===0)
                    已停止
                    @else
                    故障
                    @endif
                    </td>

                    <td >
                        
                    @if($server->status===1)
                    <button type="button" class="btn btn-danger">停止</button>
                    @else
                     <button type="button" class="btn btn-success">启动</button>
                    @endif
                        <button class="btn btn-default"type="button" onclick="yktrendEdit({{$server->id}})">修改
                        </button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td >添加</td>
                    <td ><input type="text" id="name" style="height:34px;" placeholder="请输入节点名称"></td>
                    <td>
                        <input type="text" class="form-control" id="serverNumber" placeholder="请输入服务器编号">
                    </td>
                    <td ><input type="text" class="form-control" id="ip" placeholder="请输入IP"></td>
                    <td><input type="text" class="form-control" id="address" placeholder="请输入URL"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td >
                        <button class="btn btn-default" type="button" onclick="addone()"id="pid" >添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $servers->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    // var myDate = new Date();
    // var nowdate=myDate.getFullYear()+'-'+(myDate.getMonth()+1)+'-'+myDate.getDate();
    // console.log(nowdate);
    // document.getElementById("datetimepicker").value=nowdate;
    function addone(){
        var ydate=document.getElementById('datetimepicker').value;
        var number=document.getElementById('number').value;
        console.log(ydate);
        $.ajax({
            type: 'post',
            url : "admin/addYktrend",
            data : {"ydate":ydate,"number":number},
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
    function yktrendEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['300px', '500px'],
          fix: false, //不固定
          maxmin: true,
          content: 'admin/yktrendEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
</script>