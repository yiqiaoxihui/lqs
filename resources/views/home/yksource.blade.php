@extends('layouts.app')

@section('title', '游客客源地分析')

@section('content')
<div class="yktypeline">
    <span >游客客源地分析</span>
    <select id="syear"onchange="yearChange()">
        @foreach ($years as $year)
        <option value="{{$year}}">{{$year}}</option>
        @endforeach
    </select>
    <span >年</span> 
</div>
<div id="yksource" style="min-width:800px;height:500px"></div>
@endsection
<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    var yksources=new Array();
    var years=new Array();
    var number=new Array();
    var province=new Array();
    years=<?php echo json_encode($years);?>;
    console.log(years);
    yksources=<?php echo json_encode($yksources);?>;
    for(key in yksources){
        console.log(yksources[key]['number']);
        console.log(yksources[key]['province']);
        province[key]=yksources[key]['province'];
        number[key]=yksources[key]['number'];
    }

   function yearChange()
   {
    var objS = document.getElementById("syear");
    var year = objS.options[objS.selectedIndex].value;
    console.log(year);
    $.ajax({
        type: 'post',
        url : "yearOfyksource",
        data : {"year":year},
        dataType:'JSON', 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success : function(data) {
            yksources.splice(0,yksources.length);
            province.splice(0,province.length);
            number.splice(0,number.length);            
            yksources=data;

            for(key in yksources){
                //console.log(yksources[key]['number']);
                //console.log(yksources[key]['province']);
                province[key]=yksources[key]['province'];
                number[key]=yksources[key]['number'];
            }
            kySourceChart();
           //console.log(yksources);

        },
        error : function(err) {
            //layer.msg('请按要求输入！');
        }
    });
   }
function kySourceChart()
{
    $('#yksource').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: '技术支持 by highcharts'
        },
        xAxis: {
            categories:province             //横坐标
        },
        yAxis: {
            min: 0,
            title: {
                text: '人数(人)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<td style="color:{series.color};padding:0"></td>' +'{point.y:.0f}人',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: '客源前十',
            data: number,
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                x: 4,
                y: 10,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif',
                    textShadow: '0 0 3px black'
                }
            }
        }]
    });    
}
$(function () {
    kySourceChart();
});
</script>