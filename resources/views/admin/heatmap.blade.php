@extends('admin.layout.base')

@section('title', 'Dashboard ')

@section('styles')
	<link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">
@endsection

@section('content')
<?php $diff = ['-success','-info','-warning','-danger']; ?>

<div class="content-area py-1">
<div class="container-fluid">
		<div class="box box-block bg-white">
				<div class="clearfix mb-1">
					<h5 class="float-xs-left">@lang('admin.heatmap.Ride_Heatmap')</h5>
					<div class="float-xs-right">
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<div id="world" style="height: 400px;"></div>
					</div>
					<div class="col-md-4 demo-progress">
							<h5 class="mb-2">Drivers Rating</h5>
							@if($providers->count() > 0)
								@foreach($providers as $provider)
								<p class="mb-0-5">{{$provider->first_name}} {{$provider->last_name}} <span class="float-xs-right">{{($provider->rating/5)*100}}%</span></p>
								<progress class="progress progress{{$diff[array_rand($diff)]}} progress-sm" value="{{$provider->rating}}" max="5"></progress>
								@endforeach
							@endif
					</div>
				</div>
			</div>
	</div>
</div>
@endsection

@section('scripts')
	<script type="text/javascript" src="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('main/vendor/jvectormap/jquery-jvectormap-world-mill.js')}}"></script>

	<script type="text/javascript">
		$(document).ready(function(){

		        /* Vector Map */
		    $('#world').vectorMap({
		        zoomOnScroll: false,
		        map: 'world_mill',
		        markers: [
		        @foreach($rides as $ride)
		        	@if($ride->status != "CANCELLED")
		            {latLng: [{{$ride->s_latitude}}, {{$ride->s_longitude}}], name: '{{$ride->user->first_name}}'},
		            @endif
		        @endforeach

		        ],
		        normalizeFunction: 'polynomial',
		        backgroundColor: 'transparent',
		        regionsSelectable: true,
		        markersSelectable: true,
		        regionStyle: {
		            initial: {
		                fill: 'rgba(0,0,0,0.15)'
		            },
		            hover: {
		                fill: 'rgba(0,0,0,0.15)',
		            stroke: '#fff'
		            },
		        },
		        markerStyle: {
		            initial: {
		                fill: '#43b968',
		                stroke: '#fff'
		            },
		            hover: {
		                fill: '#3e70c9',
		                stroke: '#fff'
		            }
		        },
		        series: {
		            markers: [{
		                attribute: 'fill',
		                scale: ['#43b968','#a567e2', '#f44236'],
		                values: [200, 300, 600, 1000, 150, 250, 450, 500, 800, 900, 750, 650]
		            },{
		                attribute: 'r',
		                scale: [5, 15],
		                values: [200, 300, 600, 1000, 150, 250, 450, 500, 800, 900, 750, 650]
		            }]
		        }
		    });
		});
	</script>

@endsection