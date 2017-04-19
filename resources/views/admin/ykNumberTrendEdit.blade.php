@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="ykNumberId" value="{{$yknumber->id}}">
<input type="text" name="month" id="month" class="form-control" value="{{$yknumber->month}}"readonly="readonly">
<br>
<input name="team" id="team"class="form-control" value="{{$yknumber->team}}" placeholder="">
<br>
<input name="individual" id="individual"class="form-control" value="{{$yknumber->individual}}" placeholder="">
<br>
<button class="btn btn-default" onclick="editone()" >修改</button>
</div>
@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script type="text/javascript">
var index = parent.layer.getFrameIndex(window.name); //获取窗口索引

    function editone(){
        var id=document.getElementById('ykNumberId').value;
        //var month=document.getElementById('month').value;
        var team=document.getElementById('team').value;
        var individual=document.getElementById('individual').value;
        console.log(id);console.log(team);console.log(individual);
        $.ajax({
            type: 'post',
            url : "../ykNumberEditOk",
            data : {"id":id,"individual":individual,"team":team},
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