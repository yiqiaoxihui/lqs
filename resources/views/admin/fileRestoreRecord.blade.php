@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>还原文件记录</h2>
    <div style="position: relative;margin-left: 30px;">
        <label>服务器</label>
        <select class="form-control" id="server_select_choose" onchange="serverChangeChoose()" style="display: inline;width: 400px;">
            <option value="0">-全部-</option>
        @foreach ($servers as $server)
            <option value="{{$server->id}}">{{$server->id}}-{{$server->name}}</option>
        @endforeach
        </select>
        <label style="margin-left: 30px;"t>基础镜像</label>
        <select class="form-control" id="base_select_choose" onchange="baseChangeChoose()" style="display:inline;width: 400px;">
            
        </select>
        <label style="margin-left: 30px;">增量镜像</label>
        <select class="form-control" id="overlay_select_choose" onchange="overlayChangeChoose()" style="display:inline;width: 400px;">
        </select>
    </div>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>所属增量镜像</th>
                    <th>文件绝对路径</th>
                    <th>还原原因</th>
                    <th>还原状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @if(count($fileRestoreRecords)===0)
                    <h2 style="color: #d9534f">当前无还原文件记录</h2>
                @else
                     @foreach ($fileRestoreRecords as $fileRestoreRecord)
                        <tr>
                            <td >{{$fileRestoreRecord->id}}</td>
                            <td >
                                @if($fileRestoreRecord->file->overlay!=NULL)
                                {{$fileRestoreRecord->file->overlay->name}}
                                @else
                                已删除
                                @endif
                            </td>
                            <td >
                                @if($fileRestoreRecord->file!=NULL)
                                {{$fileRestoreRecord->file->absPath}}
                                @else
                                已删除
                                @endif
                            </td>
<!--                             <td >{{$fileRestoreRecord->file->overlay->name}}</td>
                            <td >{{$fileRestoreRecord->file->absPath}}</td> -->
                            <td >
                                @if($fileRestoreRecord->restoreReason===1)
                                    <p style="color: #d9534f">文件篡改</p>
                                @elseif($fileRestoreRecord->restoreReason===2)
                                    <p style="color: #d9534f">文件丢失</p>
                                @elseif($fileRestoreRecord->restoreReason===3)
                                    <p style="color: #d9534f">篡改后丢失</p>
                                @endif
                            </td>
                            <td>
                                @if($fileRestoreRecord->result===1)
                                    <p style="color: #5cb85c">还原成功</p>
                                @else
                                    <p style="color: #d9534f">还原失败</p>
                                @endif
                            </td>
                            <td >
                                <button class="btn btn-warning"type="button" onclick="fileRestoreCancel({{$fileRestoreRecord->file->id}})">删除</button>
                            </td>
                        </tr>

                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="pagination">{!! $fileRestoreRecords->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function overlayChangeChoose(){
        var overlay_id=$('#overlay_select_choose option:selected').val();
        if(overlay_id==""){
            window.location.href="{{url("file/fileRestoreRecord")}}";
        }
        window.location.href="/lqs/public/file/fileRestoreRecord/"+overlay_id;
    }
    function baseChangeChoose(){
        var base_id=$('#base_select_choose option:selected').val();
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
                        document.getElementById("overlay_select_choose").innerHTML=insertText;
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
    function serverChangeChoose(){
        var server_id=$('#server_select_choose option:selected').val();
        if(server_id=="0"){
            window.location.href="{{url("file/fileInfo")}}";
        }
        if(server_id!="0"){
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
                        var insertText="<option></option>";
                        for (var k = 0, length = data.length; k < length; k++) {
                            insertText+=("<option value='"+data[k]['id']+"'>"+data[k]['name']+"</option>");
                            //console.log(data[k]['name']);
                        }
                        console.log(insertText);
                        document.getElementById("base_select_choose").innerHTML=insertText;
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
            $("#base_select_choose").html("");
        } 
    }
</script>