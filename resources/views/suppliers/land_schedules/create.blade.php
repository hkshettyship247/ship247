@extends('layouts.admin')

@section('content')
    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <h2 class="title">
                    CREATE Land Pricing
                </h2>
                <div>
                    <a href="{{route('supplier.land-schedules.index')}}" class="default-button-v2 outline-button">
                        <span>Back</span>
                    </a>
                </div>
            </header>

            <div class="detail-body">
                <div class="md:w-6/12">
                    <form method="POST" action="{{ route('supplier.land-schedules.store') }}" class="default-form">
                        @csrf
                        <div class="grid grid-cols-1 gap-8 mt-6">
                            <div class="form-field">
                                <label for="truck_type_id" class="form-label">Truck Type</label>
                                <select id="truck_type_id" name="truck_type_id" required
                                        class="form-input small-input mt-2 w-full block">
                                    <option value="">Select Truck Type</option>
                                    @foreach($truck_types as $id => $display_label)
                                        <option value="{{ $id }}"
                                                @if(old('truck_type_id') == $id) selected @endif
                                        >{{$display_label}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-field hidden" id="container_size_form_field">
                                <label for="container_size" class="form-label">Container Size</label>
                                <select id="container_size" name="container_size"
                                        class="form-input small-input mt-2 w-full block">
                                    <option value="">Select Container</option>
                                    @foreach($container_sizes as $value => $display_label)
                                        <option value="{{ $value }}"
                                                @if(old('container_size') == $value) selected @endif
                                        >{{$display_label}}</option>
                                    @endforeach
                                </select>
                                @error('container_size')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="axle" class="form-label">Select Axles</label>
                                <div class="form-field radio-field gap-8">
                                    <label class="switch">
                                        <input type="radio" name="axle" value="0" class="form-radio" checked>
                                        <span class="text">None</span>
                                    </label>

                                    <label class="switch">
                                        <input type="radio" name="axle" value="2" class="form-radio">
                                        <span class="text"> 2 Axles </span>
                                    </label>

                                    <label class="switch">
                                        <input type="radio" name="axle" value="3" class="form-radio">
                                        <span class="text"> 3 Axles </span>
                                    </label>

                                    <label class="switch">
                                        <input type="radio" name="axle" value="4" class="form-radio">
                                        <span class="text"> 4 Axles </span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="max_load_in_ton" class="form-label">Max Load in ton</label>
                                <input type="number" id="max_load_in_ton" name="max_load_in_ton" required
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{ old('max_load_in_ton') }}">
                            </div>

                            <div class="form-field">
                                <label for="origin_id" class="form-label">Pick Up Point</label>
                                @include('suppliers.partials._location-select2',
                                    [
                                        'name' => 'origin_id',
                                        'required' => true,
                                    ]
                                )
                                @error('origin_id')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="destination_id" class="form-label">Delivery Point</label>
                                @include('suppliers.partials._location-select2',
                                    [
                                        'name' => 'destination_id',
                                        'required' => true,
                                    ]
                                )
                                @error('destination_id')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="land_freight" class="form-label">Land Freight</label>
                                <input type="number" id="land_freight" name="land_freight" required
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{ old('land_freight') }}">
                            </div>
							
							{{--<div class="form-field">
                                <label for="our_charges" class="form-label">Our Charges</label>
                                <input type="number" id="our_charges" name="our_charges" required
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{ old('our_charges') }}">
                            </div>--}}
							
							<input type="hidden" id="our_charges" name="our_charges" required
                                       class="form-input small-input mt-2 w-full block"
                                       value="0">

                            <div class="form-field">
                                <label for="company_id" class="form-label">Company</label>
                                <select id="company_id" name="company_id" required
                                        class="form-input small-input mt-2 w-full block">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company_id => $company_name)
                                        <option value="{{ $company_id }}"
                                                @if(auth()->user()->company_id == $company_id) selected @endif
                                        >{{$company_name}}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label for="available_trucks" class="form-label">Available Trucks</label>
                                <input type="number" id="available_trucks" name="available_trucks" required
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{ old('available_trucks') }}">
                            </div>

                            <div class="form-field">
                                <label for="tt" class="form-label">Transit Time (Days)</label>
                                <input type="number" id="tt" name="tt" required
                                       class="form-input small-input mt-2 w-full block" value="{{ old('tt') }}">
                            </div>

                            <div class="form-field">
                                <label for="detention_charges_per_hour" class="form-label">Detention Charges (Per
                                    Hrs)</label>
                                <input type="number" id="detention_charges_per_hour" name="detention_charges_per_hour"
                                       required
                                       class="form-input small-input mt-2 w-full block"
                                       value="{{old('detention_charges_per_hour')}}">
                            </div>

                            <div class="form-field">
                                <label for="valid_till" class="form-label">Validity</label>
                                <input type="date" id="valid_till" name="valid_till" required
                                       class="form-input small-input mt-2 w-full block" value="{{ old('valid_till') }}">
                            </div>

                        </div>


                        <div class="form-field mt-8">
                            <button type="submit" class="default-button-v2">
                                <span>Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer-scripts')
    <script>
        $(document).ready(function () {
			
			setValidDateMin();
			
            $('#truck_type_id').change(function () {
                const truckTypeLabel = $(this).children("option:selected").text().toLowerCase();
                toggleContainerSize(truckTypeLabel);
            });

            function toggleContainerSize(truckTypeLabel) {
                if (truckTypeLabel === 'container') {
                    $('#container_size_form_field').show();
                    $('#container_size_form_field select').prop('required', true);
                } else {
                    $('#container_size_form_field').hide();
                    $('#container_size_form_field select').prop('required', false);
                }
            }
			
			function setValidDateMin(){
				const date = new Date();
				dateday="0"+(date.getDate());
				dateday=dateday.slice(-2);
				datemonth="0"+(date.getMonth()+1);
				datemonth=datemonth.slice(-2);
				etdmin=date.getFullYear()+"-"+datemonth+"-"+dateday;
				 $('#valid_till').prop('min', etdmin);
			}
        });
    </script>
@endsection
