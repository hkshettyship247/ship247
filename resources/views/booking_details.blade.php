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

    #progressbar li.active:before {
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
        border: 1px solid #D43031;
    }

    .badge.PAY_IN_PROGRESS {
        color: #ffffff !important;
        border: 1px solid #D43031;
        background: #D43031 !important;
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
                    <span>EVGM SUBMITTED</span>
                </li>
                <li class="{{ $booking->status >= config('constants.BOOKING_STATUS_EVGM_CONFIRMED') ? 'active' : '' }}">
                    <span>EVGM CONFIRMED</span>
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
                                <p class="text-sm text-gray-500">No shipping information found</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="hidden" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                        <div class="detail-body">
                            @if(isset($booking))
                            @include('admin.partials._payment_tab', ['booking' => $booking, 'track_booking_response' => $track_booking_response, 'tab' =>
                            "bookinginfo-tab"])
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
                for (var i = 0; i < this.files.length; i++) {
                    let fileBloc = $('<span/>', {class: 'file-block'}),
                        fileName = $('<span/>', {class: 'name', text: this.files.item(i).name});
                    fileBloc.append('<span class="file-delete"><span>+</span></span>')
                        .append(fileName);
                    $("#filesList > #files-names").append(fileBloc);
                    dt.items.add(this.files[i]);
                }
            });

            $('#uploadBtn').click(function() {
                let formData = new FormData();
                let files = $('#attachment')[0].files;

                for (let i = 0; i < files.length; i++) {
                    formData.append('files[]', files[i]);
                }
                formData.append('bookingId', "{{ $booking->id }}");
                formData.append('_token', "{{ csrf_token(); }}");
                @php
                $url =  route($route. 'booking.storeDocuments');
                @endphp
                $.ajax({
                    url: "{{ $url }}", // Replace with your upload endpoint
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if(response.success) {
                            alert("Document uploaded successfully!");
                        }
                        // Add your success handling here
                    },
                    error: function(xhr, status, error) {
                        console.error('Upload failed:', error);
                        // Add your error handling here
                    }
                });
            });
        });


        $(document).on('click', 'span.file-delete', function(){
            let name = $(this).next('span.name').text();
            // Supprimer l'affichage du nom de fichier
            $(this).parent().remove();
            for(let i = 0; i < dt.items.length; i++){
                // Correspondance du fichier et du nom
                if(name === dt.items[i].getAsFile().name){
                    // Suppression du fichier dans l'objet DataTransfer
                    dt.items.remove(i);
                    continue;
                }
            }
            // Mise à jour des fichiers de l'input file après suppression
            document.getElementById('attachment').files = dt.files;
        });
    </script>
@endsection