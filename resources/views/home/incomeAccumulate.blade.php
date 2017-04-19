@extends('layouts.app')

@section('title', '收入累计')

@section('content')

<div id="incomeAccumulate" style="min-width:700px;height:500px"></div>
@endsection
<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    var AllIncome=0;
    var incomeAccumulate=new Array();
    incomeAccumulate=<?php echo json_encode($incomeAccumulate);?>;
    console.log(incomeAccumulate);
    var chartdata=new Array();
    AllIncome=incomeAccumulate['team']+incomeAccumulate['individual']+incomeAccumulate['other'];
    chartdata.push(['团队',incomeAccumulate['team']]);
    chartdata.push(['个体',incomeAccumulate['individual']]);
    chartdata.push(['其他',incomeAccumulate['other']]);   
function incomeCompare()
{
    $('#incomeAccumulate').highcharts({
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
            text:"收入累计"
        },
        subtitle: {
            text: '技术支持 by highcharts'
        },
        labels: {
            style: {                         // 标签全局样式
                color: "#ff0000",
                fontSize: '20px',
                fontWeight: 'normal',
                fontFamily: ''        
            },
            items: [{                       // items 数组，可以设置多个标签
                html: '总金额:'+AllIncome+"万元",
                style: {                    // 标签样式，会继承和重写上层全局样式
                    left: '150px',
                    top: '0px',
                    color: 'red',
                    fontSize: '18px',
                    fontWeight: 'normal',
                    fontFamily: '' 
                }
            }]
        }, 
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br>金额:{point.y}万元'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %<br>金额:{point.y}万元'
                },
                showInLegend:true
            }
        },
        series: [{
            type: 'pie',
            name: '所占比:',
            data:  chartdata
        }]
    });
}
$(function () {
    incomeCompare();
});

</script>