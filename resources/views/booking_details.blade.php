@extends('layouts.admin')
@section('style')
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
        color: #2C1E3F;
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

    #progressbar li.active:before {
        background: #2C1E3F;
        color: white;
        z-index: 2;
        position: relative;
        border-color: #524177;
    }

    #progressbar li.active:after {
        background: #2C1E3F;
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

    .badge.DOWNLOAD_IN_PROGRESS,
    .badge.PAY_IN_PROGRESS,
    .badge.VIEW_IN_PROGRESS,
    .badge.BOOKING_STATUS_IN_PROGRESS {
        font-size: 0.65rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .badge.DOWNLOAD_IN_PROGRESS {
        background: #2c1e3f;
        color: #ffffff;
    }

    .badge.VIEW_IN_PROGRESS {
        background-color: #ffffff !important;
        border: 1px solid #2C1E3F;
    }

    .badge.PAY_IN_PROGRESS {
        color: #ffffff !important;
        border: 1px solid #2C1E3F;
        background: #2C1E3F !important;
    }

    @media (min-width: 991px) {
        .dashboard-detail-box .detail-body .detail-box {
            display: flex;
            align-items: center;
        }
    }

    #files-area {
        /* width: 30%; */
        margin: 0 auto;
    }

    .file-block {
        border-radius: 10px;
        background-color: rgba(144, 163, 203, 0.2);
        margin: 5px;
        color: initial;
        display: inline-flex;

        &>span.name {
            padding-right: 10px;
            width: max-content;
            display: inline-flex;
        }
    }

    .file-delete {
        display: flex;
        width: 24px;
        color: initial;
        background-color: #6eb4ff00;
        font-size: large;
        justify-content: center;
        margin-right: 3px;
        cursor: pointer;

        &:hover {
            background-color: rgba(144, 163, 203, 0.2);
            border-radius: 10px;
        }

        &>span {
            transform: rotate(45deg);
        }
    }
