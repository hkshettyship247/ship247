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
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="finance-tab"
                                    data-tabs-target="#finance" type="button" role="tab" aria-controls="finance"
                                    aria-selected="false">Finance</button>
                            </li>
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
                            @include('admin.partials._documentation_tab', ['booking' => $booking, 'tab' =>
                            "bookinginfo-tab"])
                            @endif
                        </div>
                    </div>

                    <div class="hidden" id="shippinginfo" role="tabpanel" aria-labelledby="shippinginfo-tab">
                        <div class="detail-body">
                            @if(isset($booking))
                            <div class="p-4 rounded-lg bg-gray-50">

                                 <div class="card-shipping pb-5">
                                     <div class="card-title">
                                         <h2>Documentation</h2>
                                     </div>
                                     <div class="card-body">
                                         <div class="title-sec">
                                             <p>Transport Document Receiver</p>
                                         </div>
                                         <div class="address-sec">
                                            <div class="address-info">
                                                <div class="left-content">
                                                    <h2>SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.</h2>
                                                    <a href="#" class="number">**********905</a>
                                                    <a href="#" class="link">Change</a>
                                                </div>  
                                                <div class="action-btn">
                                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></a>
                                                    </div>
                                                </div>
                                                <div class="address-info border-0">
                                                <div class="left-content">
                                                    <p> <strong> Company name and address </strong></p>
                                                    <p>SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.
                                                    <br>TOURIST CLUB AREA
                                                    <br>ABU DHABI</p>
                                                    <p>United Arab Emirates</p>
                                                </div>  
                                            </div>
                                        </div>
                                     </div>
                                 </div>

                                 <div class="card-shipping pb-5">
                                     <div class="card-title">
                                         <h4 class="pb-0"><span>Document Type</span></h4>
                                     </div>
                                     <div class="tabbing">
                                         <div class="mb-8 border-b border-gray-200">
                                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                                                <li class="mr-2" role="presentation">
                                                    <button class="inline-block p-4 pb-2 rounded-t-lg text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500" id="waybill-tab" data-tabs-target="#waybill" type="button" role="tab" aria-controls="all" aria-selected="true">Waybill</button>
                                                </li>
                                                <li class="mr-2" role="presentation">
                                                    <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" id="lading-tab" data-tabs-target="#lading" type="button" role="tab" aria-controls="lading" aria-selected="false">Bill Of Lading</button>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                        <div id="myTabContent">
                                            <div class="" id="waybill" role="tabpanel" aria-labelledby="all-tab">
                                                <div class="detail-body">
                                                     <div class="rounded-lg bg-gray-50">
                                                        <form class="wayfill" id="" action=""> 
                                                            <div class="form-group mb-4">
                                                                <input type="radio" id="1" name="" value="1">
                                                                <label for="1">Shipped on Board</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="radio" id="2" name="" value="2">
                                                                <label for="2">Received for Shipment</label>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="hidden" id="lading" role="tabpanel" aria-labelledby="lading-tab">
                                                <p class="text-sm text-gray-500">Show all uncleared list1</p>
                                            </div>
                                        </div>
                                 </div>

                                 <div class="card-shipping pb-5">
                                       <div class="card-title">
                                         <h4><span>Vessel and Location Aliases on B/L</span></h4>
                                       </div>
                                        <div class="rounded-lg bg-gray-50">
                                                <p class="pb-2"><strong>Vessel</strong></p>
                                                <form class="wayfill" id="" action=""> 
                                                    <div class="form-group mb-4">
                                                        <input type="radio" id="3" name="" value="3">
                                                        <label for="3">MSC ISABELLA(PA)/401E (First Load Port)</label>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="Locationaliases">
                                                <p class="pb-2"><strong>Location Aliases</strong></p>
                                                <div class="LocationaRow gap-4">
                                                     <div class="w-3/12">
                                                         <div class="Locationcolumn rounded-lg">
                                                            <form class="Locationform" id="" action=""> 
                                                                <label>Place of Receipt</label>
                                                                <select name="scac" id="scac" class="form-input small-input mt-2 w-9/12 rounded-lg block">
                                                                    <option value="">Select</option>
                                                                    <option value="d">1 </option>
                                                                    <option value="d">2 </option>
                                                                    <option value="d">3 </option>
                                                                    <option value="d">4 </option>
                                                                </select>
                                                            </form>
                                                             <div class="Aliasesbottom">
                                                                <p>Appointment <span><strong>20 Dec 2023 01:00</strong> </span></p>
                                                             </div>
                                                          </div>
                                                     </div>
                                                     <div class="w-3/12">
                                                         <div class="Locationcolumn rounded-lg">
                                                            <form class="Locationform" id="" action=""> 
                                                                <label>Load Port</label>
                                                                <select name="scac" id="scac" class="form-input small-input mt-2 w-9/12 rounded-lg block">
                                                                    <option value="">Select</option>
                                                                    <option value="d">1 </option>
                                                                    <option value="d">2 </option>
                                                                    <option value="d">3 </option>
                                                                    <option value="d">4 </option>
                                                                </select>
                                                            </form>
                                                             <div class="Aliasesbottom">
                                                                <p>Departing <span><strong>17 Jan 2024 01:00</strong> </span></p>
                                                             </div>
                                                          </div>
                                                     </div>
                                                     <div class="w-3/12">
                                                         <div class="Locationcolumn rounded-lg">
                                                            <form class="Locationform" id="" action=""> 
                                                                <label>Port of Discharge</label>
                                                                <select name="scac" id="scac" class="form-input small-input mt-2 w-9/12 rounded-lg block">
                                                                    <option value="">Select</option>
                                                                    <option value="d">1 </option>
                                                                    <option value="d">2 </option>
                                                                    <option value="d">3 </option>
                                                                    <option value="d">4 </option>
                                                                </select>
                                                            </form>
                                                             <div class="Aliasesbottom">
                                                                <p>Arriving <span><strong>29 Dec 2024 18:00</strong> </span></p>
                                                             </div>
                                                          </div>
                                                     </div>
                                                   
                                                 </div>
                                            </div>
                                     </div>
                                
                                   <div class="card-shipping pb-5">
                                        <div class="card-title">
                                            <h4><span>Documentation Request </span></h4>
                                        </div>
                                        <div class="Documentation-request">
                                            <div class="sec-title">
                                            <p><strong>Free detention and demurrage time</strong></p>
                                               <p>The number of free days of detention/demurrage application to your shipment before charges are applicable.</p>
                                            </div>
                                            <div class="DocumentationRow">
                                                <div class="leftcolumn">
                                                    <fieldset class="px-0">
                                                        <div class="inline-flex">
                                                            <input class="hidden" type="radio" id="no" value="no" name="gender" />
                                                            <label class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 cursor-pointer rounded-l" for="no">No</label>
                                                            <input class="hidden" type="radio" id="yes" value="yes" name="gender" checked />
                                                            <label class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 cursor-pointer rounded-r" for="yes">Yes</label>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="rightcolumn">
                                                    <h5 class="pb-3"><b>Number of free days:</b></h5>
                                                    <form class="formbox" id="" action="" >
                                                        <div class="form-check">
                                                             <label class="form-check-label" for="flexCheckDefault">
                                                                applicable free time 11 days combined (detention and demurrage) at (port of discharge / place of delivery) 
                                                            </label>
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                        </div>
                                                        <div class="form-check">
                                                             <label class="form-check-label" for="flexCheckDefault1">
                                                                 applicable free time 0 days detention at demurrage (port of discharge / place of delivery) 
                                                            </label>
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                                        </div>
                                                        <div class="form-check">
                                                             <label class="form-check-label" for="flexCheckDefault2">
                                                                 applicable free time 0 days detention at demurrage (port of discharge / place of delivery) 
                                                            </label>
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                                        </div>
                                                        <div class="form-check">
                                                             <label class="form-check-label" for="flexCheckDefault3">
                                                                 applicable free time 0 days detention at demurrage (port of discharge / place of delivery) 
                                                            </label>
                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                                        </div>
                                                     </form>
                                                 </div>
                                            </div>
                                        </div>

                                        <div class="Documentation-request">
                                            <div class="sec-title">
                                               <p><strong>Agent details on BL </strong></p>
                                               <p>Do you want Maersk Agent details at destination to be printed on BL.</p>
                                            </div>
                                            <div class="DocumentationRow">
                                                <div class="leftcolumn">
                                                    <fieldset class="px-0">
                                                        <div class="inline-flex">
                                                            <input class="hidden" type="radio" id="no2" value="no2" name="no2" checked />
                                                            <label class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 cursor-pointer rounded-l" for="no2">No</label>
                                                            <input class="hidden" type="radio" id="yes2" value="yes2" name="yes2" />
                                                            <label class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 cursor-pointer rounded-r" for="yes2">Yes</label>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="rightcolumn">
                                                   
                                                 </div>
                                            </div>
                                        </div>

                                        <div class="Documentation-request">
                                            <div class="sec-title">
                                                <p><strong>In-transit</strong></p>
                                               <p>The In-transit clause below will be include on the BL.</p>
                                            </div>
                                            <div class="DocumentationRow">
                                                <div class="leftcolumn">
                                                    <fieldset class="px-0">
                                                        <div class="inline-flex">
                                                            <input class="hidden" type="radio" id="no3" value="no3" name="no3" checked />
                                                            <label class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 cursor-pointer rounded-l" for="no3">No</label>
                                                            <input class="hidden" type="radio" id="yes3" value="yes3" name="yes3" />
                                                            <label class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 cursor-pointer rounded-r" for="yes3">Yes</label>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="rightcolumn">
                                                   
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                              

                                    <div class="card-shipping pb-5">
                                        <div class="card-title">
                                            <h4><span>Parties </span></h4>
                                        </div>
                                        <div class="parties-section">
                                            <div class="parties-row">
                                                <div class="w-4/12">
                                                    <div class="card-body">
                                                        <div class="title-sec">
                                                            <p>Shipper</p>
                                                        </div>
                                                        <div class="address-sec">
                                                            <div class="address-info">
                                                                <div class="left-content">
                                                                    <h2>SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.</h2>
                                                                    <a href="#" class="number">**********905</a>
                                                                    <a href="#" class="link">Change</a>
                                                               </div>  
                                                                <div class="action-btn">
                                                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></a>
                                                                    </div>
                                                             </div>
                                                             <div class="address-info">
                                                                <div class="left-content">
                                                                    <p> <strong> Company name and address </strong></p>
                                                                    <p>SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.
                                                                    <br>TOURIST CLUB AREA
                                                                    <br>ABU DHABI</p>
                                                                    <p>United Arab Emirates</p>
                                                               </div>  
                                                                <div class="action-btn">
                                                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                                                                </div>
                                                             </div>
                                                             <div class="address-info border-0">
                                                                <div class="left-content">
                                                                    <p>References</p>
                                                               </div>  
                                                                <div class="action-btn">
                                                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                                                                </div>
                                                             </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-4/12">
                                                    <div class="card-body">
                                                        <div class="title-sec">
                                                            <p>Consignee</p>
                                                        </div>
                                                        <div class="address-sec">
                                                            <div class="address-info">
                                                                <div class="left-content">
                                                                    <h2>SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.</h2>
                                                                    <a href="#" class="number">**********905</a>
                                                                    <a href="#" class="link">Change</a>
                                                               </div>  
                                                                <div class="action-btn">
                                                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></a>
                                                                    </div>
                                                             </div>
                                                             <div class="address-info">
                                                                <div class="left-content">
                                                                    <p> <strong> Company name and address </strong></p>
                                                                    <p>SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.
                                                                    <br>TOURIST CLUB AREA
                                                                    <br>ABU DHABI</p>
                                                                    <p>United Arab Emirates</p>
                                                               </div>  
                                                                <div class="action-btn">
                                                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                                                                </div>
                                                             </div>
                                                             <div class="address-info border-0">
                                                                <div class="left-content">
                                                                    <p>References</p>
                                                               </div>  
                                                                <div class="action-btn">
                                                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                                                                </div>
                                                             </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-4/12">
                                                    <div class="card-body">
                                                        <div class="title-sec">
                                                            <p>First Notity Party</p>
                                                        </div>
                                                        <div class="address-sec">
                                                            <div class="address-info">
                                                                <div class="left-content">
                                                                    <h2>SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.</h2>
                                                                    <a href="#" class="number">**********905</a>
                                                                    <a href="#" class="link">Change</a>
                                                               </div>  
                                                                <div class="action-btn">
                                                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></a>
                                                                    </div>
                                                             </div>
                                                             <div class="address-info">
                                                                <div class="left-content">
                                                                    <p> <strong> Company name and address </strong></p>
                                                                    <p>SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.
                                                                    <br>TOURIST CLUB AREA
                                                                    <br>ABU DHABI</p>
                                                                    <p>United Arab Emirates</p>
                                                               </div>  
                                                                <div class="action-btn">
                                                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                                                                </div>
                                                             </div>
                                                             <div class="address-info border-0">
                                                                <div class="left-content">
                                                                    <p>References</p>
                                                               </div>  
                                                                <div class="action-btn">
                                                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                                                                </div>
                                                             </div>
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card-shipping pb-5">
                                        <div class="card-title">
                                            <h4><span>Additional Parties (Optional)</span></h4>
                                        </div>
                                        <div class="parties-section">
                                            <div class="parties-row">
                                                <div class="w-4/12">
                                                    <div class="card-body">
                                                        <div class="title-sec text-center">
                                                            <p><svg class="inline" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg> Additional notify party</p>
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                                <div class="w-4/12">
                                                    <div class="card-body">
                                                        <div class="title-sec">
                                                            <p>Outward Forwarder</p>
                                                        </div>
                                                        <div class="address-sec">
                                                            <div class="address-info">
                                                                <div class="left-content">
                                                                    <h2>SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.</h2>
                                                                    <a href="#" class="number">**********905</a>
                                                                    <a href="#" class="link">Change</a>
                                                               </div>  
                                                                <div class="action-btn">
                                                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></a>
                                                                    </div>
                                                             </div>
                                                             <div class="address-info">
                                                                <div class="left-content">
                                                                    <p> <strong> Company name and address </strong></p>
                                                                    <p>SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.
                                                                    <br>TOURIST CLUB AREA
                                                                    <br>ABU DHABI</p>
                                                                    <p>United Arab Emirates</p>
                                                               </div>  
                                                                <div class="action-btn">
                                                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                                                                </div>
                                                             </div>
                                                             <div class="address-info border-0">
                                                                <div class="left-content">
                                                                    <p>References</p>
                                                               </div>  
                                                                <div class="action-btn">
                                                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                                                                </div>
                                                             </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-4/12">
                                                    <div class="card-body">
                                                        <div class="title-sec text-center">
                                                        <p><svg class="inline" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg> Inward forwarner </p>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card-shipping pb-5">
                                        <div class="card-title">
                                            <h4><span>Booked commodity: Fertilizer</span></h4>
                                        </div>
                                    </div>

                            </div>
                            @endif
                        </div>
                  

                    <div class="hidden" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                        <div class="detail-body">
                            @if(isset($booking) && $booking->payment)
                            @include('admin.partials._payment_tab', ['booking' => $booking, 'track_booking_response' => $track_booking_response, 'tab' =>
                            "bookinginfo-tab"])
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
@endsection
@section('footer-scripts')    
    <script>
        $(document).ready(function() {
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