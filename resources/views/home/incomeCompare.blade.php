@extends('layouts.app')

@section('title', '收入同期比')

@section('content')
<div class="yktypeline">
    <span >收入同期比</span>
    <select id="syear"onchange="yearChange()">
        @foreach ($years as $year)
        <option value="{{$year}}">{{$year}}</option>
        @endforeach
    </select>
    <span >年</span> 
</div>
    	<div id="incomeCompare" style="min-width:700px;height:500px"></div>
        <div id="incomeComparePie"></div>
@endsection
<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
	var LastYear=new Array();
	var ThisYear=new Array();
	var LastMonth=new Array();
    var LastMoney=new Array();
    var ThisMonth=new Array();
    var ThisMoney=new Array();   
    var LastAll=0;
    var ThisAll=0;
	LastYear=<?php echo json_encode($lastY);?>;
    ThisYear=<?php echo json_encode($thisY);?>;
	for(key in LastYear){
        LastMonth[key]=LastYear[key]['month'];
		LastMoney[key]=LastYear[key]['money'];
        LastAll+=LastYear[key]['money'];
	}
    for(key in ThisYear){
        ThisMonth[key]=ThisYear[key]['month'];
        ThisMoney[key]=ThisYear[key]['money'];
        ThisAll+=ThisYear[key]['money'];
    }
    //console.log(ThisYear);

   function yearChange()
   {
    var objS = document.getElementById("syear");
    var year = objS.options[objS.selectedIndex].value;
    console.log(year);
    $.ajax({
        type: 'post',
        url : "{{url("yearOfIncomeCompare")}}",
        data : {"year":year},
        dataType:'JSON', 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success : function(data) {

            LastYear=data['lastY'];
            ThisYear=data['thisY'];

            for(key in LastYear){
                LastMonth[key]=LastYear[key]['month'];
                LastMoney[key]=LastYear[key]['money'];
                LastAll+=LastYear[key]['money'];
            }
            for(key in ThisYear){
                ThisMonth[key]=ThisYear[key]['month'];
                ThisMoney[key]=ThisYear[key]['money'];
                ThisAll+=ThisYear[key]['money'];
            }
            console.log(LastMonth);
            incomeCompareCharts();
        },
        error : function(err) {
            layer.msg('请按要求输入！');
        }
    });
   }
function incomeCompareCharts()
{
$('#incomeCompare').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            style:{
               color: '#3E576F',
               fontSize: '30px'
             },
            text: ''
        },
        subtitle: {
            text: '技术支持 by highcharts'
        },
        xAxis: {
            categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ]
        },
        yAxis: {
            min: 0,
            title: {
                text: '万元'
            }
        },
        tooltip: {
            headerFormat: '{point.key}<br>',
            pointFormat: '<tr>{series.name}: '+'<b>{point.y:.3f} 万元</b><br>',
            footerFormat: '',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    x: 0,
                    y: 10,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                },
                pointPadding: 0.2,
                borderWidth: 0
            }
        },

        series: [{
            color:"#37ca2e",
            name: LastYear['0']['year'],
            data: LastMoney

        }, {
            name: ThisYear['0']['year'],
            data: ThisMoney

        }]
    });
    $('#incomeComparePie').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.3f}万元</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.y:.3f}万元'
                }
            }
        },
        series: [{
            type: 'pie',
            name: '',
            data: [
                {
                    color:"#37ca2e",
                    name: LastYear['0']['year']+"年",
                    y: LastAll,
                    sliced: true,
                    selected: true
                },
                {
                    name: ThisYear['0']['year']+"年",
                    y: ThisAll,
                    sliced: true,
                    selected: true
                }

            ]

        }]
    });
}

$(function () {
incomeCompareCharts();
});
</script>