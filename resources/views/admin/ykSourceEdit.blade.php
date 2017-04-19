@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="ykSourceId" value="{{$yksource->id}}">
<span>年份</span>
<input type="text"id="year" class="form-control" value="{{$yksource->year}}">
<br>
<span>省份</span>
<input id="province"class="form-control" value="{{$yksource->province}}" placeholder="">
<br>
<span>人数</span>
<input type="text" id="number" class="form-control" value="{{$yksource->number}}">
<br>
<button class="btn btn-default" onclick="editone()" >修改</button>
</div>
@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script type="text/javascript">
var index = parent.layer.getFrameIndex(window.name); //获取父窗口索引
    function editone(){
        var id=document.getElementById('ykSourceId').value;
        var year=document.getElementById('year').value;
        var province=document.getElementById('province').value;
        var number=document.getElementById('number').value;

        console.log(id);
        $.ajax({
            type: 'post',
            url : "{{url("admin/ykSourceEditOk")}}",
            data : {"id":id,"year":year,"province":province,"number":number},
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