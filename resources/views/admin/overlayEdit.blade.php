@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="overlayId" value="{{$overlay->id}}">
<span>名称</span>
<input type="text" id="name" class="form-control" value="{{$overlay->name}}">
<br>
<span>绝对路径</span>
<input id="absPath" class="form-control" value="{{$overlay->absPath}}" placeholder="">
<br>
<span>服务器</span>
    <select class="form-control" id="server_select" onchange="serverChange()">
        <option></option>
    @foreach ($servers as $server)
        <option value="{{$server->id}}">{{$server->id}}-{{$server->name}}</option>
    @endforeach
    </select>
<br>
<span>原始镜像</span>
    <select class="form-control" id="base_select">
    <option></option>
    </select>
<br>
<button class="btn btn-default" onclick="overEdit()" >修改</button>
</div>
@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script type="text/javascript">
var index = parent.layer.getFrameIndex(window.name); //获取父窗口索引
    function overEdit(){
        var id=document.getElementById('overlayId').value;
        var name=document.getElementById('name').value;
        var absPath=document.getElementById('absPath').value;
        var baseImageId=$('#base_select option:selected').val();

        console.log(id);
        $.ajax({
            type: 'post',
            url : "{{url("image/overlayEditOk")}}",
            data : {"id":id,"name":name,"absPath":absPath,"baseImageId":baseImageId},
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
</script>