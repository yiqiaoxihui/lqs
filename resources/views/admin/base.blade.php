@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>基础镜像管理</h2>
    <div class="table-outline">
<table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>名称</th>
                    <th>服务器</th>
                    <th>镜像路径</th>
                    <th>创建时间</th>
                    <th>状态</th>
                    <th>增量镜像个数</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($baseImages as $baseImage)
                <tr>
                    <td >{{$baseImage->id}}</td>
                    <td >{{$baseImage->name}}</td>
                    <td >{{$baseImage->server->name}}</td>
                    <td >{{$baseImage->absPath}}</td>
                    <td >{{$baseImage->created_at}}</td>
                    <td >
                        @if($baseImage->status===1)
                        正常
                        @elseif($baseImage->status===0)
                        停止监测
                        @else
                        镜像故障
                        @endif
                    </td>
                    <td >
                        @if(count($baseImage->overlays)>0)
                        <a href="{{url("image/overlay")}}">{{count($baseImage->overlays)}}</a>
                        @else
                        {{count($baseImage->overlays)}}
                        @endif
                    </td>
                    <td >
                        @if($baseImage->status===1)
                        <button class="btn btn-warning"type="button" onclick="baseStop({{$baseImage->id}})">停止
                        </button>
                        @elseif($baseImage->status===0)
                        <button class="btn btn-info"type="button" onclick="baseStart({{$baseImage->id}})">启动</button>
                        @else
                        @endif

                        
                        <button class="btn btn-primary"type="button" onclick="baseEdit({{$baseImage->id}})">修改
                        </button>
                        <button class="btn btn-danger"type="button" onclick="baseDelete({{$baseImage->id}})">删除
                        </button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td ><div style="margin-top:5px;">添加:</div></td>
                    <td ><input type="text" class="form-control" id="name" placeholder="请输入名称" ></td>
                    <td >
                        <select class="form-control" id="server_select">
                        @foreach ($servers as $server)
                            <option value="{{$server->id}}">{{$server->id}}-{{$server->name}}</option>
                        @endforeach
                        </select>
                    </td>
                    <td ><input type="text" class="form-control" id="absPath" placeholder="请输入镜像路径"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td >
                        <button class="btn btn-success" type="button" onclick="addone()">添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $baseImages->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function addone(){
        var name=document.getElementById('name').value;
        var server_id=$('#server_select option:selected').val();
        var absPath=document.getElementById('absPath').value;
        console.log(server_id);
        $.ajax({
            type: 'post',
            url : "{{url("compare/baseAdd")}}",
            data : {"name":name,"server_id":server_id,"absPath":absPath},
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

    function baseEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['400px', '600px'],
          fix: false, //不固定
          maxmin: true,
          content: 'baseEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
    function Delete(id){
            $.ajax({
                type: 'post',
                url : "{{url("compare/baseDelete")}}",
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
    function baseDelete(id){
        layer.msg('删除后关联增量镜像也会被删除，确定删除？', {
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
    function baseStop(id){
        $.ajax({
            type: 'post',
            url : "{{url("compare/baseStop")}}",
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
    function baseStart(id){
        $.ajax({
            type: 'post',
            url : "{{url("compare/baseStart")}}",
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