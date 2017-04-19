@extends('layouts.app')

@section('title', '游客人数同期比')

@section('content')
<div class="yktypeline">
    <span >游客人数同期比</span>
    <select id="syear"onchange="yearChange()">
        @foreach ($years as $year)
        <option value="{{$year}}">{{$year}}</option>
        @endforeach
    </select>
    <span >年</span> 
</div>
<div id="ykCompare" style="min-width:700px;height:600px"></div>
<div id="ykComparePie"></div>
@endsection
<script src="{{asset('jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
	var LastYear=new Array();
	var ThisYear=new Array();
	var LastMonth=new Array();
    var LastNumber=new Array();
    var ThisMonth=new Array();
    var ThisNumber=new Array();   
    var LastAll=0;
    var ThisAll=0;
	LastYear=<?php echo json_encode($lastY);?>;
    ThisYear=<?php echo json_encode($thisY);?>;
	for(key in LastYear){
        LastMonth[key]=LastYear[key]['month'];
		LastNumber[key]=LastYear[key]['number'];
        LastAll+=LastYear[key]['number'];
	}
    for(key in ThisYear){
        ThisMonth[key]=ThisYear[key]['month'];
        ThisNumber[key]=ThisYear[key]['number'];
        ThisAll+=ThisYear[key]['number'];
    }
   function yearChange()
   {
    var objS = document.getElementById("syear");
    var year = objS.options[objS.selectedIndex].value;
    console.log(year);
    $.ajax({
        type: 'post',
        url : "{{url("yearOfYkCompare")}}",
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
                LastNumber[key]=LastYear[key]['number'];
                LastAll+=LastYear[key]['number'];
            }
            for(key in ThisYear){
                ThisMonth[key]=ThisYear[key]['month'];
                ThisNumber[key]=ThisYear[key]['number'];
                ThisAll+=ThisYear[key]['number'];
            }
            ykCompareCharts();
        },
        error : function(err) {
            layer.msg('请按要求输入！');
        }
    });
   }
function ykCompareCharts(){
    $('#ykCompare').highcharts({
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
            text: ''
        },
        subtitle: {
            text: '技术支持 by highchars'
        },
        xAxis: {
            categories: LastMonth
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
                return '<b>'+this.series.name+'年'+ this.x +'月份: ' +'</b><br/>'+ this.y +'人';
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
                    color:"#37ca2e",
                    name:LastYear['0']['year']+"年",
                    data: LastNumber
                },
                {
                    name:ThisYear['0']['year']+"年",
                    data:ThisNumber
                }
            ]
    });
    $('#ykComparePie').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.0f}人</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.y:.0f}人'
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
                    
                    // sliced: true,
                    // selected: true,

                },
                {
                    name: ThisYear['0']['year']+"年",
                    y: ThisAll,
                    // sliced: true,
                    // selected: true,
                }

            ]
        }]
    });
}
$(function () {
    ykCompareCharts();
});


</script>