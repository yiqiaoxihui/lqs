@extends('layouts.app')

@section('title', '收入来源分析')

@section('content')
<div class="yktypeline">
    <span >收入来源分析</span>
    <select id="syear"onchange="yearChange()">
        @foreach ($years as $year)
        <option value="{{$year}}">{{$year}}</option>
        @endforeach
    </select>
    <span >年</span> 
</div>
<div id="incomeCompare" style="min-width:700px;height:500px"></div>
@endsection
<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    var incomesources=new Array();
    var years=new Array();
    years=<?php echo json_encode($years);?>;
    //console.log(years);
    var chartdata=[];
    var AllIncome=0;
    incomesources=<?php echo json_encode($incomesources);?>;
    console.log(incomesources);
    for(key in incomesources)
    {
        AllIncome+=incomesources[key]['money'];
        chartdata.push([incomesources[key]['bank'],incomesources[key]['money']]);
    }

   function yearChange()
   {
    var objS = document.getElementById("syear");
    var year = objS.options[objS.selectedIndex].value;
    console.log(year);
    $.ajax({
        type: 'post',
        url : "{{url("yearOfIncomeSource")}}",
        data : {"year":year},
        dataType:'JSON', 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success : function(data) {
            chartdata.splice(0,chartdata.length);
            AllIncome=0;
            for(key in incomesources)
            {
                AllIncome+=data[key]['money'];
                chartdata.push([data[key]['bank'],data[key]['money']]);
            }
            console.log(AllIncome);
            incomeCompare();
        },
        error : function(err) {
            layer.msg('请按要求输入！');
        }
    });
   }
function incomeCompare()
{
    $('#incomeCompare').highcharts({
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