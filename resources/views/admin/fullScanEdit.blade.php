@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="fullScanId" value="{{$fullScan->id}}">
<input type="text" name="year" id="year" class="form-control" value="{{$fullScan->year}}"readonly="readonly">
<br>
<span>增量镜像</span>
<input name="overlayId" id="overlayId"class="form-control" value="{{$fullScan->overlayId}}" placeholder="">
<br>
<span>文件路径</span>
<input name="absPath" id="absPath"class="form-control" value="{{$fullScan->absPath}}" placeholder="">
<br>
<button class="btn btn-default" onclick="editone()" >修改</button>
</div>
@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script type="text/javascript">
var index = parent.layer.getFrameIndex(window.name); //获取父窗口索引
    function editone(){
        var id=document.getElementById('fullScanId').value;
        var overlayId=document.getElementById('overlayId').value;
        var absPath=document.getElementById('absPath').value;
        console.log(id);
        $.ajax({
            type: 'post',
            url : "../ykTypeEditOk",
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


// $('#test').on('click', function(){
//     parent.$('#pid').text('我被改变了');
//     parent.layer.tips('Look here', '#pid', {time: 5000});
//     parent.layer.close(index);
// });
// $('#new').click(function(){
//     parent.layer.msg('修改成功！！！');

//     parent.layer.close(index);
// });
// $('#modify').click(function(){

//     parent.layer.msg('修改成功');
//     parent.layer.close(index);
// });

    // function addone(){
    //     var ydate=document.getElementById('datetimepicker').value;
    //     var number=document.getElementById('number').value;
    //     console.log(ydate);
    //     $.ajax({
    //         type: 'post',
    //         url : "admin/addYktrend",
    //         data : {"ydate":ydate,"number":number},
    //         dataType:'JSON', 
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    //         },
    //         success : function(data) {
    //            if(data.status==1){
    //                 alert("添加成功！");
    //            }
    //         },
    //         error : function(err) {
    //             alert("添加失败"+err);
    //         }
    //     });
    // }
</script>