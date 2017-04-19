@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="incomeSumId" value="{{$incomeSum->id}}">
<span>年份</span>
<input type="text"id="year" class="form-control" value="{{$incomeSum->year}}">
<br>
<span>团队销售额</span>
<input id="team"class="form-control" value="{{$incomeSum->team}}" placeholder="">
<br>
<span>个体销售额</span>
<input type="text" id="individual" class="form-control" value="{{$incomeSum->individual}}">
<br>
<button class="btn btn-default" onclick="editone()" >修改</button>
</div>
@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script type="text/javascript">
var index = parent.layer.getFrameIndex(window.name); //获取父窗口索引
    function editone(){
        var id=document.getElementById('incomeSumId').value;
        var year=document.getElementById('year').value;
        var team=document.getElementById('team').value;
        var individual=document.getElementById('individual').value;

        console.log(id);
        $.ajax({
            type: 'post',
            url : "{{url("incomeAnalyze/incomeSumEditOk")}}",
            data : {"id":id,"year":year,"team":team,"individual":individual},
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