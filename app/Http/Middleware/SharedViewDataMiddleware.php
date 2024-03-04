<?php

namespace App\Http\Middleware;

use App\Models\Booking;
use App\Models\Company;
use App\Models\QuickRequestForms;
use App\Models\WorkWithUsForm;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SharedViewDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $new_companies_count = Company::whereNull('read_at')->count();
        $new_work_with_us_forms_count = WorkWithUsForm::whereNull('read_at')->count();
        
		// current user role id == 4 (supplier) => get curr user company id
		if(isset(auth()->user()->role_id) && auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')){
			
			$new_bookings_count = Booking::whereNull('read_at')->where('company_id', auth()->user()->company_id)->count();
			$new_quick_request_forms_count = QuickRequestForms::whereNull('read_at')->count();
			
		}
		else{
			
			$new_bookings_count = Booking::whereNull('read_at')->count();
			$new_quick_request_forms_count = QuickRequestForms::whereNull('read_at')->count();
			
		}
		

        View::share('anyNewBooking', boolval($new_bookings_count));

        View::share([
            'anyNewBookings' => boolval($new_bookings_count),
            'anyNewCompanies' => boolval($new_companies_count),
            'anyNewWorkWithUsForms' => boolval($new_work_with_us_forms_count),
            'anyNewQuickRequestForms' => boolval($new_quick_request_forms_count),
        ]);

        return $next($request);
    }
}
