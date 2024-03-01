@extends('layouts.admin')

<style>
    .Invoiceflex,
    .Tableflex {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        max-width: 600px;
        border-bottom: 1px solid #2c1e3f;
    }

    .Tableflex .form-field {
        display: flex;
        align-items: center;
        justify-content: space-between;
        /* padding: 10px 0; */
        padding-bottom: 10px;
        margin-top: 10px;
        width: 100%;
        border-bottom: 1px solid #dddddd;
    }

    .TotalPay {
        text-align: right;
        width: 100%;
    }

    .TotalPay h2 {
        color: var(--primary-color);
        font-size: 24px;
        font-weight: bold;
        line-height: 36px;
        text-align: right;
    }

    .dashboard-detail-box .default-button-v2.primary-bg span {
        display: flex;
        align-items: center;
    }

    .profile-section .back-btn a svg,
    .dashboard-detail-box .default-button-v2.primary-bg span .me {
        margin-right: 5px;
        width: 16px;
        height: 16px;
    }

    .profile-section .back-btn {
        display: flex;
        justify-content: flex-end;
    }

    .profile-section .back-btn a {
        display: flex;
        align-items: center;
        border-bottom: 2px solid #d23c3c;
        padding: 2px 0;
        font-size: 14px;
        line-height: 20px;
        text-transform: uppercase;
        font-weight: bold;
    }
</style>

@section('content')

<section class="shadow-box mt-8">
    <div class="dashboard-detail-box">
        <header>
            <div class="md:w-6/12">
                <h2 class="title">
                    ID# {{ $payment_details->booking->id }} INVOICE
                </h2>
            </div>

            <div class="md:w-6/12 md:justify-end flex">

                <a href="{{ route($route.'generate.pdf.invoice', ['bookingID' => $payment_details->booking->id]) }}"
                    class="default-button-v2 primary-bg">
                    <span><svg class="me" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-download">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>Download</span>
                </a>
                @if($payment_details->status != 'completed')
                <a href="#" class="default-button-v2 ms-3">
                    <span>Pay</span>
                </a>
                @endif
            </div>
        </header>


        <section class="profile-section mt-14">
            <div class="sec-title mb-4">
                <span class="primary-color primary-font-medium block mt-2 view-personal-mode">BL {{ !empty($track_booking_response) ? $track_booking_response['data']->transportDocumentId : "" }}</span>
            </div>
            <div class="Invoiceflex">
                <div class="2xl:w-6/12 xl:w-6/12 w-12/12">
                    <div class="grid xl:grid-cols-2 gap-6 mb-6">
                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">Origin</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">
                                {{ $payment_details->booking->origin->fullname }}</span>
                        </div>
                    </div>
                </div>
                <div class="2xl:w-6/12 xl:w-6/12 w-12/12">
                    <div class="grid xl:grid-cols-2 gap-6 mb-6">
                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">Destination</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">
                                {{ $payment_details->booking->destination->fullname }}</span>
                        </div>
                    </div>
                </div>
                <div class="2xl:w-6/12 xl:w-6/12 w-12/12">
                    <div class="grid xl:grid-cols-2 gap-6 mb-6">
                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">Date</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">{{
                                $payment_details->booking->created_at->format('d F Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="2xl:w-6/12 xl:w-6/12 w-12/12">
                    <div class="grid xl:grid-cols-2 gap-6 mb-6">
                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">Container Type</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">15x20'
                                Standard</span>
                        </div>
                    </div>
                </div>
                <div class="2xl:w-6/12 xl:w-6/12 w-12/12">
                    <div class="grid xl:grid-cols-2 gap-6 mb-6">
                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">Product</span>
                            <span
                                class="primary-color primary-font-medium block mt-2 view-personal-mode">Vegetables</span>
                        </div>
                    </div>
                </div>
                <div class="2xl:w-6/12 xl:w-6/12 w-12/12">
                    <div class="grid xl:grid-cols-2 gap-6 mb-6">
                        <div class="form-field">
                            <span class="uppercase text-gray-400 text-xs block">Container Free Type</span>
                            <span class="primary-color primary-font-medium block mt-2 view-personal-mode">7 Days</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="Tableflex mt-5">
                <div class="form-field">
                    <span class="uppercase text-gray-400 text-xs block">Pickup Charges</span>
                    <span class="primary-color primary-font-medium block mt-2 view-personal-mode">${{
                        $payment_details->booking->pickup_charges }}</span>
                </div>
                <div class="form-field">
                    <span class="uppercase text-gray-400 text-xs block">Origin Port Charges</span>
                    <span class="primary-color primary-font-medium block mt-2 view-personal-mode">${{
                        $payment_details->booking->origin_charges }}</span>
                </div>
                <div class="form-field">
                    <span class="uppercase text-gray-400 text-xs block">Destination Port Charges</span>
                    <span class="primary-color primary-font-medium block mt-2 view-personal-mode">${{
                        $payment_details->booking->destination_charges }}</span>
                </div>
                <div class="form-field">
                    <span class="uppercase text-gray-400 text-xs block">Freight Charges</span>
                    <span class="primary-color primary-font-medium block mt-2 view-personal-mode">${{
                        $payment_details->booking->basic_ocean_freight }}</span>
                </div>
                <div class="form-field">
                    <span class="uppercase text-gray-400 text-xs block">Delivery Charges</span>
                    <span class="primary-color primary-font-medium block mt-2 view-personal-mode">${{
                        $payment_details->booking->delivery_charges }}</span>
                </div>
            </div>
            <div class="Tableflex border-0 mt-5">
                <div class="TotalPay">
                    <h2>$ {{ $payment_details->amount }} </h2>
                </div>
            </div>
            <div class="back-btn">
                <a href="{{ route($route.'bookings.show', $payment_details->booking->id) }}"><svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-arrow-left">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg> <span>Back</span></a>
            </div>
        </section>

</section>


@endsection