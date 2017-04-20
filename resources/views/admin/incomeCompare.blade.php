@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>增量镜像管理</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>名称</th>
                    <!-- <th>服务器</th> -->
                    <th>镜像路径</th>
                    <th>创建时间</th>
                    <th>状态</th>
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
                        正常
                        @elseif($overlay->status===0)
                        停止监测
                        @else
                        镜像故障
                        @endif
                    </td>
                    <td ><a href="{{url("compare/ykCompare")}}">{{$overlay->baseImage->name}}</a></td>
                    <td >
                        @if($overlay->status===1)
                        <button class="btn btn-warning"type="button" onclick="ykCompareEdit({{$overlay->id}})">停止
                        </button>
                        @elseif($overlay->status===0)
                        <button class="btn btn-info"type="button" onclick="ykCompareEdit({{$overlay->id}})">启动</button>
                        @else
                        @endif


                        <button class="btn btn-primary"type="button" onclick="ykCompareEdit({{$overlay->id}})">修改
                        </button>
                        <button class="btn btn-danger"type="button" onclick="ykCompareEdit({{$overlay->id}})">删除
                        </button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td ><div style="margin-top:5px;">添加:</div></td>
                    <td ><input type="text" class="form-control" id="year" placeholder="请输入名称" ></td>
                    <td ><input type="text" class="form-control" id="year" placeholder="path" ></td>
                    <td></td>
                    <td></td>
                    <td >
                        <select class="form-control">
                        @foreach ($baseimages as $baseimage)
                            <option value="{{$baseimage->id}}">{{$baseimage->id}}-{{$baseimage->name}}</option>
                        @endforeach
                        </select>
                    </td>
                    <td >
                        <button class="btn btn-success" type="button" onclick="addone()">添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $overlays->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function addone(){
        var year=document.getElementById('year').value;
        var month=document.getElementById('month').value;
        var money=document.getElementById('money').value;
        console.log(year);
        $.ajax({
            type: 'post',
            url : "{{url("compare/incomeCompareAdd")}}",
            data : {"year":year,"money":money,"month":month},
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

    function incomeCompareEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['400px', '600px'],
          fix: false, //不固定
          maxmin: true,
          content: 'incomeCompareEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
</script>