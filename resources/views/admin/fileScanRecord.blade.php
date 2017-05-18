@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>全盘扫描记录</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>增量镜像</th>
                    <th>文件总数</th>
                    <th>增量文件总数</th>
                    <th>全盘扫描时长</th>
                </tr>
            </thead>
            <tbody>
                @if(count($fileScanRecords)===0)
                    <h2 style="color: #d9534f">当前无全盘扫描记录</h2>
                @else
                     @foreach ($fileScanRecords as $fileScanRecord)
                        <tr>
                            <td >{{$fileScanRecord->id}}</td>
                            <td >{{$fileScanRecord->overlay->name}}</td>
                            <td >{{$fileScanRecord->allFiles}}</td>
                            <td >{{$fileScanRecord->overlayFiles}}</td>
                            <td >{{$fileScanRecord->scanTime}}</td>
                        </tr>

                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="pagination">{!! $fileScanRecords->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">

</script>