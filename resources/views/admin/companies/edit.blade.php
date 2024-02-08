@extends('layouts.admin')

@section('content')

<?php
$selected_industry = explode(',', $company_details->industry);

?>

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="w-6/12">
                <h2 class="title">
                    Create Company
                </h2>
            </div>
            
            <div class="md:w-6/12 md:justify-end flex">
                <a href="{{route('superadmin.company.details', ['companyID' =>$company_details->id ])}}" class="default-button-v2 outline-button">
                    <span>Back</span>
                </a>
            </div>
        </header>

        <div class="company-section">
            <div class="">
                <form method="POST" action="{{ route('superadmin.companyUpdate.update',$company_details->id ) }}" class="default-form" id="company-form" enctype="multipart/form-data">
                    @csrf
					<div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-2 mb-4 mt-14">
                        <p class="text-sm primary-font-medium primary-color uppercase">Administration information</p>
                    </div>
					<section class="w-8/12">
                        <div class="grid grid-cols-2 gap-8 mt-6">
							<div class="form-field">
								<label for="first_name" class="form-label">Assigned User (Current)</label>
								<label for="first_name_current" class="form-label" style="margin-top:20px">
									@if( isset($company_details->related_assigned_user->first_name) )
										@if( isset($company_details->related_assigned_user->last_name) )
											{{$company_details->related_assigned_user->first_name." ".$company_details->related_assigned_user->last_name}}
										@else
											{{$company_details->related_assigned_user->first_name}}
										@endif
									@else
										@if( isset($company_details->related_assigned_user->last_name) )
											{{$company_details->related_assigned_user->last_name}}
										@else
										-
										@endif
									@endif
								</label>
							</div>
                            <div class="form-field">
								<label for="first_name" class="form-label">Assigned User (Change)</label>
                                <select name="assigned_user" id="assigned_user" class="form-input w-full">
								
										<option 'selected' value="no">Change Assigned User</option>
								
										@if(isset($our_employees) && count($our_employees) > 0)
										@foreach ($our_employees as $k => $our_employee)
										<option value="{{ $our_employee->id }}">{{
											$our_employee->first_name.' '.$our_employee->last_name}}</option>
										@endforeach
										@endif
								</select>
                            </div>
						</div>
					</section>
                    <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-2 mb-4 mt-14">
                        <p class="text-sm primary-font-medium primary-color uppercase">personal information</p>
                    </div>
                    <input type="hidden" name="vender_admin_id" value="{{$vendor_admin->id}}"/>
                    <section class="w-8/12">
                        <div class="grid grid-cols-2 gap-8 mt-6">
                            <div class="form-field">
                                <label for="first_name" class="form-label">First Name</label>
                                <input name="first_name" type="text" id="first_name" class="form-input small-input w-full" value="{{$vendor_admin->first_name}}" required>
                            </div>
        
                            <div class="form-field">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input name="last_name" type="text" id="last_name" class="form-input small-input w-full" value="{{$vendor_admin->last_name}}" required>
                            </div>
        
                            <div class="form-field">
                                <label for="user_country">Country</label>
                                <select name="user_country" id="user_country" class="form-input small-input w-full" required>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->name }}" <?php echo ($vendor_admin->country === $country->name) ? 'selected' : '' ?> >{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
        
                            <div class="form-field">
                                <label for="user_phone_number" class="form-label">Phone Number</label>
                                <input name="user_phone_number" type="text" id="user_phone_number" class="form-input small-input w-full" value="{{$vendor_admin->phone_number}}" required>
                            </div>
        
                            <div class="form-field">
                                <label for="user_email" class="form-label">Email</label>
                                <input name="user_email" type="email" id="user_email" class="form-input small-input w-full" value="{{$vendor_admin->email}}" required>
                            </div>
                        </div>
                    </section>
        
                    <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-2 mb-4 mt-14">
                        <p class="text-sm primary-font-medium primary-color uppercase">company information</p>
                    </div>
        
                    <section class="w-8/12">
                        <div class="grid grid-cols-2 gap-8 mt-6">
                            <div class="form-field">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input type="text" name="company_name" id="company_name" class="form-input small-input w-full" value="{{$company_details->name}}" required>
                            </div>
        
                            <div class="form-field">
                                <label for="industry" class="form-label">Business Type</label>
                                <select name="industry[]" multiple id="industry" required
                                    class="mt-2 block select-multiple">
									@if(isset($industries) && count($industries) > 0)
									@foreach ($industries as $option)
									<option {{ in_array($option, $selected_industry) ? 'selected' : '' }} value="{{ $option}}">{{
										$option}}</option>
									@endforeach
									@endif
                                </select>
                            </div>
        
                            <div class="form-field">
                                <label for="email" class="form-label">Corporate Email</label>
                                <input type="email" name="email" id="email" class="form-input small-input w-full" value="{{$company_details->email}}" required>
                            </div>
        
                            <div class="form-field">
                                <label for="contact_no" class="form-label">Corporate Contact</label>
                                <input type="text" name="contact_no" id="contact_no" class="form-input small-input w-full" value="{{$company_details->contact_no}}" required>
                            </div>
        
                            <div class="form-field">
                                <label for="country">Country</label>
                                <select name="country" id="country" class="form-input small-input w-full" required>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->name }}" <?php echo ($company_details->country === $country->name) ? 'selected' : '' ?> >{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
        
                            <div class="form-field">
                                <label for="city" class="form-label">City</label>
                                <input name="city" type="text" id="city" class="form-input small-input w-full" value="{{$company_details->city}}" required>
                            </div>
                        </div>
                    </section>

                    <div class="document-section mt-14">
                        <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-1 mb-4 ">
                            <p class="text-sm primary-font-medium primary-color uppercase">documents </p>
                        </div>
						
						<div class="detail-body">
							@if(isset($company_details) && isset($company_details->documents) && count($company_details->documents) > 0 )
								@foreach ( $company_details->documents as $option)
										<?php $result = array_filter(config('constants.COMPANY_DOCUMENTS'), function ($item) use ($option) {
										return $item->value == $option->type;
									});
										$matchingObject = reset($result);
										?>
									<div class="detail-box relative items-center">
										<div class="w-3/12">
											<div class="flex flex-col gap-4">
												<div>
													<span class="head">Document Type</span>
													@if (!empty($result))
														<span class="value">{{ $matchingObject->label}}</span>
													@endif
												</div>
											</div>
										</div>

										<div class="w-4/12">
											<div class="flex flex-col gap-4">
												<div>
													<span class="head">Document Name</span>
													@if (!empty($result))
														<a href="{{ asset('storage/'.$option->path)}}" class="value"
														   target="_blank">{{ $option->name
											}}</a>
													@endif
												</div>
											</div>
										</div>

										<div class="w-3/12">
											<div class="flex flex-col gap-4">
												<div>
													<span class="head">Uploaded Date</span>
													<span class="value">{{$option->created_at}}</span>
												</div>
											</div>
										</div>
									</div>
								@endforeach

							@endif
						</div>
						@if(isset($company_details) && $company_details->status == config("constants.COMPANY_REGISTRATION_STATUS_RESUBMIT") )
						<br />
						<div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-1 mb-4 ">
							<p class="text-sm primary-font-medium primary-color uppercase">Message: </p>
						</div>
						<div class="text-left mt-5">
							<div class="form-field">
								<span class="value">{{ $company_status_history->message}}</span>
							</div>
						</div>
						@endif
						<br />
                        <div class="w-9/12">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">Document Type</span>
                                    <select name="document_type" class="form-input small-input mt-2 w-9/12 block" >
                                        <option value="">Select Document</option>
                                        @foreach (config('constants.COMPANY_DOCUMENTS') as $option)
                                        <option value="{{$option->value}}">{{$option->label}}</option>
                                        @endforeach
                                    </select>
                                    @error('document_type')
                                    <span class="error-field">{{ $message }}</span>
                                    @enderror
                                </div>
        
                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">Upload Document</span>
                                    <input type="file" name="documents[]" id="documents" class="mt-4 w-9/12" accept="application/pdf" multiple />
                                    @error('documents')
                                     <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                
                    </div>
        
                    <div class="form-field mt-8">
                        <button type="submit" class="default-button-v2">
                            <span>Save</span>
                        </button>
						<a href="{{route('superadmin.company.details', ['companyID' =>$company_details->id ])}}" class="default-button-v2 outline-button">
							<span>Cancel</span>
						</a>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</section>

@endsection