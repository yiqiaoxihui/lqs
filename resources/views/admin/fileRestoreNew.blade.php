@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>最新还原信息</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>所属增量镜像</th>
                    <th>文件绝对路径</th>
                    <th>还原原因</th>
                    <th>还原状态</th>
                </tr>
            </thead>
            <tbody>
                @if(count($fileRestoreRecords)===0)
                    <h2 style="color: #d9534f">当前无还原文件记录</h2>
                @else
                     @foreach ($fileRestoreRecords as $fileRestoreRecord)
                        <tr>
                            <td >{{$fileRestoreRecord->id}}</td>
                            <td >{{$fileRestoreRecord->file->overlay->name}}</td>
                            <td >{{$fileRestoreRecord->file->absPath}}</td>
                            <td >
                                @if($fileRestoreRecord->restoreReason===1)
                                    <p style="color: #d9534f">文件篡改</p>
                                @elseif($fileRestoreRecord->restoreReason===2)
                                    <p style="color: #d9534f">文件丢失</p>
                                @elseif($fileRestoreRecord->restoreReason===3)
                                    <p style="color: #d9534f">篡改后丢失</p>
                                @endif
                            </td>
                            <td>
                                @if($fileRestoreRecord->result===1)
                                    <p style="color: #5cb85c">还原成功</p>
                                @else
                                    <p style="color: #d9534f">还原失败</p>
                                @endif
                            </td>
                        </tr>

                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="pagination">{!! $fileRestoreRecords->render() !!}</div>
    </div>
@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>
<script src="{{asset('layer/layer.js')}}"></script>
<script type="text/javascript">

</script>