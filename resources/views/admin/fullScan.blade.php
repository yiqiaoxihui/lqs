@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>游客类型分析</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th>ID</th>
                    <th>增量镜像</th>
                    <th>文件路径</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($fullScans as $fullScan)
                <tr>
                    <td >{{$fullScan->id}}</td>
                    <td >{{$fullScan->=overlayId}}</td>
                    <td >{{$fullScan->absPath}}</td>
                    <td >
                        <button class="btn btn-default"type="button" onclick="yktrendEdit({{$fullScan->id}})">修改</button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td >添加</td>
                    <td ><input type="text" class="form-control" id="overlayId" placeholder="请输入年份" ></td>
                    <td ><input type="text" class="form-control" id="absPath" placeholder="免票儿童"></td>
                    <td >
                        <button class="btn btn-default" type="button" onclick="addone()">添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $fullScans->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function addone(){
        var overlayId=document.getElementById('overlayId').value;
        var absPath=document.getElementById('absPath').value;
        $.ajax({
            type: 'POST',
            url : "fullScanAdd",
            data : {"overlayId":overlayId,"absPath":absPath},
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    console.log(data);
                    layer.msg("添加成功！");
                    location.reload(true);
               }
            },
            error : function(err) {
                layer.msg('请按要求输入!');
            }
        });
    }
    function yktrendEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['300px', '500px'],
          fix: false, //不固定
          maxmin: true,
          content: 'fullScanEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
</script>