<div class="detail-box">
    <div class="w-2/12">
        <div class="flex flex-col gap-4">
            <div>
                <span class="head">Booking ID</span>
                <span class="value">{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }} </span>
            </div>
        </div>
    </div>

    <div class="w-3/12">
        <div class="flex flex-col gap-4">
            <div>
                <span class="head">from</span>
                <span class="value">{{isset($booking->origin->fullname) ? $booking->origin->fullname : ''}}</span>
            </div>


        </div>
    </div>

    <div class="w-3/12">
        <div class="flex flex-col gap-4">
            <div>
                <span class="head">to</span>
                <span class="value">{{isset($booking->destination->fullname) ? $booking->destination->fullname : ''}}</span>
            </div>
        </div>
    </div>

    <div class="w-2/12">
        <div class="flex flex-col gap-4">
            <div>
                <span class="head">amount</span>
                <span class="value">{{ '$' . number_format($booking->amount, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="w-2/12">
        <div class="flex justify-center items-center h-full">
            <div>
                @foreach($bookingStatusOptions as $statusKey => $statusValue)
                    @if($booking->status == $statusValue)
                        @switch($statusKey)
                            @case('BOOKING_STATUS_IN_PROGRESS')
                                <span class="badge progress small-badge">In-Progress</span>
                                @break
                            @case('BOOKING_STATUS_COMPLETED')
                                <span class="badge completed small-badge">Completed</span>
                                @break
                            @case('BOOKING_STATUS_ON_HOLD')
                                <span class="badge hold small-badge">On-hold</span>
                                @break
                            @case('BOOKING_STATUS_CANCELLED')
                                <span class="badge cancel small-badge">Cancelled</span>
                                @break
                            @case('BOOKING_STATUS_CONFIRMED')
                                <span class="badge progress confirmed small-badge">Confirmed</span>
                                @break
                            @case('BOOKING_STATUS_SI_SUBMITTED')
                                <span class="badge progress submitted small-badge">SI Submitted</span>
                                @break
                            @case('BOOKING_STATUS_SI_CONFIRMED')
                                <span class="badge progress confirmed small-badge">SI Confirmed</span>
                                @break
                            @case('BOOKING_STATUS_EVGM_SUBMITTED')
                                <span class="badge progress submitted small-badge">VGM Submitted</span>
                                @break
                            @case('BOOKING_STATUS_EVGM_CONFIRMED')
                                <span class="badge progress confirmed small-badge">VGM Confirmed</span>
                                @break
                            @case('BOOKING_STATUS_DRAFT_BL_RECEIVED')
                                <span class="badge progress received small-badge">Draft BL Received</span>
                                @break
                            @case('BOOKING_STATUS_DRAFT_BL_CONFIRMED')
                                <span class="badge progress confirmed small-badge">Draft BL Confirmed</span>
                                @break
                            @case('BOOKING_STATUS_FINISHED')
                                <span class="badge defualt finished small-badge">Finished</span>
                                @break
                        @endswitch
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="w-2/12">
        <div class="flex justify-end items-center h-full">

            <div>
                <a href="{{ route('customer.bookings.show', [$booking->id]) }}"
                    class="default-button small-button red">view details</a>
            </div>
        </div>
    </div>
</div>