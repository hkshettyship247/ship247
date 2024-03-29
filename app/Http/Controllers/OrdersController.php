<?php

namespace App\Http\Controllers;

use App\Mail\BookingCreated;
use App\Models\Booking;
use App\Models\ContainerSizes;
use App\Models\BookingAddon;
use App\Models\Company;
use App\Models\Location;
use App\Models\BookingAddonDetails;
use App\Services\MarineTrafficAPI;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class OrdersController extends Controller
{
    const PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
		$companies = Company::pluck('name', 'id'); // All companies
        $perPage = $request->input('per_page', self::PER_PAGE); // Number of records per page
        $search = $request->input('search'); // Search keyword
        $view_booking = isset($request->view_booking) && $request->view_booking != null ? $request->view_booking : null;
        $search_criteria = [
            'origin_id' => $request->origin_id,
            'destination_id' => $request->destination_id,
            'company_id' => $request->company_id,
			'sea_type' => $request->sea_type,
			'land_type' => $request->land_type,
			'air_type' => $request->air_type,
        ];

        $origin = null;
        $destination = null;
        $company = null;
		
		$bookingsQuery = Booking::query();
		
        if ($request->origin_id) {
            $origin = Location::find($request->origin_id);
            $bookingsQuery->where('origin_id', $request->origin_id);
        }

        if ($request->destination_id) {
            $destination = Location::find($request->destination_id);
            $bookingsQuery->where('destination_id', $request->destination_id);
        }

        if ($request->company_id) {
            $company = Company::find($request->company_id);
            $bookingsQuery->where('company_id', $request->company_id);
        }
        
		if(isset($request->sea_type) && $request->sea_type == true){
			$bookingsQuery->where('transportation', 'Ship');
			$sea_type=1;
		}
		else{
			$sea_type=0;
		}
		
		if(isset($request->land_type) && $request->land_type == true){
			$bookingsQuery->where('transportation', 'Land');
			$land_type=1;
		}
		else{
			$land_type=0;
		}
		
		if(isset($request->air_type) && $request->air_type == true){
			$bookingsQuery->where('transportation', 'Air');
			$air_type=1;
		}
		else{
			$air_type=0;
		}
		
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
			
			//$bookingsQuery->where('company_id', Auth::user()->company_id); // Bookings of this vendor company with company id
			
			$vendor_users = User::where('company_id', Auth::user()->company_id)->get();
			$vendor_users_array = array();
			$i=0;
			foreach($vendor_users  as $vendor_user){
				 // all bookings with users of this vendor company
				 $vendor_users_array[$i]=$vendor_user->id;
				 $i++;
			}
			if($i > 0)
			$bookingsQuery->whereIn('user_id', $vendor_users_array);
			// $bookings = $bookingsQuery->latest()->paginate($perPage)->appends($search_criteria);
			$bookings = $bookingsQuery->latest()->get();
			//dd(json_encode($bookings));
            return view('suppliers.orders.index', compact('origin', 'destination', 'company', 'bookings', 'search', 'companies', 'view_booking', 'sea_type', 'land_type', 'air_type'));
        }
        abort(404);
    }

    public function show(Request $request, Booking $booking)
    {
        if(is_null($booking->read_at)) {
            $booking->read_at = Carbon::now();
            $booking->save();
        }
        $track_booking_response = '';
        if($booking->marinetraffic_id) {
            $track_booking_response = MarineTrafficAPI::getTrackingInformation($booking->marinetraffic_id);
        }
		
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER') && $booking->user_id === Auth::user()->id) {
            return view('suppliers.orders.show', compact("booking"));
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
            //return redirect()->route('supplier.orders.index');
			return view('suppliers.orders.show', compact("booking"));
        }
        abort(404);
    }

    public function getContainerSizes()
    {
        $container_sizes = ContainerSizes::get();
        return response()->json([
            "container_sizes" => $container_sizes
        ]);
    }

    public function editOrderDetails(Request $request)
    {	
        $booking = Booking::find($request->orderId);
        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
            $route = "suppliers.";
        }
        $scac_list = Booking::scacList();
        return view($route . 'orders.edit', compact("booking", "scac_list"));
    }

    public function updateorderDetails(Request $request)
    {

        try {
            $marine_traffic_subscribe_request = false;

            $booking = Booking::findOrFail($request->orderId);

            if ($booking->shipping_number != $request->shipping_number || $booking->scac != $request->scac) {
                $marine_traffic_subscribe_request = true;
            }

            $booking->shipping_number = $request->shipping_number;
            $booking->receipt_number = $request->receipt_number;
            $booking->scac = $request->scac;
            $booking->product = $request->product;
            $booking->status = $request->status;
            $booking->update();

            if ($marine_traffic_subscribe_request && $booking->shipping_number != "" && $booking->scac != "") {
                $response = MarineTrafficAPI::subscribe($booking->shipping_number, $booking->scac);

                if ($response['success'] && isset($response['data']->subscription->shipmentId)) {
                    $booking->marinetraffic_id = $response['data']->subscription->shipmentId;
                    $booking->update();
                }
            }

            $route = null;
            if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
                $route = "supplier.";
            }
            return redirect()->route($route . 'orders.index')->with('success', 'Booking details saved successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function storeShipmentDetails(Request $request)
    {
        $selected_booking_addons = session()->get("addon_details");
        $price_breakdown = session()->get("booking_details");
        $booking_details = $request["booking_details"];
        $booking = new Booking;
        try {
            if (!empty($booking_details)) {
                DB::beginTransaction();

                $booking = new Booking;
                $booking->user_id = Auth::user()->id;
                $booking->origin_id = $booking_details["origin"]["id"];
                $booking->destination_id = $booking_details["destination"]["id"];
                $booking->amount = $booking_details["total_amount"] ?? 0;
                $booking->no_of_containers = $booking_details["no_of_containers"];
                $booking->container_size = $booking_details["container_size"]['display_label'] ?? '-';
                $booking->transportation = isset($booking_details["route_type"]) && $booking_details["route_type"] == 2 ? 'Land' : "Ship";
                $booking->product = " ";
                $booking->arrival_date_time = isset($booking_details["arrival_date_time"]) ? Carbon::parse($booking_details["arrival_date_time"]) : null;
                $booking->departure_date_time = isset($booking_details["departure_date_time"]) ? Carbon::parse($booking_details["departure_date_time"]) : null;
                $booking->company_id = $booking_details["company"]["id"];
                $booking->status = config('constants.BOOKING_PAYMENT_STATUS_ON_HOLD');

                if (isset($price_breakdown["priceBreakDown"])) {
                    $priceBreakdown = $price_breakdown["priceBreakDown"];
                    $booking->pickup_charges = $priceBreakdown["Pickup Charges"]["value"] ?? 0;

                    $booking->origin_charges = $priceBreakdown["Origin Charges"]["value"] ?? 0;
                    $booking->basic_ocean_freight = $priceBreakdown["BASIC OCEAN FREIGHT"]["value"] ?? 0;
                    $booking->destination_charges = $priceBreakdown["Destination Charges"]["value"] ?? 0;
                    $booking->delivery_charges = $priceBreakdown["Delivery Charges"]["value"] ?? 0;
                    $booking->is_checked_pickup_charges = isset($priceBreakdown["Pickup Charges"]["isChecked"]) ? ($priceBreakdown["Pickup Charges"]["isChecked"] ? 'Y' : 'N') : 'N';
                    $booking->is_checked_origin_charges = isset($priceBreakdown["Origin Charges"]["isChecked"]) ? ($priceBreakdown["Origin Charges"]["isChecked"] ? 'Y' : 'N') : 'N';
                    $booking->is_checked_basic_ocean_freight = isset($priceBreakdown["BASIC OCEAN FREIGHT"]["isChecked"]) ? ($priceBreakdown["BASIC OCEAN FREIGHT"]["isChecked"] ? 'Y' : 'N') : 'N';
                    $booking->is_checked_destination_charges = isset($priceBreakdown["Destination Charges"]["isChecked"]) ? ($priceBreakdown["Destination Charges"]["isChecked"] ? 'Y' : 'N') : 'N';
                    $booking->is_checked_delivery_charges = isset($priceBreakdown["Delivery Charges"]["isChecked"]) ? ($priceBreakdown["Delivery Charges"]["isChecked"] ? 'Y' : 'N') : 'N';
                }

                $booking->save();

                if (!empty($selected_booking_addons)) {
                    foreach ($selected_booking_addons as $addon) {
                        if (($addon["type"] == "toggle" && !empty($addon["is_checked"])) || ($addon["type"] == "counter")) {
                            $booking_addon_details = BookingAddon::find($addon["id"]);

                            $booking_addon = new BookingAddonDetails;
                            $booking_addon->booking_id = $booking->id;
                            $booking_addon->value = $addon["default_value"];
                            $booking_addon->name = $booking_addon_details->name;
                            $booking_addon->type = $booking_addon_details->type;
                            $booking_addon->step = $booking_addon_details->step;
                            $booking_addon->additional_text = $booking_addon_details->additional_text;
                            $booking_addon->save();
                        }
                    }
                }

                session()->forget("booking_details");
                session()->forget("addon_details");
                DB::commit();

                Mail::to($booking->user->email)
                    ->cc(env('ADMIN_EMAIL'))
                    ->queue(new BookingCreated($booking));
                return response()->json([
                    "status" => 'success',
                    "data" => ['booking' => $booking],
                    "message" => "Booking saved successfully.",
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => "error",
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Some error occurred.",
        ]);
    }

    public function storeInSession(Request $request)
    {
        session()->put('booking_details', $request->all());

        return response()->json([
            "status" => "success",
            "message" => "Booking details saved successfully in session",
        ]);
    }
}
