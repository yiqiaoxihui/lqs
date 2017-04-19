@extends('layouts.app')

@section('title', '游客类型分析')

@section('content')
<div class="yktypeline">
    <span >游客类型分析</span>
    <select id="syear"onchange="yearChange()">
        @foreach ($years as $year)
        <option value="{{$year}}">{{$year}}</option>
        @endforeach
    </select>
    <span >年</span> 
</div>
<div id="yktype" style="min-width:700px;height:500px"></div>
@endsection
<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    var yktype=new Array();
    var years=new Array();
    years=<?php echo json_encode($years);?>;
    console.log(years);
    yktype=<?php echo json_encode($yktype);?>;
    yktype=yktype['0'];
    var sum=yktype['childfree']+yktype['child']+yktype['older']+yktype['adult']+yktype['solider'];
    var childfree=yktype['childfree']/sum;
    var child=yktype['child']/sum;
    var older=yktype['older']/sum;
    var adult=yktype['adult']/sum;
    var solider=yktype['solider']/sum;
    console.log(yktype['childfree']);

   function yearChange()
   {
    var objS = document.getElementById("syear");
    var year = objS.options[objS.selectedIndex].value;
    console.log(year);
    $.ajax({
        type: 'post',
        url : "yearOfyktype",
        data : {"year":year},
        dataType:'JSON', 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success : function(data) {
            yktype=data['0'];
            sum=yktype['childfree']+yktype['child']+yktype['older']+yktype['adult']+yktype['solider'];
            childfree=yktype['childfree']/sum;
            child=yktype['child']/sum;
            older=yktype['older']/sum;
            adult=yktype['adult']/sum;
            solider=yktype['solider']/sum;
            showYkType();
           //if(data.status==1){
            //location.reload(true);
           //}
           console.log(yktype);

        },
        error : function(err) {
            //layer.msg('请按要求输入！');
        }
    });
   }
function showYkType()
{
$('#yktype').highcharts({
        chart:{
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
             style:{
               color: '#3E576F',
               fontSize: '26px'
             },
            text:""
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br>人数:{point.count}人'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %<br>人数:{point.count}人'
                },
                showInLegend:true
            }
        },
        series: [{
            type: 'pie',
            name: '所占比:',
            data: 
            [
                {
                    name: '免票儿童',
                    y: childfree,
                    count:yktype['childfree'],
                },
                {
                    name:'儿童',
                    y:child,
                    count:yktype['child'],
                },
                {
                    name:'老人(>60)',
                    y:older,
                    count:yktype['older'],

                },
                {
                    name:'成人',
                    y:adult,
                    count:yktype['adult'],
                },
                {
                    name:'军人',
                    y:solider,
                    count:yktype['solider'],
                }
            ]
        }]
    });
}
$(function () {
    showYkType();
});
</script>