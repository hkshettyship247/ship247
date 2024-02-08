@extends('layouts.admin')

@section('content')
<?php
$selected_industry = explode(',', $work_with_us_form_details->industry);

?>
<section class="shadow-box small-box mt-8">
    <div class="dashboard-detail-box">

        <header>
            <h2 class="title">
                Work With Us Detail
            </h2>
            <a href="{{route('superadmin.work-with-us-forms.index')}}" class="default-button-v2 outline-button">
                <span>Back</span>
            </a>
        </header>

        @if(isset($work_with_us_form_details))
        <div class="profile-section mt-14">

            <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-1 mb-4 ">
                <p class="text-sm primary-font-medium primary-color uppercase">information</p>
            </div>


            <div class="flex md:w-6/12">
                <div class="grid gap-6">
                    <div class="form-field">
                        <span class="form-label">Full name</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $work_with_us_form_details->first_name }} {{$work_with_us_form_details->last_name}}</span>
                    </div>

                    <div class="form-field">
                        <span class="form-label">Email</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $work_with_us_form_details->email }}</span>
                    </div>

                    <div class="form-field">
                        <span class="form-label">Phone number</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $work_with_us_form_details->phone_number }}</span>
                    </div>

                    <div class="form-field">
                        <span class="form-label">Company</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $work_with_us_form_details->company_name }}</span>
                    </div>

                    <div>
                        <form method="POST" class="default-form"
                        action="{{ route('superadmin.work-with-us-forms.update_status', ['id' => $work_with_us_form_details->id]) }}">

                            <div class="">
                                <span class="form-label">Industry</span>
								@if($work_with_us_form_details->status !== config('constants.WORK_WITH_US_FORM_STATUS_ACCEPTED'))
                                <select name="industry[]" multiple id="industry" required
                                    class="mt-2 block select-multiple">
									@if(isset($industries) && count($industries) > 0)
									@foreach ($industries as $option)
									<option {{ in_array($option, $selected_industry) ? 'selected' : '' }} value="{{ $option}}">{{
										$option}}</option>
									@endforeach
									@endif
                                </select>
								@else
									<br /><br />
									@foreach ($selected_industry as $selected_industry_value)
									{{strtoupper($selected_industry_value)}} <br />
									@endforeach
								@endif
                            </div>

                            @csrf
                            @method('PATCH')

                            <div class="form-field mt-6">
                                <span class="form-label">Status</span>
								@if($work_with_us_form_details->status !== config('constants.WORK_WITH_US_FORM_STATUS_ACCEPTED'))
									<select name="status" id="status" class="form-input w-full">
										<option value="{{config('constants.WORK_WITH_US_FORM_STATUS_PENDING')}}" {{
											$work_with_us_form_details->status ===
											config('constants.WORK_WITH_US_FORM_STATUS_PENDING') ? 'selected' : '' }}>Pending
										</option>
										<option value="{{config('constants.WORK_WITH_US_FORM_STATUS_ACCEPTED')}}" {{
											$work_with_us_form_details->status ===
											config('constants.WORK_WITH_US_FORM_STATUS_ACCEPTED') ? 'selected' : '' }}>Accept
										</option>
										<option value="{{config('constants.WORK_WITH_US_FORM_STATUS_REJECTED')}}" {{
											$work_with_us_form_details->status ===
											config('constants.WORK_WITH_US_FORM_STATUS_REJECTED') ? 'selected' : '' }}>Reject
										</option>
									</select>
								@else
									ACCEPTED
								@endif
                            </div>
							
							<div class="form-field mt-6">
								<span class="form-label">Assigned User (Current)</span>
						
								@if( isset($work_with_us_form_details->related_assigned_user->first_name) )
									@if( isset($work_with_us_form_details->related_assigned_user->last_name) )
										{{$work_with_us_form_details->related_assigned_user->first_name." ".$work_with_us_form_details->related_assigned_user->last_name}}
									@else
										{{$work_with_us_form_details->related_assigned_user->first_name}}
									@endif
								@else
									@if( isset($work_with_us_form_details->related_assigned_user->last_name) )
										{{$work_with_us_form_details->related_assigned_user->last_name}}
									@else
										-
									@endif
								@endif
								<br /><br />
                                <span class="form-label">Assigned User (Change)</span>
								@if($work_with_us_form_details->status !== config('constants.WORK_WITH_US_FORM_STATUS_ACCEPTED'))
									<select name="assigned_user" id="assigned_user" class="form-input w-full">
								
										<option 'selected' value="no">Change Assigned User</option>
										
										@if(isset($our_employees) && count($our_employees) > 0)
										@foreach ($our_employees as $our_employee)
										<option value="{{ $our_employee->id }}">{{
											$our_employee->first_name.' '.$our_employee->last_name}}</option>
										@endforeach
										@endif
									</select>
								@else
									@if( isset($work_with_us_form_details->related_assigned_user->first_name) )
										@if( isset($work_with_us_form_details->related_assigned_user->last_name) )
											{{$work_with_us_form_details->related_assigned_user->first_name." ".$work_with_us_form_details->related_assigned_user->last_name}}
										@else
											{{$work_with_us_form_details->related_assigned_user->first_name}}
										@endif
									 @else
										@if( isset($work_with_us_form_details->related_assigned_user->last_name) )
											{{$work_with_us_form_details->related_assigned_user->last_name}}
										@else
											-
										@endif
									 @endif
								@endif
                            </div>
							
							@if($work_with_us_form_details->status !== config('constants.WORK_WITH_US_FORM_STATUS_ACCEPTED'))
                            <button type="submit" class="default-button-v2 mt-10">
                                <span>Update</span>
                            </button>
							@endif
                        </form>
                    </div>


                </div>
            </div>
        </div>



        @endif
    </div>
</section>

@endsection