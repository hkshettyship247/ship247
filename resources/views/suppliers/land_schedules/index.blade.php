@extends('layouts.admin')

@section('content')
    @if(isset($_GET['imported_rows']) && is_numeric($_GET['imported_rows']) && $_GET['imported_rows'] > 0)
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ $_GET['imported_rows'] }} rows were imported successfully!
    </div>
    @endif

    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <div class="w-6/12">
                    <h2 class="title">
                        LAND pricing
                    </h2>
                </div>

                <div class="w-6/12 justify-end flex">
                    <a href="{{route('supplier.land-schedules.create')}}" class="default-button-v2">
                        <span>ADD land pricing</span>
                    </a>

                    <a href="#" data-modal-target="import-modal" data-modal-toggle="import-modal"
                       class="default-button-v2 ml-4">
                        <span>import</span>
                    </a>
                </div>
            </header>

            <section class="search-result mt-8 mb-12">
                <form action="{{route('supplier.land-schedules.index')}}" class="default-form">
                    <div class="flex items-end justify-between flex-row gap-4">
                        <div class="md:w-5/12">
                            <div class="flex gap-4">
                                <div class="w-6/12">
                                    <div class="form-field">
                                        <label for="origin_id" class="text-xs uppercase text-gray-400">Origin</label>
                                        @include('suppliers.partials._location-select2',
                                            [
                                                'name' => 'origin_id',
                                                'selected_option_value' => $origin->id ?? null,
                                                'selected_option_text' => $origin->fullname ?? null,
                                            ]
                                        )
                                    </div>
                                </div>

                                <div class="w-6/12">
                                    <div class="form-field">
                                        <label for="destination_id" class="text-xs uppercase text-gray-400">Destination</label>
                                        @include('suppliers.partials._location-select2',
                                            [
                                                'name' => 'destination_id',
                                                'selected_option_value' => $destination->id ?? null,
                                                'selected_option_text' => $destination->fullname ?? null,
                                            ]
                                        )
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="md:w-4/12">
                            <div class="flex gap-4">
                                <div class="w-6/12">
                                    <div class="form-field">
                                        <label for="truck_type_id" class="text-xs uppercase text-gray-400">Truck Type</label>
                                        <select id="truck_type_id" name="truck_type_id"
                                                class="form-input small-input w-full">
                                            <option value="">Select Truck Type</option>
                                            @foreach($truck_types as $truck_type_id => $truck_type_label)
                                                <option value="{{ $truck_type_id }}"
                                                        @if($truck_type && $truck_type->id == $truck_type_id) selected @endif
                                                >{{$truck_type_label}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="w-6/12">
                                    <div class="form-field">
                                        <label for="axle" class="text-xs uppercase text-gray-400">Axle</label>
                                        <select id="axle" name="axle"
                                                class="form-input small-input w-full">
                                            <option value="">Select Axle</option>
                                            @foreach($axles as $value => $label)
                                                <option value="{{ $value }}"
                                                        @if($axle === $value) selected @endif
                                                >{{$label}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="md:w-2/12">
                            <div class="form-field">
                                {{--<label for="company_id" class="text-xs uppercase text-gray-400">Company</label>
                                <select id="company_id" name="company_id"
                                        class="form-input small-input w-full">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company_id => $company_name)
                                        <option value="{{ $company_id }}"
                                                @if($company && $company->id == $company_id) selected @endif
                                        >{{$company_name}}</option>
                                    @endforeach
                                </select>--}}
                            </div>
                        </div>

                    </div>
					
					<br /><br />
					<div style="margin-left: 900px;">
					 <div class="md:w-1/12 justify-end flex">
                            <button type="submit" class="default-button-v2 small-button outline-button">
                                <span>Search</span>
                            </button>
                     </div>
					</div>
					
                </form>
            </section>

            <div class="detail-body mt-10">
                @if(isset($landSchedules) && count($landSchedules) > 0)
                    @foreach ($landSchedules as $landSchedule)
                        <div class="detail-box relative">
                            <div class="w-6/14">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Pick Up Point</span>
                                        <span class="value">{{$landSchedule->origin->fullname}}</span>
                                    </div>
                                    <div>
                                        <span class="head">Delivery Point</span>
                                        <span class="value">{{$landSchedule->destination->fullname}}</span>
                                    </div>
									<div>
                                        <span class="head">Ref No</span>
                                        <span class="value">{{$landSchedule->reference_no}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/14">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Truck Type</span>
                                        <span class="value">{{$landSchedule->truckType->display_label}}</span>
                                    </div>

                                    <div>
                                        <span class="head">Axle</span>
                                        <span
                                            class="value">{{$landSchedule->axle ? $landSchedule->axle." axle" : 'None'}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/14">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Max Load in Ton</span>
                                        <span class="value">{{number_format($landSchedule->max_load_in_ton, 2)}}</span>
                                    </div>

                                    <div>
                                        <span class="head">Land Freight</span>
                                        <span class="value">{{'$'.number_format($landSchedule->land_freight, 2)}}</span>
                                    </div>
									
									<div>
                                        <span class="head">Our Charges</span>
                                        <span class="value">{{'$'.number_format($landSchedule->our_charges, 2)}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/14">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Container</span>
                                        <span class="value">{{$landSchedule->container_size
                                            ? $landSchedule->containerSize->display_label : '-'}}</span>
                                    </div>
                                    <div>
                                        <span class="head">Company</span>
                                        <span class="value">{{ $landSchedule->company->name}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/14">
                                <div class="flex justify-end items-center h-full">

                                    <button id="dropdownScheduleButton" data-dropdown-toggle="dropdownSchedule-{{$landSchedule->id}}"
                                            class="inline-flex justify-center items-center gap-x-1 rounded-md px-3 py-2 text-sm text-white primary-bg"
                                            type="button">
                                        View More
                                        <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div id="dropdownSchedule-{{$landSchedule->id}}"
                                         class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownScheduleButton">
                                            <li>
                                                <a href="{{route('supplier.land-schedules.edit', [$landSchedule->id])}}"
                                                   class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                                    <span>Edit Details</span>
                                                </a>
                                            </li>
                                            <li>
                                                <form
                                                    action="{{route('supplier.land-schedules.destroy', [$landSchedule->id])}}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="block px-4 py-2 hover:bg-red-600 hover:text-white"
                                                            type="submit">Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                @else
                    <div class="p-4 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-500">No pricing found</p>
                    </div>
                @endif

            </div>

            <footer>
                {{ $landSchedules->links() }}
            </footer>
        </div>
    </section>

    <div id="import-modal" tabindex="-1"
         class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
         style="background: rgba(0, 0, 0, 0.6)">
        <div class="relative w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="import-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>

                <div class="p-6">
                    <form method="POST" action="{{ route('supplier.land-schedules.import') }}"
                          enctype="multipart/form-data" class="default-form">
                        @csrf
                        <div class="grid gap-8 mt-4">
                            <div class="form-field">
                                <label for="import_file" class="form-label">Import File</label>
                                <input type="file" id="import_file" name="import_file" required
                                       accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                       class="form-input small-input mt-2 w-full block">
                            </div>

                            <div class="form-field">
                                <button type="submit" class="default-button-v2">
                                    <span>Upload</span>
                                </button>
                                <a class="default-button-v2" href="/templates/import_land_pricing_template.xlsx"
                                   download><span>Download the template</span></a>
                            </div>

                            <div>
                                <h3>
                                    <a href="{{ asset('/pdf/ship247-template-format.pdf') }}" class="underline">Click here</a> to download the instruction.
                                </h3>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
