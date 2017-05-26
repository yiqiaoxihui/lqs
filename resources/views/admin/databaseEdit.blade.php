@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="database" value="{{$dataBase->id}}">
<span>url</span>
<input type="text" id="url" class="form-control" value="{{$dataBase->url}}">
<br>
<span>用户名</span>
<input id="username"class="form-control" value="{{$dataBase->username}}" placeholder="">
<br>
<span>密码</span>
<input type="password" id="password" class="form-control" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" >
<br>
<span>确认密码</span>
<input type="password" id="password_confirmed" class="form-control" value="">
<p id="pwd_error" style="color: red;display: none;" >两次密码不一致!</p>
<br>
<button class="btn btn-default" onclick="editone()" >修改</button>
</div>
@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script type="text/javascript">
var index = parent.layer.getFrameIndex(window.name); //获取父窗口索引
    function editone(){
        var id=document.getElementById('database').value;
        var url=document.getElementById('url').value;
        var username=document.getElementById('username').value;
        var password=document.getElementById('password').value;
        var password_confirmed=document.getElementById('password_confirmed').value;
        if(password!=password_confirmed){
            
            document.getElementById("pwd_error").style.display="";
            return 0;
        }
        console.log(id);
        $.ajax({
            type: 'post',
            url : "{{url("database/dataBaseEditOk")}}",
            data : {"id":id,"url":url,"username":username,"password":password},
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