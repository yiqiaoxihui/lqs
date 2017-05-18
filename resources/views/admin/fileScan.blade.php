@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>全盘扫描管理</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>名称</th>
                    <th>镜像路径</th>
                    <th>创建时间</th>
                    <th>状态</th>
                    <th>服务器</th>
                    <th>原始镜像</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($overlays as $overlay)
                <tr>
                    <td >{{$overlay->id}}</td>
                    <td >{{$overlay->name}}</td>
                    
                    <td >{{$overlay->absPath}}</td>
                    <td >{{$overlay->created_at}}</td>
                    <td >
                        @if($overlay->status===1)
                        <span style="color: #5cb85c">正常</span>
                        @elseif($overlay->status===0)
                        <span style="color: #5bc0de">停止监测</span>
                        @else
                        <span style="color: #d9534f">镜像故障</span>
                        @endif
                    </td>
                    <td ><a href="{{url("admin")}}">{{$overlay->baseImage->server->name}}</a></td>
                    <td ><a href="{{url("image/base")}}">{{$overlay->baseImage->name}}</a></td>
                    <td >
                        @if($overlay->scan===1)
                        <button class="btn btn-warning"type="button" onclick="overlayScanStop({{$overlay->id}})">停止扫描
                        </button>
                        @elseif($overlay->scan===0)
                        <button class="btn btn-info"type="button" onclick="overlayScanStart({{$overlay->id}})">开启扫描</button>
                        @else
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">{!! $overlays->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function overlayScanStop(id){
        $.ajax({
            type: 'post',
            url : "{{url("file/fileScanStop")}}",
            data : {"id":id},
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    layer.msg("停止成功！");
                    location.reload(true);
               }
            },
            error : function(err) {
                layer.msg('停止失败！');
            }

        });
    }
    function overlayScanStart(id){
        $.ajax({
            type: 'post',
            url : "{{url("file/fileScanStart")}}",
            data : {"id":id},
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    layer.msg("启动成功！");
                    location.reload(true);
               }
            },
            error : function(err) {
                layer.msg('启动失败！');
            }

        });
    }
</script>