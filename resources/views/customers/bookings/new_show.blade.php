@extends('layouts.admin')
<style>
  
    /* 14-02-2024 CSS Start */
   
    #progressbar {
        width: 100%;
        position: relative;
        counter-reset: step;
        overflow: hidden;
        padding: 80px 0px 20px;
    }   
    #progressbar li {
        list-style-type: none;
        color: red;
        text-transform: uppercase;
        font-size: 9px;
        width: 10%;
        float: left;
        position: relative;
    }
    #progressbar li:before {
        content: counter(step);
        counter-increment: step;
        width: 20px;
        height: 20px;
        line-height: 20px;
        display: block;
        font-size: 0;
        color: #ffffff;
        font-weight: bold;
        background: #DCDCDC;
        border-radius: 100%;
        margin: 0 auto 5px auto;
        text-align: center;
        z-index: 2;
        position: relative;
        border: 4px solid #EFEFEF;
    }
    #progressbar li:after {
        content: '';
        width: 100%;
        border: 1px dashed #C6C6C6;
        position: absolute;
        left: -50%;
        top: 10px;
    }
    #progressbar li.active:before  {
        background: #D43031;
        color: white;
        z-index: 2;
        position: relative;
        border-color: #FFCECE;
    }
    #progressbar li.active:after {
        background: #D43031;
        z-index: 1;
        border: 1px solid;
    }
    #progressbar li.active span {
        color: #000;
    }
    #progressbar li span {
        position: absolute;
        top: -35px;
        left: 50%;
        transform: translateX(-50%);
        color: #848484;
        font-size: 12px;
        line-height: 16px;
        text-transform: uppercase;
        text-align: center;
    }
    .dashboard-detail-box .tabbing #myTab {
        width: 100% !important; 
    }
    .dashboard-detail-box .detail-body .detail-box .head {
        line-height: 30px !important;
    }
    .dashboard-detail-box .detail-body .detail-box.d-block {
        display: block;
    }
    .dashboard-detail-box .detail-body .detail-box.d-block .mb-2.d-flex {
        display: flex;
        justify-content: space-between;
    }
    .dashboard-detail-box .border-left {
        position: relative;
        margin-left: 40px;
    }
   .dashboard-detail-box .step-content-1 {
        position: relative;
        width: 100%;
    }
    .dashboard-detail-box .step-content-1::before {
        content: '';
        position: absolute;
        top: 5px;
        left: -42px;
        width: 15px;
        height: 15px;
        border: 2px solid #C6C6C6;
        border-radius: 100%;
        z-index: 11;
        background: #ffffff;
    }
    .dashboard-detail-box .step-content-1:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 10px;
        left: -35px;
        width: 1px;
        height: 100%;
        border: 1px dashed #C6C6C6;
    }
    .dashboard-detail-box .step-content-1 .value {
        display: flex !important;
    }

    </style>
