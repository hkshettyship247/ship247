<div class="rounded-lg bg-gray-50">
    <div class="detail-box">
        <div class="w-2/12">
            <div class="flex flex-col gap-4">
                <div>
                    <span class="head">Booking ID</span>
                    <span class="value">{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT)
                        }}</span>
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
                    <span class="value">{{isset($booking->origin->fullname) ?
                        $booking->origin->fullname :
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
                    <span class="value">{{ '$' . number_format($booking->amount, 2)
                        }}</span>
                </div>

                <div>
                    <span class="head">CARGO READY</span>
                    <span class="value">{{ date('d M y',
                        strtotime($booking->departure_date_time))
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
                    <span class="value">{{isset($booking->company->name) ?
                        $booking->company->name :
                        '-'}}</span>
                </div>
            </div>
        </div>

        <div class="w-2/12">
            <div class="flex flex-col gap-4">
                <div>
                    <span class="head">Shipping Number</span>
                    <span class="value">{{isset($booking->shipping_number) ?
                        $booking->shipping_number :
                        '-'}}</span>
                </div>

                <div>
                    <span class="head">Receipt Number</span>
                    <span class="value">{{isset($booking->receipt_number) ?
                        $booking->receipt_number :
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