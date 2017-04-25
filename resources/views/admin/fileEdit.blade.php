@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="fileId" value="{{$file->id}}">
<span>绝对路径</span>
<input id="absPath" class="form-control" value="{{$file->absPath}}" placeholder="">
<br>
<span></span>
<select class="form-control" id="server_select" onchange="serverChange()">
    <option></option>
@foreach ($servers as $server)
    <option value="{{$server->id}}" 
    @if($server->id===$file->overlay->baseImage->server->id)selected="selected"@endif>
    {{$server->id}}-{{$server->name}}
    </option>
@endforeach
</select>
<br>
<span >原始镜像</span>
<select class="form-control" id="base_select" onchange="baseChange()">
@foreach($file->overlay->baseImage->server->baseImages as $baseImage)
    <option value="{{$baseImage->id}}" 
    @if($baseImage->id===$file->overlay->baseImage->id)selected="selected"@endif>
    {{$baseImage->id}}-{{$baseImage->name}}
    </option>
@endforeach

</select>
<br>
<span >增量镜像</span>
<select class="form-control" id="overlay_select">
<option></option>
@foreach ($file->overlay->baseImage->overlays as $overlay)
    <option value="{{$overlay->id}}" 
    @if($overlay->id===$file->overlay->id)selected="selected"@endif>
    {{$overlay->id}}-{{$overlay->name}}
    </option>
@endforeach
</select>
<br>
<button class="btn btn-default" onclick="editone()" >修改</button>
</div>
@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script type="text/javascript">
var index = parent.layer.getFrameIndex(window.name); //获取父窗口索引
    function editone(){
        var id=document.getElementById('fileId').value;
        var absPath=document.getElementById('absPath').value;
        var overlayId=$('#overlay_select option:selected').val();

        console.log(id);
        $.ajax({
            type: 'post',
            url : "{{url("incomeAnalyze/fileEditOk")}}",
            data : {"id":id,"absPath":absPath,"overlayId":overlayId},
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    parent.layer.msg('修改成功');
                    parent.location.reload(true);
                    parent.layer.close(index);

               }
            },
            error : function(err) {
                alert("修改失败！");
            }
        });
    }
    function serverChange(){
        var server_id=$('#server_select option:selected').val();
        if(server_id!=""){
            $.ajax({
                type: 'post',
                url : "{{url("incomeAnalyze/getBaseimageByServer")}}",
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
            $("#overlay_select").html("");
        }
    }
    function baseChange(){
        var base_id=$('#base_select option:selected').val();
        if(base_id!=""){
            $.ajax({
                type: 'post',
                url : "{{url("incomeAnalyze/getOverlayByBase")}}",
                data : {"base_id":base_id},
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
</script>