@extends('layouts.admin')

@section('content')

    <?php
    $bookingData = $data["bookings"]->toArray();
    $bookings = $data["bookings"];

    $inProgressBookingsCount = count(array_filter($bookingData, function ($booking) {
        return $booking['status'] === config('constants.BOOKING_STATUS_IN_PROGRESS');
    }));

    $cancelledBookingsCount = count(array_filter($bookingData, function ($booking) {
        return $booking['status'] === config('constants.BOOKING_STATUS_CANCELLED');
    }));

    $onHoldBookingsCount = count(array_filter($bookingData, function ($booking) {
        return $booking['status'] === config('constants.BOOKING_STATUS_ON_HOLD');
    }));

    $completedBookingsCount = count(array_filter($bookingData, function ($booking) {
        return $booking['status'] === config('constants.BOOKING_STATUS_COMPLETED');
    }));
    ?>

    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <div class="dashboard-counter admin-counter">
                <div class="4xl:w-3/12 lg:w-4/12 w-full">
                    <div class="count-box">
                        <h2 class="title">Registered Users</h2>

                        <div class="flex">
                            <p class="number mb-4">{{$data["registered_users"]}}</p>
                        </div>

                        <div class="flex">
                            <a href="{{route('superadmin.customers.index')}}" class="default-button red">
                                <span>view all</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="4xl:w-3/12 lg:w-4/12 w-full">
                    <div class="count-box">
                        <h2 class="title">Total Bookings</h2>

                        <div class="flex">
                            <p class="number mb-4">{{$data["total_bookings"]}}</p>
                        </div>

                        <div class="flex">
                            <a href="{{route('superadmin.dashboard.index')}}" class="default-button red">
                                <span>view all</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="4xl:w-3/12 lg:w-4/12 w-full">
                    <div class="count-box">
                        <h2 class="title">TOTAL EARNINGS</h2>

                        <div class="flex">
                            <p class="number mb-4"> {{ '$' . number_format($data["total_earnings"], 2) }} </p>
                        </div>

                        <div class="flex">
                            <a href="{{route('superadmin.invoices.index')}}" class="default-button red">
                                <span>view all</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <div class="w-6/12">
                    <h2 class="title">
                        Track by Booking ID
                    </h2>
                </div>
            </header>
            <section class="search-result mt-8">
                <form class="default-form" action="{{ url()->current() }}" method="GET">
                    <div class="flex lg:items-end items-start lg:flex-row flex-col lg:gap-6 gap-4">
                        <div class="lg:w-3/12 w-full">
                            <div class="form-field">
                                <label for="name" class="form-label-small">Booking ID</label>
                                <input type="text" name="booking_id"
                                       id="booking_id" class="form-input small-input w-full"
                                       placeholder="Booking ID" value="{{ request('booking_id') ?? '' }}">
                            </div>
                        </div>

                        <div class="lg:w-3/12 w-full">
                            <button type="submit" class="default-button-v2 outline-button">
                                <span>Search</span>
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </section>

    @if(request('booking_id'))
        @if($data['track_booking_response']['success'])
            @include('admin.partials._shipment_tracking')
        @endif
    @endif

    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <div class="md:w-3/12">
                    <h2 class="title">
                        Last 10 Bookings
                    </h2>
                </div>
                <div class="md:w-6/12">
                    {{-- <form class="dashboard-searchbar">
                        <input type="text" class="search-bar"
                            placeholder="Search By : BL, SHIPPING LINE, POO, POD, AMOUNT, TRANSPORTATION, STATUS ETC. …." />
                        <button class="submit-btn">
                            <img src="/images/svg/search-icon.svg" alt="">
                        </button>
                    </form> --}}
                    <form class="dashboard-searchbar" action="{{ route('superadmin.dashboard.index') }}" method="GET">
                        <input type="text" class="search-bar" name="search"
                               placeholder="Search By: BL, SHIPPING LINE, POO, POD, AMOUNT, TRANSPORTATION, STATUS ETC. …."
                               value="{{ request('search') }}"/>
                        <button class="submit-btn" type="submit">
                            <img src="/images/svg/search-icon.svg" alt="">
                        </button>
                    </form>
                </div>
            </header>

            <div class="tabbing mt-8">
                <div class="md:mb-8 mb-4 border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                        data-tabs-toggle="#myTabContent" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 pb-2 rounded-t-lg" id="all-tab" data-tabs-target="#all"
                                    type="button" role="tab" aria-controls="all" aria-selected="false">All
                            </button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="inprogress-tab"
                                    data-tabs-target="#inprogress" type="button" role="tab" aria-controls="inprogress"
                                    aria-selected="false">in-progress
                            </button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="completed-tab"
                                    data-tabs-target="#completed" type="button" role="tab" aria-controls="completed"
                                    aria-selected="false">Completed
                            </button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="canceled-tab"
                                    data-tabs-target="#canceled" type="button" role="tab" aria-controls="canceled"
                                    aria-selected="false">Canceled
                            </button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 pb-2 rounded-t-lg hover:text-gray-600" id="onhold-tab"
                                    data-tabs-target="#onhold" type="button" role="tab" aria-controls="onhold"
                                    aria-selected="false">on-hold
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <div id="myTabContent">
                <div class="" id="all" role="tabpanel" aria-labelledby="all-tab">
                    <div class="detail-body">
                        @if(isset($bookings) && count($bookings)> 0)
                            @foreach ($bookings as $booking)
                                @include('admin.partials._booking-detail-box', ['booking' => $booking, 'tab'=> 'all-tab'])
                            @endforeach
                        @else
                            <div class="p-4 rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-500">No bookings found</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="hidden" id="inprogress" role="tabpanel" aria-labelledby="inprogress-tab">
                    <div class="detail-body">
                        @if(isset($bookings) && count($bookings)> 0 && $inProgressBookingsCount > 0)
                            @foreach ($bookings as $booking)
                                @if($booking->status == config('constants.BOOKING_STATUS_IN_PROGRESS'))
                                    @include('admin.partials._booking-detail-box', ['booking' => $booking, 'tab'=> 'inprogress-tab'])
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
                                    @include('admin.partials._booking-detail-box', ['booking' => $booking , 'tab'=> 'completed-tab'])
                                @endif
                            @endforeach
                        @else
                            <div class="p-4 rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-500">No completed bookings found</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="hidden" id="canceled" role="tabpanel" aria-labelledby="canceled-tab">
                    <div class="detail-body">
                        @if(isset($bookings) && count($bookings)> 0 && $cancelledBookingsCount > 0)
                            @foreach ($bookings as $booking)
                                @if($booking->status == config('constants.BOOKING_STATUS_CANCELLED'))
                                    @include('admin.partials._booking-detail-box', ['booking' => $booking, 'tab'=> 'canceled-tab'])
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
                                    @include('admin.partials._booking-detail-box', ['booking' => $booking, 'tab'=> 'onhold-tab'])
                                @endif
                            @endforeach
                        @else
                            <div class="p-4 rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-500">No cancelled bookings found</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- <footer>
                    <p class="number">Showing <strong>{{ $bookings->firstItem() }}
                            - {{ $bookings->lastItem() }} </strong></p>
                    {{ $bookings->links() }}
                </footer> --}}
            </div>
        </div>
    </section>
@endsection
