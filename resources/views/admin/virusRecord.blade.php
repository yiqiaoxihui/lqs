@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>杀毒记录</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>所属增量镜像</th>
                    <th>文件绝对路径</th>
                    <th>病毒编号</th>
                    <th>病毒名称</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @if(count($virusRecords)===0)
                    <h2 style="color: #d9534f">当前无杀毒记录</h2>
                @else
                     @foreach ($virusRecords as $virusRecord)
                        <tr>
                            <td >{{$virusRecord->id}}</td>
                            <td >{{$virusRecord->overlay->name}}</td>
                            <td >{{$virusRecord->filename}}</td>
                            <td >{{$virusRecord->virus->code}}</td>
                            <td>{{$virusRecord->virus->name}}</td>
                            <td >
                                <button class="btn btn-warning"type="button" onclick="virusRecordDelete({{$virusRecord->id}})">删除</button>
                            </td>
                        </tr>

                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="pagination">{!! $virusRecords->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function virusRecordDelete(id){
        $.ajax({
            type: 'post',
            url : "{{url("virus/virusRecordDelete")}}",
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
</script>