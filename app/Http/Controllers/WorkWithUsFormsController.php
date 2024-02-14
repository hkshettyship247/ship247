<?php

namespace App\Http\Controllers;

use App\Mail\WorkWithUsFormSubmitted;
use App\Models\WorkWithUsForm;
use App\Models\Industry;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class WorkWithUsFormsController extends Controller
{
    const PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $work_with_us_forms_query = WorkWithUsForm::query();

        $search_criteria = [
            'name' => $request->name,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'contact_number' => $request->contact_number,
            'industry' => $request->industry,
        ];

        $name = $request->input('name');
        $company_name = $request->input('company_name');
        $email = $request->input('email');
        $industry = $request->input('industry');
        $contact_number = $request->input('contact_number');

        if ($name) {
            $work_with_us_forms_query->where(function ($q) use ($name) {
                 // Split the full name into first name and last name
                $searchTerms = explode(' ', $name);
                $firstName = $searchTerms[0];
                $lastName = count($searchTerms) > 1 ? $searchTerms[1] : null;

                $q->where(function ($fullNameQuery) use ($firstName, $lastName) {
                        $fullNameQuery->where('first_name', 'like', '%' . $firstName . '%')
                                    ->where('last_name', 'like', '%' . $lastName . '%');
                    });
                    // Add a separate condition for searching by last name only
                    $q->orWhere('last_name', 'like', '%' . $name . '%');
            });

        }

        if ($email) {
            $work_with_us_forms_query->where(function ($q) use ($email) {
                $q->where('email', 'like', '%' . $email . '%');
            });
        }
        if ($contact_number) {
            $work_with_us_forms_query->where(function ($q) use ($contact_number) {
                $q->where('phone_number', 'like', '%' . $contact_number . '%');
            });
        }
        if ($industry) {
            $work_with_us_forms_query->where(function ($q) use ($industry) {
                $q->where('industry', 'like', '%' . $industry . '%');
            });
        }
        if ($company_name) {
            $work_with_us_forms_query->where(function ($q) use ($company_name) {
                $q->where('company_name', 'like', '%' . $company_name . '%');
            });
        }

        // TODO: Add Filters
        $work_with_us_forms = $work_with_us_forms_query->with('related_assigned_user')->latest()->paginate(self::PER_PAGE);
		
        $route = null;
        if(auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')){
            $route = "admin.";
        }

        else if(auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')){
            $route = "employees.";
        }

        return view($route.'work_with_us_forms.index', compact('work_with_us_forms',  'name', 'email', 'company_name', 'industry', 'contact_number'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function workWithUsFormDetailsByID(Request $request)
    {
        $work_with_us_form_details = WorkWithUsForm::with('related_assigned_user')->findOrFail($request->workWithUsFormID);
        if(is_null($work_with_us_form_details->read_at)) {
            $work_with_us_form_details->read_at = Carbon::now();
            $work_with_us_form_details->save();
        }
        $industries = Industry::pluck('name')->toArray();
		$our_employees =  User::where('role_id', config('constants.USER_TYPE_EMPLOYEE'))->orWhere('role_id', config('constants.USER_TYPE_SUPERADMIN'))->where('deleted_at', null)->get();
		$company_details = Company::where('wwuforms_id', $request->workWithUsFormID)->first();
		
        $route = null;
        if(auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')){
            $route = "admin.";
        }

        else if(auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')){
            $route = "employees.";
        }
		
		return view($route.'work_with_us_forms.detail', compact('work_with_us_form_details', 'industries', 'our_employees', 'company_details'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateStatus(Request $request)
    {
		//dd($updated_form->id);
		
		if($request->assigned_user != 'no'){
			WorkWithUsForm::where('id' , $request->id)->update(['status' => $request->status, 'assigned_user' => $request->assigned_user, 'industry' => (is_array($request->industry) && count($request->industry) ? implode(',', $request->industry) : '')]);
		}
		else{
			WorkWithUsForm::where('id' , $request->id)->update(['status' => $request->status, 'industry' => (is_array($request->industry) && count($request->industry) ? implode(',', $request->industry) : '')]);
		}
		
		if($request->status == config('constants.WORK_WITH_US_FORM_STATUS_ACCEPTED')){ // if form is accepted
			
			$updated_form = WorkWithUsForm::with('related_assigned_user')->findOrFail($request->id);
			
			// create vendor company 
			
			$company = new Company();
			
			$company->name = $updated_form->company_name;
			$company->email = $updated_form->email;
			$company->contact_no = $updated_form->phone_number;
			$company->business_type = $updated_form->industry;
			$company->industry = $updated_form->industry;
			$company->wwuforms_id = $request->id;

			$company->country = "";
			$company->city = "";
			$company->website = "";
			$company->description = "";
		   
			$company->status = config('constants.COMPANY_REGISTRATION_STATUS_PENDING'); // Company Pending Approval
			$company->assigned_user = $updated_form->assigned_user;
			
			$company->save();
			$companyId = $company->id;
			
			// create vendor admin user
			
			$user = new User;
			$user->first_name = $updated_form->first_name;
			$user->last_name = $updated_form->last_name;
			$user->role_id = config('constants.USER_TYPE_SUPPLIER');
			
			$user->country = ""; // need to add from form, after changing work for us form - vendors
			$user->phone_number = $company->contact_no; // need to change
			$user->email = $company->email; // need to change
			$user->status = config('constants.USER_STATUS_INACTIVE');
			$user->position = 'vendor admin';
			
			$user->company_id = $companyId;
			
			$default_password = $company->email.$company->contact_no;
			$user->password = Hash::make($request->password);
			
			//$user->deleted_at = date("Y-m-d H:i:s"); // User Inactive
			$user->save();
		
		}
		
        return redirect()->back()->with('success', 'Work with us form status updated successfully.');
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'phone_number' => ['required', 'unique:App\Models\WorkWithUsForm,phone_number', 'max:255'],
            'email' => ['required', 'email', 'unique:work_with_us_forms,email', 'max:255'],
            'company_name' => ['required', 'max:255'],
            'industry' => ['required', 'array'],
			'vendor_terms' => ['accepted'],
        ]);

        $selected_industries = Industry::whereIn('id', $request->industry)->pluck('name')->toArray();
		$default_users = User::where('role_id', config('constants.USER_TYPE_SUPERADMIN'))->first();
        $form = new WorkWithUsForm;
        $form->first_name = $request->first_name;
        $form->last_name = $request->last_name;
        $form->phone_number = $request->phone_number;
        $form->email = $request->email;
        $form->company_name = $request->company_name;
        $form->industry = is_array($selected_industries) && count($selected_industries)
            ? implode(',', $selected_industries) : '';
		$form->assigned_user = $default_users->id;
		
        $form->save();

        // Send EMail 
        //$admin_email = 'hkshetty.itconsultantuae@gmail.com';
		$admin_email = env('ADMIN_EMAIL');
        if($admin_email) {
            //Mail::to($admin_email)->queue(new WorkWithUsFormSubmitted($form));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkWithUsForm $workWithUsForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkWithUsForm $workWithUsForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkWithUsForm $workWithUsForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkWithUsForm $workWithUsForm)
    {
        //
    }
}
