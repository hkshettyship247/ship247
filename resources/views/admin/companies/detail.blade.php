@extends('layouts.admin')

@section('content')

    <section class="shadow-box mt-8">
        <div class="dashboard-detail-box">
            <header>
                <div class="md:w-6/12">
                    <h2 class="title">
                        Company Details
                    </h2>
                </div>

                <div class="md:w-6/12 md:justify-end flex">
                    <a href="{{route('superadmin.company.index')}}" class="default-button-v2 outline-button">
                        <span>Back</span>
                    </a>
					@if($company_details->status != config('constants.COMPANY_REGISTRATION_STATUS_REJECTED') )
					<a href="{{route('superadmin.company.edit', ['companyID' =>$company_details->id ])}}" class="default-button-v2 outline-button">
                        <span>Edit</span>
                    </a>
					@endif
                </div>
            </header>

            @if(isset($company_details))

                <section class="company-section mt-14">
				
					<div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-2 mb-4 mt-14">
                        <p class="text-sm primary-font-medium primary-color uppercase">Administration information</p>
                    </div>
					<div class="form-field mt-6">
					<span class="form-label"><b>Assigned User: <b /></span>
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
					<br /><br />
					</div>
					
                    <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-2 mb-4">
                        <p class="text-sm primary-font-medium primary-color uppercase">company information</p>

                        <div>
                            @if($company_details->status == config('constants.COMPANY_REGISTRATION_STATUS_APPROVED') )
                                <span class="badge completed">
                        Verified
                    </span>
                            @endif
                            @if($company_details->status == config('constants.COMPANY_REGISTRATION_STATUS_PENDING') )
                                <span class="badge progress">
                        Pending Approval
                    </span>
                            @endif
                            @if($company_details->status == config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT') )
                                <span class="badge cancel">
                        Re-submit Request
                    </span>
                            @endif
							@if($company_details->status == config('constants.COMPANY_REGISTRATION_STATUS_REJECTED') )
                                <span class="badge cancel">
                        Rejected
                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="flex">
                        <div class="2xl:w-2/12 xl:w-3/12 w-4/12">
                            <p>
                                <span class="uppercase text-gray-400 text-xs block">id</span>
                                <span class="primary-color primary-font-medium block mt-2">{{ str_pad($company_details->id, 5,
                            '0', STR_PAD_LEFT) }}</span>
                            </p>
                        </div>

                        <div class="2xl:w-8/12 xl:w-9/12 w-8/12">
                            <div class="grid xl:grid-cols-2 gap-6">
                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">Name</span>
                                    <span class="primary-color primary-font-medium block mt-1">
                                {{$company_details->name}}
                            </span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">Industry</span>
                                    <span class="primary-color primary-font-medium block mt-1">
                                {{isset($company_details->industry) ? $company_details->industry : "-"}}
                            </span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">Email</span>
                                    <span class="primary-color primary-font-medium block mt-1">
                                {{$company_details->email}}
                            </span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">Contact No.</span>
                                    <span class="primary-color primary-font-medium block mt-1">
                                {{$company_details->contact_no}}
                            </span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">Country</span>
                                    <span class="primary-color primary-font-medium block mt-1">
                                {{$company_details->country}}
                            </span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">city</span>
                                    <span class="primary-color primary-font-medium block mt-1">
                                {{$company_details->city}}
                            </span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">Website</span>
                                    <span class="primary-color primary-font-medium block mt-1">
                                {{$company_details->website}}
                            </span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">About</span>
                                    <span class="primary-color primary-font-medium block mt-1">
                                {{$company_details->description}}
                            </span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">Document Type</span>
                                    <span class="primary-color primary-font-medium block mt-1">
                                @if(isset($company_details->documents) && count($company_details->documents) > 0)
                                            @foreach ($company_details->documents as $attachment)
                                                    <?php $result = array_filter(config('constants.COMPANY_DOCUMENTS'), function ($item) use ($attachment) {
                                                    return $item->value == $attachment->type;
                                                });
                                                    $matchingObject = reset($result);
                                                    ?>
                                                @if (!empty($result))
                                                    {{ $matchingObject->label }}
                                                @endif
                                            @endforeach
                                        @endif
                            </span>
                                </div>

                                <div class="form-field">
                                    <span class="uppercase text-gray-400 text-xs block">Document Name</span>
                                    <span class="primary-color primary-font-medium block mt-1">
                                @if(isset($company_details->documents) && count($company_details->documents) > 0)
                                            @foreach ($company_details->documents as $attachment)
                                                <a href="{{ asset('storage/'.$attachment->path)}}" target="_blank">{{ $attachment->name
                                    }}</a>
                                            @endforeach
                                        @endif
                            </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            @endif

            @if(isset($users) && count($users) > 0)

                <section class="profile-section mt-14">
                    @foreach ( $users as $user )
                        <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-2 mb-4">
                            <p class="text-sm primary-font-medium primary-color uppercase">user information</p>
                        </div>

                        <div class="flex">
                            <div class="2xl:w-2/12 xl:w-3/12 w-4/12">
                                <p>
                                    <span class="uppercase text-gray-400 text-xs block">id</span>
                                    <span class="primary-color primary-font-medium block mt-2">{{ $user->id }}</span>
                                </p>
                            </div>

                            <div class="2xl:w-8/12 xl:w-9/12 w-8/12">
                                <div class="grid xl:grid-cols-2 gap-6">
                                    <div class="form-field">
                                        <span class="uppercase text-gray-400 text-xs block">first name</span>
                                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $user->first_name }}</span>
                                    </div>

                                    <div class="form-field">
                                        <span class="uppercase text-gray-400 text-xs block">last name</span>
                                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $user->last_name }}</span>
                                    </div>

                                    <div class="form-field">
                                        <span
                                            class="uppercase text-gray-400 text-xs flex-inline items-center">email</span>
                                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $user->email }}</span>
                                    </div>

                                    <div class="form-field">
                                        <span class="uppercase text-gray-400 text-xs block">phone number</span>
                                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $user->phone_number }}</span>
                                    </div>

                                    <div class="form-field">
                                        <span class="uppercase text-gray-400 text-xs block">country</span>
                                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $user->country }}</span>
                                    </div>

                                    <div class="form-field">
                                        <span class="uppercase text-gray-400 text-xs block">city</span>
                                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $user->city }}</span>
                                    </div>

                                    <div class="form-field">
                                        <span class="uppercase text-gray-400 text-xs block">department</span>
                                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $user->department }}</span>
                                    </div>

                                    <div class="form-field">
                                        <span class="uppercase text-gray-400 text-xs block">job title</span>
                                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $user->job_title }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </section>
            @endif

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
				
		{{--@if(isset($company_details) && $company_details->status == config("constants.COMPANY_REGISTRATION_STATUS_RESUBMIT") )
					<br />
                    <div class="w-9/12">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">Document Type</span>
                                <select name="document_type" class="form-input small-input mt-2 w-9/12 block" <?php echo
                                (isset($company_details) && $company_details->status ==
                                    config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT')) ? '' : 'required' ?> >
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
                                <input multiple type="file" name="documents[]" id="documents" class="mt-4 w-9/12"
                                       accept="application/pdf"
                                        <?php echo (isset($company_details) && $company_details->status ==
                                    config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT')) ? '' : 'required' ?> />

                                @error('documents')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
				
				@elseif(isset($company_details) && $company_details->status == config("constants.COMPANY_REGISTRATION_STATUS_PENDING") )
					<br />
                    <div class="w-9/12">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="form-field">
                                <span class="uppercase text-gray-400 text-xs block">Document Type</span>
                                <select name="document_type" class="form-input small-input mt-2 w-9/12 block" <?php echo
                                (isset($company_details) && $company_details->status ==
                                    config('constants.COMPANY_REGISTRATION_STATUS_PENDING')) ? '' : 'required' ?> >
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
                                <input multiple type="file" name="documents[]" id="documents" class="mt-4 w-9/12"
                                       accept="application/pdf"
                                        <?php echo (isset($company_details) && $company_details->status ==
                                    config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT')) ? '' : 'required' ?> />

                                @error('documents')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
				@endif--}} 
            </div>
			
            <section class="mt-20">
                @if(isset($company_details))

                    @if($company_details->status == config('constants.COMPANY_REGISTRATION_STATUS_PENDING') ||
                    $company_details->status == config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT') ||
                    $company_details->status == config('constants.COMPANY_REGISTRATION_STATUS_REJECTED'))
                        <div class="flex">
							@if($company_details->status != config('constants.COMPANY_REGISTRATION_STATUS_REJECTED'))
								<form action="{{route('superadmin.companyReject.reject',$company_details->id )}}"
									  method="post">
									@csrf
									<button class="default-button-v2 outline-button ml-4" type="submit">
										<span>Reject</span>
									</button>
								</form>
							@else
								<form action="{{route('superadmin.companyPending.activate',$company_details->id )}}"
									  method="post">
									@csrf
									<button class="default-button-v2 outline-button ml-4" type="submit">
										<span>Activate</span>
									</button>
								</form>
							@endif
							@if($company_details->status != config('constants.COMPANY_REGISTRATION_STATUS_REJECTED'))
                            <form method="POST"
                                  action="{{route('superadmin.companyStatus.update',$company_details->id )}}"
                                  class="default-form">
                                @csrf
								@if($company_details->status != config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT'))
									<button type="submit" name="status" class="default-button-v2 ml-4" value="{{config('constants.COMPANY_REGISTRATION_STATUS_APPROVED')}}">
										<span>Approve</span>
									</button>
									<button type="button" id="rejectBtn" class="default-button-v2 outline-button ml-4">
										<span>Resubmit</span>
									</button>
								@else
									<button type="submit" name="status" class="default-button-v2 outline-button ml-4" value="{{config('constants.COMPANY_REGISTRATION_STATUS_APPROVED')}}">
										<span>Approve</span>
									</button>
									<button type="submit" name="reuploadedstatus" class="default-button-v2 ml-4" value="{{config('constants.COMPANY_REGISTRATION_STATUS_PENDING')}}">
										<span>Reuploaded</span>
									</button>
								@endif

                                <div id="rejectFields" style="display: none;" class="text-left mt-10">
                                    <div class="form-field">
                                        <label for="message" class="form-label">Message:</label>
                                        <textarea name="message" id="message" style="height: 300px; width: 700px;" 
                                                  required> </textarea>
                                    </div>
                                    <div class="form-field" style="margin-top: 5px">
                                        <button type="submit" name="status" class="default-button-v2 small-button"
                                                value="{{config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT')}}">
                                            <span>Submit</span>
                                        </button>
										<button type="button" id="cancelBtn" class="default-button-v2 small-button">
											<span>Cancel</span>
										</button>
                                    </div>
                                </div>
                            </form>
							@endif
                        </div>
                    @endif
                @endif
            </section>

            {{-- <section class="status-section mt-14">
                <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-2 mb-4">
                    <p class="text-sm primary-font-medium primary-color uppercase">Status History</p>
                </div>
            </section>

            @if(isset($company_details))


            <table class="shipping-details">
                <thead>
                    <th>
                        <span class="head">Status</span>
                    </th>

                    <th>
                        <span class="head">DateTime</span>
                    </th>
                </thead>

                <tbody>

                    @if(isset($company_details->history) && count($company_details->history) > 0)
                    @foreach ($company_details->history as $history )


                    <tr>
                        <td>
                            @if(config('constants.COMPANY_REGISTRATION_STATUS_APPROVED') == $history->status )
                            <span>Verified</span>
                            @elseif(config('constants.COMPANY_REGISTRATION_STATUS_PENDING') == $history->status )
                            <span>Pending</span>
                            @elseif(config('constants.COMPANY_REGISTRATION_STATUS_RESUBMIT') == $history->status )
                            <span>Resubmit <strong>Message: </strong> {{$history->message}} </span>
                            @endif

                        </td>

                        <td>
                            <span>{{ $history->created_at }}</span>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td>
                            <span>No history</span>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>


            @endif

            {{-- <footer>
                <p class="number">Showing <strong>1 - 10</strong></p>
                <ul class="pagination">
                    <li class="active">
                        1
                    </li>
                    <li>
                        2
                    </li>
                    <li>
                        3
                    </li>
                </ul>
                <p class="total">Total <strong>200</strong></p>
            </footer> --}}
        </div>
    </section>


    <script>
        const rejectBtn = document.getElementById('rejectBtn');
		const cancelBtn = document.getElementById('cancelBtn');
        const rejectFields = document.getElementById('rejectFields');

        rejectBtn.addEventListener('click', function () {
            rejectFields.style.display = 'block';
        });
		
		cancelBtn.addEventListener('click', function () {
            rejectFields.style.display = 'none';
        });
		
    </script>

@endsection
