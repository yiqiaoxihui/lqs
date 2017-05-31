@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>文件还原管理</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>所属增量镜像</th>
                    <th>文件绝对路径</th>
                    <th>还原原因</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @if(count($fileRestores)===0)
                    <h2 style="color: #d9534f">当前无还原文件</h2>
                @else
                     @foreach ($fileRestores as $fileRestore)
                        <tr>
                            <td >{{$fileRestore->id}}</td>
                            <td >
                                @if($fileRestore->file->overlay!=NULL)
                                {{$fileRestore->file->overlay->name}}
                                @else
                                已删除
                                @endif
                            </td>
                            <td >
                                @if($fileRestore->file!=NULL)
                                {{$fileRestore->file->absPath}}
                                @else
                                已删除
                                @endif
                            </td>
                            <td >
                                @if($fileRestore->restoreReason===1)
                                    <p style="color: #d9534f">文件篡改</p>
                                @elseif($fileRestore->restoreReason===2)
                                    <p style="color: #d9534f">文件丢失</p>
                                @elseif($fileRestore->restoreReason===3)
                                    <p style="color: #d9534f">篡改后丢失</p>
                                @endif
                            </td>
                            <td >
                                <button class="btn btn-warning"type="button" onclick="fileRestoreCancel({{$fileRestore->file->id}})">取消还原</button>
                            </td>
                        </tr>

                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="pagination">{!! $fileRestores->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
function fileRestoreCancel(id){
    $.ajax({
        type: 'post',
        url : "{{url("file/fileRestoreCancel")}}",
        data : {"id":id},
        dataType:'JSON', 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success : function(data) {
           if(data.status==1){
                layer.msg("取消还原！");
                location.reload(true);
           }
        },
        error : function(err) {
            layer.msg('restore cancel error!!!');
        }
    });   
}
</script>