</style>
@endsection
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
                <a href="{{route($route.'bookings.index')}}" class="default-button-v2">
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
                                {{ str_replace('_', ' ', ucwords(strtolower(substr($badgeClass,
                                strlen('BOOKING_STATUS_'))))) }}
                            </span>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="parties-details">
             <header>
                <h4 class="title">Parties Details</h4>
             </header>                
           
            <div class="parties-detail-inner-sec">
                <div class="sec-title mb-5">
                    <p><strong>Booking Party + Forwader + Deciding party + Named Account + Third Party booking agent</strong></p>
                </div>  
                
                <div class="parties-detail-row-sec">
                        <div class="w-6/12">
                            <form class="addform" id="" action="">
                                <div class="form-group">
                                    <label class="form-label">Party Name</label>
                                    <select name="dcac" id="dcac" class="form-input mb-3 small-input mt-2 w-12/12 rounded-lg block">
                                        <option value="{{ ($booking->user) ? $booking->user->id : '' }}">{{ ($booking->user) ? $booking->user->email : '' }}</option>
                                    </select>
                               </div>
                                <div class="address-row">
                                    <div class="w-6/12">
                                         <div class="address-details">
                                             <p>Address</p>
                                             <h4>PO BOX 43338<br>
                                             ABU DHABI, Abu Zaby<br>
                                             United Arab Emirates.
                                            </h4>
                                         </div>
                                     </div>
                                </div>
                             </form>
                    </div>   
                    <div class="w-6/12">
                        <form class="roleselect" id="" action="">
                            <label class="form-label">Role</label>
                             <div class="form-check-inline">
                                <div class="w-6/12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" id="shipper">
                                        <label class="form-check-label" for="shipper"> Shipper</label>
                                    </div>
                                </div>
                                <div class="w-6/12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" id="Forwarder">
                                        <label class="form-check-label" for="Forwarder"> Forwarder</label>
                                    </div>
                                </div>
                                <div class="w-6/12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" id="Consignee">
                                        <label class="form-check-label" for="Consignee"> Consignee</label>
                                    </div>
                                </div>
                                <div class="w-6/12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" id="Decidong party">
                                        <label class="form-check-label" for="Decidong party"> Deciding party</label>
                                    </div>
                                </div>
                                
                                <div class="w-6/12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" id="Master Operator">
                                        <label class="form-check-label" for="Master Operator"> Master Operator</label>
                                    </div>
                                </div>
                           </div>
                      </form>
                    </div>
                </div>  
                

                <div class="parties-detail">
                        
                </div>  
                
                <div class="addparty my-5">
                     <a href="#" class="flex"><svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg><span>Add party<span> </a>
              </div>
            </div>         
        </div>

        <div class="step-progress">
            <ul id="progressbar">
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_IN_PROGRESS') ? 'active' : '' }}">
                    <span>NEW</span>
                </li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_IN_PROGRESS') ? 'active' : '' }}">
                    <span>Pending</span>
                </li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_CONFIRMED') ? 'active' : '' }}">
                    <span>Confirmed</span>
                </li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_SI_SUBMITTED') ? 'active' : '' }}">
                    <span>SI SUBMITTED</span>
                </li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_SI_CONFIRMED') ? 'active' : '' }}">
                    <span>SI CONFIRMED</span>
                </li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_EVGM_SUBMITTED') ? 'active' : '' }}">
                    <span>VGM SUBMITTED</span>
                </li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_EVGM_CONFIRMED') ? 'active' : '' }}">
                    <span>VGM CONFIRMED</span>
                </li>
                <li
                    class="{{ $booking->status >= config('constants.BOOKING_STATUS_DRAFT_BL_RECEIVED') ? 'active' : '' }}">
                    <span>DRAFT BL RECEIVED</span>
                </li>
                <li
                    class="{{ $booking->status >= config('constants.BOOKING_STATUS_DRAFT_BL_CONFIRMED') ? 'active' : '' }}">
                    <span>DRAFT BL CONFIRMED</span>
                </li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_FINISHED') ? 'active' : '' }}">
                    <span>FINISHED</span>
                </li>
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
                            @if(isset($booking) && $booking->payment)
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="finance-tab"
                                    data-tabs-target="#finance" type="button" role="tab" aria-controls="finance"
                                    aria-selected="false">Finance</button>
                            </li>
                            @endif
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600"
                                    id="bookinginfo-tab" data-tabs-target="#bookinginfo" type="button" role="tab"
                                    aria-controls="bookinginfo" aria-selected="false">BOOKING INFO</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600"
                                    id="documentation-tab" data-tabs-target="#documentation" type="button" role="tab"
                                    aria-controls="documentation" aria-selected="false">DOCUMENTATION</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600"
                                    id="shippinginfo-tab" data-tabs-target="#shippinginfo" type="button" role="tab"
                                    aria-controls="shippinginfo" aria-selected="false">shipping instructions</button>
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
                        @include('admin.partials._tracking', ['booking' => $booking, 'tab' =>
                            "all-tab"])
                    </div>
                    <div class="hidden" id="finance" role="tabpanel" aria-labelledby="finance-tab">
                        <div class="detail-body">
                            @if(isset($booking))
                            @include('admin.partials._booking-detail-finance', ['booking' => $booking, 'tab' =>
                            "finance-tab"])
                            @endif
                        </div>
                    </div>

                    <div class="hidden" id="bookinginfo" role="tabpanel" aria-labelledby="bookinginfo-tab">
                        <div class="detail-body">
                            @if(isset($booking))
                            @include('admin.partials._booking-info', ['booking' => $booking, 'tab' =>
                            "bookinginfo-tab"])
                            @endif
                        </div>
                    </div>

                    <div class="hidden" id="documentation" role="tabpanel" aria-labelledby="documentation-tab">
                        <div class="detail-body">
                            @if(isset($booking))
                            @include('admin.partials._documentation_tab', ['booking' => $booking, 'route' => $route, 'tab' =>
                            "bookinginfo-tab"])
                            @endif
                        </div>
                    </div>

                    <div class="hidden" id="shippinginfo" role="tabpanel" aria-labelledby="shippinginfo-tab">
                        <div class="detail-body">
                            @if(isset($booking))
                            @include('admin.partials._shipping_tab', ['booking' => $booking, 'track_booking_response' => $track_booking_response, 'route' => $route, 'tab' =>
                            "shippinginfo-tab"])
                            @endif
                        </div>
                    </div>
                  
                    <div class="hidden" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                        <div class="detail-body">
                            @if(isset($booking) && $booking->payment)
                            @include('admin.partials._payment_tab', ['booking' => $booking, 'track_booking_response' => $track_booking_response, 'tab' =>
                            "payment-tab"])
                            @else
                            <p class="text-sm text-gray-500">No payment information found</p>
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
                @if ($booking->is_checked_pickup_charges == 'Y')
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">Pickup Charges</span>
                        <span class="value">{{ $booking->pickup_charges > 0 ? '$' .
                            number_format($booking->pickup_charges, 2) : 'Amount will be shared later' }}</span>

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


                @if ($booking->is_checked_basic_ocean_freight == 'Y')
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">Basic Ocean Freight Charges</span>
                        <span class="value">{{ '$' . number_format($booking->basic_ocean_freight , 2) }}</span>

                    </div>
                </div>
                @endif

                @if ($booking->is_checked_destination_charges == 'Y')
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">Destination Charges</span>
                        <span class="value">{{ '$' . number_format($booking->destination_charges , 2) }}</span>

                    </div>
                </div>
                @endif

                @if ($booking->is_checked_delivery_charges == 'Y')
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">Delivery Charges</span>
                        <span class="value">{{ $booking->delivery_charges > 0 ? '$' .
                            number_format($booking->delivery_charges,2) : 'Amount will be shared later' }}</span>

                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</section>

