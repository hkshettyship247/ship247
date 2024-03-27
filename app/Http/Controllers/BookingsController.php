<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Location;
use App\Models\PartyAdress;
use Illuminate\Support\Str;
use App\Mail\BookingCreated;
use App\Models\BookingAddon;
use Illuminate\Http\Request;
use App\Models\ContainerSizes;
use App\Models\BookingDocument;
use App\Models\PartyCompanyAdress;
use App\Services\MarineTrafficAPI;
use Illuminate\Support\Facades\DB;
use App\Models\BookingAddonDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class BookingsController extends Controller
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

        if (isset($request->sea_type) && $request->sea_type == true) {
            $bookingsQuery->where('transportation', 'Ship');
            $sea_type = 1;
        } else {
            $sea_type = 0;
        }

        if (isset($request->land_type) && $request->land_type == true) {
            $bookingsQuery->where('transportation', 'Land');
            $land_type = 1;
        } else {
            $land_type = 0;
        }

        if (isset($request->air_type) && $request->air_type == true) {
            $bookingsQuery->where('transportation', 'Air');
            $air_type = 1;
        } else {
            $air_type = 0;
        }

        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {

            // $bookings = $bookingsQuery->latest()->paginate($perPage)->appends($search_criteria);
            $bookings = $bookingsQuery->latest()->get();

            return view('admin.bookings.index', compact('origin', 'destination', 'company', 'bookings', 'search', 'companies', 'sea_type', 'land_type', 'air_type'));
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {

            // $bookings = $bookingsQuery->latest()->paginate($perPage)->appends($search_criteria);
            $bookings = $bookingsQuery->latest()->get();

            return view('employees.bookings.index', compact('origin', 'destination', 'company', 'bookings', 'search', 'companies', 'sea_type', 'land_type', 'air_type'));
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_CUSTOMER')) {

            $bookingsQuery->where('user_id', Auth::user()->id); // only list bookings of this customer with user id
            // $bookings = $bookingsQuery->latest()->paginate($perPage)->appends($search_criteria);
            $bookings = $bookingsQuery->latest()->get();

            return view('customers.bookings.index', compact('origin', 'destination', 'company', 'bookings', 'search', 'companies', 'view_booking', 'sea_type', 'land_type', 'air_type'));
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {

            $bookingsQuery->where('company_id', Auth::user()->company_id); // Bookings of this vendor company with company id
            /**
			//will use this for orders module to house bookings from vendor users for other vendors schedules
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
             **/
            // $bookings = $bookingsQuery->latest()->paginate($perPage)->appends($search_criteria);
            $bookings = $bookingsQuery->latest()->get();

            return view('suppliers.bookings.index', compact('origin', 'destination', 'company', 'bookings', 'search', 'companies', 'view_booking', 'sea_type', 'land_type', 'air_type'));
        }
        abort(404);
    }

    public function show(Request $request, Booking $booking)
    {
        if (is_null($booking->read_at)) {
            $booking->read_at = Carbon::now();
            $booking->save();
        }
        $track_booking_response = '';
        if ($booking->marinetraffic_id) {
            $track_booking_response = MarineTrafficAPI::getTrackingInformation($booking->marinetraffic_id);
        }


        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "superadmin.";
            //return view('customers.bookings.new_show', compact('booking', 'track_booking_response'));
            // return view('admin.bookings.show', compact("booking"));
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employee.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_CUSTOMER') && $booking->user_id === Auth::user()->id) {
            $route = "customer.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_CUSTOMER')) {
            return redirect()->route('customer.bookings.index');
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER') && $booking->user_id === Auth::user()->id) {
            return view('suppliers.bookings.show', compact("booking"));
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
            //return redirect()->route('supplier.bookings.index');
            return view('suppliers.bookings.show', compact("booking"));
        }
        return view('booking_details', compact('route', 'booking', 'track_booking_response'));
    }

    public function getContainerSizes()
    {
        $container_sizes = ContainerSizes::get();
        return response()->json([
            "container_sizes" => $container_sizes
        ]);
    }

    public function editBookingDetails(Request $request)
    {
        $booking = Booking::find($request->bookingId);
        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "admin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_CUSTOMER')) {
            $route = "customers.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employees.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
            $route = "suppliers.";
        }
        $scac_list = Booking::scacList();
        return view($route . 'bookings.edit', compact("booking", "scac_list"));
    }

    public function updatebookingDetails(Request $request)
    {

        try {
            $marine_traffic_subscribe_request = false;

            $booking = Booking::findOrFail($request->bookingId);

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
            if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
                $route = "superadmin.";
            } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
                $route = "employee.";
            } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
                $route = "supplier.";
            }
            return redirect()->route($route . 'bookings.index')->with('success', 'Booking details saved successfully.');
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

    public function storeDocuments(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'master_bill_file' => 'nullable|mimes:' . implode(',', config('constants.ALLOWED_DOCUMENT_TYPES')) . '|max:10240',
            'house_bill_file' => 'nullable|mimes:' . implode(',', config('constants.ALLOWED_DOCUMENT_TYPES')) . '|max:10240',
            'certificate_file' => 'nullable|mimes:' . implode(',', config('constants.ALLOWED_DOCUMENT_TYPES')) . '|max:10240',
            'commercial_invoice_file' => 'nullable|mimes:' . implode(',', config('constants.ALLOWED_DOCUMENT_TYPES')) . '|max:10240',
            'packing_list_file' => 'nullable|mimes:' . implode(',', config('constants.ALLOWED_DOCUMENT_TYPES')) . '|max:10240',
            'other_file' => 'nullable|mimes:' . implode(',', config('constants.ALLOWED_DOCUMENT_TYPES')) . '|max:10240',
        ]);

        $bookingDocument = BookingDocument::where('booking_id', $request->bookingId)->first();
        if (empty($bookingDocument)) {
            $bookingDocument = new BookingDocument();
        }

        // Master Bill of Lading
        if ($request->hasFile('master_bill_file')) {
            $masterBillFile = $request->file('master_bill_file');
            $masterBillFilename = $this->uploadFile($masterBillFile);
            $bookingDocument->booking_id = $request->bookingId;
            $bookingDocument->master_bill_lading = $masterBillFilename;
            $bookingDocument->save();
        }

        // House Bill of Lading
        if ($request->hasFile('house_bill_file')) {
            $houseBillFile = $request->file('house_bill_file');
            $houseBillFilename = $this->uploadFile($houseBillFile);
            $bookingDocument->booking_id = $request->bookingId;
            $bookingDocument->house_bill_lading = $houseBillFilename;
            $bookingDocument->save();
        }

        // Certificate of Origin
        if ($request->hasFile('certificate_file')) {
            $certificateFile = $request->file('certificate_file');
            $certificateFilename = $this->uploadFile($certificateFile);
            $bookingDocument->booking_id = $request->bookingId;
            $bookingDocument->certificate_of_origin = $certificateFilename;
            $bookingDocument->save();
        }

        // Commercial Invoice
        if ($request->hasFile('commercial_invoice_file')) {
            $commercialInvoiceFile = $request->file('commercial_invoice_file');
            $commercialInvoiceFilename = $this->uploadFile($commercialInvoiceFile);
            $bookingDocument->booking_id = $request->bookingId;
            $bookingDocument->commercial_invoice = $commercialInvoiceFilename;
            $bookingDocument->save();
        }

        // Packing List
        if ($request->hasFile('packing_list_file')) {
            $packingListFile = $request->file('packing_list_file');
            $packingListFilename = $this->uploadFile($packingListFile);
            $bookingDocument->booking_id = $request->bookingId;
            $bookingDocument->packing_list = $packingListFilename;
            $bookingDocument->save();
        }

        // Other
        if ($request->hasFile('other_file')) {
            $otherFile = $request->file('other_file');
            $otherFilename = $this->uploadFile($otherFile);
            $bookingDocument->booking_id = $request->bookingId;
            $bookingDocument->other_document = $otherFilename;
            $bookingDocument->save();
        }

        return redirect()->back()->with('message', 'Documents uploaded successfully!');
    }

    public function storeReceiverDocuments(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'receiverName' => 'required',
            'number' => 'required',
        ]);

        $booking = Booking::findOrFail($request->booking_id);
        $type = $request->type;
        $partyAdress = PartyAdress::where(['booking_id' => $booking->id, 'type' => constant("App\Models\PartyAdress::$type")])->first();
        if (empty($partyAdress)) {
            $partyAdress = new PartyAdress();
        }
        $partyAdress->booking_id = $booking->id;
        $partyAdress->receiverName = $request->receiverName;
        $partyAdress->number = $request->number;
        $partyAdress->type = $type;
        $partyAdress->save();

        return redirect()->back()->with('message', 'Data saved successfully!');
    }

    public function partyCompanyAddress (Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'company_name' => 'required',
            'address' => 'required',
        ]);

        $booking = Booking::findOrFail($request->booking_id);
        $type = $request->type;
        $partyAdress = PartyCompanyAdress::where(['booking_id' => $booking->id, 'type' => constant("App\Models\PartyCompanyAdress::$type")])->first();
        if (empty($partyAdress)) {
            $partyAdress = new PartyCompanyAdress();
        }
        $partyAdress->booking_id = $booking->id;
        $partyAdress->company_name = $request->company_name;
        $partyAdress->address = $request->address;
        $partyAdress->type = $type;
        $partyAdress->save();

        return redirect()->back()->with('message', 'Data saved successfully!');
    }

    public function partyAddressForm(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);
        $type = $request->type;
        $partyAdress = PartyAdress::where(['booking_id' => $booking->id, 'type' => $type])->first();

        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "superadmin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employee.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
            $route = "supplier.";
        }
        return view('party_booking_form', compact('route', 'partyAdress', 'booking', 'type'));
    }

    public function partyCompanyAddressForm(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);
        $type = $request->type;
        $partyCompanyAdress = PartyCompanyAdress::where(['booking_id' => $booking->id, 'type' => $type])->first();

        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "superadmin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employee.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
            $route = "supplier.";
        }
        return view('booking_party_company_form', compact('route', 'partyCompanyAdress', 'booking', 'type'));
    }

    // Define a function to handle file uploads
    private function uploadFile($file, $oldFilename = null)
    {
        try {
            // Construct a random filename to avoid collisions
            $randomNumber = Str::random(10); // Generates a random string of length 10
            $originalFilename = $file->getClientOriginalName();
            $filename = $randomNumber . '_' . $originalFilename;

            // Delete the old file, if it exists
            if ($oldFilename) {
                $oldFilePath = 'booking_documents/' . $oldFilename;
                if (Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
            }

            // Store the file in the storage directory
            $file->storeAs('booking_documents', $filename, 'public');

            return $filename;
        } catch (\Exception $e) {
            // Handle any exceptions
            return null;
        }
    }

    public function removeDocument(Request $request)
    {
        // Find the document by its ID and booking ID
        $document = BookingDocument::where(['id' => $request->docId, 'booking_id' => $request->bookingId])->first();

        if (empty($document)) {
            return response()->json(['success' => false, 'message' => 'Document not found.']);
        }

        // Delete the file from storage
        Storage::disk('public')->delete('booking_documents/' . $document->filename);

        // Delete the record from the database
        $document->delete();

        // Return a JSON response indicating success
        return response()->json(['success' => true, 'message' => 'Document removed successfully!']);
    }
}
