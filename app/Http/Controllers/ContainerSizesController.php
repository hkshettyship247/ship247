<?php

namespace App\Http\Controllers;

use App\Models\ContainerSizes;
use Illuminate\Http\Request;

class ContainerSizesController extends Controller
{

    const PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $container_size_query = ContainerSizes::query();
        // TODO: Add Filters
        $container_sizes = $container_size_query->paginate(self::PER_PAGE);
           $route = null;
        if(auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')){
            $route = "admin.";
        }
        
        else if(auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')){
            $route = "employees.";
        }
        return view($route.'container_sizes.index', compact('container_sizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
           $route = null;
        if(auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')){
            $route = "admin.";
        }
        
        else if(auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')){
            $route = "employees.";
        }
        return view($route.'container_sizes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $containerSize = new ContainerSizes;
        $containerSize->display_label = $request->display_label;
        $containerSize->value = $request->value;
        $containerSize->cma_value = $request->cma_value;
        $containerSize->hapag_value = $request->hapag_value;
        $containerSize->msc_value = $request->msc_value;
        $containerSize->save();

           $route = null;
        if(auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')){
            $route = "superadmin.";
        }
        
        else if(auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')){
            $route = "employee.";
        }
        return redirect()->route($route.'container-sizes.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContainerSizes $containerSize)
    {
           $route = null;
        if(auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')){
            $route = "admin.";
        }
        
        else if(auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')){
            $route = "employees.";
        }
        return view($route.'container_sizes.edit', compact('containerSize'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContainerSizes $containerSize)
    {
        $containerSize->display_label = $request->display_label;
        $containerSize->value = $request->value;
        $containerSize->cma_value = $request->cma_value;
        $containerSize->hapag_value = $request->hapag_value;
        $containerSize->msc_value = $request->msc_value;
        $containerSize->save();

           $route = null;
        if(auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')){
            $route = "superadmin.";
        }
        
        else if(auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')){
            $route = "employee.";
        }
        return redirect()->route($route.'container-sizes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContainerSizes $containerSize)
    {
        $containerSize->delete();

           $route = null;
        if(auth()->user()->role_id == config('constants.USER_TYPE_SUPERADMIN')){
            $route = "superadmin.";
        }
        
        else if(auth()->user()->role_id == config('constants.USER_TYPE_EMPLOYEE')){
            $route = "employee.";
        }
        return redirect()->route($route.'container-sizes.index');
    }
}
