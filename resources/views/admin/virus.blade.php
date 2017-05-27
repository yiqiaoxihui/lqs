@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>数据库管理</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>病毒编号</th>
                    <th>病毒名称</th>
                    <th>病毒特征值</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($viruses as $virus)
                <tr>
                    <td >{{$virus->id}}</td>
                    <td >{{$virus->code}}</td>
                    
                    <td >{{$virus->name}}</td>
                    <td >{{$virus->hash}}</td>
                    <td >
                        <button class="btn btn-primary"type="button" onclick="virusEdit({{$virus->id}})">修改
                        </button>
                        <button class="btn btn-danger"type="button" onclick="virusDelete({{$virus->id}})">删除
                        </button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td >添加</td>
                    <td ><input type="text" id="code" style="height:34px;" placeholder="请输入病毒编号"></td>
                    <td>
                        <input type="text" class="form-control" id="name" placeholder="病毒名称">
                    </td>
                    <td ><input type="text" class="form-control" id="hash" placeholder="病毒特征值"></td>
                    <td >
                        <button class="btn btn-default" type="button" onclick="addVirus()" id="pid" >添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $viruses->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    
    function addVirus(){
        var name=document.getElementById('name').value;
        var hash=document.getElementById('hash').value;
        var code=document.getElementById('code').value;
        console.log(name);
        $.ajax({
            type: 'post',
            url : "{{url("virus/virusAdd")}}",
            data : {"name":name,"hash":hash,"code":code},
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

    function virusEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['800px', '900px'],
          fix: false, //不固定
          maxmin: true,
          content: 'virusEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }

    function virusDelete(id){
        $.ajax({
            type: 'post',
            url : "{{url("virus/virusDelete")}}",
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