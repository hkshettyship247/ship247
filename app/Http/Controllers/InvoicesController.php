<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Booking;
use App\Models\Payments;
use Illuminate\Http\Request;
use PDF;

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
                if($addon->step) {
                    $addonAmount += floatval($addon->value) * floatval($addon->step);
                } else {
                    $addonAmount += floatval($addon->value);
                }
            }
        }

        $data = [
            'booking' => $booking
        ];
        
        $filename = "Booking_".$booking->id."_".date("YmdHis").".pdf";
        $pdf = PDF::loadView('pdfs.booking-invoice', $data);
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
