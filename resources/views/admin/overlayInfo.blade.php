@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>增量镜像管理</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>名称</th>
                    <th>镜像路径</th>
                    <th>创建时间</th>
                    <th>状态</th>
                    <th>服务器</th>
                    <th>原始镜像</th>
                    <th>文件数量</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($overlays as $overlay)
                <tr>
                    <td >{{$overlay->id}}</td>
                    <td >{{$overlay->name}}</td>
                    
                    <td >{{$overlay->absPath}}</td>
                    <td >{{$overlay->created_at}}</td>
                    <td >
                        @if($overlay->status===1)
                        <span style="color: #5cb85c">正常</span>
                        @elseif($overlay->status===0)
                        <span style="color: #5bc0de">停止监测</span>
                        @else
                        <span style="color: #d9534f">镜像故障</span>
                        @endif
                    </td>
                    <td ><a href="{{url("admin")}}">{{$overlay->baseImage->server->name}}</a></td>
                    <td ><a href="{{url("image/base")}}">{{$overlay->baseImage->name}}</a></td>
                    <td><a href="{{url("file/fileInfo")}}">{{count($overlay->files)}}</td>
                    <td >
                        @if($overlay->status===1)
                        <button class="btn btn-warning"type="button" onclick="overlayStop({{$overlay->id}})">停止
                        </button>
                        @elseif($overlay->status===0)
                        <button class="btn btn-info"type="button" onclick="overlayStart({{$overlay->id}})">启动</button>
                        @else
                        @endif


                        <button class="btn btn-primary"type="button" onclick="overlayEdit({{$overlay->id}})">修改
                        </button>
                        <button class="btn btn-danger"type="button" onclick="overlayDelete({{$overlay->id}})">删除
                        </button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td ><div style="margin-top:5px;">添加:</div></td>
                    <td ><input type="text" class="form-control" id="name" placeholder="请输入名称" ></td>
                    <td ><input type="text" class="form-control" id="absPath" placeholder="path" ></td>
                    <td></td>
                    <td></td>
                    <td >
                        <select class="form-control" id="server_select" onchange="serverChange()">
                            <option></option>
                        @foreach ($servers as $server)
                            <option value="{{$server->id}}">{{$server->id}}-{{$server->name}}</option>
                        @endforeach
                        </select>
                    </td>
                    <td >
                        <select class="form-control" id="base_select">
                        <option></option>
                        </select>
                    </td>
                    <td></td>
                    <td >
                        <button class="btn btn-success" type="button" onclick="addOverlay()">添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $overlays->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function serverChange(){
        var server_id=$('#server_select option:selected').val();
        if(server_id!=""){
            $.ajax({
                type: 'post',
                url : "{{url("image/getBaseimageByServer")}}",
                data : {"server_id":server_id},
                dataType:'JSON', 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success : function(data) {
                   if(data!=null){
                        console.log("find success!");
                        //console.log(data);
                        var insertText="";
                        for (var k = 0, length = data.length; k < length; k++) {
                            insertText+=("<option value='"+data[k]['id']+"'>"+data[k]['name']+"</option>");
                            //console.log(data[k]['name']);
                        }
                        console.log(insertText);
                        document.getElementById("base_select").innerHTML=insertText;
                        //layer.msg("添加成功！");
                        //location.reload(true);
                   }
                },
                error : function(err) {
                    layer.msg('find baseimages error！');
                    
                }
            });  
        }else{
            console.log("not select anything!");
            $("#base_select").html("");
        }
    }
    
    
    //console.log({{$baseimages[0]->id}});
    function addOverlay(){
        var name=document.getElementById('name').value;
        var absPath=document.getElementById('absPath').value;
        var baseImageId=$('#base_select option:selected').val();
        if(baseImageId==""||name==""||absPath==""){
            alert("please input content!");
        }
        console.log(baseImageId);
        $.ajax({
            type: 'post',
            url : "{{url("image/overlayAdd")}}",
            data : {"name":name,"absPath":absPath,"baseImageId":baseImageId},
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

    function overlayEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['600px', '800px'],
          fix: false, //不固定
          maxmin: true,
          content: 'overlayEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
    function Delete(id){
            $.ajax({
                type: 'post',
                url : "{{url("image/overlayDelete")}}",
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
    function overlayDelete(id){
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
    function overlayStop(id){
        $.ajax({
            type: 'post',
            url : "{{url("image/overlayStop")}}",
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
    function overlayStart(id){
        $.ajax({
            type: 'post',
            url : "{{url("image/overlayStart")}}",
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