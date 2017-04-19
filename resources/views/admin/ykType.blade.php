@extends('layouts/admin')

@section('title', '后台管理')

@section('content')
<h2>游客类型分析</h2>
    <div class="table-outline">
        <table class="table">
            <thead>
                <tr style="height:60px;">
                    <th>ID</th>
                    <th>日期</th>
                    <th>免票儿童</th>
                    <th>儿童</th>
                    <th>成人</th>
                    <th>老人</th>
                    <th>军人</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($yktypes as $yktype)
                <tr>
                    <td >{{$yktype->id}}</td>
                    <td >{{$yktype->year}}</td>
                    <td >{{$yktype->childfree}}人</td>
                    <td >{{$yktype->child}}人</td>
                    <td >{{$yktype->adult}}人</td>
                    <td >{{$yktype->older}}人</td>
                    <td >{{$yktype->solider}}人</td>
                    <td >
                        <button class="btn btn-default"type="button" onclick="yktrendEdit({{$yktype->id}})">修改</button>
                    </td>
                </tr>
                @endforeach
                <tr class="info">
                    <td >添加</td>
                    <td ><input type="text" class="form-control" id="year" placeholder="请输入年份" ></td>
                    <td ><input type="text" class="form-control" id="childfree" placeholder="免票儿童"></td>
                    <td ><input type="text" class="form-control" id="child" placeholder="儿童"></td>
                    <td ><input type="text" class="form-control" id="adult" placeholder="成人"></td>
                    <td ><input type="text" class="form-control" id="older" placeholder="老人"></td>
                    <td ><input type="text" class="form-control" id="solider" placeholder="军人"></td>
                    <td >
                        <button class="btn btn-default" type="button" onclick="addone()">添加</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">{!! $yktypes->render() !!}</div>
    </div>

@endsection

<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    function addone(){
        var year=document.getElementById('year').value;
        var childfree=document.getElementById('childfree').value;
        var child=document.getElementById('child').value;
        var adult=document.getElementById('adult').value;
        var older=document.getElementById('older').value;   
        var solider=document.getElementById('solider').value;
        console.log(year);
        console.log(childfree);
        console.log(child);
        console.log(adult);
        console.log(older);
        console.log(solider);
        $.ajax({
            type: 'POST',
            url : "yktypeAdd",
            data : {"year":year,"childfree":childfree,"child":child,"adult":adult,"older":older,"solider":solider},
            dataType:'JSON', 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data) {
               if(data.status==1){
                    console.log(data);
                    layer.msg("添加成功！");
                    location.reload(true);
               }
            },
            error : function(err) {
                layer.msg('请按要求输入!');
            }
        });
    }
    function yktrendEdit(id){
        console.log(id);
        layer.open({
          type: 2,
          area: ['300px', '500px'],
          fix: false, //不固定
          maxmin: true,
          content: 'ykTypeEdit/'+id,
          cancel:function(index){
            location.reload(true);
          }
        });

    }
</script>