@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>监控文件管理</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="">
                    <th>所属增量镜像</th>
                    <th width="9%">文件路径</th>
                    <th width="6%">文件类型</th>
                    <th width="6%">文件大小</th>
                    <th width="7%">哈希值</th>
                    <th width="8%">文件元信息位置</th>
                    <th width="7%">文件数据位置</th>
                    <th width="6%">是否被篡改</th>
                    <th>创建时间</th>
                    <th>修改时间</th>
                    <th width="6%">监控状态</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($files as $file)
                <tr @if($file->status===-1||$file->isModified===1)style="background: #e29896;color:#ffffff"@endif>
                    <td >{{$file->overlay->name}}</td>
                    <td >{{$file->absPath}}</td>
                    <td >
                    @if(intval(($file->mode)/4096)===8)
                    常规文件
                    @else
                    未知
                    @endif</td>
                    <td >{{$file->size}}字节</td>
                    <td >{{$file->hash}}</td>
                    <td >
                    @if($file->inodePosition===2)
                        增量镜像
                    @elseif($file->inodePosition===1)
                        原始镜像
                    @else
                        未知
                    @endif
                    </td>
                    <td >
                    @if($file->dataPosition===2)
                        增量镜像
                    @elseif($file->dataPosition===1)
                        原始镜像
                    @else
                        未知
                    @endif
                    </td>
                    <td >
                    @if($file->isModified===1)
                        <p style="color: #d9534f">是</p>
                        @else
                        <p style="color: #5cb85c">否</p>
                    @endif
                    </td>
                    <td >{{$file->createTime}}</td>
                    <td >{{$file->modifyTime}}</td>
                    <td>
                    @if($file->status===1)
                        <p style="color: #5cb85c">监控中</p>
                    @elseif($file->status==0)
                       <p style="color: #5bc0de">已停止</p> 
                    @else
                        <p style="color: #d9534f">文件丢失</p>
                    @endif
                    </td>
                    <td width="14%">
                        @if($file->restore==1)
                            <button class="btn btn-warning"type="button" onclick="fileRestoreCancel({{$file->id}})">取消还原
                            </button>
                        @else
                            @if($file->status===1)
                            <button class="btn btn-warning"type="button" onclick="fileStop({{$file->id}})">停止
                            </button>
                            @elseif($file->status===0)
                            <button class="btn btn-info"type="button" onclick="fileStart({{$file->id}})">启动</button>
                            @endif
                            @if($file->isModified===1||$file->status===-1)
                            <button class="btn btn-success"type="button" onclick="fileRestore({{$file->id}})">还原</button>
                            @else
                            @endif
                            <button class="btn btn-primary" type="button" onclick="fileEdit({{$file->id}})">修改</button>
                        @endif
                        <button class="btn btn-danger" type="button" onclick="fileDelete({{$file->id}})">删除
                        </button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    
                    <td >绝对路径</td>
                    <td ><input type="text" class="form-control" id="absPath" placeholder="请输入文件路径"></td>
                    <td >服务器</td>
                    <td >
                        <select class="form-control" id="server_select" onchange="serverChange()">
                            <option>-选择-</option>
                        @foreach ($servers as $server)
                            <option value="{{$server->id}}">{{$server->id}}-{{$server->name}}</option>
                        @endforeach
                        </select>
                    </td>
                    <td >原始镜像</td>
                    <td >
                        <select class="form-control" id="base_select" onchange="baseChange()">
                        <option></option>
                        </select>
                    </td>
                    <td >增量镜像</td>
                    <td >
                        <select class="form-control" id="overlay_select">
                        <option></option>
                        </select>
                    </td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td >
                        <button class="btn btn-success" type="button" onclick="fileAdd()">添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $files->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function serverChange(){
        var server_id=$('#server_select option:selected').val();
        if(server_id!=""){
            $.ajax({
                type: 'post',
                url : "{{url("file/getBaseimageByServer")}}",
                data : {"server_id":server_id},
                dataType:'JSON', 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success : function(data) {
                   if(data!=null){
                        console.log("find success!");
                        //console.log(data);
                        var insertText="<option>-选择-</option>";
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
    function baseChange(){
        var base_id=$('#base_select option:selected').val();
        if(base_id!=""){
            $.ajax({
                type: 'post',
                url : "{{url("file/getOverlayByBase")}}",
                data : {"base_id":base_id},
                dataType:'JSON', 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success : function(data) {
                   if(data!=null){
                        console.log("find success!");
                        //console.log(data);
                        var insertText="<option>-选择-</option>";
                        for (var k = 0, length = data.length; k < length; k++) {
                            insertText+=("<option value='"+data[k]['id']+"'>"+data[k]['name']+"</option>");
                            //console.log(data[k]['name']);
                        }
                        console.log(insertText);
                        document.getElementById("overlay_select").innerHTML=insertText;
                        //layer.msg("添加成功！");
                        //location.reload(true);
                   }
                },
                error : function(err) {
                    layer.msg('find overlays error！');
                    
                }
            });  
        }else{
            console.log("not select anything!");
            $("#overlay_select").html("");
        }
    }
    function fileRestore(id){
        $.ajax({
            type: 'post',
            url : "{{url("file/fileRestore")}}",
            data : {"id":id},
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    layer.msg("开始还原！");
                    location.reload(true);
               }
            },
            error : function(err) {
                layer.msg('restore error!!!');
            }
        });   
    }
    function fileRestoreCancel(id){
        $.ajax({
            type: 'post',
            url : "{{url("file/fileRestoreCancel")}}",
            data : {"id":id},
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    layer.msg("取消还原！");
                    location.reload(true);
               }
            },
            error : function(err) {
                layer.msg('restore cancel error!!!');
            }
        });   
    }
    function fileStart(id){
        $.ajax({
            type: 'post',
            url : "{{url("file/fileStart")}}",
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
                layer.msg('boot error!!!');
            }
        });
    }
    function fileStop(id){
        $.ajax({
            type: 'post',
            url : "{{url("file/fileStop")}}",
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
                layer.msg('boot error!!!');
            }
        });
    }
    function fileAdd(){
        var absPath=document.getElementById('absPath').value;
        var overlayId=$('#overlay_select option:selected').val();
        console.log(overlayId);
        $.ajax({
            type: 'post',
            url : "{{url("file/fileAdd")}}",
            data : {"absPath":absPath,"overlayId":overlayId},
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

    function fileEdit(id){
        //console.log(id);
        layer.open({
          type: 2,
          area: ['600px', '800px'],
          fix: false, //不固定
          maxmin: true,
          content: 'fileEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
    function Delete(id){
            $.ajax({
                type: 'post',
                url : "{{url("file/fileDelete")}}",
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
    function fileDelete(id){
        layer.msg('确定删除？', {
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
</script>