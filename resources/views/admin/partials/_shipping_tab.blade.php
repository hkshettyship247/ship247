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
                        @php
                            $documentReceiver = App\Models\PartyAdress::where(['booking_id' => $booking->id, 'type' => App\Models\PartyAdress::document_receiver])->first();
                        @endphp
                        <h2>{{ !empty($documentReceiver) ? $documentReceiver->receiverName : 'SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.' }}</h2>
                        <a href="javascript:void(0)" class="number">{{ !empty($documentReceiver) ? str_pad(substr($documentReceiver->number, -3), strlen($documentReceiver->number), '*', STR_PAD_LEFT) : '**********905' }}
                        </a>
                        <a href="javascript:void(0)" data-modal-toggle="document-modal" type="{{ App\Models\PartyAdress::document_receiver }}" data-modal-toggle="document-modal" class="link document-modal">Change</a>
                    </div>
                    <div class="action-btn">
                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-star">
                                <polygon
                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                </polygon>
                            </svg></a>
                    </div>
                </div>
                <div class="address-info border-0">
                    <div class="left-content">
                        <p><strong>Company name and address</strong></p>
                        <p>
                            {{ $booking->company->name }}
                            <br>
                            @if ($booking->company->city)
                                {{ $booking->company->city }},
                            @endif
                            @if ($booking->company->country)
                                {{ $booking->company->country }}
                            @endif
                        </p>
                        @if ($booking->company->country)
                            <p>{{ $booking->company->country }}</p>
                        @endif
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
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                    data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button
                            class="inline-block p-4 pb-2 rounded-t-lg text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                            id="waybill-tab" data-tabs-target="#waybill" type="button" role="tab" aria-controls="all"
                            aria-selected="true">Waybill</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button
                            class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300"
                            id="lading-tab" data-tabs-target="#lading" type="button" role="tab" aria-controls="lading"
                            aria-selected="false">Bill Of Lading</button>
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
                                <input type="radio" id="1" name="document_type" value="1">
                                <label for="1">Shipped on Board</label>
                            </div>
                            <div class="form-group">
                                <input type="radio" id="2" name="document_type" value="2">
                                <label for="2">Received for Shipment</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="hidden" id="lading" role="tabpanel" aria-labelledby="lading-tab">
                <p class="text-sm text-gray-500">3 Origianl Bill of Lading</p>
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
                    {{-- <label for="3">MSC ISABELLA(PA)/401E (First Load Port)</label> --}}
                    <label for="3">{{ (isset($track_booking_response['data']) && $track_booking_response['data']) ? $track_booking_response['data']?->vesselName : '' }}</label>
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
                                @if (!empty($track_booking_response['data']))
                                    <option value="{{ $track_booking_response['data']->finalPortUnlocode }}">
                                        {{ $track_booking_response['data']->finalPortName }},
                                        {{ $track_booking_response['data']->finalPortCountry }}
                                        [{{ $track_booking_response['data']->finalPortUnlocode }}]
                                    </option>
                                @endif
                            </select>
                        </form>
                        <div class="Aliasesbottom">
                            <p>Departing <span><strong>{{ (isset($track_booking_response['data']) && $track_booking_response['data']) ? \Carbon\Carbon::parse($track_booking_response['data']->plannedEta)->format('d M Y H:i') : '' }}</strong></span></p>
                        </div>
                    </div>
                </div>
                <div class="w-3/12">
                    <div class="Locationcolumn rounded-lg">
                        <form class="Locationform" id="" action="">
                            <label>Load Port</label>
                            <select name="scac" id="scac" class="form-input small-input mt-2 w-9/12 rounded-lg block">
                                @if(isset($track_booking_response['data']) && $track_booking_response['data'])
                                <option value="">
                                    {{ $track_booking_response['data']->originPortName }},
                                    {{ $track_booking_response['data']->originPortCountry }}
                                    [{{ $track_booking_response['data']->originPortUnlocode }}]
                                </option>
                                @endif
                            </select>
                        </form>
                        <div class="Aliasesbottom">
                            <p>Departing <span><strong>{{ (isset($track_booking_response['data']) && $track_booking_response['data']) ? \Carbon\Carbon::parse($track_booking_response['data']->plannedEta)->format('d M Y H:i') : '' }}</strong></span></p>
                        </div>
                    </div>
                </div>
                <div class="w-3/12">
                    <div class="Locationcolumn rounded-lg">
                        <form class="Locationform" id="portOfDischargeForm" action="">
                            <label>Port of Discharge</label>
                            <select name="portOfDischarge" id="portOfDischarge" class="form-input small-input mt-2 w-9/12 rounded-lg block">
                                @if (!empty($track_booking_response['data']))
                                    <option value="{{ $track_booking_response['data']->finalPortUnlocode }}">
                                        {{ $track_booking_response['data']->finalPortName }},
                                        {{ $track_booking_response['data']->finalPortCountry }}
                                        [{{ $track_booking_response['data']->finalPortUnlocode }}]
                                    </option>
                                @endif
                            </select>
                        </form>
                        <div class="Aliasesbottom">
                            <p>Arriving <span><strong>{{  !empty($track_booking_response['data']) ? \Carbon\Carbon::parse($track_booking_response['data']->finalPortPredictiveArrivalUtc)->format('d M Y H:i') : '' }}</strong></span></p>
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
                <p>The number of free days of detention/demurrage application to your shipment before charges are
                    applicable.</p>
            </div>
            <div class="DocumentationRow">
                <div class="leftcolumn">
                    <fieldset class="px-0">
                        <div class="inline-flex">
                            <input class="hidden" type="radio" id="no" value="no" name="gender" />
                            <label
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 cursor-pointer rounded-l"
                                for="no">No</label>
                            <input class="hidden" type="radio" id="yes" value="yes" name="gender" checked />
                            <label
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 cursor-pointer rounded-r"
                                for="yes">Yes</label>
                        </div>
                    </fieldset>
                </div>
                <div class="rightcolumn">
                    <h5 class="pb-3"><b>Number of free days:</b></h5>
                    <form class="formbox" id="" action="">
                        <div class="form-check">
                            <label class="form-check-label" for="flexCheckDefault">
                                applicable free time 11 days combined (detention and demurrage) at (port of discharge /
                                place of delivery)
                            </label>
                            <input class="form-check-input" type="radio" name="free_days" value="" id="flexCheckDefault">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="flexCheckDefault1">
                                applicable free time 0 days detention at demurrage (port of discharge / place of
                                delivery)
                            </label>
                            <input class="form-check-input" type="radio" name="free_days" value="" id="flexCheckDefault1">
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
                            <input class="hidden" type="radio" id="no2" value="no2" name="is_maersk_agent" checked />
                            <label
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 cursor-pointer rounded-l"
                                for="no2">No</label>
                            <input class="hidden" type="radio" id="yes2" value="yes2" name="is_maersk_agent" />
                            <label
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 cursor-pointer rounded-r"
                                for="yes2">Yes</label>
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
                            <input class="hidden" type="radio" id="no3" value="no3" name="in_transit" checked />
                            <label
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 cursor-pointer rounded-l"
                                for="no3">No</label>
                            <input class="hidden" type="radio" id="yes3" value="yes3" name="in_transit" />
                            <label
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 cursor-pointer rounded-r"
                                for="yes3">Yes</label>
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
                                @php
                                    $shipper = App\Models\PartyAdress::where(['booking_id' => $booking->id, 'type' => App\Models\PartyAdress::shipper])->first();
                                @endphp
                                <div class="left-content">
                                    <h2>{{ !empty($shipper) ? $shipper->receiverName : 'SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.' }}</h2>
                                    <a href="javascript:void(0)" class="number">{{ !empty($shipper) ? str_pad(substr($shipper->number, -3), strlen($shipper->number), '*', STR_PAD_LEFT) : '**********905' }}
                                    </a>
                                    <!-- Link to trigger the modal -->
                                    <a href="javascript:void(0)" data-modal-toggle="document-modal" type="{{ App\Models\PartyAdress::shipper }}" data-modal-toggle="document-modal" class="link document-modal">Change</a>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                            <polygon
                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                            </polygon>
                                        </svg></a>
                                </div>
                            </div>
                            <div class="address-info">
                                <div class="left-content">
                                    <p> <strong> Company name and address </strong></p>
                                    <p>{{ $booking->company->name }}</p>
                                    <p>{{ $booking->company->address }}</p>
                                    <p>{{ $booking->company->city }}</p>
                                    <p>{{ $booking->company->country }}</p>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg></a>
                                </div>
                            </div>
                            <div class="address-info border-0">
                                <div class="left-content">
                                    <p>References</p>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg></a>
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
                                @php
                                    $consignee = App\Models\PartyAdress::where(['booking_id' => $booking->id, 'type' => App\Models\PartyAdress::consignee])->first();
                                @endphp
                                <div class="left-content">
                                    <h2>{{ !empty($consignee) ? $consignee->receiverName : 'SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.' }}</h2>
                                    <a href="javascript:void(0)" class="number">{{ !empty($consignee) ? str_pad(substr($consignee->number, -3), strlen($consignee->number), '*', STR_PAD_LEFT) : '**********905' }}
                                    </a>
                                    <!-- Link to trigger the modal -->
                                    <a href="javascript:void(0)" data-modal-toggle="document-modal" type="{{ App\Models\PartyAdress::consignee }}" data-modal-toggle="document-modal" class="link document-modal">Change</a>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                            <polygon
                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                            </polygon>
                                        </svg></a>
                                </div>
                            </div>
                            <div class="address-info">
                                <div class="left-content">
                                    <p> <strong> Company name and address </strong></p>
                                    <p>SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.
                                        <br>TOURIST CLUB AREA
                                        <br>ABU DHABI
                                    </p>
                                    <p>United Arab Emirates</p>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg></a>
                                </div>
                            </div>
                            <div class="address-info border-0">
                                <div class="left-content">
                                    <p>References</p>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg></a>
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
                                @php
                                    $notityparty = App\Models\PartyAdress::where(['booking_id' => $booking->id, 'type' => App\Models\PartyAdress::notityparty])->first();
                                @endphp
                                <div class="left-content">
                                    <h2>{{ !empty($notityparty) ? $notityparty->receiverName : 'SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.' }}</h2>
                                    <a href="javascript:void(0)" class="number">{{ !empty($notityparty) ? str_pad(substr($notityparty->number, -3), strlen($notityparty->number), '*', STR_PAD_LEFT) : '**********905' }}
                                    </a>
                                    <!-- Link to trigger the modal -->
                                    <a href="javascript:void(0)" data-modal-toggle="document-modal" type="{{ App\Models\PartyAdress::notityparty }}" data-modal-toggle="document-modal" class="link document-modal">Change</a>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                            <polygon
                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                            </polygon>
                                        </svg></a>
                                </div>
                            </div>
                            <div class="address-info">
                                <div class="left-content">
                                    <p> <strong> Company name and address </strong></p>
                                    <p>SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.
                                        <br>TOURIST CLUB AREA
                                        <br>ABU DHABI
                                    </p>
                                    <p>United Arab Emirates</p>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg></a>
                                </div>
                            </div>
                            <div class="address-info border-0">
                                <div class="left-content">
                                    <p>References</p>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg></a>
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
                            <p>
                                <svg class="inline" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <line x1="20" y1="8" x2="20" y2="14"></line>
                                    <line x1="23" y1="11" x2="17" y2="11"></line>
                                </svg> Additional notify party</p>
                        </div>
                        <div class="address-sec">
                            <div class="address-info">
                                @php
                                    $additionalnotityparty = App\Models\PartyAdress::where(['booking_id' => $booking->id, 'type' => App\Models\PartyAdress::additionalnotityparty])->first();
                                @endphp
                                <div class="left-content">
                                    <h2>{{ !empty($additionalnotityparty) ? $additionalnotityparty->receiverName : 'SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.' }}</h2>
                                    <a href="javascript:void(0)" class="number">{{ !empty($additionalnotityparty) ? str_pad(substr($additionalnotityparty->number, -3), strlen($additionalnotityparty->number), '*', STR_PAD_LEFT) : '**********905' }}
                                    </a>
                                    <!-- Link to trigger the modal -->
                                    <a href="javascript:void(0)" data-modal-toggle="document-modal" type="{{ App\Models\PartyAdress::additionalnotityparty }}" data-modal-toggle="document-modal" class="link document-modal">Change</a>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                            <polygon
                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                            </polygon>
                                        </svg></a>
                                </div>
                            </div>
                            <div class="address-info">
                                <div class="left-content">
                                    <p> <strong> Company name and address </strong></p>
                                    <p>SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.
                                        <br>TOURIST CLUB AREA
                                        <br>ABU DHABI
                                    </p>
                                    <p>United Arab Emirates</p>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg></a>
                                </div>
                            </div>
                            <div class="address-info border-0">
                                <div class="left-content">
                                    <p>References</p>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg></a>
                                </div>
                            </div>
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
                                @php
                                    $outwardforwarder = App\Models\PartyAdress::where(['booking_id' => $booking->id, 'type' => App\Models\PartyAdress::outwardforwarder])->first();
                                @endphp
                                <div class="left-content">
                                    <h2>{{ !empty($outwardforwarder) ? $outwardforwarder->receiverName : 'SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.' }}</h2>
                                    <a href="javascript:void(0)" class="number">{{ !empty($outwardforwarder) ? str_pad(substr($outwardforwarder->number, -3), strlen($outwardforwarder->number), '*', STR_PAD_LEFT) : '**********905' }}
                                    </a>
                                    <!-- Link to trigger the modal -->
                                    <a href="javascript:void(0)" data-modal-toggle="document-modal" type="{{ App\Models\PartyAdress::outwardforwarder }}" data-modal-toggle="document-modal" class="link document-modal">Change</a>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                            <polygon
                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                            </polygon>
                                        </svg></a>
                                </div>
                            </div>
                            <div class="address-info">
                                <div class="left-content">
                                    <p> <strong> Company name and address </strong></p>
                                    <p>SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.
                                        <br>TOURIST CLUB AREA
                                        <br>ABU DHABI
                                    </p>
                                    <p>United Arab Emirates</p>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg></a>
                                </div>
                            </div>
                            <div class="address-info border-0">
                                <div class="left-content">
                                    <p>References</p>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-4/12">
                    <div class="card-body">
                        <div class="title-sec text-center">
                            <p><svg class="inline" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <line x1="20" y1="8" x2="20" y2="14"></line>
                                    <line x1="23" y1="11" x2="17" y2="11"></line>
                                </svg> Inward forwarner </p>
                        </div>
                        <div class="address-sec">
                            <div class="address-info">
                                @php
                                    $inwardforwarner = App\Models\PartyAdress::where(['booking_id' => $booking->id, 'type' => App\Models\PartyAdress::inwardforwarner])->first();
                                @endphp
                                <div class="left-content">
                                    <h2>{{ !empty($inwardforwarner) ? $inwardforwarner->receiverName : 'SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.' }}</h2>
                                    <a href="javascript:void(0)" class="number">{{ !empty($inwardforwarner) ? str_pad(substr($inwardforwarner->number, -3), strlen($inwardforwarner->number), '*', STR_PAD_LEFT) : '**********905' }}
                                    </a>
                                    <!-- Link to trigger the modal -->
                                    <a href="javascript:void(0)" data-modal-toggle="document-modal" type="{{ App\Models\PartyAdress::inwardforwarner }}" data-modal-toggle="document-modal" class="link document-modal">Change</a>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                            <polygon
                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                            </polygon>
                                        </svg></a>
                                </div>
                            </div>
                            <div class="address-info">
                                <div class="left-content">
                                    <p> <strong> Company name and address </strong></p>
                                    <p>SHIP 247 FOR LOGISTIC SERVICES - SOLE PROPRIETORSHIP L.L.C.
                                        <br>TOURIST CLUB AREA
                                        <br>ABU DHABI
                                    </p>
                                    <p>United Arab Emirates</p>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg></a>
                                </div>
                            </div>
                            <div class="address-info border-0">
                                <div class="left-content">
                                    <p>References</p>
                                </div>
                                <div class="action-btn">
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg></a>
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
            <h4><span>Booked commodity: Fertilizer</span></h4>
        </div>
        <div class="booked-commodity">
            <form class="" action="" id="">
                <div class="form-check-inline">
                    <label>Kind of packages</label>
                    <select name="scac" id="scac" class="form-input small-input mt-2 w-9/12 rounded-lg block">
                        <option value="">Aluminium Bulk</option>
                        <option value="d">1 </option>
                        <option value="d">2 </option>
                        <option value="d">3 </option>
                        <option value="d">4 </option>
                    </select>
                </div>
                <div class="form-check-inline">
                    <label>6 digit HS Code</label>
                    <input type="text" placeholder="315025"
                        class="form-input small-input mt-2 w-9/12 rounded-lg block" />
                </div>
            </form>
        </div>
        <div class="cargo-description">
            <div class="sec-title mb-2">
                <h4>Cargo description</h4>
            </div>
            <div class="info-box-sec">
                <div class="svg-info mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-info">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                </div>
                <div class="text-info">
                    <h5>Do not enter Agent address, Free time, In-transit or transsipment clauses here - use the <a
                            href="#">Document Type</a> Local customs regulations need the actual cargo description
                        within the first 2. </h5>
                    <p>To enable your instant draft bill, we will not be validating these clauses entered here.
                </div>
            </div>
        </div>
        <div class="template-sec">
            <div class="content-box">
                <h4>2 by 20GP FCL SAID TO CONTAIN<br>
                    NATURCOMPLET-G SACO 25KG</h4><br>
                <h4>HUMIC ACID FERTILIZER<br>
                    INCOTERMS: FCA ZARAGOZA FACTORY<br>
                    BANK NAME EBILAEAD-EMIRATES NBD BANK PJSC</h4>
            </div>
            <div class="fieldtext">
                <div class="form-group-inline">
                    <input type="text" class="form-input small-input w-12/12 rounded-lg block"
                        placeholder="Enter a name for your template" />
                </div>
                <div class="form-group-btn">
                    <a href="#" class="btn outline-btn">Create Template</a>
                    <a href="#" class="btn dark-btn">Open Template</a>
                </div>
            </div>
        </div>
    </div>


    <div class="card-shipping pb-5">
        <div class="card-title">
            <h4><span>Add Marks and Numbers</span></h4>
        </div>
        <div class="card-btn mt-3">
            <a href="#" class="btn">Add another description for this shipment</a>
            <a href="#" class="btn">Copy these details to another description</a>
        </div>
        <div class="addmark-sec">
            <h2>Give container details, VGM and seals</h2>
        </div>
        <div class="tabbing">
            <div class="mb-8 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                    data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button
                            class="inline-block p-4 pb-2 rounded-t-lg text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                            id="containerd-tab" data-tabs-target="#containerd" type="button" role="tab"
                            aria-controls="all" aria-selected="true">Container details</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button
                            class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600 dark:border-transparent text-gray-500 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300"
                            id="additionald-tab" data-tabs-target="#additionald" type="button" role="tab"
                            aria-controls="additionald" aria-selected="false">Seals and Additional Details</button>
                    </li>
                </ul>
            </div>
        </div>
        <div id="myTabContent">
            <div class="" id="containerd" role="tabpanel" aria-labelledby="all-tab">
                <div class="detail-body">
                    <div class="rounded-lg bg-gray-50">
                        <div class="relative overflow-x-auto">
                            <h2 class="mb-3"><strong> 20 Dry Standard</strong></h2>
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Number
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Container Number
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Pkgs (count)
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Cargo wt. (kg)
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Volume (m3)
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            VGM (kg)
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            VGM method
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($track_booking_response))
                                    @foreach($track_booking_response['data']?->containers as $cIndex => $container)
                                    <tr class="border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $container->isoCode }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $container->id }}
                                        </td>
                                        <td class="px-6 py-4">
                                            20
                                        </td>
                                        <td class="px-6 py-4">
                                            20000.000
                                        </td>
                                        <td class="px-6 py-4">
                                            00000.000
                                        </td>
                                        <td class="px-6 py-4">
                                            20180
                                        </td>
                                        <td class="px-6 py-4">
                                            Weight of cargo added to count.
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden" id="additionald" role="tabpanel" aria-labelledby="additionald-tab">
                <div class="detail-body">
                    <div class="rounded-lg bg-gray-50">
                        <div class="relative overflow-x-auto">
                            <h2 class="mb-3"><strong> 24 Dry Standard</strong></h2>
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Number
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Container Number
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Shippers seal
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Carrier seal
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Customs seal
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Vet seal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            1/2
                                        </th>
                                        <td class="px-6 py-4">
                                            MRSUO178658
                                        </td>
                                        <td class="px-6 py-4">

                                        </td>
                                        <td class="px-6 py-4">

                                        </td>
                                        <td class="px-6 py-4">

                                        </td>
                                        <td class="px-6 py-4">

                                        </td>
                                    </tr>
                                    <tr class="border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            1/2
                                        </th>
                                        <td class="px-6 py-4">
                                            MRSUO178658
                                        </td>
                                        <td class="px-6 py-4">

                                        </td>
                                        <td class="px-6 py-4">

                                        </td>
                                        <td class="px-6 py-4">

                                        </td>
                                        <td class="px-6 py-4">

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="terms-sec mt-8 mb-3">
            <p><a href="#" class="btn">Continue </a> By submitting the VGM you agree to the <a href="#"
                    class="link">Terms & Conditions</a> for supplying the gross weight.</p>
        </div>
    </div>
</div>