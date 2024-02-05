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
                        SEA pricing
                    </h2>
                </div>

                <div class="w-6/12 justify-end flex">
                    <a href="{{route($route_user.'sea-schedules.create')}}" class="default-button-v2">
                        <span>ADD Sea pricing</span>
                    </a>

                    <a href="#" data-modal-target="import-modal" data-modal-toggle="import-modal"
                       class="default-button-v2 ml-4">
                        <span>import</span>
                    </a>
                </div>
            </header>

            <section class="search-result mt-8 mb-12">
                <form action="{{route($route_user.'sea-schedules.index')}}" class="default-form">
                    <div class="flex items-start flex-row gap-4">
                        <div class="md:w-6/12">
                            <div class="flex gap-4">
                                <div class="w-6/12">
                                    <div class="form-field">
                                        <label for="origin_id" class="text-xs uppercase text-gray-400">Origin</label>
                                        @include('admin.partials._location-select2',
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
                                        <label for="destination_id"
                                               class="text-xs uppercase text-gray-400">Destination</label>
                                        @include('admin.partials._location-select2',
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
                            <div class="form-field">
                                <label for="company_id" class="text-xs uppercase text-gray-400">Company</label>
                                <select id="company_id" name="company_id"
                                        class="form-input small-input w-full">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company_id => $company_name)
                                        <option value="{{ $company_id }}"
                                                @if($company && $company->id == $company_id) selected @endif
                                        >{{$company_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-end justify-between flex-row gap-4">
                        <div class="md:w-5/12">
                            <div class="flex gap-4">
                                <div class="w-6/12">
                                    <div class="form-field">
                                        <label for="etd_start_date" class="text-xs uppercase text-gray-400">ETD Start
                                            Date</label>
                                        <input name="etd_start_date" type="date" class="form-input small-input w-full"
                                               value="{{ $etd['start_date'] }}">
                                    </div>
                                </div>

                                <div class="w-6/12">
                                    <div class="form-field">
                                        <label for="etd_end_date" class="text-xs uppercase text-gray-400">ETD End
                                            Date</label>
                                        <input name="etd_end_date" type="date" class="form-input small-input w-full"
                                               value="{{ $etd['end_date'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="md:w-5/12">
                            <div class="flex gap-4">
                                <div class="w-6/12">
                                    <div class="form-field">
                                        <label for="eta_start_date" class="text-xs uppercase text-gray-400">ETA Start
                                            Date</label>
                                        <input name="eta_start_date" type="date" class="form-input small-input w-full"
                                               value="{{ $eta['start_date'] }}">
                                    </div>
                                </div>

                                <div class="w-6/12">
                                    <div class="form-field">
                                        <label for="eta_end_date" class="text-xs uppercase text-gray-400">ETA End
                                            Date</label>
                                        <input name="eta_end_date" type="date" class="form-input small-input w-full"
                                               value="{{ $eta['end_date'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="md:w-2/12 justify-between flex">
                            <button type="submit" class="default-button-v2 small-button outline-button">
                                <span>Search</span>
                            </button>
                        </div>

                    </div>
                </form>
            </section>

            <div class="detail-body mt-10">
                @if(isset($seaSchedules) && count($seaSchedules) > 0)
                    @foreach ($seaSchedules as $seaSchedule)
                        <div class="detail-box relative">
                            {{-- <div class="absolute left-4 -top-3">
                                <span class="badge progress small-badge">{{"Active"}}</span>
                            </div> --}}

                            <div class="w-4/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Origin</span>
                                        <span class="value">{{$seaSchedule->origin->fullname}}</span>
                                    </div>
                                    <div>
                                        <span class="head">Destination</span>
                                        <span class="value">{{$seaSchedule->destination->fullname}}</span>
                                    </div>
                                    <div>
                                        <span class="head">Container</span>
                                        <span class="value">{{$seaSchedule->containerSize->display_label}}</span>
                                    </div>
                                    <div>
                                        <span class="head">Company</span>
                                        <span class="value">{{ $seaSchedule->company->name}}</span>
                                    </div>
									<div>
                                        <span class="head">Ref No</span>
                                        <span class="value">{{ $seaSchedule->reference_no}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/12">
                                <div class="flex flex-col gap-4">

                                    <div>
                                        <span class="head">Origin Charges Included</span>
                                        <span
                                            class="value">{{$seaSchedule->origin_charges_included ? 'Yes' : 'No'}}</span>
                                    </div>
                                    <div>

                                        <span class="head">Origin Charges</span>
                                        <span class="value">{{$seaSchedule->origin_charges_included
                                        ? "-" : '$'.number_format($seaSchedule->origin_charges, 2)}}</span>
                                    </div>
                                    <div>
                                        <span class="head">Pickup Charges</span>
                                        <span
                                            class="value">{{$seaSchedule->pickup_charges ? '$'.number_format($seaSchedule->pickup_charges, 2) : '-'}}</span>
                                    </div>
                                    <div>
                                        <span class="head">Ocean Freight</span>
                                        <span class="value">{{'$'.number_format($seaSchedule->ocean_freight, 2)}}</span>
                                    </div>
									 <div>
                                        <span class="head">Our Charges</span>
                                        <span class="value">{{'$'.number_format($seaSchedule->our_charges, 2)}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/12">
                                <div class="flex flex-col gap-4">
                                    <div>
                                        <span class="head">Destination Charges Included</span>
                                        <span
                                            class="value">{{$seaSchedule->destination_charges_included ? 'Yes' : 'No'}}</span>
                                    </div>
                                    <div>
                                        <span class="head">Destination Charges</span>
                                        <span class="value">{{$seaSchedule->destination_charges_included
                                        ? "-" : '$'.number_format($seaSchedule->destination_charges, 2)}}</span>
                                    </div>
                                    <div>
                                        <span class="head">Delivery Charges</span>
                                        <span
                                            class="value">{{$seaSchedule->delivery_charges ? '$'.number_format($seaSchedule->delivery_charges, 2) : '-'}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-2/12">
                                <div class="flex justify-end items-center h-full">

                                    <button id="dropdownScheduleButton"
                                            data-dropdown-toggle="dropdownSchedule-{{$seaSchedule->id}}"
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
                                    <div id="dropdownSchedule-{{$seaSchedule->id}}"
                                         class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 top-0 right-0">
                                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownScheduleButton">
                                            <li>
                                                <a href="{{route($route_user.'sea-schedules.edit', [$seaSchedule->id])}}"
                                                   class="block px-4 py-2 hover:bg-red-600 hover:text-white">
                                                    <span>Edit Details</span>
                                                </a>
                                            </li>
                                            <li>
                                                <form
                                                    action="{{route($route_user.'sea-schedules.destroy', [$seaSchedule->id])}}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="block w-full text-left px-4 py-2 hover:bg-red-600 hover:text-white"
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
                {{ $seaSchedules->links() }}
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
                    <form method="POST" action="{{ route($route_user.'sea-schedules.import') }}"
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
                                <a class="default-button-v2" href="/templates/import_sea_pricings_template.xlsx"
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
