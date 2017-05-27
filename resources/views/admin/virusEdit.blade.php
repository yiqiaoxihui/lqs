@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="virus" value="{{$virus->id}}">
<span>病毒编号</span>
<input type="text" id="code" class="form-control" value="{{$virus->code}}">
<br>
<span>病毒名称</span>
<input id="name" class="form-control" value="{{$virus->name}}" placeholder="">
<br>
<span>特征值</span>
<input type="text" id="hash" class="form-control" value="{{$virus->hash}}" >
<br>
<button class="btn btn-default" onclick="editone()" >修改</button>
</div>
@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script type="text/javascript">
var index = parent.layer.getFrameIndex(window.name); //获取父窗口索引
    function editone(){
        var id=document.getElementById('virus').value;
        var code=document.getElementById('code').value;
        var name=document.getElementById('name').value;
        var hash=document.getElementById('hash').value;
        console.log(id);
        $.ajax({
            type: 'post',
            url : "{{url("virus/virusEditOk")}}",
            data : {"id":id,"code":code,"name":name,"hash":hash},
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