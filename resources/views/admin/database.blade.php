@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>数据库管理</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>地址</th>
                    <th>用户名</th>
                    <th>密码</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($dataBases as $dataBase)
                <tr>
                    <td >{{$dataBase->id}}</td>
                    <td >{{$dataBase->url}}</td>
                    
                    <td >{{$dataBase->username}}</td>
                    <td >*****************</td>
                    <td >
                        <button class="btn btn-primary"type="button" onclick="dataBaseEdit({{$dataBase->id}})">修改
                        </button>
                        <button class="btn btn-danger"type="button" onclick="dataBaseDelete({{$dataBase->id}})">删除
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    
    function addOverlay(){
        var name=document.getElementById('name').value;
        var absPath=document.getElementById('absPath').value;
        var baseImageId=$('#base_select option:selected').val();
        if(baseImageId==""||name==""||absPath==""){
            alert("please input content!");
        }
        console.log(baseImageId);
        $.ajax({
            type: 'post',
            url : "{{url("image/overlayAdd")}}",
            data : {"name":name,"absPath":absPath,"baseImageId":baseImageId},
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    layer.msg("添加成功！");
                    location.reload(true);
               }
            },
            error : function(err) {
                layer.msg('请按要求输入！');
            }
        });
    }

    function dataBaseEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['800px', '900px'],
          fix: false, //不固定
          maxmin: true,
          content: 'dataBaseEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
    function Delete(id){
            $.ajax({
                type: 'post',
                url : "{{url("image/overlayDelete")}}",
                data : {"id":id},
                dataType:'JSON', 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success : function(data) {
                   if(data.status==1){
                        layer.msg("删除成功！");
                        location.reload(true);
                   }
                },
                error : function(err) {
                    layer.msg('删除失败！');
                }

            });
    }
    function overlayDelete(id){
        layer.msg('删除后关联增量镜像也会被删除，确定删除？', {
          time: 0 //不自动关闭
          ,btn: ['删除', '取消']
          ,yes: function(index){
            Delete(id);
            layer.close(index);
            // layer.msg('删除成功！', {
            //   icon: 6
            //   ,btn: ['关闭']
            // });
          }
        });
    }
</script>