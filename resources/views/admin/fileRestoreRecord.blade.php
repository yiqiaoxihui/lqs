@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>收入累计</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th style="">ID</th>
                    <th>团队</th>
                    <th>个体</th>
                    <th>其他</th>
                    <th>更新</th>
                </tr>
            </thead>
            <tbody>
                <tr><input type="hidden"  id="id"value="{{$incomeAccumulate->id}}">
                    <td>{{$incomeAccumulate->id}}</td>
                    <td ><input type="text" class="form-control" id="team" placeholder="请输入年份" value="{{$incomeAccumulate->team}}">万元</td>
                    <td ><input type="text" class="form-control" id="individual" placeholder="请输入月份" value="{{$incomeAccumulate->individual}}">万元</td>
                    <td ><input type="text" class="form-control" id="other" placeholder="请输入金额" value="{{$incomeAccumulate->other}}">万元</td>
                    <td >
                        <button class="btn btn-default"type="button" onclick="incomeAccumulateUpdate()">更新</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function incomeAccumulateUpdate(){
        var id=document.getElementById('id').value;
        var team=document.getElementById('team').value;
        var individual=document.getElementById('individual').value;
        var other=document.getElementById('other').value;
        console.log(team);
        $.ajax({
            type: 'post',
            url : "{{url("incomeAnalyze/incomeAccumulateUpdate")}}",
            data : {"id":id,"team":team,"other":other,"individual":individual},
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    layer.msg("更新成功！");
                    location.reload(true);
               }
            },
            error : function(err) {
                layer.msg('请按要求输入！');
            }
        });
    }
</script>