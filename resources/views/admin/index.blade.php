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
                    <button type="button" class="btn btn-danger" onclick="serverStop({{$server->id}})">停止</button>
                    @else
                     <button type="button" class="btn btn-success" onclick="serverStart({{$server->id}})">启动</button>
                    @endif
                        <button class="btn btn-default"type="button" onclick="serverEdit({{$server->id}})">修改
                        </button>
                        <button class="btn btn-danger"type="button" onclick="serverDelete({{$server->id}})">删除
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
                    <td ><input type="text" class="form-control" id="IP" placeholder="请输入IP"></td>
                    <td><input type="text" class="form-control" id="address" placeholder="请输入URL"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td >
                        <button class="btn btn-default" type="button" onclick="addone()" id="pid" >添加</button>
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
        var name=document.getElementById('name').value;
        var serverNumber=document.getElementById('serverNumber').value;
        var address=document.getElementById('address').value;
        var IP=document.getElementById('IP').value;
        console.log(name);
        $.ajax({
            type: 'post',
            url : "admin/addServer",
            data : {"name":name,"serverNumber":serverNumber,"address":address,"IP":IP},
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
                // var str=err.responseText;
                // var obj=JSON.parse(str);
                // console.log(obj);
                // console.log(obj.name[0]);
                // console.log(err);
                var obj_json=err.responseJSON;
                //console.log(obj_json.name[0]);
                for(key in obj_json){
                    var id="#"+key;
                    layer.tips(obj_json[key], id, {
                      tips: 3,
                      tipsMore: true,
                      time: 5000,
                    });
                    console.log(id+":"+obj_json[key]);
                }
                layer.msg('请按要求输入！');
            }

        });
        // for(key in response){
        //     console.log(key+":"+response[key]);
        // }
    }
    function serverEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['500px', '800px'],
          fix: false, //不固定
          maxmin: true,
          content: 'admin/serverEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
    function Delete(id){
            $.ajax({
                type: 'post',
                url : "admin/serverDelete",
                data : {"id":id},
                dataType:'JSON', 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success : function(data) {
                   if(data.status==1){
                        layer.msg("删除成功！");
                        location.reload(true);
                   }
                },
                error : function(err) {
                    layer.msg('删除失败！');
                }

            });
    }
    function serverDelete(id){
        layer.msg('删除后该节点镜像也会被删除，确定删除？', {
          time: 0 //不自动关闭
          ,btn: ['删除', '取消']
          ,yes: function(index){
            Delete(id);
            layer.close(index);
            // layer.msg('删除成功！', {
            //   icon: 6
            //   ,btn: ['关闭']
            // });
          }
        });
    }
    function serverStop(id){
        $.ajax({
            type: 'post',
            url : "admin/serverStop",
            data : {"id":id},
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    layer.msg("停止成功！");
                    location.reload(true);
               }
            },
            error : function(err) {
                layer.msg('停止失败！');
            }

        });
    }
    function serverStart(id){
        $.ajax({
            type: 'post',
            url : "admin/serverStart",
            data : {"id":id},
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    layer.msg("启动成功！");
                    location.reload(true);
               }
            },
            error : function(err) {
                layer.msg('启动失败！');
            }

        });
    }
</script>