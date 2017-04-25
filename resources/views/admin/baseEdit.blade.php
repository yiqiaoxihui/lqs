@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="baseImage" value="{{$baseImage->id}}">
<span>名称</span>
<input type="text" id="name" class="form-control" value="{{$baseImage->name}}">
<br>
<span>绝对路径</span>
<input id="absPath" class="form-control" value="{{$baseImage->absPath}}" placeholder="绝对路径">
<br>
<span>服务器</span>
<select class="form-control" id="server_select">
    @foreach($servers as $server)
    <option value="{{$server->id}}">{{$server->id}}-{{$server->name}}</option>
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
        var id=document.getElementById('baseImage').value;
        var name=document.getElementById('name').value;
        var absPath=document.getElementById('absPath').value;
        var server_id=$('#server_select option:selected').val();//选中的值
        console.log(server_id);
        $.ajax({
            type: 'post',
            url : "{{url("image/baseEditOk")}}",
            data : {"id":id,"name":name,"absPath":absPath,"server_id":server_id},
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

</script>