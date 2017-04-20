@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>监控文件管理</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="">
                    <th>所属增量镜像</th>
                    <th style="">文件路径</th>
                    <th>文件类型</th>
                    <th>文件大小</th>
                    <th>哈希值</th>
                    <th>文件元信息位置</th>
                    <th>文件数据位置</th>
                    <th>是否被篡改</th>
                    <th>创建时间</th>
                    <th>最近修改时间</th>
                    <th>监控状态</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($files as $file)
                <tr>
                    <td >{{$file->overlay->name}}</td>
                    <td >{{$file->absPath}}</td>
                    <td >{{$file->mode}}</td>
                    <td >{{$file->size}}字节</td>
                    <td >{{$file->hash}}</td>
                    <td >
                    @if($file->inodePosition===2)
                        增量镜像
                    @elseif($file->inodePosition===1)
                        原始镜像
                    @else
                        未知
                    @endif
                    </td>
                    <td >
                    @if($file->dataPosition===2)
                        增量镜像
                    @elseif($file->dataPosition===1)
                        原始镜像
                    @else
                        未知
                    @endif
                    </td>
                    <td >
                    @if($file->isModified===1)
                        <p style="color: #d9534f">是</p>
                    @else
                        <p style="color: #5cb85c">否</p>
                    @endif
                    </td>
                    <td >{{$file->createTime}}</td>
                    <td >{{$file->modifyTime}}</td>
                    <td>
                    @if($file->status===1)
                        <p style="color: #5cb85c">监控中</p>
                    @elseif($file->status==0)
                       <p style="color: #5bc0de">已停止</p> 
                    @else
                        <p style="color: #d9534f">文件丢失</p>
                    @endif
                    </td>
                    <td >
                        @if($file->status===1)
                        <button class="btn btn-warning"type="button" onclick="incomeSourceStop({{$file->id}})">停止
                        </button>
                        @elseif($file->status===0)
                        <button class="btn btn-info"type="button" onclick="incomeSourceBoot({{$file->id}})">启动</button>
                        @else
                        @endif
                        <button class="btn btn-primary"type="button" onclick="incomeSourceEdit({{$file->id}})">修改</button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td ><div style="margin-top:5px;">添加:</div></td>
                    <td >
                        <select class="form-control">
                        @foreach ($overlays as $overlay)
                            <option value="{{$overlay->id}}">{{$overlay->id}}-{{$overlay->name}}</option>
                        @endforeach
                        </select>
                    </td>
                    <td ><input type="text" class="form-control" id="bank" placeholder="请输入文件路径"></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td >
                        <button class="btn btn-success" type="button" onclick="addone()">添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $files->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function incomeSourceBoot(id){
        $.ajax({
            type: 'post',
            url : "{{url("incomeAnalyze/incomeSourceBoot")}}",
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
                layer.msg('boot error!!!');
            }
        });
    }
    function incomeSourceStop(id){
        $.ajax({
            type: 'post',
            url : "{{url("incomeAnalyze/incomeSourceStop")}}",
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
                layer.msg('boot error!!!');
            }
        });
    }
    function addone(){
        var year=document.getElementById('year').value;
        var bank=document.getElementById('bank').value;
        var money=document.getElementById('money').value;
        console.log(year);
        $.ajax({
            type: 'post',
            url : "{{url("incomeAnalyze/incomeSourceAdd")}}",
            data : {"year":year,"bank":bank,"money":money},
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

    function incomeSourceEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['400px', '500px'],
          fix: false, //不固定
          maxmin: true,
          content: 'incomeSourceEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
</script>