@extends('templates.main')
@section('content') 
    @if(Session::get('message'))
    <?php $message = Session::get('message');?>
    <div class="alert alert-block alert-{{$message[0]}}">
    	<a href="#" data-dismiss="alert" class="close">×</a>
    	<h4>{{$message[1]}}</h4>
    	{{$message[2]}}
    </div>
    @endif
    @include('BaseAnalytics')
    
    <script type="text/javascript">
    	google.load('visualization', '1.0', {'packages':['corechart']});

		google.setOnLoadCallback(function(){
			var json_text = $.ajax({
				type: 'POST',
				url: "{{url('/analytics/getData')}}",
				data: {
					channel_id : {{$channel_id}}},
				dataType:"json",
				async: false
			}).responseText;
			var json = eval("(" + json_text + ")");
			var dados = new google.visualization.DataTable(json.dados);

			var chart = new google.visualization.LineChart(document.getElementById('area_grafico'));
			chart.draw(dados, json.config);
		});
    </script>
    <div id="area_grafico"></div>
    
@stop