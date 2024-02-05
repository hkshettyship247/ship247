<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ContainerSizes;
use App\Models\User;
use App\Services\MarineTrafficAPI;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Number of records per page
        $search = $request->input('search'); // Search keyword

        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN') ||
            auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $bookingsQuery = Booking::query();
        } else {
            $bookingsQuery = Booking::where('user_id', auth()->user()->id);
        }
        if ($search) {
            $bookingsQuery->where(function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->whereHas('destination', function ($destinationQuery) use ($search) {
                        $destinationQuery->where('city', 'like', '%' . $search . '%')
                            ->orWhere('code', 'like', '%' . $search . '%')
                            ->orWhereHas('country', function ($countryQuery) use ($search) {
                                $countryQuery->where('name', 'like', '%' . $search . '%');
                            });
                    })->orWhereHas('origin', function ($originQuery) use ($search) {
                        $originQuery->where('city', 'like', '%' . $search . '%')
                            ->orWhere('code', 'like', '%' . $search . '%')
                            ->orWhereHas('country', function ($countryQuery) use ($search) {
                                $countryQuery->where('name', 'like', '%' . $search . '%');
                            });
                    })->orWhereHas('company', function ($companyQuery) use ($search) {
                        $companyQuery->where('name', 'like', '%' . $search . '%');
                    });
                })->orWhere('container_size', 'like', '%' . $search . '%')
                    ->orWhere('product', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }
//        $bookings = $bookingsQuery->latest()->paginate($perPage);
        $bookings = $bookingsQuery->latest()->limit(10)->get();

        $booking_id = $request->booking_id;
        $track_booking = null;
        $track_booking_response = null;
        if ($booking_id) {
            $track_booking = Booking::find($booking_id);
            if ($track_booking) {
                if ($track_booking?->marinetraffic_id) {
                    if (auth()->user()->role_id == config('constants.USER_TYPE_CUSTOMER')) {
                        if (intval(auth()->user()->company_id) === intval($track_booking->company_id)) {
                            $track_booking_response = MarineTrafficAPI::getTrackingInformation($track_booking->marinetraffic_id);
                        } else {
                            $track_booking_response = [
                                'success' => false,
                                'data' => "Booking Not Found!",
                            ];
                        }
					} else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
						if (intval(auth()->user()->company_id) === intval($track_booking->company_id)) {
                            $track_booking_response = MarineTrafficAPI::getTrackingInformation($track_booking->marinetraffic_id);
                        } else {
                            $track_booking_response = [
                                'success' => false,
                                'data' => "Booking Not Found!",
                            ];
                        }
                    } else if (in_array(auth()->user()->role_id, [
                        config('constants.USER_TYPE_EMPLOYEE'), config('constants.USER_TYPE_SUPERADMIN')
                    ])
                    ) {
                        $track_booking_response = MarineTrafficAPI::getTrackingInformation($track_booking->marinetraffic_id);
                    }
                    if($track_booking_response['success']) {
                        $locations = [];
                        foreach ($track_booking_response['data']?->transportationPlan?->locations as $location) {
                            $locations[$location->portId] = $location;
                        }

                        $vessels = [];
                        foreach ($track_booking_response['data']?->transportationPlan?->vessels as $vessel) {
                            $vessels[$vessel->shipId] = $vessel;
                        }
                        $track_booking_response['data']->locationsArray = $locations;
                        $track_booking_response['data']->vesselsArray = $vessels;
                        $track_booking_response['data']->containerSizesArray = ContainerSizes::pluck('display_label', 'value');
                        $track_booking_response['data']->lastEvent = end($track_booking_response['data']->transportationPlan->events);
                    }
                } else {
                    $track_booking_response = [
                        'success' => false,
                        'data' => "Booking Tracking Not Found!",
                    ];
                }
            } else {
                $track_booking_response = [
                    'success' => false,
                    'data' => "Booking Not Found!",
                ];
            }
        }

        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $data = [
                "total_bookings" => Booking::count(),
                "total_earnings" => Booking::whereIn("status", [
                    config('constants.BOOKING_STATUS_IN_PROGRESS'),
                    config('constants.BOOKING_STATUS_COMPLETED'),
                ])->sum('amount'),
                "registered_users" => User::where('role_id', config('constants.USER_TYPE_CUSTOMER'))->count(),
                "in_progress_bookings" => Booking::where("status", config('constants.BOOKING_STATUS_IN_PROGRESS'))->count(),
                "on_hold_bookings" => Booking::where("status", config('constants.BOOKING_STATUS_ON_HOLD'))->count(),
                "bookings" => $bookings,
                "search" => $search,
                'track_booking' => $track_booking,
                'track_booking_response' => $track_booking_response
            ];
            return view('admin.dashboard', compact('data', 'track_booking', 'track_booking_response'));
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_CUSTOMER')) {
            $data = [
                "total_bookings" => Booking::where('user_id', auth()->user()->id)->count(),
                "in_progress_bookings" => Booking::where('user_id', auth()->user()->id)->where("status", config('constants.BOOKING_STATUS_IN_PROGRESS'))->count(),
                "on_hold_bookings" => Booking::where('user_id', auth()->user()->id)->where("status", config('constants.BOOKING_STATUS_ON_HOLD'))->count(),
                'track_booking' => $track_booking,
                'track_booking_response' => $track_booking_response
            ];
            return view('customers.dashboard', compact('data', 'track_booking', 'track_booking_response'));
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $data = [
                "total_bookings" => Booking::count(),
                "total_earnings" => Booking::whereIn("status", [
                    config('constants.BOOKING_STATUS_IN_PROGRESS'),
                    config('constants.BOOKING_STATUS_COMPLETED'),
                ])->sum('amount'),
                "registered_users" => User::where('role_id', config('constants.USER_TYPE_CUSTOMER'))->count(),
                "in_progress_bookings" => Booking::where("status", config('constants.BOOKING_STATUS_IN_PROGRESS'))->count(),
                "on_hold_bookings" => Booking::where("status", config('constants.BOOKING_STATUS_ON_HOLD'))->count(),
                "bookings" => $bookings,
                "search" => $search,
                'track_booking' => $track_booking,
                'track_booking_response' => $track_booking_response
            ];
            return view('employees.dashboard', compact('data'));
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
            $data = [
                "total_bookings" => Booking::count(),
                "in_progress_bookings" => Booking::where("status", config('constants.BOOKING_STATUS_IN_PROGRESS'))->count(),
                "on_hold_bookings" => Booking::where("status", config('constants.BOOKING_STATUS_ON_HOLD'))->count(),
                "bookings" => $bookings,
                "search" => $search,
                'track_booking' => $track_booking,
                'track_booking_response' => $track_booking_response
            ];
            return view('suppliers.dashboard', compact('data'));
        }
        abort(404);
    }
}
