<?php

namespace App\Http\Middleware;

use App\Models\Booking;
use App\Models\Company;
use App\Models\QuickRequestForms;
use App\Models\WorkWithUsForm;
use App\Models\User;
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
			$new_ordersQuery = Booking::whereNull('read_at');
			$vendor_users = User::where('company_id', Auth::user()->company_id)->get();
			$vendor_users_array = array();
			$i=0;
			foreach($vendor_users  as $vendor_user){
				 // all bookings with users of this vendor company
				 $vendor_users_array[$i]=$vendor_user->id;
				 $i++;
			}
			if($i > 0)
			$new_ordersQuery->whereIn('user_id', $vendor_users_array);
			$new_orders_count = $new_ordersQuery->count();
			$new_quick_request_forms_count = QuickRequestForms::whereNull('read_at')->count();
			
			$vendor_company = Company::where('id', Auth::user()->company_id)->first();
			
			//dd($vendor_company->sea_type);
			
			View::share('anyNewBooking', boolval($new_bookings_count));

			View::share([
				'anyNewBookings' => boolval($new_bookings_count),
				'anyNewOrders' => boolval($new_orders_count),
				'anyNewCompanies' => boolval($new_companies_count),
				'anyNewWorkWithUsForms' => boolval($new_work_with_us_forms_count),
				'anyNewQuickRequestForms' => boolval($new_quick_request_forms_count),
				'seaTypeCompany' => boolval($vendor_company->sea_type),
				'landTypeCompany' => boolval($vendor_company->land_type),
				'airTypeCompany' => boolval($vendor_company->air_type),
			]);
			
		}
		else{
			
			$new_bookings_count = Booking::whereNull('read_at')->count();
			$new_quick_request_forms_count = QuickRequestForms::whereNull('read_at')->count();
			
			View::share('anyNewBooking', boolval($new_bookings_count));

			View::share([
				'anyNewBookings' => boolval($new_bookings_count),
				'anyNewCompanies' => boolval($new_companies_count),
				'anyNewWorkWithUsForms' => boolval($new_work_with_us_forms_count),
				'anyNewQuickRequestForms' => boolval($new_quick_request_forms_count),
			]);
			
		}

        return $next($request);
    }
}
