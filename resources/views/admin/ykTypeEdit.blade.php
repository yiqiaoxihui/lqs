@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<div style="text-align:center;">

<input type="hidden" id="yktypeid" value="{{$yktype->id}}">
<input type="text" name="year" id="year" class="form-control" value="{{$yktype->year}}"readonly="readonly">
<br>
<span>免票儿童</span>
<input name="childfree" id="childfree"class="form-control" value="{{$yktype->childfree}}" placeholder="">
<br>
<span>儿童</span>
<input type="text" name="child" id="child" class="form-control" value="{{$yktype->child}}">
<br>
<span>成人</span>
<input name="adult" id="adult"class="form-control" value="{{$yktype->adult}}" placeholder="">
<br>
<span>老人</span>
<input name="older" id="older"class="form-control" value="{{$yktype->older}}" placeholder="">
<br>
<span>军人</span>
<input type="text" name="solider" id="solider" class="form-control" value="{{$yktype->solider}}">
<br>
<button class="btn btn-default" onclick="editone()" >修改</button>
</div>
@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script type="text/javascript">
var index = parent.layer.getFrameIndex(window.name); //获取父窗口索引
    function editone(){
        var id=document.getElementById('yktypeid').value;
        var year=document.getElementById('year').value;
        var childfree=document.getElementById('childfree').value;
        var child=document.getElementById('child').value;
        var adult=document.getElementById('adult').value;
        var older=document.getElementById('older').value;
        var solider=document.getElementById('solider').value;
        console.log(id);
        $.ajax({
            type: 'post',
            url : "../ykTypeEditOk",
            data : {"id":id,"year":year,"childfree":childfree,"child":child,
            "adult":adult,"older":older,"solider":solider},
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