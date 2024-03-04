<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Payments;
use Illuminate\Http\Request;
use App\Models\WorkWithUsForm;
use App\Services\MarineTrafficAPI;
use App\Models\CompanyStatusHistory;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function generatePDFInvoice(Request $request)
    {

        $booking = Booking::find($request->bookingID);
        $addonAmount = 0;
        foreach ($booking->addons as $addon) {
            if ($addon->type === "toggle" && is_numeric($addon->value)) {
                $addonAmount += intval($addon->value);
            } else if ($addon->value > 0 && $addon->type === "counter") {
                if ($addon->step) {
                    $addonAmount += floatval($addon->value) * floatval($addon->step);
                } else {
                    $addonAmount += floatval($addon->value);
                }
            }
        }

        $data = [
            'booking' => $booking
        ];

        $filename = "Booking_" . $booking->id . "_" . date("YmdHis") . ".pdf";

        $pdf = PDF::loadView('pdfs.booking-invoice', $data);
        $pdf->setOptions([
            'fontDir' => base_path('storage/fonts/'),
            'fontCache' => base_path('storage/fonts/'),
            'defaultFont' => 'figtree_normal_9535977b91b6b425175b658df2ea7634',
        ]);
        return $pdf->download($filename);
    }


    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 5); // Number of records per page
        $search = $request->input('search'); // Search keyword



        // Apply the user_id filter for non-admin users
        // if (auth()->user()->role_id !== 1) {
        //     $paymentsQuery->where('user_id', auth()->user()->id);
        // }

        if (auth()->user()->role_id == 1) {
            $paymentsQuery = Payments::with(['booking.user']);
        } else {


            $paymentsQuery = Payments::with(['booking.user'])->whereHas('booking.user', function ($query) {
                $query->where('id', auth()->user()->id);
            });
        }

        // Apply search conditions if search keyword is provided
        if ($search) {
            $paymentsQuery->where(function ($query) use ($search) {
                $query->orWhereHas('booking', function ($query) use ($search) {
                    $query->where('destination', 'like', '%' . $search . '%')
                        ->orWhere('origin', 'like', '%' . $search . '%')
                        ->orWhere('container_size', 'like', '%' . $search . '%')
                        ->orWhere('product', 'like', '%' . $search . '%')
                        ->orWhere('status', 'like', '%' . $search . '%')
                        ->orWhere('id', 'like', '%' . $search . '%');
                });
            });
        }

        $payments = $paymentsQuery->latest()->paginate($perPage);

        if (auth()->user()->role_id == 1) {
            return view('admin.invoices.index', compact('payments', 'search'));
        } else {
            return view('customers.invoices.index', compact('payments', 'search'));
        }
    }

    public function getBookingInvoice(Request $request)
    {

        $payment_details = Payments::with(['booking.user'])->find($request->paymentID);
        return view('admin.invoices.detail', compact("payment_details"));
    }

    public function getPaymentDetails(Request $request)
    {
        $payment_details = Payments::with(['booking.user'])->find($request->paymentID);

        $track_booking_response = '';
        if ($payment_details->booking->marinetraffic_id) {
            $track_booking_response = MarineTrafficAPI::getTrackingInformation($payment_details->booking->marinetraffic_id);
        }
        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "superadmin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employee.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
            $route = "supplier.";
        } else {
            $route = "customer.";
        }

        return view('admin.invoices.payment-details', compact('payment_details', 'route', 'track_booking_response'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
