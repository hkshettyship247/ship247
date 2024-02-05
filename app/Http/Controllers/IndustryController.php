<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Number of records per page
        $search = $request->input('search'); // Search keyword

        $industryQuery = Industry::query();

        if ($search) {
            $industryQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('contact_no', 'like', '%' . $search . '%')
                    ->orWhere('country', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('business_type', 'like', '%' . $search . '%')
                    ->orWhere('website', 'like', '%' . $search . '%')
                    ->orWhere('message', 'like', '%' . $search . '%');
            });
        }

        $industries = $industryQuery->latest()->paginate($perPage);

          $route = null;
        if(auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')){
            $route = "admin.";
        }
        
        else if(auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')){
            $route = "employees.";
        }
        return view($route.'industries.index', compact('industries', 'search'));
    }

    public function create()
    {
          $route = null;
        if(auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')){
            $route = "admin.";
        }
        
        else if(auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')){
            $route = "employees.";
        }
        return view($route.'industries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Assuming your table for industries is named 'industries'
        ]);

        $industry = new Industry();
        $industry->name = $request->name;
        $industry->save();

          $route = null;
        if(auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')){
            $route = "superadmin.";
        }
        
        else if(auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')){
            $route = "employee.";
        }
        return redirect()->route($route.'industry.index')->with('success', 'Industry saved successfully.');
    }

    public function destroy(Industry $industry)
    {
        
          $route = null;
        if(auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')){
            $route = "superadmin.";
        }
        
        else if(auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')){
            $route = "employee.";
        }$industry->delete();
        return redirect()->route($route.'industry.index')->with('success', 'Industry deleted successfully.');
    }
}
