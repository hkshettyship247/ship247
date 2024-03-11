@extends('layouts.admin')

@section('content')
<?php

$bookingData = $bookings->toArray();

$inProgressBookingsCount = count(array_filter($bookingData, function ($booking) {
    return $booking['status'] === config('constants.BOOKING_STATUS_IN_PROGRESS') ;
}));

$cancelledBookingsCount = count(array_filter($bookingData, function ($booking) {
    return $booking['status'] ===config('constants.BOOKING_STATUS_CANCELLED');
}));

$onHoldBookingsCount = count(array_filter($bookingData, function ($booking) {
    return $booking['status'] ===config('constants.BOOKING_STATUS_ON_HOLD');
}));

$completedBookingsCount = count(array_filter($bookingData, function ($booking) {
    return $booking['status'] ===config('constants.BOOKING_STATUS_COMPLETED');
}));

?>

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="w-3/12">
                <h2 class="title">
                    Bookings
                </h2>
            </div>

            <div class="w-3/12 justify-end flex">
                <a href="/" class="default-button-v2">
                    <span>Search & Booking</span>
                </a>
            </div>
        </header>
		
		<section class="search-result mt-8 mb-12">

            <form class="default-form" action="{{ route('customer.bookings.index') }}" method="GET">

                <div class="flex lg:items-end items-start lg:flex-row flex-col lg:gap-6 gap-4">
                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="origin_id" class="form-label-small">Origin</label>
                            @include('customers.partials._location-select2',
                                [
                                    'name' => 'origin_id',
                                    'selected_option_value' => $origin->id ?? null,
                                    'selected_option_text' => $origin->fullname ?? null,
                                ]
                            )
                        </div>
                    </div>

                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="destination_id" class="form-label-small">Destination</label>
                            @include('customers.partials._location-select2',
                                [
                                    'name' => 'destination_id',
                                    'selected_option_value' => $destination->id ?? null,
                                    'selected_option_text' => $destination->fullname ?? null,
                                ]
                            )
                        </div>
                    </div>

                    <div class="lg:w-3/12 w-full">
                        <div class="form-field">
                            <label for="company_id" class="form-label-small">Company</label>
                            <select id="company_id" name="company_id"
                                    class="form-input small-input w-full">
                                <option value="">Select Company</option>
                                @if(isset($companies) && count($companies) >0  )
                                @foreach($companies as $company_id => $company_name)
                                    <option value="{{ $company_id }}"
                                            @if( isset($company) && $company->id == $company_id) selected @endif
                                    >{{$company_name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="lg:w-3/12 w-full">
                        <button type="submit" class="default-button-v2 outline-button">
                            <span>Search</span>
                        </button>
                    </div>
				 </div>	
				
				<br />
				<div class="3xl:w-3/12 w-full">
                        <div class="form-field">
                            <label for="industry" class="text-xs uppercase text-gray-400">Transportation</label>
							<br />
							<label for="sea" class="text-xs uppercase text-gray-400">Sea</label>
							@if($sea_type == 1)
								<input type="checkbox" id="sea_type" name="sea_type" checked />
							@else
								<input type="checkbox" id="sea_type" name="sea_type" />
							@endif
							<label for="land" class="text-xs uppercase text-gray-400">Land</label>
							@if($land_type == 1)
								<input type="checkbox" id="land_type" name="land_type" checked />
							@else
								<input type="checkbox" id="land_type" name="land_type" />
							@endif
							<label for="air" class="text-xs uppercase text-gray-400">Air</label>
							@if($air_type == 1)
								<input type="checkbox" id="air_type" name="air_type" checked />
							@else
								<input type="checkbox" id="air_type" name="air_type" />
							@endif	
                        </div>
                    </div>
					
            </form>
        </section>
		
        <div class="tabbing mt-8">
            <div class="mb-8 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                    data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 pb-2 rounded-t-lg" id="all-tab" data-tabs-target="#all"
                            type="button" role="tab" aria-controls="all" aria-selected="false">All</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="inprogress-tab"
                            data-tabs-target="#inprogress" type="button" role="tab" aria-controls="inprogress"
                            aria-selected="false">in-progress</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="completed-tab"
                            data-tabs-target="#completed" type="button" role="tab" aria-controls="completed"
                            aria-selected="false">Completed</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="canceled-tab"
                            data-tabs-target="#canceled" type="button" role="tab" aria-controls="canceled"
                            aria-selected="false">Canceled</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="onhold-tab"
                            data-tabs-target="#onhold" type="button" role="tab" aria-controls="onhold"
                            aria-selected="false">on-hold</button>
                    </li>
                </ul>
            </div>
        </div>

        <div id="myTabContent">
            <div class="" id="all" role="tabpanel" aria-labelledby="all-tab">
                <div class="detail-body">
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
                    @if(isset($bookings) && count($bookings)> 0)
                    @foreach ($bookings as $booking)
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
                        @endforeach

                        @else

                        <div class="p-4 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-500">No bookings found</p>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="hidden" id="inprogress" role="tabpanel"
                    aria-labelledby="inprogress-tab">
                    <div class="detail-body">
                        @if(isset($bookings) && count($bookings)> 0 && $inProgressBookingsCount > 0)
                        @foreach ($bookings as $booking)
                        @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
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
                                        @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED') )
                                        <span class="badge completed">
                                            Completed
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
                                        <span class="badge progress">
                                            In-Progress
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_CANCELLED'))
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

                            <div class="w-2/12">
                                <div class="flex justify-end items-center h-full">

                                    <div>
                                        <a href="{{ route('customer.bookings.show', [$booking->id]) }}"
                                            class="default-button small-button red">view details</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endif
                        @endforeach
                        @else
                        <div class="p-4 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-500">No in-progress bookings found</p>
                        </div>
                        @endif

                    </div>
                </div>
                <div class="hidden" id="completed" role="tabpanel"
                    aria-labelledby="completed-tab">
                    <div class="detail-body">
                        @if(isset($bookings) && count($bookings)> 0 && $completedBookingsCount > 0)
                        @foreach ($bookings as $booking)
                        @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED') )
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
                                        @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED') )
                                        <span class="badge completed">
                                            Completed
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
                                        <span class="badge progress">
                                            In-Progress
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_CANCELLED'))
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

                            <div class="w-2/12">
                                <div class="flex justify-end items-center h-full">

                                    <div>
                                        <a href="{{ route('customer.bookings.show', [$booking->id]) }}"
                                            class="default-button small-button red">view details</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endif
                        @endforeach
                        @else
                        <div class="p-4 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-500">No completed bookings found</p>
                        </div>
                        @endif

                    </div>
                </div>
                <div class="hidden" id="canceled" role="tabpanel"
                    aria-labelledby="canceled-tab">
                    <div class="detail-body">
                        @if(isset($bookings) && count($bookings)> 0 && $cancelledBookingsCount > 0)
                        @foreach ($bookings as $booking)
                        @if($booking->status == config('constants.BOOKING_STATUS_CANCELLED'))
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
                                        @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED') )
                                        <span class="badge completed">
                                            Completed
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
                                        <span class="badge progress">
                                            In-Progress
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_CANCELLED'))
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

                            <div class="w-2/12">
                                <div class="flex justify-end items-center h-full">

                                    <div>
                                        <a href="{{ route('customer.bookings.show', [$booking->id]) }}"
                                            class="default-button small-button red">view details</a>
                                    </div>
                                </div>
                            </div>

                        </div>
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
                        @if($booking->status == config('constants.BOOKING_STATUS_ON_HOLD'))
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
                                        @if($booking->status == config('constants.BOOKING_STATUS_COMPLETED') )
                                        <span class="badge completed">
                                            Completed
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
                                        <span class="badge progress">
                                            In-Progress
                                        </span>
                                        @endif
                                        @if($booking->status == config('constants.BOOKING_STATUS_CANCELLED'))
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

                            <div class="w-2/12">
                                <div class="flex justify-end items-center h-full">

                                    <div>
                                        <a href="{{ route('customer.bookings.show', [$booking->id]) }}"
                                            class="default-button small-button red">view details</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endif
                        @endforeach
                        @else
                        <div class="p-4 rounded-lg bg-gray-50">
                            <p class="text-sm text-gray-500">No onhold bookings found</p>
                        </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
</section>
@endsection
