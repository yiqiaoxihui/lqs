@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="incomeSourceId" value="{{$incomeSource->id}}">
<span>年份</span>
<input type="text"id="year" class="form-control" value="{{$incomeSource->year}}">
<br>
<span>月份</span>
<input id="bank"class="form-control" value="{{$incomeSource->bank}}" placeholder="">
<br>
<span>金额</span>
<input type="text" id="money" class="form-control" value="{{$incomeSource->money}}">
<br>
<button class="btn btn-default" onclick="editone()" >修改</button>
</div>
@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script type="text/javascript">
var index = parent.layer.getFrameIndex(window.name); //获取父窗口索引
    function editone(){
        var id=document.getElementById('incomeSourceId').value;
        var year=document.getElementById('year').value;
        var bank=document.getElementById('bank').value;
        var money=document.getElementById('money').value;

        console.log(id);
        $.ajax({
            type: 'post',
            url : "{{url("incomeAnalyze/incomeSourceEditOk")}}",
            data : {"id":id,"year":year,"bank":bank,"money":money},
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