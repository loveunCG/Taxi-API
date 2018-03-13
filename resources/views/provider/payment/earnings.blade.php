@extends('provider.layout.app')

@section('content')
<div class="pro-dashboard-head">
        <div class="container">
            <a href="{{url('provider/earnings')}}" class="pro-head-link active">Payment Statements</a>
             <a href="{{url('provider/upcoming')}}" class="pro-head-link">Upcoming</a>
   <!--         <a href="new-provider-patner-invoices.html" class="pro-head-link">Payment Invoices</a>
            <a href="new-provider-banking.html" class="pro-head-link">Banking</a> -->
        </div>
    </div>

    <div class="pro-dashboard-content">
        <!-- Earning head -->
        <div class="earning-head">
            <div class="container">
                <div class="earning-element">
                    <p class="earning-txt">TOTAL EARNINGS</p>
                    <p class="earning-price" id="set_fully_sum">00.00</p>
                </div>
                <div class="earning-element row no-margin">

                 <div class="col-lg-2 col-md-3 col-sm-3 col-xs-4">
                        <div class="earning-box">
                            <p class="dashboard-count">{{$today}}</p>
                            <p class="dashboard-txt">TRIPS COMPLETED TODAY</p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-4">
                        <div class="earning-box">
                            <p class="dashboard-count">{{Setting::get('daily_target',0)}}</p>
                            <p class="dashboard-txt">DAILY TRIP TARGET </p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-4">
                        <div class="earning-box">
                            <p class="dashboard-count">{{$provider[0]->accepted->count()}}</p>
                            <p class="dashboard-txt">FULLY COMPLETED TRIPS</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-4">
                        <div class="earning-box">
                            <p class="dashboard-count">
                            @if($provider[0]->accepted->count() != 0)
                                {{$provider[0]->accepted->count()/$provider[0]->accepted->count()*100}}%
                            @else
                            	0%
                            @endif
                            </p>
                            <p class="dashboard-txt">ACCEPTANCE RATE</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-4">
                        <div class="earning-box">
                            <p class="dashboard-count">
                                {{$provider[0]->cancelled->count()}}
                            </p>
                            <p class="dashboard-txt">DRIVER CANCELLATIONS</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- End of earning head -->

        <!-- Earning Content -->
        <div class="earning-content gray-bg">
            <div class="container">

                <!-- Earning section -->
                <div class="earning-section pad20 row no-margin">
                    <div class="earning-section-head">
                        <h3 class="earning-section-tit">Weekly Earnings</h3>
                    </div>

                    <!-- Earning acc-wrapper -->
                    <div class="col-lg-7 col-md-8 col-sm-10 col-xs-12 no-padding"">
                        <div class="earn-acc-wrapper">
                            <div class="earning-acc pad20">
                                <!-- Earning acc head -->
                                <div class="row no-margin">
                                    <div class="pull-left trip-left">
                                        <h3 data-toggle="collapse" data-target="#demo1" class="accordion-toggle collapsed acc-tit">
                                            <span class="arrow-icon fa fa-chevron-right"></span>Trip Earnings
                                        </h3>
                                    </div>
                                </div>
                                <!-- End of eaning acc head -->
                                <!-- Earning acc body -->
                                <div class="accordian-body earning-acc-body collapse row" id="demo1">
                                    <table class="table table-condensed table-responsive" style="border-collapse:collapse;">
                                        <tbody>
                                        <?php $sum_weekly = 0; ?>
                                        @foreach($weekly as $day)
                                            <tr>
                                                <td>
                                                @if($day->created_at)
                                                    {{date('Y-m-d',strtotime($day->created_at))}} - {{$day->created_at->diffForHumans()}}
                                                @else
                                                    -
                                                @endif
                                                </td>
                                                <td class="text-right">
                                                @if($day->payment != "")
                                                {{currency($day->payment->provider_pay)}}
                                                @else
                                                {{currency(0.00)}}
                                                @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- End of earning acc-body -->
                            </div>
                            <div class="earning-acc pad20 border-top">
                                <div class="row no-margin">
                                    <div class="pull-left trip-left">
                                        <h3 class="acc-tit estimate-tit">
                                            Estimated Payout
                                        </h3>
                                    </div>

                                    <div class="pull-right trip-right">
                                        <p class="earning-cost no-margin">{{currency($weekly_sum)}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of earning acc-wrapper -->
                </div>
                <!-- End of earning section -->

                <!-- Earning section -->
                <div class="earning-section earn-main-sec pad20">
                    <!-- Earning section head -->
                    <div class="earning-section-head row no-margin">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 no-left-padding">
                            <h3 class="earning-section-tit">Daily Earnings</h3>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <div class="daily-earn-right text-right">
                                <div class="status-block display-inline row no-margin">
                                    <form class="form-inline status-form">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select type="password" class="form-control mx-sm-3">
                                                <option>All Trips</option>
                                                <option>Completed</option>
                                                <option>Pending</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <!-- View tab -->

                                <!-- End of view tab -->
                            </div>
                        </div>
                    </div>
                    <!-- End of earning section head -->

                    <!-- Earning-section content -->
                    <div class="tab-content list-content">
                        <div class="list-view pad30 ">

                            <table class="earning-table table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Pickup Time</th>
                                        <th>Booking Id</th>
                                        <th>Vehicle</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Distance(KM)</th>
                                        <th>Invoice Amount</th>
                                        <th>Cash Collected</th>
                                        <th>Total Earnings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $fully_sum = 0; ?>
                                @foreach($fully as $each)
                                    <tr>
                                        <td>{{date('Y D, M d - H:i A',strtotime($each->created_at))}}</td>
                                        <td>{{ $each->booking_id }}</td>
                                        <td>
                                        	@if($each->service_type)
                                        		{{$each->service_type->name}}
                                        	@endif
                                        </td>
                                        <td>
                                        	@if($each->finished_at != null && $each->started_at != null) 
                                                <?php 
                                                $StartTime = \Carbon\Carbon::parse($each->started_at);
                                                $EndTime = \Carbon\Carbon::parse($each->finished_at);
                                                echo $StartTime->diffInHours($EndTime). " Hours";
                                                echo " ".$StartTime->diffInMinutes($EndTime). " Minutes";
                                                ?>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{$each->status}}</td>
                                        <td>{{$each->distance}}Kms</td>
                                        <td> 
                                            @if($day->payment != "")
                                            {{currency($day->payment->total)}}
                                            @else
                                            {{currency(0.00)}}
                                            @endif
                                        </td>
                                        <td>
                                        	@if($each->payment != "")
                                        		<?php $each_sum = 0;
                                        		$each_sum = $each->payment->provider_pay;
                                        		$fully_sum += $each_sum;
                                        		?>
                                        		{{currency($each_sum)}}
                                        	@endif
                                        </td>
                                        <td>{{currency($fully_sum)}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                <!-- End of earning section -->
            </div>
        </div>
        <!-- Endd of earning content -->
    </div>                
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	document.getElementById('set_fully_sum').textContent = "{{currency($fully_sum)}}";
</script>
@endsection