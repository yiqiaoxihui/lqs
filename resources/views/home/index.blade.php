@extends('layouts.app')

@section('title', '近七日游客走势图')

@section('content')
    	<div id="yktrend" style="min-width:700px;height:600px"></div>
@endsection
<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    //alert("我是浏览器默认alert!");
	var jstrends=new Array();
	var jsdate=new Array();
	var jsnumber=new Array();
	jstrends=<?php echo json_encode($yktrends);?>;
	//console.log(jstrends['0']['id']);
	var trendslen=jstrends.length;
	for(key in jstrends){
		console.log(jstrends[trendslen-key-1]['ydate']);
		console.log(jstrends[trendslen-key-1]['number']);
		jsdate[key]=jstrends[trendslen-key-1]['ydate'];
		jsnumber[key]=jstrends[trendslen-key-1]['number'];
	}

$(function () {
    $('#yktrend').highcharts({
        chart: {
            type: 'line'
        },
        exporting :{
	      url:'http://localhost/export/index.php'
		},
        title: {
        	style:{
			   color: '#3E576F',
			   fontSize: '26px'
			 },
            text: '近七日游客走势图'
        },
        subtitle: {
            text: '技术支持 by highchars'
        },
        xAxis: {
            categories: jsdate
        },
        yAxis: {
            title: {
                text: '人数（人）'
            },
            lineWidth: 1

        },
        tooltip: {
            enabled: true,
            formatter: function() {
                return '<b>'+ this.x +': ' +'</b><br/>'+ this.y +'人';
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        return  this.y +'人';
                    }
                },
                enableMouseTracking: true
            }
        },
        series: [{
            name: '近七日游客走势图',
            data: jsnumber
        }]
    });
});
</script>