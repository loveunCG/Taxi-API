@extends('provider.layout.app')

@section('content')
<div class="col-md-9">
    <div class="dash-content">
        <div class="row no-margin">
            <div class="col-md-12">
                <h4 class="page-title">My Trips</h4>
            </div>
        </div>

        <div class="row no-margin ride-detail">
            <div class="col-md-12">
                <table class="table table-condensed" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>TOS</th>
                            <th>Date</th>
                            <th>Payment</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($Jobs as $Job)
                        <tr data-toggle="collapse" data-target="#demo1" class="accordion-toggle collapsed">
                            <td><span class="arrow-icon fa fa-chevron-right"></span></td>
                            <td>{{ $Job->user->first_name }} {{ $Job->user->last_name }}</td>
                            <td>{{ $Job->payment ? $Job->payment->total : 'N/A' }}</td>
                            <td>{{ $Job->service_type->name }}</td>
                            <td>{{ $Job->created_at }}</td>
                            <td>{{ $Job->payment_mode }}</td>
                        </tr>
                        <tr class="hiddenRow">
                            <td colspan="6">
                                <div class="accordian-body collapse row" id="demo1">
                                    <div class="col-md-6">
                                        <div class="my-trip-left">
                                            <div class="map-responsive-trip">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d386950.6511603643!2d-73.70231446529533!3d40.738882125234106!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNueva+York!5e0!3m2!1ses-419!2sus!4v1445032011908" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                                            </div>
                                            <div class="from-to row no-margin">
                                                <div class="from">
                                                    <h5>FROM</h5>
                                                    <h6>{{ $Job->started_at }}</h6>
                                                    <p>{{ $Job->s_address }}</p>
                                                </div>
                                                <div class="to">
                                                    <h5>TO</h5>
                                                    <h6>{{ $Job->finished_at }}</h6>
                                                    <p>{{ $Job->d_address }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="mytrip-right">

                                            <div class="fare-break">

                                                <h4 class="text-center"><strong>FARE BREAKDOWN</strong></h4>

                                                <h5>Base Fare <span>{{ $Job->payment ? $Job->payment->base_price : 'N/A' }}</span></h5>
                                                <h5><strong>Time Based Fare </strong><span><strong>{{ $Job->payment ? $Job->payment->time_price : 'N/A' }}</strong></span></h5>
                                                <h5 class="big"><strong>TOTAL </strong><span><strong>{{ $Job->payment ? $Job->payment->total : 'N/A' }}</strong></span></h5>

                                            </div>

                                            @if($Job->rating)
                                            <div class="trip-user">
                                                <div class="rating-outer">
                                                    <input type="hidden" class="rating" value="{{ $Job->rating->provider_rating }}" />
                                                </div>
                                                <p>{{ $Job->rating->provider_comment }}</p>
                                            </div>
                                            @endif

                                        </div>

                                    </div>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @if(!count($Jobs))
                        <tr>
                            <td colspan="999">No Trips taken yet.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection