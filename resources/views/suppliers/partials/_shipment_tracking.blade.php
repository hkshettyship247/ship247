<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="md:w-3/12">
                <h2 class="title">
                    Shipment Details
                </h2>
            </div>
        </header>

        <div class="detail-body">
            <div class="detail-box gap-4 relative">
                <div class="lg:w-2/12 lg:mb-0 mb-4">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Bill of Lading:</span>
                            <span class="value">{{ $data['track_booking_response']['data']?->transportDocumentId
                                }}</span>
                        </div>
                        <div>
                            <span class="head">Carrier:</span>
                            <span class="value">{{ $data['track_booking_response']['data']?->carrier }}</span>
                        </div>
                    </div>
                </div>

                <div class="lg:w-4/12 lg:mb-0 mb-4">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Origin:</span>
                            <span class="value">
                                {{ $data['track_booking_response']['data']?->originPortName }},
                                {{ $data['track_booking_response']['data']?->originPortCountry }}
                                [{{ $data['track_booking_response']['data']?->originPortUnlocode }}]
                            </span>
                        </div>
                        <div>
                            <span class="head">Destination:</span>
                            <span class="value">
                                {{ $data['track_booking_response']['data']?->finalPortName }},
                                {{ $data['track_booking_response']['data']?->finalPortCountry }}
                                [{{ $data['track_booking_response']['data']?->finalPortUnlocode }}]
                            </span>
                        </div>
                    </div>
                </div>

                <div class="lg:w-4/12 lg:mb-0 mb-4">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Container Details:</span>
                            <span class="value">{{ count($data['track_booking_response']['data']?->containers) }}</span>
                        </div>
                        <div>
                            <span class="head">Container Number:</span>
                            <span class="value">{{ implode(',
                                ',array_column($data['track_booking_response']['data']?->containers, 'id')) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="md:w-3/12">
                <h2 class="title">
                    Shipment Status
                </h2>
            </div>
        </header>

        <div class="detail-body">
            <div class="detail-box gap-4 relative">
                <div class="lg:w-2/12 lg:mb-0 mb-4">
                    <div class="flex flex-col gap-4">
                        <div>
                            <span class="head">Currently:</span>
                            <span class="value">
                                @if($data['track_booking_response']['data']?->shipmentStatus == 0)
                                Booked
                                @elseif($data['track_booking_response']['data']?->shipmentStatus == 13)
                                Completed
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="shipment-route mt-10">
            <div class="flex w-full justify-between">
                <div class="origin text-xs md:text-base">
                    <h2 class="port-code font-bold">{{ $data['track_booking_response']['data']?->originPortUnlocode }}
                    </h2>
                    <h4 class="port-name">{{ $data['track_booking_response']['data']?->originPortName }},
                        {{ $data['track_booking_response']['data']?->originPortCountry }}</h4>
                </div>

                <div class="destination text-right text-xs md:text-base">
                    <h2 class="port-code font-bold">{{ $data['track_booking_response']['data']?->finalPortUnlocode }}
                    </h2>
                    <h4 class="port-name">{{ $data['track_booking_response']['data']?->finalPortName }},
                        {{ $data['track_booking_response']['data']?->finalPortCountry }}</h4>
                </div>
            </div>

            <div class="tracking-line flex w-full justify-between items-center relative mt-[20px]">

                <div class="origin">
                    <svg viewBox="0 0 24 24" id="hollowCircle" width="38">
                        <path
                            d="M12.5,19 C16.0898509,19 19,16.0898509 19,12.5 C19,8.91014913 16.0898509,6 12.5,6 C8.91014913,6 6,8.91014913 6,12.5 C6,16.0898509 8.91014913,19 12.5,19 Z M12.5,15 C11.1192881,15 10,13.8807119 10,12.5 C10,11.1192881 11.1192881,10 12.5,10 C13.8807119,10 15,11.1192881 15,12.5 C15,13.8807119 13.8807119,15 12.5,15 Z"
                            fill-rule="nonzero"></path>
                    </svg>
                </div>

                @php
                // Assuming the timestamps are provided in the response
                $departureTimestamp =
                \Carbon\Carbon::parse($data['track_booking_response']['data']->originPortPredictiveDepartureUtc);
                $arrivalTimestamp =
                \Carbon\Carbon::parse($data['track_booking_response']['data']->finalPortPredictiveArrivalUtc);
                $currentTimestamp = \Carbon\Carbon::now(); // Assuming this is the current time

                // Calculate the total duration of the journey in seconds
                $totalJourneyDuration = $arrivalTimestamp->diffInSeconds($departureTimestamp);

                // Calculate the elapsed time since departure in seconds
                $elapsedSinceDeparture = $currentTimestamp->diffInSeconds($departureTimestamp);

                // Calculate the percentage of the journey completed
                $percentageCompleted = ($elapsedSinceDeparture / $totalJourneyDuration) * 100;

                // Calculate the left position of the ship icon
                $left = number_format($percentageCompleted, 4) ?: 0;
                @endphp

                <div class="tracking-bar w-full bg-black h-[4px] relative mt-[10px]">
                    <div class="absolute top-[-26px] z-10" id="ship-icon-container" style="left: {{ $left }}%;">
                        <img src="/images/ship-icon.svg" alt="" class="w-[20px]" id="ship-icon">
                    </div>
                </div>

                <div class="destination">
                    <svg viewBox="0 0 24 24" width="32">
                        <path
                            d="M12,2 C15.87,2 19,5.13 19,9 C19,12.0911879 17.1799157,15.8324059 13.539747,20.2236541 C13.4603444,20.3194399 13.3721769,20.4076075 13.2763911,20.4870101 C12.426019,21.191935 11.1652017,21.0740266 10.4602769,20.2236546 L10.4602629,20.2236661 C6.82008765,15.8324128 5,12.0911907 5,9 C5,5.13 8.13,2 12,2 Z M12,11.5 C13.3807119,11.5 14.5,10.3807119 14.5,9 C14.5,7.61928813 13.3807119,6.5 12,6.5 C10.6192881,6.5 9.5,7.61928813 9.5,9 C9.5,10.3807119 10.6192881,11.5 12,11.5 Z"
                            fill-rule="nonzero"></path>
                    </svg>
                </div>
            </div>

            <div class="flex w-full justify-between mt-[20px]">
                <div class="origin text-xs md:text-base">
                    <p class="port-code font-bold">
                        @if($data['track_booking_response']['data']?->originPortActualDepartureUtc)
                        ATD: {{
                        Carbon\Carbon::parse($data['track_booking_response']['data']?->originPortActualDepartureUtc)->setTimezone('UTC')->format('Y-m-d
                        H:i') }}
                        @elseif($data['track_booking_response']['data']?->originPortPredictiveDepartureUtc)
                        ETD: {{
                        Carbon\Carbon::parse($data['track_booking_response']['data']?->originPortPredictiveDepartureUtc)->setTimezone('UTC')->format('Y-m-d
                        H:i') }}
                        @endif UTC
                    </p>
                </div>

                <div class="destination text-right text-xs md:text-base">
                    <p class="port-code font-bold">
                        @if($data['track_booking_response']['data']?->finalPortActualArrivalUtc)
                        ATA: {{
                        Carbon\Carbon::parse($data['track_booking_response']['data']?->finalPortActualArrivalUtc)->setTimezone('UTC')->format('Y-m-d
                        H:i') }}
                        @elseif($data['track_booking_response']['data']?->finalPortPredictiveArrivalUtc)
                        Predictive ETA: {{
                        Carbon\Carbon::parse($data['track_booking_response']['data']?->finalPortPredictiveArrivalUtc)->setTimezone('UTC')->format('Y-m-d
                        H:i') }}
                        @endif
                        UTC</p>
                    <p class="font-bold text-gray-500">Planned ETA:
                        {{
                        Carbon\Carbon::parse($data['track_booking_response']['data']?->plannedEta)->setTimezone('UTC')->format('Y-m-d
                        H:i') }}
                        UTC</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="md:w-3/12">
                <h2 class="title">
                    Events Timeline
                </h2>
            </div>
        </header>

        @foreach($data['track_booking_response']['data']?->containers as $cIndex => $container)
        @include('suppliers.partials._event-timeline-heading', ['popup' => false])

        <div id="container-event-timeline-modal-{{$cIndex}}" tabindex="-1"
            class="fixed top-0 left-0 bottom-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%)] max-h-full"
            style="background: rgba(0, 0, 0, 0.6)">
            <div class="relative w-full max-w-4xl max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="container-event-timeline-modal-{{$cIndex}}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>

                    <div class="p-6">
                        @include('suppliers.partials._event-timeline-heading', ['popup' => true])
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>