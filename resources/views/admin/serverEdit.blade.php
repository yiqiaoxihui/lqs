@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="serverid" value="{{$server->id}}">
<input type="text" name="name" id="name" class="form-control" value="{{$server->name}}" placeholder="server name">
<br>
<input name="serverNumber" id="serverNumber"class="form-control" value="{{$server->serverNumber}}" placeholder="server id">
<br>
<input name="address" id="address"class="form-control" value="{{$server->address}}" placeholder="server url">
<br>
<input name="IP" id="IP"class="form-control" value="{{$server->IP}}" placeholder="server IP">
<br>
<button class="btn btn-default" onclick="editone()" >修改</button>
</div>
@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script type="text/javascript">
var index = parent.layer.getFrameIndex(window.name); //获取窗口索引

    function editone(){
        var id=document.getElementById('serverid').value;
        var name=document.getElementById('name').value;
        var address=document.getElementById('address').value;
        var serverNumber=document.getElementById('serverNumber').value;
        var IP=document.getElementById('IP').value;
        console.log(id);console.log(serverNumber);
        $.ajax({
            type: 'post',
            url : "../serverEditOk",
            data : {"id":id,"address":address,"serverNumber":serverNumber,"IP":IP,"name":name},
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
                alert("修改失败！！");
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