<div id="document-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full" style="background: rgba(0, 0, 0, 0.6)">
    <div class="relative w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="document-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>

            <div class="p-6 modal-content">
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer-scripts')    
    <script>
        $(document).ready(function() {

            // Bind click event to the "Change" link
            $('a.document-modal').click(function(e) {
                e.preventDefault(); // Prevent default link behavior
                const type = $(this).attr('type');
                const booking_id = "{{ $booking->id }}";
                // Perform AJAX request to fetch form HTML
                $.ajax({
                    url: "{{ route($route. 'booking.party_address') }}", // Replace with the URL of your form view
                    method: 'GET',
                    data: {type: type, booking_id: booking_id},
                    success: function(response) {
                        // Populate the modal with the fetched form HTML
                        $('.modal-content').html(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors if any
                        console.error(error);
                    }
                });
            });
            
            $('a.company-address').click(function(e) {
                e.preventDefault(); // Prevent default link behavior
                const type = $(this).attr('type');
                const booking_id = "{{ $booking->id }}";
                // Perform AJAX request to fetch form HTML
                $.ajax({
                    url: "{{ route($route. 'booking.party_company_address') }}", // Replace with the URL of your form view
                    method: 'GET',
                    data: {type: type, booking_id: booking_id},
                    success: function(response) {
                        // Populate the modal with the fetched form HTML
                        $('.modal-content').html(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors if any
                        console.error(error);
                    }
                });
            });

            $(document).on('click', '.create_template', function(e) {
                e.preventDefault(); // Prevent default link behavior
                var $this = $(this);
                // Remove any previous error messages
                $('.name_error').empty();
                $('.address_error').empty();
                
                $.ajax({
                    url: "{{ route($route. 'booking.template') }}",
                    method: 'POST',
                    data: $('#bookingTempalteForm').serialize(),
                    beforeSend: function() {
                        // Show loader before sending request
//                         <button disabled="" type="button" class="text-white bg-green-700 hover:bg-orange-600 focus:ring-4 focus:ring-orange-300 font-medium  text-sm px-5 py-2.5 text-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center">
    
// </button>
                        $this.html(`<svg role="status" class="inline mr-3 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"></path>
    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"></path>
    </svg>
    Loading...`);
                    },
                    // success: function(response) {
                    //     if (response.success) {
                    //         // Populate the modal with the fetched form HTML
                    //         $this.html('Create Template');
                    //         $('.template_name').html(response.booking_template.name);
                    //         $('#address').html(response.booking_template.address);
                    //         showSuccessNotification('Data stored successfully!');
                    //     }
                    // },
                    // error: function(response) {
                    //     // Handle errors if any
                    //     $this.html('Create Template');
                    //     $.each(response.responseJSON.errors, function(field, messages) {
                    //         $.each(messages, function(index, message) {
                    //             $('.' + field + '_error').html(message);
                    //         });
                    //     });
                    // }
                });
            });

            const dt = new DataTransfer();

            $("#attachment").on('change', function(e) {
                uploadFiles();
            });

            // Event listener for file upload
            function uploadFiles() {
                if ($('#attachment')[0].files.length === 0) {
                    alert("Please select one or more files to upload.");
                    return;
                }
                
                let formData = new FormData();
                let files = $('#attachment')[0].files;

                for (let i = 0; i < files.length; i++) {
                    formData.append('files[]', files[i]);
                }
                formData.append('bookingId', "{{ $booking->id }}");
                formData.append('_token', "{{ csrf_token(); }}");
                @php
                $url =  route($route. 'booking.storeDocuments');
                $spinner = asset('images/Spinner-2.gif');
                @endphp

                // AJAX call to upload files
                $.ajax({
                    url: "{{ $url }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        // Show loader before sending request
                        $('.spinner').html('<img src="{{ $spinner }}" style="display: block; margin: auto;">');
                    },
                    success: function(response) {
                        if(response.success) {
                            // Add file blocks with delete buttons using the documents data from the response
                            $('.spinner').html('');
                            addFileBlocks(response.documents);
                            Swal.fire({
                                title: 'Success',
                                text: "Document uploaded successfully!",
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Upload failed:', error);
                    }
                });
            };

            function addFileBlocks(documents) {
                documents.forEach(function(document) {
                    let fileBloc = $('<span/>', {class: 'file-block'}),
                        fileName = $('<span/>', {class: 'name', text: document.filename}),
                        bookingId = document.booking_id,
                        docId = document.id;

                    fileBloc.append('<span class="file-delete removeFile" bookingId="' + bookingId + '" docId="' + docId + '"><span>+</span></span>')
                        .append(fileName);
                    $("#filesList > #files-names").append(fileBloc);
                });
            }

            $('.addparty a').click(function(e){
                e.preventDefault(); // Prevent the default action of the link

                const party = `
                <div class="parties-detail-row-sec">
                        <div class="w-6/12">
                            <form class="addform" id="" action="">
                                <div class="form-group">
                                    <label class="form-label">Party Name</label>
                                    <select name="dcac" id="dcac" class="form-input mb-3 small-input mt-2 w-12/12 rounded-lg block">
                                        <option value="">Ship 247 for Logistic Services - Abu Dhabi</option>
                                    </select>
                               </div>
                                <div class="address-row">
                                    <div class="w-6/12">
                                         <div class="address-details">
                                             <p>Address</p>
                                             <h4>PO BOX 43338<br>
                                             ABU DHABI, Abu Zaby<br>
                                             United Arab Emirates.
                                            </h4>
                                         </div>
                                     </div>
                                </div>
                             </form>
                    </div>   
                    <div class="w-6/12">
                         <form class="roleselect" id="" action="">
                                <label class="form-label">Role</label>
                                 <div class="form-check-inline">
                                    <div class="w-6/12">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" value="" id="shipper">
                                            <label class="form-check-label" for="shipper"> Shipper</label>
                                        </div>
                                    </div>
                                    <div class="w-6/12">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" value="" id="Forwarder">
                                            <label class="form-check-label" for="Forwarder"> Forwarder</label>
                                        </div>
                                    </div>
                                    <div class="w-6/12">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" value="" id="Consignee">
                                            <label class="form-check-label" for="Consignee"> Consignee</label>
                                        </div>
                                    </div>
                                    <div class="w-6/12">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" value="" id="Decidong party">
                                            <label class="form-check-label" for="Decidong party"> Deciding party</label>
                                        </div>
                                    </div>
                                    
                                    <div class="w-6/12">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" value="" id="Master Operator">
                                            <label class="form-check-label" for="Master Operator"> Master Operator</label>
                                        </div>
                                    </div>
                               </div>
                          </form>
                    </div>
                </div>`;

                // Clone the parties-detail-row-sec div and append it to the addparty div
                $('.parties-detail').append(party);
            });

        });
        
        
        $(document).on('click', 'span.removeFile', function(){
            var $this = $(this);
            Swal.fire({
                title: 'Confirm',
                text: 'Are you sure you want to delete this file ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: "red",
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, make an AJAX request with the selected date
                    @php
                        $deleteUrl =  route($route. 'booking.removeDocument');
                    @endphp
                    var docId = $this.attr('docId');
                    var bookingId = $this.attr('bookingId');
                    var token = "{{ csrf_token() }}";
                    $.ajax({
                        url: "{{ $deleteUrl }}",
                        method: 'POST',
                        data: {_token: token, docId: docId, bookingId: bookingId},
                        success: function(response) {
                            console.log(response);
                            
                            if (response.success) {
                                let name = $this.next('span.name').text();
                                // Supprimer l'affichage du nom de fichier
                                $this.parent().remove();
                                
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                });
                            }
                        },
                        error: function(error) {
                            // Handle error
                            var errorMessage = error.responseJSON.error;
                            Swal.fire({
                                title: 'Error',
                                text: errorMessage,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            }); 
        });

        $(document).on('click', 'span.delete-doc', function(){
            let name = $(this).next('span.name').text();
            // Supprimer l'affichage du nom de fichier
            $(this).parent().remove();
        });
    </script>
@endsection