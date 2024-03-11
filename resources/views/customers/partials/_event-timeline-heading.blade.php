<div class="detail-body">
    <div class="{{$popup ? "detail-box ADD-CLASSES-FOR-Popup" : "detail-box"}} gap-4 relative">
        <div class="lg:w-3/12 lg:mb-0 mb-4">
            <div class="flex flex-col gap-4">
                <div>
                    <span class="head">CONTAINER NUMBER:</span>
                    <span class="value">{{ $container->id }}</span>
                </div>
                @if($container->isoCode)
                    <div>
                        <span class="head">CONTAINER SIZE:</span>
                        <span class="value">
                            {{ $data['track_booking_response']['data']->containerSizesArray[$container->isoCode] }}
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:w-5/12 lg:mb-0 mb-4">
            <div class="flex flex-col gap-4">
                <div>
                    <span class="head">LATEST MOVEMENT EVENT:</span>
                    <span class="value">
                        {{ $data['track_booking_response']['data']?->lastEvent->eventTypeDescription }}
                    </span>
                </div>

                <div>
                    <span class="head">PORT:</span>
                    <span class="value">
                        @if($data['track_booking_response']['data']?->lastEvent->location?->portId)
                            {{$data['track_booking_response']['data']->locationsArray[$data['track_booking_response']['data']?->lastEvent->location?->portId]?->locationName}},
                            {{$data['track_booking_response']['data']->locationsArray[$data['track_booking_response']['data']?->lastEvent->location?->portId]?->locationCountry}}
                        @else
                            -
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="lg:w-2/12 lg:mb-0 mb-4">
            <div class="flex flex-col gap-4">
                <div>
                    <span class="head">VESSEL / VOYAGE:</span>
                    <span class="value">
                        @if($data['track_booking_response']['data']?->lastEvent?->vessel->shipId)
                            {{ $data['track_booking_response']['data']->vesselsArray[$data['track_booking_response']['data']?->lastEvent?->vessel->shipId]->vesselName }}
                            / {{$data['track_booking_response']['data']?->lastEvent->carrierVoyageNumber}}
                        @else
                            -
                        @endif
                    </span>
                </div>

                <div>
                    <span class="head">DATE-TIME</span>
                    <span class="value">{{ Carbon\Carbon::parse($data['track_booking_response']['data']?->lastEvent->eventDatetime)->setTimezone('UTC')->format('Y-m-d H:i') }}
                                        (UTC)</span>
                </div>
            </div>
        </div>
        @if(!$popup)
        <div class="lg:w-2/12 lg:mb-0 mb-4">
            <div class="flex justify-end items-center h-full">
                <div>
                    <a href="#" data-modal-toggle="container-event-timeline-modal-{{$cIndex}}"
                       class="default-button small-button red">view details</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@if($popup)
    @foreach($track_booking_response['data']?->transportationPlan?->events as $event)
        @include('customers.partials._event-timeline-row')
    @endforeach
@endif
