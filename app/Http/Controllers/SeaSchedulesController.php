<?php

namespace App\Http\Controllers;

use App\Imports\SeaPricingsImport;
use App\Models\Company;
use App\Models\ContainerSizes;
use App\Models\Location;
use App\Models\SeaSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SeaSchedulesController extends Controller
{
    const PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search_criteria = [
            'origin_id' => $request->origin_id,
            'destination_id' => $request->destination_id,
            'company_id' => $request->company_id,
            'eta_start_date' => $request->eta_start_date,
            'eta_end_date' => $request->eta_end_date,
            'etd_start_date' => $request->etd_start_date,
            'etd_end_date' => $request->etd_end_date,
        ];

        $origin = null;
        $destination = null;
        $company = null;
        $eta = ['start_date' => $request->eta_start_date, 'end_date' => $request->eta_end_date];
        $etd = ['start_date' => $request->etd_start_date, 'end_date' => $request->etd_end_date];

        $seaSchedulesQuery = SeaSchedule::query();

        if ($request->origin_id) {
            $origin = Location::find($request->origin_id);
            $seaSchedulesQuery->where('origin_id', $request->origin_id);
        }

        if ($request->destination_id) {
            $destination = Location::find($request->destination_id);
            $seaSchedulesQuery->where('destination_id', $request->destination_id);
        }

        if ($request->company_id) {
            $company = Company::find($request->company_id);
            $seaSchedulesQuery->where('company_id', $request->company_id);
        }

        if ($etd['start_date']) {
            $seaSchedulesQuery->whereHas('details', function ($q) use ($etd) {
                $q->whereDate('etd', '>=', $etd['start_date']);
            });
        }
        if ($etd['end_date']) {
            $seaSchedulesQuery->whereHas('details', function ($q) use ($etd) {
                $q->whereDate('etd', '<=', $etd['end_date']);
            });
        }
        if ($eta['start_date']) {
            $seaSchedulesQuery->whereHas('details', function ($q) use ($eta) {
                $q->whereDate('eta', '>=', $eta['start_date']);
            });
        }
        if ($eta['end_date']) {
            $seaSchedulesQuery->whereHas('details', function ($q) use ($eta) {
                $q->whereDate('eta', '<=', $eta['end_date']);
            });
        }

        $companies = Company::whereNotIn('id', config('constants.IGNORED_COMPANIES'))
            ->pluck('name', 'id');
		
        $route = null;
        $route_user = '';
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "admin.";
            $route_user = 'superadmin.';
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employees.";
            $route_user = 'employee.';
        }  else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
			$company = Company::find(Auth::user()->company_id);
            $seaSchedulesQuery->where('company_id', Auth::user()->company_id);
            $route = "suppliers.";
            $route_user = 'supplier.';
        }
		
		$seaSchedules = $seaSchedulesQuery->latest()
            ->paginate(self::PER_PAGE)
            ->appends($search_criteria);

        return view($route . 'sea_schedules.index',
            compact('seaSchedules', 'companies', 'origin', 'destination', 'company', 'eta', 'etd', 'route_user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $companiesQuery = Company::whereNotIn('id', config('constants.IGNORED_COMPANIES'));
            
        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "admin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employees.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
			$companiesQuery->where('id', Auth::user()->company_id);
            $route = "suppliers.";
        }
		
		$companies=$companiesQuery->pluck('name', 'id'); // TODO: Filter Companies by their type
        $container_sizes = ContainerSizes::get();
        return view($route . 'sea_schedules.create',
            compact('companies', 'container_sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		/*
		$request->validate([
            'etd' => ['required', 'date', 'after:yesterday'],
			'valid_till' => ['required', 'date', 'after:yesterday'],
        ]);
		*/
		
		$company = Company::find($request->company_id);
		$origin = Location::find($request->origin_id);
		$destination = Location::find($request->destination_id);
		
        $seaSchedule = new SeaSchedule();
        $seaSchedule->origin_id = $request->origin_id;
        $seaSchedule->destination_id = $request->destination_id;
        $seaSchedule->company_id = $request->company_id;
        $seaSchedule->container_size = $request->container_size;
        $seaSchedule->pickup_charges = isset($request->pickup_charges) && $request->pickup_charges != null ? $request->pickup_charges : 0;
        $seaSchedule->origin_charges = isset($request->origin_charges_included) ? 0 : $request->origin_charges;
        $seaSchedule->origin_charges_included = isset($request->origin_charges_included) ? 1 : 0;
        $seaSchedule->ocean_freight = $request->ocean_freight;
		$seaSchedule->our_charges = $request->our_charges;
        $seaSchedule->destination_charges = isset($request->destination_charges_included) ? 0 : $request->destination_charges;
        $seaSchedule->destination_charges_included = isset($request->destination_charges_included) ? 1 : 0;
        $seaSchedule->delivery_charges = isset($request->delivery_charges) && $request->delivery_charges != null ? $request->delivery_charges : 0;
		$now = new Carbon();
		$seaSchedule->reference_no = strtoupper(substr(str_replace(' ', '', $company->name), 0, 6).$origin->code.$destination->code.(auth()->user()->id).$now->format("YmdHisv")); 
        $seaSchedule->save();

        $seaSchedule->details()->create([
            'eta' => $request->eta,
            'etd' => $request->etd,
            'valid_till' => $request->valid_till,
            'tt' => $request->tt,
            'ft' => $request->ft,
        ]);
        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "superadmin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employee.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
            $route = "supplier.";
        }

        return redirect()->route($route . 'sea-schedules.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeaSchedule $seaSchedule)
    {
        $companiesQuery = Company::whereNotIn('id', config('constants.IGNORED_COMPANIES'));
            
        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "admin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employees.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
			$companiesQuery->where('id', Auth::user()->company_id);
            $route = "suppliers.";
        }
		
		$companies = $companiesQuery->pluck('name', 'id'); // TODO: Filter Companies by their type
        $container_sizes = ContainerSizes::get();
        return view($route . 'sea_schedules.edit',
            compact('companies', 'container_sizes', 'seaSchedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SeaSchedule $seaSchedule)
    {
		/** Not validated because may be they need to adjust things
		$request->validate([
            'etd' => ['required', 'date', 'after:yesterday'],
			'valid_till' => ['required', 'date', 'after:yesterday'],
        ]);
		**/
		
        $seaSchedule->origin_id = $request->origin_id;
        $seaSchedule->destination_id = $request->destination_id;
        $seaSchedule->company_id = $request->company_id;
        $seaSchedule->container_size = $request->container_size;
        $seaSchedule->pickup_charges = isset($request->pickup_charges) && $request->pickup_charges != null ? $request->pickup_charges : 0;
        $seaSchedule->origin_charges = isset($request->origin_charges_included) ? 0 : (!empty($request->origin_charges) ? $request->origin_charges : 0);
        $seaSchedule->origin_charges_included = isset($request->origin_charges_included) ? 1 : 0;
        $seaSchedule->ocean_freight = $request->ocean_freight;
		$seaSchedule->our_charges = $request->our_charges;
        $seaSchedule->destination_charges = isset($request->destination_charges_included) ? 0 : $request->destination_charges;
        $seaSchedule->destination_charges_included = isset($request->destination_charges_included) ? 1 : 0;
        $seaSchedule->delivery_charges = isset($request->delivery_charges) && $request->delivery_charges != null ? $request->delivery_charges : 0;
        $seaSchedule->save();

        // Delete details data
        $seaSchedule->details()->delete();

        $seaSchedule->details()->create([
            'eta' => $request->eta,
            'etd' => $request->etd,
            'valid_till' => $request->valid_till,
            'tt' => $request->tt,
            'ft' => $request->ft,
        ]);
        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "superadmin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employee.";
        }  else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
            $route = "supplier.";
        }

        return redirect()->route($route . 'sea-schedules.index')->with('success', 'Price details update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeaSchedule $seaSchedule)
    {
        // Delete details data
        $seaSchedule->details()->delete();

        $seaSchedule->delete();
        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "superadmin.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employee.";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
            $route = "supplier.";
        }


        return redirect()->route($route . 'sea-schedules.index')->with('success', 'Sea pricing removed successfully.');
    }

    public function import(Request $request)
    {
        try {
            $seaPricingsImport = new SeaPricingsImport;
            $seaPricingsImport->import($request->file('import_file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            Log::debug($failures);
//            foreach ($failures as $failure) {
//                $failure->row(); // row that went wrong
//                $failure->attribute(); // either heading key (if using heading row concern) or column index
//                $failure->errors(); // Actual error messages from Laravel validator
//                $failure->values(); // The values of the row that has failed.
//            }
        }

        $route = null;
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "superadmin";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employee";
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
            $route = "supplier";
        }

        return redirect()->route(
            $route . '.sea-schedules.index',
            ['imported_rows' => $seaPricingsImport->imported_rows_count]
        );
    }

    public function duplicatePrice(SeaSchedule $seaSchedule)
    {
        // Clone the SeaSchedule instance
        $duplicateSchedule = $seaSchedule->replicate();
        // Save the duplicated schedule
        $duplicateSchedule->save();

        $route_user = '';
        if (auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')) {
            $route = "admin.";
            $route_user = 'superadmin.';
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')) {
            $route = "employees.";
            $route_user = 'employee.';
        } else if (auth()->user()->role_id == config('constants.USER_TYPE_SUPPLIER')) {
            $route = "suppliers.";
            $route_user = 'supplier.';
        }
        // Redirect or return a response
        return redirect()->route($route_user.'sea-schedules.edit', [$duplicateSchedule->id]);
    }
}
