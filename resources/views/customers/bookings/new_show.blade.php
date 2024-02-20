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
        /* height: 4px; */
        /* background: linear-gradient(270deg, #DCDCDC 9.5%, rgba(217, 217, 217, 0.00) 100%); */
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
    .dashboard-detail-box .border-left::before {
        content: '';
        position: absolute;
        top: 10px;
        left: -35px;
        width: 1px;
        height: 70%;
        border: 1px dashed #C6C6C6;
    }
    .dashboard-detail-box .step-content-1 {
        position: relative;
        width: 100%;
        margin-bottom: 15px;
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

                <div class="w-2/12">
                    <div class="flex justify-between flex-col items-end h-full">
                        <div>
                            @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED'))
                            <span class="badge completed">
                                Completed
                            </span>
                            @endif
                            @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
                            <span class="badge progress">
                                In-Progress
                            </span>
                            @endif
                            @if($booking->status ==config('constants.BOOKING_STATUS_CANCELLED'))
                            <span class="badge cancel">
                                Cancelled
                            </span>
                            @endif
                            @if($booking->status == config('constants.BOOKING_STATUS_ON_HOLD'))
                            <span class="badge hold">
                                On-hold
                            </span>
                            @endif
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
                                <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="inprogress-tab"
                                    data-tabs-target="#inprogress" type="button" role="tab" aria-controls="inprogress"
                                    aria-selected="false">Finance</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="completed-tab"
                                    data-tabs-target="#completed" type="button" role="tab" aria-controls="completed"
                                    aria-selected="false">BOOKING INFO</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="cancelled-tab"
                                    data-tabs-target="#cancelled" type="button" role="tab" aria-controls="cancelled"
                                    aria-selected="false">DOCUMENTATION</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="onhold-tab"
                                    data-tabs-target="#onhold" type="button" role="tab" aria-controls="onhold"
                                    aria-selected="false">shipping instructions</button>
                            </li>
                            <li class="mr-2" role="presentation">
                                <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="onhold-tab"
                                    data-tabs-target="#onhold" type="button" role="tab" aria-controls="onhold"
                                    aria-selected="false">Payment</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="myTabContent">
                    <div class="border-left" id="all" role="tabpanel" aria-labelledby="all-tab">
                        <div class="step-content-1">
                            <div class="mb-2 d-flex rouded-circle">
                                <h4><strong>Jebel Ali, AE</strong></h4>
                                <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="502" height="19" viewBox="0 0 502 19">
                                    <g id="Component_24_2" data-name="Component 24 – 2" transform="translate(0 1)">
                                        <g id="upload-icon" transform="translate(487.429 0)">
                                        <path id="Path_1222" data-name="Path 1222" d="M10.1,7.9a.646.646,0,1,1-.913.913L7.714,7.335v4.879a.643.643,0,1,1-1.286,0V7.335L4.957,8.814A.646.646,0,0,1,4.044,7.9L6.615,5.329a.643.643,0,0,1,.913,0Zm4.043-2.938V16.071A1.928,1.928,0,0,1,12.214,18H1.929A1.928,1.928,0,0,1,0,16.071V1.929A1.928,1.928,0,0,1,1.929,0H9.681a1.929,1.929,0,0,1,1.485.694l2.526,3.034a1.928,1.928,0,0,1,.45,1.234ZM10.286,3.214a.643.643,0,0,0,.643.643h1.2L10.286,1.646Zm2.571,1.929H10.929A1.928,1.928,0,0,1,9,3.214V1.286H1.929a.643.643,0,0,0-.643.643V16.071a.643.643,0,0,0,.643.643H12.214a.643.643,0,0,0,.643-.643Z" fill="#d43031"/>
                                        </g>
                                        <text id="Please_upload_the_document_confirming_this_part_of_the_delivery_is_done." data-name="Please upload the document confirming this part of the delivery is done." transform="translate(502 14)" fill="#2c1e3f" font-size="14" font-family="SegoeUI, Segoe UI" opacity="0"><tspan x="-445.566" y="0">Please upload the document confirming this part of the delivery is done.</tspan></text>
                                    </g>
                                    </svg>
                                </a>                              
                            </div>
                            <div class="flex">
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Movement Type</span>
                                            <span class="head flex"><svg id="ship" class="mr-2" xmlns="http://www.w3.org/2000/svg" width="15.603" height="18" viewBox="0 0 15.603 18">
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
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Event</span>
                                        </div>
                                        <div>
                                            <span class="head mb-4">Departure</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Date</span>
                                            <span class="head flex">
                                                2023-04-22</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Trip Number</span>
                                            <span class="head flex">
                                                316W</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Transport Name</span>
                                            <span class="head flex">
                                                MAERSK INNOSHIMA</span>
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
                                <h4><strong>Jebel Ali, AE</strong></h4>
                                <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="502" height="19" viewBox="0 0 502 19">
                                    <g id="Component_24_2" data-name="Component 24 – 2" transform="translate(0 1)">
                                        <g id="upload-icon" transform="translate(487.429 0)">
                                        <path id="Path_1222" data-name="Path 1222" d="M10.1,7.9a.646.646,0,1,1-.913.913L7.714,7.335v4.879a.643.643,0,1,1-1.286,0V7.335L4.957,8.814A.646.646,0,0,1,4.044,7.9L6.615,5.329a.643.643,0,0,1,.913,0Zm4.043-2.938V16.071A1.928,1.928,0,0,1,12.214,18H1.929A1.928,1.928,0,0,1,0,16.071V1.929A1.928,1.928,0,0,1,1.929,0H9.681a1.929,1.929,0,0,1,1.485.694l2.526,3.034a1.928,1.928,0,0,1,.45,1.234ZM10.286,3.214a.643.643,0,0,0,.643.643h1.2L10.286,1.646Zm2.571,1.929H10.929A1.928,1.928,0,0,1,9,3.214V1.286H1.929a.643.643,0,0,0-.643.643V16.071a.643.643,0,0,0,.643.643H12.214a.643.643,0,0,0,.643-.643Z" fill="#d43031"/>
                                        </g>
                                        <text id="Please_upload_the_document_confirming_this_part_of_the_delivery_is_done." data-name="Please upload the document confirming this part of the delivery is done." transform="translate(502 14)" fill="#2c1e3f" font-size="14" font-family="SegoeUI, Segoe UI" opacity="0"><tspan x="-445.566" y="0">Please upload the document confirming this part of the delivery is done.</tspan></text>
                                    </g>
                                    </svg>
                                </a>                              
                            </div>
                            <div class="flex">
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Movement Type</span>
                                            <span class="head flex"><svg id="ship" class="mr-2" xmlns="http://www.w3.org/2000/svg" width="15.603" height="18" viewBox="0 0 15.603 18">
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
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Event</span>
                                        </div>
                                        <div>
                                            <span class="head mb-4">Departure</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Date</span>
                                            <span class="head flex">
                                                2023-04-22</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Trip Number</span>
                                            <span class="head flex">
                                                316W</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Transport Name</span>
                                            <span class="head flex">
                                                MAERSK INNOSHIMA</span>
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
                                <h4><strong>Jebel Ali, AE</strong></h4>
                                <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="502" height="19" viewBox="0 0 502 19">
                                    <g id="Component_24_2" data-name="Component 24 – 2" transform="translate(0 1)">
                                        <g id="upload-icon" transform="translate(487.429 0)">
                                        <path id="Path_1222" data-name="Path 1222" d="M10.1,7.9a.646.646,0,1,1-.913.913L7.714,7.335v4.879a.643.643,0,1,1-1.286,0V7.335L4.957,8.814A.646.646,0,0,1,4.044,7.9L6.615,5.329a.643.643,0,0,1,.913,0Zm4.043-2.938V16.071A1.928,1.928,0,0,1,12.214,18H1.929A1.928,1.928,0,0,1,0,16.071V1.929A1.928,1.928,0,0,1,1.929,0H9.681a1.929,1.929,0,0,1,1.485.694l2.526,3.034a1.928,1.928,0,0,1,.45,1.234ZM10.286,3.214a.643.643,0,0,0,.643.643h1.2L10.286,1.646Zm2.571,1.929H10.929A1.928,1.928,0,0,1,9,3.214V1.286H1.929a.643.643,0,0,0-.643.643V16.071a.643.643,0,0,0,.643.643H12.214a.643.643,0,0,0,.643-.643Z" fill="#d43031"/>
                                        </g>
                                        <text id="Please_upload_the_document_confirming_this_part_of_the_delivery_is_done." data-name="Please upload the document confirming this part of the delivery is done." transform="translate(502 14)" fill="#2c1e3f" font-size="14" font-family="SegoeUI, Segoe UI" opacity="0"><tspan x="-445.566" y="0">Please upload the document confirming this part of the delivery is done.</tspan></text>
                                    </g>
                                    </svg>
                                </a>                              
                            </div>
                            <div class="flex">
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Movement Type</span>
                                            <span class="head flex"><svg id="ship" class="mr-2" xmlns="http://www.w3.org/2000/svg" width="15.603" height="18" viewBox="0 0 15.603 18">
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
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Event</span>
                                        </div>
                                        <div>
                                            <span class="head mb-4">Departure</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Date</span>
                                            <span class="head flex">
                                                2023-04-22</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Trip Number</span>
                                            <span class="head flex">
                                                316W</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-2/12">
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="head mb-4">Transport Name</span>
                                            <span class="head flex">
                                                MAERSK INNOSHIMA</span>
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
                    </div>
                    <div class="hidden" id="inprogress" role="tabpanel" aria-labelledby="inprogress-tab">
                        <div class="detail-body">
                            @if(isset($bookings) && count($bookings)> 0 && $inProgressBookingsCount > 0)
                                @foreach ($bookings as $booking)
                                    @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS') )
                                        @include('admin.partials._booking-detail-box', ['booking' => $booking, 'tab' => "inprogress-tab"])
                                    @endif
                                @endforeach
                            @else
                                <div class="p-4 rounded-lg bg-gray-50">
                                    <p class="text-sm text-gray-500">No in-progress bookings found</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="hidden" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                        <div class="detail-body">
                            @if(isset($bookings) && count($bookings)> 0 && $completedBookingsCount > 0)
                                @foreach ($bookings as $booking)
                                    @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED') )
                                        @include('admin.partials._booking-detail-box', ['booking' => $booking, 'tab' => "completed-tab"])
                                    @endif
                                @endforeach
                            @else
                                <div class="p-4 rounded-lg bg-gray-50">
                                    <p class="text-sm text-gray-500">No bookings found</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="hidden" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                        <div class="detail-body">
                            @if(isset($bookings) && count($bookings)> 0 && $cancelledBookingsCount > 0)
                                @foreach ($bookings as $booking)
                                    @if($booking->status == config('constants.BOOKING_STATUS_CANCELLED') )
                                        @include('admin.partials._booking-detail-box', ['booking' => $booking, 'tab' => "cancelled-tab"])
                                    @endif
                                @endforeach
                            @else
                                <div class="p-4 rounded-lg bg-gray-50">
                                    <p class="text-sm text-gray-500">No cancelled bookings found</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="hidden" id="onhold" role="tabpanel" aria-labelledby="onhold-tab">
                        <div class="detail-body">
                            @if(isset($bookings) && count($bookings)> 0 && $onHoldBookingsCount > 0)
                                @foreach ($bookings as $booking)
                                    @if($booking->status == config('constants.BOOKING_STATUS_ON_HOLD') )
                                        @include('admin.partials._booking-detail-box', ['booking' => $booking, 'tab' => "onhold-tab"])
                                    @endif
                                @endforeach
                            @else
                                <div class="p-4 rounded-lg bg-gray-50">
                                    <p class="text-sm text-gray-500">No cancelled bookings found</p>
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