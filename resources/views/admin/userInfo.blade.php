@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>用户管理</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>用户名</th>
                    <th>帐号</th>
                    <th>类型</th>
                    <th>状态</th>
                    <th>管理</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($users as $user)
                <tr>
                    <td >{{$user->id}}</td>
                    <td >{{$user->name}}</td>
                    <td >{{$user->email}}</td>
                    <td >
                    @if($user->type===2)
                        <p style="color: #5cb85c">超级管理员</p>
                    @elseif($user->type==1)
                        <p style="color: #5bc0de">普通管理员</p>
                    @else
                    
                    @endif
                    </td>
                    <td >
                    @if($user->status===1)
                        <p style="color: #5cb85c">活动</p>
                    @elseif($user->type==1)
                        <p style="color: #5bc0de">禁用</p>
                    @else
                    
                    @endif
                    </td>
                    <td >
                    @if($user->type===2)
                    <button class="btn btn-primary"type="button" onclick="spotYkEdit({{$user->id}})">修改</button>
                    @else
                    <button class="btn btn-danger"type="button" onclick="spotYkEdit({{$user->id}})">禁用</button>
                    <button class="btn btn-primary"type="button" onclick="spotYkEdit({{$user->id}})">修改</button>
                    @endif

                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td ><div style="margin-top:5px;">添加:</div></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td >
                        <button class="btn btn-success" type="button" onclick="addone()">添加用户</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $users->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function addone(){
        
        var day=document.getElementById('spotsYkDate').value;
        var number=document.getElementById('number').value;
        var spotsname=document.getElementById('spotsname').value;
        //console.log(year);
        $.ajax({
            type: 'post',
            url : "{{url("user/spotsYkAdd")}}",
            data : {"day":day,"number":number,"spotsname":spotsname},
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

    function spotYkEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['300px', '500px'],
          fix: false, //不固定
          maxmin: true,
          content: 'spotsYkEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
</script>