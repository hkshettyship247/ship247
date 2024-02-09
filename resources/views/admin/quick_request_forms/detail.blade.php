@extends('layouts.admin')

@section('content')

<section class="shadow-box small-box mt-8">
    <div class="dashboard-detail-box">

        <header>
            <h2 class="title">
                Request Detail
                {{-- {{ $quick_request_form_details->first_name }} --}}
            </h2>
            <a href="{{route('supplier.quick-request-forms.index')}}" class="default-button-v2 outline-button">
                <span>Back</span>
            </a>
        </header>

        <div class="form-field mt-6">
            <span class="form-label"><b>Quoted: <b /></span>
            @if($quick_request_form_details->is_quoted == 1)
                @if( isset($quick_request_form_details->user->last_name) )
                    {{$quick_request_form_details->user->first_name." ".$quick_request_form_details->user->last_name}}
                @else
                 -   
                @endif
            @else
                <section class="w-8/12">
                    <form action="{{ route($route_user.'quote-quick-request') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$quick_request_form_details->id}}"/>
                        <div class="grid grid-cols-2 gap-8 mt-6">
                            <div class="form-field">
                                <label for="first_name" class="form-label">Assigned User (Change)</label>
                                <select name="assigned_user" id="assigned_user" class="form-input w-full">
                                        @if(isset($our_employees) && count($our_employees) > 0)
                                        @foreach ($our_employees as $k => $our_employee)
                                        <option {{ $k == 0 ? 'selected' : '' }} value="{{ $our_employee->id }}">{{
                                            $our_employee->first_name.' '.$our_employee->last_name}}</option>
                                        @endforeach
                                        @endif
                                </select>
                            </div>
                            <div class="form-field mt-6">
                                <button type="submit" class="default-button-v2">Submit</button>
                            </div>
                        </div>
                    </form>
                </section>
            @endif

        @if(isset($quick_request_form_details))
        <div class="profile-section mt-14">

            <div class="flex justify-between items-center w-full border-b-2 border-gray-300 pb-1 mb-4 ">
                <p class="text-sm primary-font-medium primary-color uppercase">information</p>
            </div>


            <div class="flex">
                <div class="grid gap-6">
                    <div class="form-field">
                        <span class="uppercase text-gray-400 text-xs block">Full name</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $quick_request_form_details->name }}</span>
                    </div>

                    <div class="form-field">
                        <span class="uppercase text-gray-400 text-xs flex-inline items-center">Email</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $quick_request_form_details->email }}</span>
                    </div>

                    <div class="form-field">
                        <span class="uppercase text-gray-400 text-xs block">Phone number</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $quick_request_form_details->phone }}</span>
                    </div>

                    <div class="form-field">
                        <span class="uppercase text-gray-400 text-xs block">Company</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $quick_request_form_details->company }}</span>
                    </div>

                    <div class="form-field">
                        <span class="uppercase text-gray-400 text-xs block">Origin Name</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $quick_request_form_details->origin_name }}</span>
                    </div>

                    <div class="form-field">
                        <span class="uppercase text-gray-400 text-xs block">Destination Name</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $quick_request_form_details->destination_name }}</span>
                    </div>
                    <div class="form-field">
                        <span class="uppercase text-gray-400 text-xs block">ETD</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">
                            {{ $quick_request_form_details->etd === '-' ? "-" : \Carbon\Carbon::parse($quick_request_form_details->etd)->format('d, M, Y') }}</span>
                    </div>
                    <div class="form-field">
                        <span class="uppercase text-gray-400 text-xs block">ETA</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">
                            {{ $quick_request_form_details->eta === '-' ? "-" : \Carbon\Carbon::parse($quick_request_form_details->eta)->format('d, M, Y') }}</span>
                    </div>
                    <div class="form-field">
                        <span class="uppercase text-gray-400 text-xs block">Booking Company</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $quick_request_form_details->booking_company }}</span>
                    </div>

                    <div class="form-field">
                        <span class="uppercase text-gray-400 text-xs block">Route Type</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                            $quick_request_form_details->route_type == 1 ? 'SEA' : 'LAND'}}</span>
                    </div>

                    <div class="form-field">
                        <span class="uppercase text-gray-400 text-xs block">Message</span>
                        <span class="primary-color primary-font-medium block mt-2 view-personal-mode">
                            {{
                            $quick_request_form_details->description != null && $quick_request_form_details->description != "" ? $quick_request_form_details->description : '-'}}</span>
                    </div>
                </div>
            </div>
        </div>



        @endif
    </div>
</section>

@endsection
