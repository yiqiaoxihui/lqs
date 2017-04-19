@extends('layouts.app')

@section('title', '游客数量走势图')

@section('content')
    	<div id="yknumber" style="min-width:700px;height:600px"></div>

@endsection
<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
	var yknumbers=new Array();
	var month=new Array();//月份
	var team=new Array();//团队
    var individual=new Array();//散客
	yknumbers=<?php echo json_encode($yknumbers);?>;
	//console.log(jstrends['0']['id']);
	var yknumberslen=yknumbers.length;
	for(key in yknumbers){
		console.log(yknumbers[yknumberslen-key-1]['team']);
		console.log(yknumbers[yknumberslen-key-1]['individual']);
        console.log(yknumbers[yknumberslen-key-1]['month']);
        month[key]=yknumbers[yknumberslen-key-1]['month'];
		team[key]=yknumbers[yknumberslen-key-1]['team'];
		individual[key]=yknumbers[yknumberslen-key-1]['individual'];
	}
$(function () {
    $('#yknumber').highcharts({
        chart: {
            type: 'spline'
        },
        exporting :{
	      url:'http://localhost/export/index.php'
		},
        title: {
        	style:{
			   color: '#3E576F',
			   fontSize: '26px'
			 },
            text: '游客数量走势图'
        },
        subtitle: {
            text: '技术支持 by highchars'
        },
        xAxis: {
            categories: month
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
            spline: {
                dataLabels: {
                    enabled: true,
                    formatter: function() 
                    {
                        return this.y+"人";
                    }
                },
                enableMouseTracking: true
            }
        },
        series: [{
                name: '团体',
                data: team,
                color:"#37ca2e"
                },
                {
                    name: '个人',
                    data: individual
                }
            ]
    });
});
</script>