@section('content')
<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <h2 class="title">
                Bookings Details
            </h2>
            <div class="searchbar">

            </div>
            <div>
                <a href="{{route('superadmin.bookings.index')}}" class="default-button-v2">
                    <span>Back</span>
                </a>
            </div>
        </header>

        @if(isset($booking))
        <div class="detail-body">
            <div class="detail-box">
                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Booking ID</span>
                            <span class="value">{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>

                        <div>
                            <span class="head">No of Container</span>
                            <span class="value">{{$booking->no_of_containers}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">from</span>
                            <span class="value">{{isset($booking->origin->fullname) ? $booking->origin->fullname :
                                '-'}}</span>
                        </div>

                        <div>
                            <span class="head">Container</span>
                            <span class="value">{{$booking->container_size}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-3/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">to</span>
                            <span class="value">{{isset($booking->destination->fullname) ?
                                $booking->destination->fullname : ''}}</span>
                        </div>

                        <div>
                            <span class="head">product</span>
                            <span class="value">{{$booking->product}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">amount</span>
                            <span class="value">{{ '$' . number_format($booking->amount, 2) }}</span>
                        </div>

                        <div>
                            <span class="head">CARGO READY</span>
                            <span class="value">{{ date('d M y', strtotime($booking->departure_date_time))
                                }}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Transportation</span>
                            <span class="value">{{$booking->transportation}}</span>
                        </div>

                        <div>
                            <span class="head">Shipping line</span>
                            <span class="value">{{isset($booking->company->name) ? $booking->company->name :
                                '-'}}</span>
                        </div>
                    </div>
                </div>

                <div class="w-2/12">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Shipping Number</span>
                            <span class="value">{{isset($booking->shipping_number) ? $booking->shipping_number :
                                '-'}}</span>
                        </div>

                        <div>
                            <span class="head">Receipt Number</span>
                            <span class="value">{{isset($booking->receipt_number) ? $booking->receipt_number :
                                '-'}}</span>
                        </div>
                    </div>
                </div>
                @php
                    $bookingStatusOptions = [
                        'BOOKING_STATUS_IN_PROGRESS' => [
                            'label' => config('constants.BOOKING_STATUS_IN_PROGRESS'),
                            'class' => 'progress',
                        ],
                        'BOOKING_STATUS_COMPLETED' => [
                            'label' => config('constants.BOOKING_STATUS_COMPLETED'),
                            'class' => 'completed',
                        ],
                        'BOOKING_STATUS_ON_HOLD' => [
                            'label' => config('constants.BOOKING_STATUS_ON_HOLD'),
                            'class' => 'hold',
                        ],
                        'BOOKING_STATUS_CANCELLED' => [
                            'label' => config('constants.BOOKING_STATUS_CANCELLED'),
                            'class' => 'cancel',
                        ],
                        'BOOKING_STATUS_CONFIRMED' => [
                            'label' => config('constants.BOOKING_STATUS_CONFIRMED'),
                            'class' => 'confirmed',
                        ],
                        'BOOKING_STATUS_SI_SUBMITTED' => [
                            'label' => config('constants.BOOKING_STATUS_SI_SUBMITTED'),
                            'class' => 'si-submitted',
                        ],
                        'BOOKING_STATUS_SI_CONFIRMED' => [
                            'label' => config('constants.BOOKING_STATUS_SI_CONFIRMED'),
                            'class' => 'progress',
                        ],
                        'BOOKING_STATUS_EVGM_SUBMITTED' => [
                            'label' => config('constants.BOOKING_STATUS_EVGM_SUBMITTED'),
                            'class' => 'progress',
                        ],
                        'BOOKING_STATUS_EVGM_CONFIRMED' => [
                            'label' => config('constants.BOOKING_STATUS_EVGM_CONFIRMED'),
                            'class' => 'progress',
                        ],
                        'BOOKING_STATUS_DRAFT_BL_RECEIVED' => [
                            'label' => config('constants.BOOKING_STATUS_DRAFT_BL_RECEIVED'),
                            'class' => 'progress',
                        ],
                        'BOOKING_STATUS_DRAFT_BL_CONFIRMED' => [
                            'label' => config('constants.BOOKING_STATUS_DRAFT_BL_CONFIRMED'),
                            'class' => 'progress',
                        ],
                        'BOOKING_STATUS_FINISHED' => [
                            'label' => config('constants.BOOKING_STATUS_FINISHED'),
                            'class' => 'defualt',
                        ],
                    ];
                @endphp

                <div class="w-2/12">
                    <div class="flex justify-between flex-col items-end h-full">
                        <div>
                            @foreach($bookingStatusOptions as $badgeClass => $status)
                                @if($booking->status == $status['label'])
                                    <span class="badge {{ $status['class'] }} {{ $badgeClass }}">
                                        {{ str_replace('_', ' ', ucwords(strtolower(substr($badgeClass, strlen('BOOKING_STATUS_'))))) }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="step-progress">
            <ul id="progressbar">
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_IN_PROGRESS') ? 'active' : '' }}"><span>NEW</span></li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_IN_PROGRESS') ? 'active' : '' }}"><span>Pending</span></li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_CONFIRMED') ? 'active' : '' }}"><span>Confirmed</span></li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_SI_SUBMITTED') ? 'active' : '' }}"><span>SI SUBMITTED</span></li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_SI_CONFIRMED') ? 'active' : '' }}"><span>SI CONFIRMED</span></li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_EVGM_SUBMITTED') ? 'active' : '' }}"><span>EVGM SUBMITTED</span></li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_EVGM_CONFIRMED') ? 'active' : '' }}"><span>EVGM CONFIRMED</span></li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_DRAFT_BL_RECEIVED') ? 'active' : '' }}"><span>DRAFT BL RECEIVED</span></li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_DRAFT_BL_CONFIRMED') ? 'active' : '' }}"><span>DRAFT BL CONFIRMED</span></li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_FINISHED') ? 'active' : '' }}"><span>FINISHED</span></li>
            </ul>
        </div>
        

        <div class="detail-body"> 
            <div class="detail-box d-block">
                <div class="tabbing">
                    <div class="mb-8 border-b border-gray-200">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                            data-tabs-toggle="#myTabContent" role="tablist">
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 pb-2 rounded-t-lg" id="all-tab" data-tabs-target="#all"
                                    type="button" role="tab" aria-controls="all" aria-selected="false">Tracking</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="finance-tab"
                                    data-tabs-target="#finance" type="button" role="tab" aria-controls="finance"
                                    aria-selected="false">Finance</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="bookinginfo-tab"
                                    data-tabs-target="#bookinginfo" type="button" role="tab" aria-controls="bookinginfo"
                                    aria-selected="false">BOOKING INFO</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="documentation-tab"
                                    data-tabs-target="#documentation" type="button" role="tab" aria-controls="documentation"
                                    aria-selected="false">DOCUMENTATION</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="shippinginfo-tab"
                                    data-tabs-target="#shippinginfo" type="button" role="tab" aria-controls="shippinginfo"
                                    aria-selected="false">shipping instructions</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="payment-tab"
                                    data-tabs-target="#payment" type="button" role="tab" aria-controls="payment"
                                    aria-selected="false">Payment</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="myTabContent">
                    <div class="border-left" id="all" role="tabpanel" aria-labelledby="all-tab">
                        @if($booking->transportation == \App\Models\Booking::LAND)
                        <div class="step-content-1">
                            <div class="mb-2 d-flex rouded-circle">
                                <h4><strong>{{isset($booking->origin->fullname) ? $booking->origin->fullname : ''}}</strong></h4>
                            </div>
                            <div class="flex">
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Movement Type</span>
                                            <span class="value flex">
                                                <svg id="truck-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 23.119 28.33"><path id="Path_739" data-name="Path 739" d="M120,318.485h8.381a.484.484,0,0,0,0-.968H120a.484.484,0,0,0,0,.968" transform="translate(-112.628 -299.227)" fill="#10b44c"></path><path id="Path_740" data-name="Path 740" d="M128.377,352.007H120a.484.484,0,0,0,0,.968h8.381a.484.484,0,0,0,0-.968" transform="translate(-112.628 -331.73)" fill="#10b44c"></path><path id="Path_741" data-name="Path 741" d="M22.977,11.951a.484.484,0,0,0-.343-.141H20.656V8.635a1.581,1.581,0,0,0-.066-.448.481.481,0,0,0,.065-.242V.484A.484.484,0,0,0,20.172,0H2.946a.484.484,0,0,0-.484.484V7.945a.481.481,0,0,0,.066.243,1.582,1.582,0,0,0-.066.447V11.81H.484A.484.484,0,0,0,0,12.294V16.67a.484.484,0,0,0,.484.484H2.462v5.482a.486.486,0,0,0-.013.111h0v1.761a1.431,1.431,0,0,0,1.232,1.416V27.24A1.091,1.091,0,0,0,4.77,28.33H7.84A1.091,1.091,0,0,0,8.93,27.24V25.915l5.8-.1V27.24a1.091,1.091,0,0,0,1.089,1.09h3.07a1.091,1.091,0,0,0,1.089-1.09V25.72h.016a1.428,1.428,0,0,0,.678-1.21V22.748a.482.482,0,0,0-.014-.113v-5.48h1.979a.484.484,0,0,0,.484-.484V12.294a.484.484,0,0,0-.142-.343M2.462,16.186H.968V12.778H2.462Zm.968.8H19.688v5.282H3.43ZM19.688,8.635V9.85H3.43V8.635a.613.613,0,0,1,.613-.611H19.075a.613.613,0,0,1,.613.611M3.43,10.817H19.688v5.2H3.43ZM19.688.968V7.18a1.58,1.58,0,0,0-.613-.124H4.043a1.581,1.581,0,0,0-.613.124V.968ZM3.417,24.509V23.232H19.7v1.277a.461.461,0,0,1-.231.4.48.48,0,0,0-.2.061c-.011,0-.021,0-.032,0H3.879a.463.463,0,0,1-.462-.462M7.962,27.24a.121.121,0,0,1-.122.122H4.77a.121.121,0,0,1-.122-.122v-1.3H7.562l.4-.007Zm11.047,0a.121.121,0,0,1-.122.122h-3.07a.121.121,0,0,1-.122-.122V25.8l3.314-.059Zm3.142-11.053H20.656V12.778h1.5Z" fill="#10b44c"></path></svg>
                                                Land
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col">
                                        <div>
                                            <span class="head mb-4">Event</span>
                                        </div>
                                        <div>
                                            <span class="value mb-4">Departure</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Date</span>
                                            <span class="value flex">
                                                {{ date('Y-m-d', strtotime($booking->departure_date_time)) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Trip Number</span>
                                            <span class="value flex">
                                                {{ isset($track_booking_response['data']) ? $track_booking_response['data']?->transportDocumentId : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Transport Name</span>
                                            <span class="value flex">
                                                {{ isset($track_booking_response['data']) ? $track_booking_response['data']?->carrier : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Notes</span>
                                            <span class="value flex">
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-content-1">
                            <div class="mb-2 d-flex rouded-circle">
                                <h4><strong>{{isset($booking->destination->fullname) ? $booking->destination->fullname : ''}}</strong></h4>                            
                            </div>
                            <div class="flex">
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Movement Type</span>
                                            <span class="value flex">
                                                <svg id="truck-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 23.119 28.33"><path id="Path_739" data-name="Path 739" d="M120,318.485h8.381a.484.484,0,0,0,0-.968H120a.484.484,0,0,0,0,.968" transform="translate(-112.628 -299.227)" fill="#10b44c"></path><path id="Path_740" data-name="Path 740" d="M128.377,352.007H120a.484.484,0,0,0,0,.968h8.381a.484.484,0,0,0,0-.968" transform="translate(-112.628 -331.73)" fill="#10b44c"></path><path id="Path_741" data-name="Path 741" d="M22.977,11.951a.484.484,0,0,0-.343-.141H20.656V8.635a1.581,1.581,0,0,0-.066-.448.481.481,0,0,0,.065-.242V.484A.484.484,0,0,0,20.172,0H2.946a.484.484,0,0,0-.484.484V7.945a.481.481,0,0,0,.066.243,1.582,1.582,0,0,0-.066.447V11.81H.484A.484.484,0,0,0,0,12.294V16.67a.484.484,0,0,0,.484.484H2.462v5.482a.486.486,0,0,0-.013.111h0v1.761a1.431,1.431,0,0,0,1.232,1.416V27.24A1.091,1.091,0,0,0,4.77,28.33H7.84A1.091,1.091,0,0,0,8.93,27.24V25.915l5.8-.1V27.24a1.091,1.091,0,0,0,1.089,1.09h3.07a1.091,1.091,0,0,0,1.089-1.09V25.72h.016a1.428,1.428,0,0,0,.678-1.21V22.748a.482.482,0,0,0-.014-.113v-5.48h1.979a.484.484,0,0,0,.484-.484V12.294a.484.484,0,0,0-.142-.343M2.462,16.186H.968V12.778H2.462Zm.968.8H19.688v5.282H3.43ZM19.688,8.635V9.85H3.43V8.635a.613.613,0,0,1,.613-.611H19.075a.613.613,0,0,1,.613.611M3.43,10.817H19.688v5.2H3.43ZM19.688.968V7.18a1.58,1.58,0,0,0-.613-.124H4.043a1.581,1.581,0,0,0-.613.124V.968ZM3.417,24.509V23.232H19.7v1.277a.461.461,0,0,1-.231.4.48.48,0,0,0-.2.061c-.011,0-.021,0-.032,0H3.879a.463.463,0,0,1-.462-.462M7.962,27.24a.121.121,0,0,1-.122.122H4.77a.121.121,0,0,1-.122-.122v-1.3H7.562l.4-.007Zm11.047,0a.121.121,0,0,1-.122.122h-3.07a.121.121,0,0,1-.122-.122V25.8l3.314-.059Zm3.142-11.053H20.656V12.778h1.5Z" fill="#10b44c"></path></svg>
                                                Land
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col">
                                        <div>
                                            <span class="head mb-4">Event</span>
                                        </div>
                                        <div>
                                            <span class="value mb-4">Departure</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Date</span>
                                            <span class="value flex">
                                                2023-04-22</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Trip Number</span>
                                            <span class="value flex">
                                                316W</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Transport Name</span>
                                            <span class="value flex">
                                                {{ isset($track_booking_response['data']) ? $track_booking_response['data']?->carrier : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Notes</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="step-content-1">
                            <div class="mb-2 d-flex rouded-circle">
                                <h4><strong>{{isset($booking->origin->port) ? $booking->origin->port : ''}}</strong></h4>                             
                            </div>
                            <div class="flex">
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Movement Type</span>
                                            <span class="value flex">
                                                <img src="/images/svg/truck-icon.svg" class="mr-2" alt="">
                                                Land
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col">
                                        <div>
                                            <span class="head mb-4">Event</span>
                                        </div>
                                        <div>
                                            <span class="value mb-4">Departure</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Date</span>
                                            <span class="value flex">
                                                {{ date('Y-m-d', strtotime($booking->departure_date_time)) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Trip Number</span>
                                            <span class="value flex">
                                                316W</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Transport Name</span>
                                            <span class="value flex">
                                                {{ isset($track_booking_response['data']) ? $track_booking_response['data']?->carrier : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Notes</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-content-1">
                            <div class="mb-2 d-flex rouded-circle">
                                <h4><strong>{{ $booking->origin->code }}</strong></h4>                            
                            </div>
                            <div class="flex">
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Movement Type</span>
                                            <span class="value flex"><svg id="ship" class="mr-2" xmlns="http://www.w3.org/2000/svg" width="15.603" height="18" viewBox="0 0 15.603 18">
                                                <path id="Path_730" data-name="Path 730" d="M12.037,455.389a2.056,2.056,0,0,1-1.3-.471l-.01-.008a1.241,1.241,0,0,0-1.624,0,2.021,2.021,0,0,1-2.611,0,1.241,1.241,0,0,0-1.624,0,2.021,2.021,0,0,1-2.611,0,1.242,1.242,0,0,0-1.624,0,.39.39,0,0,1-.494-.6,2.02,2.02,0,0,1,2.611,0,1.242,1.242,0,0,0,1.624,0,2.02,2.02,0,0,1,2.611,0,1.242,1.242,0,0,0,1.624,0,2.018,2.018,0,0,1,2.6-.008l.01.008a1.241,1.241,0,0,0,1.624,0,2.021,2.021,0,0,1,2.611,0,.39.39,0,0,1-.494.6,1.242,1.242,0,0,0-1.624,0,2.057,2.057,0,0,1-1.305.478Z" transform="translate(0 -437.389)" fill="#423460"/>
                                                <path id="Path_731" data-name="Path 731" d="M32.825,206.319a2.053,2.053,0,0,1-1.308-.478,1.266,1.266,0,0,0-1.624,0,2.028,2.028,0,0,1-2.611,0,1.254,1.254,0,0,0-1.62,0,2.051,2.051,0,0,1-1.309.48l-.074,0a.365.365,0,0,1-.35-.266l-2.341-7.017a.39.39,0,0,1,.2-.476l6.6-3.121a.387.387,0,0,1,.332,0l6.663,3.121a.39.39,0,0,1,.2.477l-2.341,7.017a.39.39,0,0,1-.37.267.31.31,0,0,1-.055,0Zm-6.354-1.56a2.03,2.03,0,0,1,1.306.48,1.246,1.246,0,0,0,1.623,0,2.063,2.063,0,0,1,2.613,0,1.317,1.317,0,0,0,.591.28l2.136-6.405-6.182-2.9-6.121,2.894,2.137,6.407a1.322,1.322,0,0,0,.592-.283,2.03,2.03,0,0,1,1.3-.478Z" transform="translate(-20.786 -188.319)" fill="#423460"/>
                                                <path id="Path_732" data-name="Path 732" d="M85.159,61.97a.387.387,0,0,1-.165-.037L80.448,59.8l-4.484,2.121a.39.39,0,0,1-.557-.353V57.366a.39.39,0,0,1,.39-.39h1.17v-2.73a.39.39,0,0,1,.39-.39H83.6a.39.39,0,0,1,.39.39v2.73h1.17a.39.39,0,0,1,.39.39v4.214a.39.39,0,0,1-.39.39Zm-4.712-2.988a.385.385,0,0,1,.165.037l4.157,1.947v-3.21H83.6a.39.39,0,0,1-.39-.39V54.635H77.748v2.731a.39.39,0,0,1-.39.39h-1.17v3.2l4.093-1.937a.394.394,0,0,1,.167-.037Z" transform="translate(-72.676 -51.904)" fill="#423460"/>
                                                <path id="Path_733" data-name="Path 733" d="M185.03,2.731h-1.56a.39.39,0,0,1-.39-.39V.78a.781.781,0,0,1,.78-.78h.78a.781.781,0,0,1,.78.78v1.56a.39.39,0,0,1-.39.39Zm-1.17-.78h.78V.78h-.78Z" transform="translate(-176.449)" fill="#423460"/>
                                                <path id="Path_734" data-name="Path 734" d="M205,216.691a.39.39,0,0,1-.39-.39v-9.752a.39.39,0,1,1,.78,0V216.3a.39.39,0,0,1-.39.39" transform="translate(-197.197 -198.692)" fill="#423460"/>
                                                </svg>
                                                Ship</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col">
                                        <div>
                                            <span class="head mb-4">Event</span>
                                        </div>
                                        <div>
                                            <span class="value mb-4">Arrival</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Date</span>
                                            <span class="value flex">
                                                {{ isset($track_booking_response['data']) ? Carbon\Carbon::parse($track_booking_response['data']?->originPortActualDepartureUtc)->setTimezone('UTC')->format('Y-m-d
                                                H:i') : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Trip Number</span>
                                            <span class="value flex">
                                                {{ isset($track_booking_response['data']) ? $track_booking_response['data']?->transportDocumentId : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Transport Name</span>
                                            <span class="value flex">
                                                {{ isset($track_booking_response['data']) ? $track_booking_response['data']?->carrier : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Notes</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex">
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Movement Type</span>
                                            <span class="value flex"><svg id="ship" class="mr-2" xmlns="http://www.w3.org/2000/svg" width="15.603" height="18" viewBox="0 0 15.603 18">
                                                <path id="Path_730" data-name="Path 730" d="M12.037,455.389a2.056,2.056,0,0,1-1.3-.471l-.01-.008a1.241,1.241,0,0,0-1.624,0,2.021,2.021,0,0,1-2.611,0,1.241,1.241,0,0,0-1.624,0,2.021,2.021,0,0,1-2.611,0,1.242,1.242,0,0,0-1.624,0,.39.39,0,0,1-.494-.6,2.02,2.02,0,0,1,2.611,0,1.242,1.242,0,0,0,1.624,0,2.02,2.02,0,0,1,2.611,0,1.242,1.242,0,0,0,1.624,0,2.018,2.018,0,0,1,2.6-.008l.01.008a1.241,1.241,0,0,0,1.624,0,2.021,2.021,0,0,1,2.611,0,.39.39,0,0,1-.494.6,1.242,1.242,0,0,0-1.624,0,2.057,2.057,0,0,1-1.305.478Z" transform="translate(0 -437.389)" fill="#423460"/>
                                                <path id="Path_731" data-name="Path 731" d="M32.825,206.319a2.053,2.053,0,0,1-1.308-.478,1.266,1.266,0,0,0-1.624,0,2.028,2.028,0,0,1-2.611,0,1.254,1.254,0,0,0-1.62,0,2.051,2.051,0,0,1-1.309.48l-.074,0a.365.365,0,0,1-.35-.266l-2.341-7.017a.39.39,0,0,1,.2-.476l6.6-3.121a.387.387,0,0,1,.332,0l6.663,3.121a.39.39,0,0,1,.2.477l-2.341,7.017a.39.39,0,0,1-.37.267.31.31,0,0,1-.055,0Zm-6.354-1.56a2.03,2.03,0,0,1,1.306.48,1.246,1.246,0,0,0,1.623,0,2.063,2.063,0,0,1,2.613,0,1.317,1.317,0,0,0,.591.28l2.136-6.405-6.182-2.9-6.121,2.894,2.137,6.407a1.322,1.322,0,0,0,.592-.283,2.03,2.03,0,0,1,1.3-.478Z" transform="translate(-20.786 -188.319)" fill="#423460"/>
                                                <path id="Path_732" data-name="Path 732" d="M85.159,61.97a.387.387,0,0,1-.165-.037L80.448,59.8l-4.484,2.121a.39.39,0,0,1-.557-.353V57.366a.39.39,0,0,1,.39-.39h1.17v-2.73a.39.39,0,0,1,.39-.39H83.6a.39.39,0,0,1,.39.39v2.73h1.17a.39.39,0,0,1,.39.39v4.214a.39.39,0,0,1-.39.39Zm-4.712-2.988a.385.385,0,0,1,.165.037l4.157,1.947v-3.21H83.6a.39.39,0,0,1-.39-.39V54.635H77.748v2.731a.39.39,0,0,1-.39.39h-1.17v3.2l4.093-1.937a.394.394,0,0,1,.167-.037Z" transform="translate(-72.676 -51.904)" fill="#423460"/>
                                                <path id="Path_733" data-name="Path 733" d="M185.03,2.731h-1.56a.39.39,0,0,1-.39-.39V.78a.781.781,0,0,1,.78-.78h.78a.781.781,0,0,1,.78.78v1.56a.39.39,0,0,1-.39.39Zm-1.17-.78h.78V.78h-.78Z" transform="translate(-176.449)" fill="#423460"/>
                                                <path id="Path_734" data-name="Path 734" d="M205,216.691a.39.39,0,0,1-.39-.39v-9.752a.39.39,0,1,1,.78,0V216.3a.39.39,0,0,1-.39.39" transform="translate(-197.197 -198.692)" fill="#423460"/>
                                                </svg>
                                                Ship</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col">
                                        <div>
                                            <span class="head mb-4">Event</span>
                                        </div>
                                        <div>
                                            <span class="value mb-4">Departure</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Date</span>
                                            <span class="value flex">
                                            {{ isset($track_booking_response['data']) ? Carbon\Carbon::parse($track_booking_response['data']?->finalPortActualArrivalUtc)->setTimezone('UTC')->format('Y-m-d
                                            H:i') : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Trip Number</span>
                                            <span class="value flex">
                                                {{ isset($track_booking_response['data']) ? $track_booking_response['data']?->transportDocumentId : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Transport Name</span>
                                            <span class="value flex">
                                                {{ isset($track_booking_response['data']) ? $track_booking_response['data']?->carrier : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Notes</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step-content-1">
                            <div class="mb-2 d-flex rouded-circle">
                                <h4><strong>{{isset($booking->destination->port) ? $booking->destination->port : ''}}</strong></h4>                             
                            </div>
                            <div class="flex">
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Movement Type</span>
                                            <span class="value flex">
                                                <img src="/images/svg/truck-icon.svg" class="mr-2" alt="">
                                                Land
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col">
                                        <div>
                                            <span class="head mb-4">Event</span>
                                        </div>
                                        <div>
                                            <span class="value mb-4">Departure</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Date</span>
                                            <span class="value flex">
                                                2023-04-22</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Trip Number</span>
                                            <span class="value flex">
                                                {{ isset($track_booking_response['data']) ? $track_booking_response['data']?->transportDocumentId : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Transport Name</span>
                                            <span class="value flex">
                                                {{ isset($track_booking_response['data']) ? $track_booking_response['data']?->carrier : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Notes</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="hidden" id="finance" role="tabpanel" aria-labelledby="finance-tab">
                        <div class="detail-body">
                            @if(isset($booking))
                            @include('admin.partials._booking-detail-finance', ['booking' => $booking, 'tab' => "finance-tab"])
                            @endif
                        </div>
                    </div>

                    <div class="hidden" id="bookinginfo" role="tabpanel" aria-labelledby="bookinginfo-tab">
                        <div class="detail-body">
                            @if(isset($booking))
                                <div class="rounded-lg bg-gray-50">
                                    <div class="detail-box">
                                        <div class="w-2/12">
                                            <div class="flex flex-col gap-4">
                                                <div>
                                                    <span class="head">Booking ID</span>
                                                    <span class="value">{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                                                </div>
                        
                                                <div>
                                                    <span class="head">No of Container</span>
                                                    <span class="value">{{$booking->no_of_containers}}</span>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <div class="w-3/12">
                                            <div class="flex flex-col gap-4">
                                                <div>
                                                    <span class="head">from</span>
                                                    <span class="value">{{isset($booking->origin->fullname) ? $booking->origin->fullname :
                                                        '-'}}</span>
                                                </div>
                        
                                                <div>
                                                    <span class="head">Container</span>
                                                    <span class="value">{{$booking->container_size}}</span>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <div class="w-3/12">
                                            <div class="flex flex-col gap-4">
                                                <div>
                                                    <span class="head">to</span>
                                                    <span class="value">{{isset($booking->destination->fullname) ?
                                                        $booking->destination->fullname : ''}}</span>
                                                </div>
                        
                                                <div>
                                                    <span class="head">product</span>
                                                    <span class="value">{{$booking->product}}</span>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <div class="w-2/12">
                                            <div class="flex flex-col gap-4">
                                                <div>
                                                    <span class="head">amount</span>
                                                    <span class="value">{{ '$' . number_format($booking->amount, 2) }}</span>
                                                </div>
                        
                                                <div>
                                                    <span class="head">CARGO READY</span>
                                                    <span class="value">{{ date('d M y', strtotime($booking->departure_date_time))
                                                        }}</span>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <div class="w-2/12">
                                            <div class="flex flex-col gap-4">
                                                <div>
                                                    <span class="head">Transportation</span>
                                                    <span class="value">{{$booking->transportation}}</span>
                                                </div>
                        
                                                <div>
                                                    <span class="head">Shipping line</span>
                                                    <span class="value">{{isset($booking->company->name) ? $booking->company->name :
                                                        '-'}}</span>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <div class="w-2/12">
                                            <div class="flex flex-col gap-4">
                                                <div>
                                                    <span class="head">Shipping Number</span>
                                                    <span class="value">{{isset($booking->shipping_number) ? $booking->shipping_number :
                                                        '-'}}</span>
                                                </div>
                        
                                                <div>
                                                    <span class="head">Receipt Number</span>
                                                    <span class="value">{{isset($booking->receipt_number) ? $booking->receipt_number :
                                                        '-'}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $bookingStatusOptions = [
                                                'BOOKING_STATUS_IN_PROGRESS' => [
                                                    'label' => config('constants.BOOKING_STATUS_IN_PROGRESS'),
                                                    'class' => 'progress',
                                                ],
                                                'BOOKING_STATUS_COMPLETED' => [
                                                    'label' => config('constants.BOOKING_STATUS_COMPLETED'),
                                                    'class' => 'completed',
                                                ],
                                                'BOOKING_STATUS_ON_HOLD' => [
                                                    'label' => config('constants.BOOKING_STATUS_ON_HOLD'),
                                                    'class' => 'hold',
                                                ],
                                                'BOOKING_STATUS_CANCELLED' => [
                                                    'label' => config('constants.BOOKING_STATUS_CANCELLED'),
                                                    'class' => 'cancel',
                                                ],
                                                'BOOKING_STATUS_CONFIRMED' => [
                                                    'label' => config('constants.BOOKING_STATUS_CONFIRMED'),
                                                    'class' => 'confirmed',
                                                ],
                                                'BOOKING_STATUS_SI_SUBMITTED' => [
                                                    'label' => config('constants.BOOKING_STATUS_SI_SUBMITTED'),
                                                    'class' => 'si-submitted',
                                                ],
                                                'BOOKING_STATUS_SI_CONFIRMED' => [
                                                    'label' => config('constants.BOOKING_STATUS_SI_CONFIRMED'),
                                                    'class' => 'progress',
                                                ],
                                                'BOOKING_STATUS_EVGM_SUBMITTED' => [
                                                    'label' => config('constants.BOOKING_STATUS_EVGM_SUBMITTED'),
                                                    'class' => 'progress',
                                                ],
                                                'BOOKING_STATUS_EVGM_CONFIRMED' => [
                                                    'label' => config('constants.BOOKING_STATUS_EVGM_CONFIRMED'),
                                                    'class' => 'progress',
                                                ],
                                                'BOOKING_STATUS_DRAFT_BL_RECEIVED' => [
                                                    'label' => config('constants.BOOKING_STATUS_DRAFT_BL_RECEIVED'),
                                                    'class' => 'progress',
                                                ],
                                                'BOOKING_STATUS_DRAFT_BL_CONFIRMED' => [
                                                    'label' => config('constants.BOOKING_STATUS_DRAFT_BL_CONFIRMED'),
                                                    'class' => 'progress',
                                                ],
                                                'BOOKING_STATUS_FINISHED' => [
                                                    'label' => config('constants.BOOKING_STATUS_FINISHED'),
                                                    'class' => 'defualt',
                                                ],
                                            ];
                                        @endphp
                        
                                        <div class="w-2/12">
                                            <div class="flex justify-between flex-col items-end h-full">
                                                <div>
                                                    @foreach($bookingStatusOptions as $badgeClass => $status)
                                                        @if($booking->status == $status['label'])
                                                            <span class="badge {{ $status['class'] }} {{ $badgeClass }}">
                                                                {{ str_replace('_', ' ', ucwords(strtolower(substr($badgeClass, strlen('BOOKING_STATUS_'))))) }}
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="hidden" id="documentation" role="tabpanel" aria-labelledby="documentation-tab">
                        <div class="detail-body">
                            @if(isset($booking))
                                <div class="p-4 rounded-lg bg-gray-50">
                                    <p class="text-sm text-gray-500">No documentation found</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="hidden" id="shippinginfo" role="tabpanel" aria-labelledby="shippinginfo-tab">
                        <div class="detail-body">
                            @if(isset($booking))
                                <div class="p-4 rounded-lg bg-gray-50">
                                    <p class="text-sm text-gray-500">No shipping information found</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="hidden" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                        <div class="detail-body">
                            @if(isset($booking))
                                <div class="p-4 rounded-lg bg-gray-50">
                                    <p class="text-sm text-gray-500">No payment found</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(isset($booking->addons) && count($booking->addons) > 0)
        <h2 class="title mt-8">
            Bookings Addons Details
        </h2>
        <div class="detail-body">
            @foreach ($booking->addons as $addon)
            <div class="detail-box relative">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">{{$addon->name}}</span>
                        @if($addon->type === 'toggle')
                        @if(is_numeric($addon->value))
                        <span class="value">{{ '$' . number_format($addon->value, 2) }}</span>
                        @else
                        <span class="value">{{$addon->value}}</span>
                        @endif
                        @elseif($addon->type === 'counter')
                        @if(floatval($addon->step) > 0)
                        <span class="value">{{ '$' . number_format($addon->value * floatval($addon->step) , 2) }}</span>
                        @else
                        <span class="value">{{ '$' . number_format($addon->value, 2) }}</span>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <h2 class="title mt-8">
            Bookings Price Breakdown 
        </h2>

        <div class="detail-body">
            <div class="detail-box relative">
                @if ($booking->is_checked_pickup_charges  == 'Y')
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">Pickup Charges</span>
                        <span class="value">{{  $booking->pickup_charges > 0 ? '$' . number_format($booking->pickup_charges, 2) : 'Amount will be shared later' }}</span>

                    </div>
                </div>
                @endif
               
               
                @if ($booking->is_checked_origin_charges == 'Y')
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">Origin Charges</span>
                        <span class="value">{{ '$' . number_format($booking->origin_charges, 2) }}</span>

                    </div>
                </div>
                @endif
               
               
                @if ($booking->is_checked_basic_ocean_freight  == 'Y')
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">Basic Ocean Freight Charges</span>
                        <span class="value">{{ '$' . number_format($booking->basic_ocean_freight , 2) }}</span>

                    </div>
                </div>
                @endif
               
                @if ($booking->is_checked_destination_charges  == 'Y')
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">Destination Charges</span>
                        <span class="value">{{ '$' . number_format($booking->destination_charges , 2) }}</span>

                    </div>
                </div>
                @endif
             
                @if ($booking->is_checked_delivery_charges   == 'Y')
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">Delivery Charges</span>
                        <span class="value">{{  $booking->delivery_charges > 0 ? '$' . number_format($booking->delivery_charges,2) : 'Amount will be shared later'  }}</span>

                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</section>
@endsection