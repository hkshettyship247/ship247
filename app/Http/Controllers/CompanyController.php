<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\CompanyDocuments;
use App\Models\Country;
use App\Models\CompanyStatusHistory;
use App\Models\User;
use App\Models\Industry;
use App\Models\CustomerCompanies;
use Illuminate\Http\Request;
use DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::all();
        $industries = Industry::all();
        $company_details = auth()->user()->company;
        return view('customers.shipperRegistration', compact('countries', 'company_details', 'industries'));
    }

    public function getCompanies(Request $request)
    {
        $perPage = $request->input('per_page', 15); // Number of records per page
        $search = $request->input('search'); // Search keyword

        $search_criteria = [
            'name' => $request->name,
            'email' => $request->email,
            'country' => $request->country,
            'status' => $request->status,
        ];
        $companyQuery = Company::query();

        $name = $request->input('name');
        $email = $request->input('email');
        $country = $request->input('country');
        $status = $request->input('status');

        // if ($search) {
        //     $companyQuery->where(function ($query) use ($search) {
        //         $query->where('name', 'like', '%' . $search . '%')
        //               ->orWhere('email', 'like', '%' . $search . '%')
        //               ->orWhere('contact_no', 'like', '%' . $search . '%')
        //               ->orWhere('country', 'like', '%' . $search . '%')
        //               ->orWhere('city', 'like', '%' . $search . '%')
        //               ->orWhere('business_type', 'like', '%' . $search . '%')
        //               ->orWhere('website', 'like', '%' . $search . '%')
        //               ->orWhere('message', 'like', '%' . $search . '%');
        //     });
        // }


        if ($email) {
            $companyQuery->where(function ($emailQuery) use ($email) {
                $emailQuery->where('email', 'like', '%' . $email . '%');
            });
        }
        if ($name) {
            $companyQuery->where(function ($nameQuery) use ($name) {
                $nameQuery->where('name', 'like', '%' . $name . '%');
            });
        }
        if ($country) {
            $companyQuery->where(function ($countryQuery) use ($country) {
                $countryQuery->where('country', 'like', '%' . $country . '%');
            });
        }
        if ($status) {
            $companyQuery->where(function ($statusQuery) use ($status) {
                $statusQuery->where('status', 'like', '%' . $status . '%');
            });
        }

        $companies = $companyQuery->latest()->paginate($perPage)->appends($search_criteria);;

        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "admin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employees.";
        }

        return view($route . 'companies.index', compact('companies', 'search', 'name', 'email', 'country', 'status'));
    }

    public function getCompanyDetails(Request $request)
    {
        $company_details = Company::with('related_assigned_user')->findOrFail($request->companyID);
        if(is_null($company_details->read_at)) {
            $company_details->read_at = Carbon::now();
            $company_details->save();
        }

        $users = User::where('company_id', $request->companyID)->get();

        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "admin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employees.";
        }
        return view($route . 'companies.detail', compact('company_details', 'users'));
    }
	
	public function setCompanyDetails(Request $request)
    {
        $company_details = Company::with('related_assigned_user')->findOrFail($request->companyID);
		$countries = Country::all();
        $industries = Industry::pluck('name')->toArray();
		$our_employees =  User::where('role_id', config('constants.USER_TYPE_EMPLOYEE'))->orWhere('role_id', config('constants.USER_TYPE_SUPERADMIN'))->where('deleted_at', null)->get();
        if(is_null($company_details->read_at)) {
            $company_details->read_at = Carbon::now();
            $company_details->save();
        }

		$vendor_admin = User::where('company_id', $request->companyID)->first();
		
        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "admin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employees.";
        }
        return view($route . 'companies.edit', compact('company_details', 'vendor_admin', 'countries', 'industries', 'our_employees'));
    }
	
    /**
     * Show the form for creating a new resource.
     */
    public function createCompany()
    {
        $countries = Country::all();
        $industries = Industry::all();
		$our_employees =  User::where('role_id', config('constants.USER_TYPE_EMPLOYEE'))->orWhere('role_id', config('constants.USER_TYPE_SUPERADMIN'))->where('deleted_at', null)->get();
        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "admin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employees.";
        }

        return view($route . 'companies.create', compact('countries', 'industries', 'our_employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "superadmin";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employee";
        }

        $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'required|email',
            'industry' => 'required|array',
            'contact_no' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
			'assigned_user' => 'required|max:255',
        ]);

        $selected_industries = Industry::whereIn('name', $request->industry)->pluck('name')->toArray();

        try {
            DB::beginTransaction();

            if (isset($request->companyID) && $request->companyID != null) {
                $company = Company::find($request->companyID);
            } else {
                $company = new Company();
            }

            $company->name = $request->company_name;
            $company->email = $request->email;
            $company->contact_no = $request->contact_no;
            $company->business_type = is_array($selected_industries) && count($selected_industries)
                ? implode(',', $selected_industries) : '';
            $company->country = $request->country;
            $company->city = $request->city;
            $company->website = $request->website;
            $company->description = $request->about;
            $company->industry = is_array($selected_industries) && count($selected_industries)
                ? implode(',', $selected_industries) : '';
            $company->status = isset($request->user_id) && $request->user_id == "new_user" ? config('constants.COMPANY_REGISTRATION_STATUS_APPROVED') : config('constants.COMPANY_REGISTRATION_STATUS_PENDING');
			if($request->assigned_user != 'no'){
				$company->assigned_user = $request->assigned_user;
			}
			$company->save();
            $companyId = $company->id;

            // Create a directory for the company's documents using the company ID
            if ($request->hasFile('documents')) {
                // Assuming documents[] is an array of uploaded files

                CompanyDocuments::where('company_id', $companyId)->where('type', $request->document_type)->delete();
                $companyDocumentsPath = "companies/{$companyId}";

                foreach ($request->file('documents') as $documentFile) {
                    if ($documentFile->isValid()) {
                        // Generate a unique timestamp for each file
                        $timestamp = now()->timestamp;

                        // Store the document using the timestamp as the file name within the company's directory
                        $documentPath = $documentFile->storeAs('public/' . $companyDocumentsPath, $timestamp . '.' . $documentFile->getClientOriginalExtension());

                        // Create a new CompanyDocuments record for each file
                        $companyDocument = new CompanyDocuments;
                        $companyDocument->name = $timestamp;
                        $companyDocument->company_id = $companyId;
                        $companyDocument->type = $request->document_type;
                        $companyDocument->path = str_replace("public/", "", $documentPath);
                        $companyDocument->status = config('constants.COMPANY_REGISTRATION_STATUS_PENDING');
                        $companyDocument->save();
                    } else {
                        // Handle invalid files
                    }
                }
            }

            if (isset($request->user_id) && $request->user_id == "new_user") {
                $request->validate([
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'country' => 'required|string|max:255',
                    'user_email' => 'required|string|email|max:255',
                    'user_phone_number' => 'required|string|max:20',
                    'password' => 'required',
                ]);

                $user = new User;
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->country = $request->user_country;
                $user->phone_number = $request->user_phone_number;
                $user->email = $request->user_email;
                $user->company_id = $companyId;
                $user->password = Hash::make($request->password);
            } else {
                $user = auth()->user();
                $user->company_id = $company->id;
            }

            $user->save();

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route(isset($request->user_id) && $request->user_id == "new_user" ? $route . '.company.create' : 'company.index')->with('error', $e->getMessage());
        }

        DB::commit();
        return redirect()->route(isset($request->user_id) && $request->user_id == "new_user" ? $route . '.company.create' : 'company.index')->with('success', 'Company details saved successfully.');
    }
	
	 /**
     * Store a newly created resource in storage.
     */
    public function updateCompany(Request $request)
    {
		//dd($request->vender_admin_id);
		
        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "superadmin";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employee";
        }

        $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'required|email',
            'industry' => 'required|array',
            'contact_no' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
			'assigned_user' => 'required|max:255',
        ]);

        $selected_industries = Industry::whereIn('name', $request->industry)->pluck('name')->toArray();

        try {
            DB::beginTransaction();

            $company = Company::find($request->companyID);

            $company->name = $request->company_name;
            $company->email = $request->email;
            $company->contact_no = $request->contact_no;
            $company->business_type = is_array($selected_industries) && count($selected_industries)
                ? implode(',', $selected_industries) : '';
            $company->country = $request->country;
            $company->city = $request->city;
            $company->website = $request->website;
            $company->description = $request->about;
            $company->industry = is_array($selected_industries) && count($selected_industries)
                ? implode(',', $selected_industries) : '';
			if($request->assigned_user != 'no'){
				$company->assigned_user = $request->assigned_user;
			}
			$company->save();
            $companyId = $company->id;

            // Create a directory for the company's documents using the company ID
            if ($request->hasFile('documents')) {
                // Assuming documents[] is an array of uploaded files

                CompanyDocuments::where('company_id', $companyId)->where('type', $request->document_type)->delete();
                $companyDocumentsPath = "companies/{$companyId}";

                foreach ($request->file('documents') as $documentFile) {
                    if ($documentFile->isValid()) {
                        // Generate a unique timestamp for each file
                        $timestamp = now()->timestamp;

                        // Store the document using the timestamp as the file name within the company's directory
                        $documentPath = $documentFile->storeAs('public/' . $companyDocumentsPath, $timestamp . '.' . $documentFile->getClientOriginalExtension());

                        // Create a new CompanyDocuments record for each file
                        $companyDocument = new CompanyDocuments;
                        $companyDocument->name = $timestamp;
                        $companyDocument->company_id = $companyId;
                        $companyDocument->type = $request->document_type;
                        $companyDocument->path = str_replace("public/", "", $documentPath);
                        $companyDocument->status = config('constants.COMPANY_REGISTRATION_STATUS_PENDING');
                        $companyDocument->save();
                    } else {
                        // Handle invalid files
                    }
                }
            }
			
			$request->validate([
				'first_name' => 'required|string|max:255',
				'last_name' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'user_email' => 'required|string|email|max:255',
                'user_phone_number' => 'required|string|max:20',
            ]);
			
            // save vendor admin

            $user = User::where('id', $request->vender_admin_id)->first();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->country = $request->user_country;
            $user->phone_number = $request->user_phone_number;
            $user->email = $request->user_email;
            
            $user->save();

        } catch (\Exception $e) {
            DB::rollback();
			
			$company_details = Company::with('related_assigned_user')->findOrFail($request->companyID);
			$countries = Country::all();
			$industries = Industry::pluck('name')->toArray();
			$our_employees =  User::where('role_id', config('constants.USER_TYPE_EMPLOYEE'))->orWhere('role_id', config('constants.USER_TYPE_SUPERADMIN'))->where('deleted_at', null)->get();
			if(is_null($company_details->read_at)) {
				$company_details->read_at = Carbon::now();
				$company_details->save();
			}

			$vendor_admin = User::where('company_id', $request->companyID)->first();
			
			$route = null;
			if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
				$route = "admin.";
			} else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
				$route = "employees.";
			}
			return view($route . 'companies.edit', compact('company_details', 'vendor_admin', 'countries', 'industries', 'our_employees'))->with('error', $e->getMessage());
        }

        DB::commit();
		
		$company_details = Company::with('related_assigned_user')->findOrFail($request->companyID);
        if(is_null($company_details->read_at)) {
            $company_details->read_at = Carbon::now();
            $company_details->save();
        }

        $users = User::where('company_id', $request->companyID)->get();

        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "admin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employees.";
        }
        return view($route . 'companies.detail', compact('company_details', 'users'))->with('success', 'Company details saved successfully.');
    }
	
    /**
     * Display the specified resource.
     */
    public function assignCompaniesToCustomer(Request $request)
    {

        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "superadmin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employee.";
        }

        try {
            DB::beginTransaction();

            $selectedCompanyIds = $request->input('companies', []);
            $customer = User::find($request->customerID);
            if (isset($customer) && count($selectedCompanyIds) > 0) {
                CustomerCompanies::where('customer_id', $request->customerID)->delete();
                foreach ($selectedCompanyIds as $companyId) {
                    CustomerCompanies::create([
                        'customer_id' => $customer->id,
                        'company_id' => $companyId,
                    ]);
                }
                $customer->update();
                DB::commit();

                return redirect()->route($route . 'customer.detail', $request->customerID)->with('success', 'Company assigned successfully.');
            } else {
                return redirect()->route($route . 'customer.detail', $request->customerID)->with('error', 'Some error has occurred');
            }

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route($route . 'customer.detail', $request->customerID)->with('error', $e->getMessage());
        }
    }

    public function updateCompanyStatus(Request $request)
    {
        $company = Company::find($request->companyID);

        $company->status = $request->status;

        if ($request->status == config('constants.COMPANY_REGISTRATION_STATUS_APPROVED')) {
            $company->is_activated = 1;
        }

        if ($request->status == config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT')) {
            $company->message = $request->message;
        }
        $company->save();

        $company_status_history = new CompanyStatusHistory;
        $company_status_history->company_id = $request->companyID;
        $company_status_history->status = $request->status;
        $company_status_history->message = $request->status == config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT') ? $request->message : null;
        $company_status_history->save();

        return redirect()->back()->with('success', 'Company status updated successfully.');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        if($company->status != config('constants.COMPANY_REGISTRATION_STATUS_APPROVED')) {
            $company_users = User::where('company_id', $company->id)->get();
            foreach ($company_users as $user) {
                $user->email = 'deleted - ' . $user->email;
                $user->save();
                $user->delete();
            }
            $company->documents()->delete();
            $company->delete();
        }

        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "superadmin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employee.";
        }
        return redirect()->route($route . 'company.index')->with('success', 'Company deleted successfully.');
    }
}
