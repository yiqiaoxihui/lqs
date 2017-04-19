@extends('layouts.app')

@section('title', '收入总统计')

@section('content')
    	<div id="incomeSum" style="min-width:700px;height:500px"></div>
        <div id="incomeSumPie"></div>
@endsection
<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
var Xyear=new Array();
var teams=new Array();
var individuals=new Array();
var LastYear=new Array();
var ThisYear=new Array();
LastYear=<?php echo json_encode($lastY);?>;
ThisYear=<?php echo json_encode($thisY);?>;
Xyear[0]=LastYear['0']['year'];
Xyear[1]=ThisYear['0']['year'];
teams[0]=LastYear['0']['team'];
teams[1]=ThisYear['0']['team'];
individuals[0]=LastYear['0']['individual'];
individuals[1]=ThisYear['0']['individual'];

console.log(LastYear);

$(function () {
    $('#incomeSum').highcharts({
        chart: {
            type: 'column'
        },
        title: {
        	style:{
			   color: '#3E576F',
			   fontSize: '30px'
			 },
            text: '收入总统计'
        },
        subtitle: {
            text: '技术支持 by highcharts'
        },
        xAxis: {
            categories:Xyear
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
            name: "团队",
            data: teams

        }, {
            name: "散客",
            data: individuals

        }]
    });
});

// $(function () {
//     $('#incomeSumPie').highcharts({
//         chart: {
//             plotBackgroundColor: null,
//             plotBorderWidth: null,
//             plotShadow: false
//         },
//         title: {
//             text: ''
//         },
//         tooltip: {
//             pointFormat: '{series.name}: <b>{point.y:.3f}万元</b>'
//         },
//         plotOptions: {
//             pie: {
//                 allowPointSelect: true,
//                 cursor: 'pointer',
//                 dataLabels: {
//                     enabled: true,
//                     color: '#000000',
//                     connectorColor: '#000000',
//                     format: '<b>{point.name}</b>: {point.y:.3f}万元'
//                 }
//             }
//         },
//         series: [{
//             type: 'pie',
//             name: '',
//             data: [
//                 {
//                     color:"#37ca2e",
//                     name: LastYear['0']['year']+"年",
//                     y: LastAll,
//                     sliced: true,
//                     selected: true
//                 },
//                 {
//                     name: ThisYear['0']['year']+"年",
//                     y: ThisAll,
//                     sliced: true,
//                     selected: true
//                 }

//             ]

//         }]
//     });
// });
</script>