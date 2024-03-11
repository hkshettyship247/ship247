<div class="detail-body">
    <div class="detail-box gap-4 relative">
        <div class="lg:w-3/12 lg:mb-0 mb-4">
            <div class="flex flex-col gap-4">
                <div>
                    <span class="head">CARRIER EVENT</span>
                    <span
                        class="value">{{ $event->eventTypeDescription }}</span>
                </div>
            </div>
        </div>
        <div class="lg:w-2/12 lg:mb-0 mb-4">
            <div class="flex flex-col gap-4">
                <div>
                    <span class="head">STATUS</span>
                    <span class="value">
                        @if($event->eventStatus === 'PLN')
                            Planned
                        @elseif($event->eventStatus === 'ACT')
                            Completed
                        @endif
                    </span>
                </div>
            </div>
        </div>
        <div class="lg:w-2/12 lg:mb-0 mb-4">
            <div class="flex flex-col gap-4">
                <div>
                    <span class="head">PORT</span>
                    <span class="value">
                        @if($event->location?->portId)
                            {{$data['track_booking_response']['data']->locationsArray[$event->location?->portId]?->locationName}},
                            {{$data['track_booking_response']['data']->locationsArray[$event->location?->portId]?->locationCountry}}
                        @else
                            -
                        @endif
                    </span>
                </div>
            </div>
        </div>
        <div class="lg:w-3/12 lg:mb-0 mb-4">
            <div class="flex flex-col gap-4">
                <div>
                    <span class="head">VESSEL / VOYAGE:</span>
                    <span class="value">
                        @if($event?->vessel->shipId)
                            {{ $data['track_booking_response']['data']->vesselsArray[$event?->vessel->shipId]->vesselName }}
                            / {{$event->carrierVoyageNumber}}
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
                    <span class="head">DATE-TIME</span>
                    <span class="value">{{ Carbon\Carbon::parse($event->eventDatetime)->setTimezone('UTC')->format('Y-m-d H:i') }}
                                        (UTC)</span>
                </div>
            </div>
        </div>
    </div>
</div>
