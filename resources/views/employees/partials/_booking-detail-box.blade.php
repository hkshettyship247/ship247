<div class="detail-box gap-4 relative {{is_null($booking->read_at) ? 'bookings-new' : ''}}">
    @php
        $bookingStatusOptions = [
            'BOOKING_STATUS_IN_PROGRESS' => config('constants.BOOKING_STATUS_IN_PROGRESS'),
            'BOOKING_STATUS_COMPLETED' => config('constants.BOOKING_STATUS_COMPLETED'),
            'BOOKING_STATUS_ON_HOLD' => config('constants.BOOKING_STATUS_ON_HOLD'),
            'BOOKING_STATUS_CANCELLED' => config('constants.BOOKING_STATUS_CANCELLED'),
            'BOOKING_STATUS_CONFIRMED' => config('constants.BOOKING_STATUS_CONFIRMED'),
            'BOOKING_STATUS_SI_SUBMITTED' => config('constants.BOOKING_STATUS_SI_SUBMITTED'),
            'BOOKING_STATUS_SI_CONFIRMED' => config('constants.BOOKING_STATUS_SI_CONFIRMED'),
            'BOOKING_STATUS_EVGM_SUBMITTED' => config('constants.BOOKING_STATUS_EVGM_SUBMITTED'),
            'BOOKING_STATUS_EVGM_CONFIRMED' => config('constants.BOOKING_STATUS_EVGM_CONFIRMED'),
            'BOOKING_STATUS_DRAFT_BL_RECEIVED' => config('constants.BOOKING_STATUS_DRAFT_BL_RECEIVED'),
            'BOOKING_STATUS_DRAFT_BL_CONFIRMED' => config('constants.BOOKING_STATUS_DRAFT_BL_CONFIRMED'),
            'BOOKING_STATUS_FINISHED' => config('constants.BOOKING_STATUS_FINISHED'),
        ];
    @endphp
    <div class="absolute left-4 -top-3">
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

    <div class="lg:w-2/12 lg:mb-0 mb-4">
        <div class="flex flex-col gap-4">
            <div>
                <span class="head">Booking ID</span>
                <span class="value">{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }} </span>
            </div>
            <div>
                <span class="head">BL Number</span>
                <span class="value">{{isset($booking->shipping_number) ? $booking->shipping_number : '-'}}</span>
            </div>
        </div>
    </div>

    <div class="lg:w-4/12">
        <div class="flex flex-col gap-4">
            <div>
                <span class="head">from</span>
                <span class="value">{{isset($booking->origin->fullname) ? $booking->origin->fullname : ''}}</span>
            </div>

            <div>
                <span class="head">to</span>
                <span class="value">{{isset($booking->destination->fullname) ?$booking->destination->fullname : '' }}</span>
            </div>
        </div>
    </div>

    <div class="lg:w-2/12 lg:mt-0 mt-4">
        <div class="flex flex-col gap-4">
            <div>
                <span class="head">No of Container</span>
                <span class="value">{{$booking->no_of_containers}}</span>
            </div>

            <div>
                <span class="head">Container</span>
                <span class="value">{{$booking->container_size}}</span>
            </div>
        </div>
    </div>

    <div class="lg:w-2/12 lg:mt-0 mt-4">
        <div class="flex flex-col gap-4">
            <div>
                <span class="head">amount</span>
                <span class="value">{{ '$' . number_format($booking->amount, 2) }}</span>
            </div>

            <div>
                <span class="head">Shipping line</span>
                <span class="value">{{isset($booking->company) ? $booking->company->name : ''}}</span>
            </div>
        </div>
    </div>

    <div class="lg:w-2/12 w-full lg:mt-0 mt-6">
        <div class="flex lg:justify-end items-start h-full">

            <button id="dropdownInvoiceButton-{{$booking->id}}{{isset($tab) ? '-'.$tab : ''}}" data-dropdown-toggle="dropdownInvoice-{{$booking->id}}{{isset($tab) ? '-'.$tab : ''}}"
                class="inline-flex justify-center items-center gap-x-1 rounded-md px-3 py-2 text-sm text-white primary-bg"
                type="button">
                View More
                <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div id="dropdownInvoice-{{$booking->id}}{{isset($tab) ? '-'.$tab : ''}}"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownInvoiceButton-{{$booking->id}}{{isset($tab) ? '-'.$tab : ''}}">
                    <li>
                        <a href="{{ route('employee.bookings.edit', [$booking->id]) }}"
                            class="block px-4 py-2 hover:bg-red-600 hover:text-white">Edit </a>
                    </li>
                    <li>
                        <a href="{{ route('employee.bookings.show', [$booking->id]) }}"
                            class="block px-4 py-2 hover:bg-red-600 hover:text-white">View Details</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- <div class="lg:w-2/12 lg:mt-0 mt-6">
        <div class="flex justify-end items-center h-full">
            <div>
                <a href="{{ route('employee.bookings.show', [$booking->id]) }}"
                   class="default-button small-button red">view details</a>
            </div>
            <div>
                <a href="{{ route('employee.bookings.edit', [$booking->id]) }}"
                   class="default-button small-button red">Edit </a>
            </div>
        </div>
    </div> --}}
</div>
