@extends('user.layout.base')

@section('title', 'Ride Confirmation ')

@section('styles')
<style type="text/css">
    .surge-block{
        background-color: black;
        width: 50px;
        height: 50px;
        border-radius: 25px;
        margin: 0 auto;
        padding: 10px;
        padding-top: 15px;
    }
    .surge-text{
        top: 11px;
        font-weight: bold;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="col-md-9">
    <div class="dash-content">
        <div class="row no-margin">
            <div class="col-md-12">
                <h4 class="page-title">@lang('user.ride.ride_now')</h4>
            </div>
        </div>
        @include('common.notify')
        <div class="row no-margin">
            <div class="col-md-6">
                <form action="{{url('create/ride')}}" method="POST" id="create_ride">

                {{ csrf_field() }}
                    <dl class="dl-horizontal left-right">
                        <dt>@lang('user.type')</dt>
                        <dd>{{$service->name}}</dd>
                        <dt>@lang('user.total_distance')</dt>
                        <dd>{{$fare->distance}} Kms</dd>
                        <dt>@lang('user.eta')</dt>
                        <dd>{{$fare->time}}</dd>
                        <dt>@lang('user.estimated_fare')</dt>
                        <dd>{{currency($fare->estimated_fare)}}</dd>
                        <hr>
                        @if(Auth::user()->wallet_balance > 0)

                        <input type="checkbox" name="use_wallet" value="1"><span style="padding-left: 15px;">@lang('user.use_wallet_balance')</span>
                        <br>
                        <br>
                            <dt>@lang('user.available_wallet_balance')</dt>
                            <dd>{{currency(Auth::user()->wallet_balance)}}</dd>
                        @endif
                    </dl>

                    <input type="hidden" name="s_address" id="origin-input" value="{{Request::get('s_address')}}">
                    <input type="hidden" name="d_address" id="destination-input" value="{{Request::get('d_address')}}">
                    <input type="hidden" name="s_latitude" value="{{Request::get('s_latitude')}}">
                    <input type="hidden" name="distance" value="{{$fare->distance}}">
                    <input type="hidden" name="s_latitude" id="origin_latitude" value="{{Request::get('s_latitude')}}">
                    <input type="hidden" name="s_longitude" id="origin_longitude" value="{{Request::get('s_longitude')}}">
                    <input type="hidden" name="d_latitude" id="destination_latitude" value="{{Request::get('d_latitude')}}">
                    <input type="hidden" name="d_longitude" id="destination_longitude" value="{{Request::get('d_longitude')}}">
                    <input type="hidden" name="current_longitude" id="long">
                    <input type="hidden" name="current_latitude" id="lat">

                    <p>@lang('user.payment_method')</p>
                    <select class="form-control" name="payment_mode" id="payment_mode" onchange="card(this.value);">
                      <option value="CASH">CASH</option>
                      @if(Setting::get('CARD') == 1)
                      @if($cards->count() > 0)
                        <option value="CARD">CARD</option>
                      @endif
                      @endif
                    </select>
                    <br>

                    @if(Setting::get('CARD') == 1)
                        @if($cards->count() > 0)
                        <select class="form-control" name="card_id" style="display: none;" id="card_id">
                          <option value="">Select Card</option>
                          @foreach($cards as $card)
                            <option value="{{$card->card_id}}">{{$card->brand}} **** **** **** {{$card->last_four}}</option>
                          @endforeach
                        </select>
                        @endif
                    @endif

                    @if($fare->surge == 1)

                        <span><em>Note : Due to High Demand the fare may vary!</em></span>
                        <div class="surge-block"><span class="surge-text">{{$fare->surge_value}}</span>
                        </div>

                    @endif

                    <button type="submit" class="half-primary-btn fare-btn">@lang('user.ride.ride_now')</button>
                    <button type="button" class="half-secondary-btn fare-btn" data-toggle="modal" data-target="#schedule_modal">Schedule Later</button>

                </form>
            </div>

            <div class="col-md-6">
                <div class="user-request-map">
                    <?php
                    $map_icon = asset('asset/img/marker-start.png');
                    $static_map = "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=600x450&maptype=roadmap&format=png&visual_refresh=true&markers=icon:".$map_icon."%7C".$request->s_latitude.",".$request->s_longitude."&markers=icon:".$map_icon."%7C".$request->d_latitude.",".$request->d_longitude."&path=color:0x191919|weight:8|enc:".$request->route_key."&key=".env('GOOGLE_MAP_KEY'); ?>
                    <div class="map-static map-responsive" id="map"  >
                    </div>
                    <div class="from-to row no-margin">
                        <div class="from">
                            <h5>FROM</h5>
                            <p>{{$request->s_address}}</p>
                        </div>
                        <div class="to">
                            <h5>TO</h5>
                            <p>{{$request->d_address}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<!-- Schedule Modal -->
<div id="schedule_modal" class="modal fade schedule-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Schedule a Ride</h4>
      </div>
      <form>
      <div class="modal-body">

        <label>Date</label>
        <input value="{{date('m/d/Y')}}" type="text" id="datepicker" placeholder="Date" name="schedule_date">
        <label>Time</label>
        <input value="{{date('H:i')}}" type="text" id="timepicker" placeholder="Time" name="schedule_time">

      </div>
      <div class="modal-footer">
        <button type="button" id="schedule_button" class="btn btn-default" data-dismiss="modal">Schedule Ride</button>
      </div>

      </form>
    </div>

  </div>
</div>


@endsection

@section('scripts')

    <script type="text/javascript">
        var current_latitude = 13.0574400;
        var current_longitude = 80.2482605;
        var s_latitude = parseFloat('{{Request::get('s_latitude')}}');
        var d_longitude = parseFloat('{{Request::get('d_longitude')}}');
        var s_longitude = parseFloat('{{Request::get('s_longitude')}}');
        var d_latitude = parseFloat('{{Request::get('d_latitude')}}');
        var s_position, d_position;
        var poly, geodesicPoly;
        var markerArray = [];
        function initMap() {
          var directionsService = new google.maps.DirectionsService;
          var stepDisplay = new google.maps.InfoWindow;
          var map = new google.maps.Map(document.getElementById('map'), {
              mapTypeControl: false,
              zoomControl: true,
              center: {lat: current_latitude, lng: current_longitude},
              zoom: 15,
                styles : [{"elementType":"geometry","stylers":[{"color":"#f5f5f5"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"color":"#e4e8e9"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#7de843"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#9bd0e8"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}]
          });
          var directionsDisplay = new google.maps.DirectionsRenderer({map: map});
          directionsService.route({
            origin: document.getElementById('origin-input').value,
            destination: document.getElementById('destination-input').value,
            travelMode: 'DRIVING'
          }, function(response, status) {
            // Route the directions and pass the response to a function to create
            // markers for each step.
            if (status === 'OK') {
              directionsDisplay.setDirections(response);
              // showSteps(response, markerArray, stepDisplay, map);
            } else {
              window.alert('Directions request failed due to ' + status);
            }
          });

          function showSteps(directionResult, markerArray, stepDisplay, map) {
           var myRoute = directionResult.routes[0].legs[0];
           for (var i = 0; i < myRoute.steps.length; i++) {
             var marker = markerArray[i] = markerArray[i] || new google.maps.Marker;
             marker.setMap(map);
             marker.setPosition(myRoute.steps[i].start_location);

           }
         }

        }








        $(document).ready(function(){
            $('#schedule_button').click(function(){
                $("#datepicker").clone().attr('type','hidden').appendTo($('#create_ride'));
                $("#timepicker").clone().attr('type','hidden').appendTo($('#create_ride'));
                document.getElementById('create_ride').submit();
            });
        });
    </script>
    <script type="text/javascript">
        var date = new Date();
        date.setDate(date.getDate()-1);
        $('#datepicker').datepicker({
            startDate: date
        });
        $('#timepicker').timepicker({showMeridian : false});
    </script>
    <script type="text/javascript">
        function card(value){
            if(value == 'CARD'){
                $('#card_id').fadeIn(300);
            }else{
                $('#card_id').fadeOut(300);
            }
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initMap"></script>

@endsection
