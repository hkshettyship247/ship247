<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ship247</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;700&display=swap" rel="stylesheet">

</head>
<body style="background-color: #ffffff; font-family: 'Figtree', sans-serif; font-size: 16px; margin: 0; padding: 0;">
<div style="margin: 0 auto; background-color: #ffffff; padding: 0; color: #000000; line-height: 1.5;">
    <table style="width: 100%;">
        <tr>
            <td valign="top" style="padding-bottom: 30px; font-family: 'Figtree', 'Arial', sans-serif;">
                {{-- <img src="{{ asset('/images/logo.png') }}" alt="Ship247 Logo" style="width: 180px;" /> --}}
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/images/logo.png'))) }}" alt="Ship247 Logo" style="width: 180px;" />
            </td>

            <td>
                <p style="margin: 0; padding: 0; text-align: right; font-family: 'Figtree', 'Arial', sans-serif; font-size: 14px;">
                    <strong>Canada</strong> <br>
                    1310 Rene Levesque <br>
                    Ouest Montreal, QC <br>
                    +15148124893 <br><br>

                    <strong>UAE</strong> <br>
                    TCA Abu Dhabi <br>
                    +97125469669
                </p>
            </td>
        </tr>

        <tr>
            <td valign="top">
                <p style="margin: 0; padding: 0; text-align: left; font-family: 'Figtree', 'Arial', sans-serif; font-size: 14px;">
                    <strong style="font-size: 16px;">Invoice to</strong>
                    <span style="display: block; font-size: 18px; font-weight: bold; margin-top: 0px">{{ ($booking->user) ? $booking->user->fullname : '' }}</span>
                    {{isset($booking->user->company) ? ($booking->user->company->city .',  ' .$booking->user->company->country  )  : null }} <br> {{isset($booking->user->company) ? $booking->user->company->name : null }}                    
                </p>
            </td>

            <td valign="top">
                <p style="margin: 0; padding: 0; text-align: right; font-family: 'Figtree', 'Arial', sans-serif; font-size: 14px;">
                    <span style="font-size: 16px;"> {{$booking->created_at->format('j M Y')}} </span>

                    <span style="display: block; font-size: 18px; font-weight: bold; margin-top: 0px">Invoice {{str_pad($booking->id, 6, '0', STR_PAD_LEFT)}}</span>
                </p>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="margin-bottom: 0px; padding: 0px; line-height: 2; font-family: 'Figtree', 'Arial', sans-serif; font-size: 14px;">
                <table style="width: 100%; margin-top: 20px; margin-bottom: 20px; border-collapse: separate;border-spacing:0;" border="1">
                    <tr>
                        <td valign="middle" style="padding: 0 5px">
                            <strong>POL : </strong> {{$booking->origin->fullname}}
                        </td>
                        <td valign="middle" style="padding: 0 5px">
                            <strong>POD : </strong> {{$booking->destination->fullname}}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 0 5px">
                            <strong>Type : </strong> {{$booking->container_size}} x {{$booking->no_of_containers}}
                        </td>

                        <td style="padding: 0 5px">
                            <strong>Transportation :</strong> {{$booking->transportation}}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 0 5px">
                            <strong>ETD :</strong> {{  \Carbon\Carbon::parse($booking->departure_date_time)->format('d, M, Y')}}
                        </td>
                        <td style="padding: 0 5px">
                            <strong>ETA :</strong> {{  \Carbon\Carbon::parse($booking->arrival_date_time)->format('d, M, Y')}}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 0 5px">
                            <strong>Pickup :</strong> {{$booking->is_checked_pickup_charges == "Y" ?  "Yes" : "No"}}
                        </td>
                        <td style="padding: 0 5px">
                            <strong>Delivery :</strong> {{$booking->is_checked_delivery_charges == "Y" ?  "Yes" : "No"}}
                        </td>
                    </tr>

                    <tr>
                        @foreach($booking->addons as $addon)
                            @if($addon->type === 'toggle')
                            <td style="padding: 0 5px">
                                <strong class="capitalize">{{strtoupper($addon->name)}} :</strong> Yes <br />
                            </td>
                            @endif
                        @endforeach
                    </tr>

                </table>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <table style="width: 100%; padding-top: 10px;" cellspacing="0">
                    <tr>
                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px;font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px;">
                            <strong>Description</strong>
                        </td>
                        
                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px; padding-right: 10px; text-align: right;font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px;">
                            <strong>Price</strong>
                        </td>
                    </tr>

                    @if($booking->is_checked_basic_ocean_freight == "Y")
                    <tr>
                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px;font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px;">
                            Ocean Freight
                        </td>
                        
                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px; padding-right: 10px; text-align: right;font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px;">
                            ${{ number_format($booking->basic_ocean_freight, 0) }}
                        </td>
                    </tr>
                    @endif

                    @if($booking->is_checked_pickup_charges == "Y")
                    <tr>
                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px;font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px;">
                            Pickup Charges
                        </td>
                        
                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px; padding-right: 10px; text-align: right;font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px;">
                            {{ $booking->pickup_charges > 0 ? 'USD '. number_format($booking->pickup_charges, 0) : "AMOUNT WILL BE SHARED LATER" }}
                        </td>
                    </tr>
                    @endif

                    @if($booking->is_checked_origin_charges == "Y")
                    <tr>
                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px;font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px;">
                            Origin Charges
                        </td>
                        
                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px; padding-right: 10px; text-align: right;font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px;">
                            ${{ number_format($booking->origin_charges, 0) }}
                        </td>
                    </tr>
                    @endif

                    @if($booking->is_checked_destination_charges == "Y")
                    <tr>
                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px;font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px;">
                            Destination Charges
                        </td>
                        
                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px; padding-right: 10px; text-align: right;font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px;">
                            ${{ number_format($booking->destination_charges, 0) }}
                        </td>
                    </tr>
                    @endif

                    @if($booking->is_checked_delivery_charges == "Y")
                    <tr>
                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px;font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px;">
                            Delivery Charges
                        </td>
                        
                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px; padding-right: 10px; text-align: right;font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px;">
                            {{ $booking->delivery_charges > 0 ? 'USD '. number_format($booking->delivery_charges, 0)  :  "AMOUNT WILL BE SHARED LATER"}}
                        </td>
                    </tr>
                    @endif

                    @php($i= 2)
                    @foreach($booking->addons as $addon)
                    <tr>
                 
                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px;font-family: 'Figtree', sans-serif;font-size: 14px;">
                            {{$addon->name == "Additional Container Free Time at POD" ? $addon->name . ' ' . $addon->value . " days" : $addon->name}}
                        </td>

                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px; padding-right: 10px; text-align: right;font-family: 'Figtree', sans-serif;font-size: 14px;">
                            @if($addon->type === 'toggle')
                                @if(is_numeric($addon->value))
                                    ${{ number_format($addon->value, 0) }}
                                @else
                                    {{$addon->value}}
                                @endif
                            @elseif($addon->type === 'counter')
                                @if($addon->step)
                                    ${{ number_format($addon->value * $addon->step, 0) }}
                                @else
                                    ${{ number_format($addon->value, 0) }}
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach

                    <!-- Total -->
                    <tr>
                        <td style="border-bottom: 2px solid #E8E8E8; padding-top: 8px; padding-right: 10px; text-align: right;font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px;">
                            <strong style="margin-bottom: 10px; display: block;">Sub Total:</strong>
                            {{-- <strong style="margin-bottom: 10px; display: block;">VAT 5%:</strong> --}}
                            <strong style="margin-bottom: 10px; display: block;">Discount:</strong>
                        </td>

                        <td style="border-bottom: 2px solid #E8E8E8; padding-top: 8px; padding-right: 10px; text-align: right;font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px;">
                            <strong style="margin-bottom: 10px; display: block;">${{ $booking->amount }}</strong>
                            {{-- <strong style="margin-bottom: 10px; display: block;">${{ $booking->amount - ($booking->amount * (5/100))}}</strong> --}}
                            {{-- <strong style="margin-bottom: 10px; display: block;">${{ $booking->amount * (5/100)}}</strong> --}}
                            <strong style="margin-bottom: 10px; display: block;">$0</strong>
                        </td>
                    </tr>

                    <tr>
                        <td style="border-bottom: 2px solid #E8E8E8; padding-top: 8px; padding-right: 10px; text-align: right;font-family: 'Figtree', 'Arial', sans-serif;font-size: 16px;">
                            <strong style="margin-bottom: 10px; display: block;">Grand Total:</strong>
                        </td>

                        <td style="border-bottom: 2px solid #E8E8E8; padding-top: 8px; padding-right: 10px; text-align: right;font-family: 'Figtree', 'Arial', sans-serif;font-size: 16px;">
                            <strong style="margin-bottom: 10px; display: block;">${{ number_format($booking->amount, 0) }}</strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
            
        <tr>
            <td colspan="2">
                <table style="width: 100%;">

                    <tr>
                        <td width="50%" style="padding: 20px; font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px; background: #DEDEDE">
                            <strong>Payment Method</strong> <br><br>
                            WIO Bank P.J.S.C <br>
                            Account holder: Ship 247 for logistic <br>
                            services - Sole Proprietorship L.L.C. <br>
                            IBAN: AE440860000009899702975 <br>
                            Bic: WIOBAEADXXX <br>
                            Currency: USD
                        </td>

                        <td width="50%" style="padding: 20px; font-family: 'Figtree', 'Arial', sans-serif;font-size: 14px; text-align: right;">
                            {{-- <img src="{{ asset('/images/invoice-stamp.jpeg') }}" alt="Ship247 Logo" width="200px" style="width: 200px;" /> --}}
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/images/invoice-stamp.jpeg'))) }}" width="200px" style="width: 200px;">
                            <strong style="margin-top: 10px; display: block;">THANKS FOR YOUR BUSINESS!</strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <p style="margin: 0; padding: 30px 0 0; font-family: 'Figtree', 'Arial', sans-serif; font-size: 12px;">
                    <strong style="font-size: 18px;">TERMS AND CONDITIONS</strong> <br>
                    1. The charges for the Services (“Charges”) are as per individual quotations for the relevant Services issued and provided by SHIP 247 , and agreed with each Customer from case to case. <br><br>
                    2. All Charges are payable in accordance with invoice terms. Any credit is granted subject to the STC or separate terms.
                    <br><br>3. SHIP 247 or its Group may invoice Charges to Customer, or the relevant company in Customer's Group, where agreed.
                    <br><br>4. Any third party costs incurred as a result of the Services are to be paid by Customer as per invoice. These are costs which are incurred
                    by SHIP 247 with 3rd parties (e.g. terminals, customs authorities etc.) which are outside of SHIP 247 ' control and are paid
                    incidentall y to the services. Third party costs are not fixed.
                    <br><br>5. Unless otherwise specified in additional agreement to this Agreement, SHIP 247 has the option to increase the Charges from time to
                    time during any Rates Period due to any unforeseen increase in the charges of its SHIP 247 , or due to adverse market conditions or
                    any Event of Force Majeure. SHIP 247 shall use all reasonable endeavours to liaise with and give advance notice to Customer of any
                    such increase or anticipated increase.
                    <br><br>6. In case of violation by the Customer of the due date payment for agreed Charges (both, advance or post payment) to the Services,
                    the Customer shall pay a fine in the size of 1% (one percent) on the amount of due payment for each day of delay. In case of delay in
                    payment more then 30 (thirty) days the size of fine will up to 10% (ten percent) on the amount of due payment for each day of delay.
                    <br><br>7. Without dispute the Customer compensates all Charges, actually borne by SHIP 247 at execution and implementation of the
                    Customer`s Application. SHIP 247 reserves the right to demand and impose fines and fees (Booking cancellation fee, Late payment
                    fee in favour to shipping lines and other NVOCC, non-giving of the Goods to shipment, downtime of vehicles, etc.) according to
                    tariffs from appropriate service providers and the Customer is obliged to reimburse all appropriate fines that have been imposed to
                    SHIP 247 by engaged third parties (service providers).
                </p>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <table style="width: 100%; margin-top: 20px">
                    <tr>
                        <td>
                            
                            <p style="margin: 0; padding: 0; font-family: 'Figtree', 'Arial', sans-serif; font-size: 12px;">
                                
                                8. Hereby Customer declares and guarantees that in case of abandonment / non-claim of the cargo by Customer, as well as by the
                                consignee that will be indicated by Customer in Application / Order to shipment / Booking note / Purchase order and/or in
                                appropriate shipping document (B/L, Sea Waybill, etc.) as consignee in the port or terminal of arrival/destination, Customer will
                                unconditionally compensate and reimburse SHIP 247 for all additional costs, charges and fines actually incurred by SHIP 247 to
                                favor of the shipping line or other carrier, customs, port administration and any other engaged third party and state authorities,
                                including in the case of brining by the shipping line, as well as other above-mentioned engaged parties and state authorities, any
                                claims and suits against SHIP 247 for compensation of all costs, charges and fines associated with the storage, seizure, sale off and/or
                                any other disposal of abandoned / unclaimed cargoes, and made in accordance with local rules and any other relevant international
                                convention that are applied.
                                <br><br>9. In case of breach cl. 3.8, Customer undertakes hold harmless SHIP 247 and to indemnify SHIP 247 any damage, and assume solely all
                                and any liability, possible fines and compensation for expenses and damages that may be sued from any state authorities and other
                                authorized bodies for violating the rules and legislation in the field of delivery, transshipping, storage, utilization and customs
                                procedures under transportation of cargoes.
                                <br><br>    10. DISCLAIMER: <br>
                                Hereby SHIP 247 as a freight forwarder and provider the ocean, land and/or air transportation booking services declares and
                                confirms that Base Freight Rates (BAS), storage rates and any fines, as well as any surcharges, fee and charges thereon, are produced
                                and quoted by the respective origin service providers, such as: shipping lines, other sea carriers incl. NVOCC, stevedoring and
                                terminal companies, port administrations and/or local authorities, etc. Based on this, SHIP 247 does not bear any responsibility for
                                the addition by service providers any surcharges, fees and charges to BAS, other services and penalties to any other fees and
                                surcharges, changes in the rates of any fees, surcharges, cost of storage and fines, including Base Rate, initiated by providers of
                                appropriate services, and SHIP 247 will not be liable for absorbing such costs and all of above mentioned is for client/vendor's
                                account, namely, but not exclusively: BAF (Bunker Adjustment Factor), CAF (Currency Adjustment Factor), Congestion Surcharge,
                                CUC (Chassis Using Charge), DDF (Documentation Fee - Destination), Demurrage (Demurrage), Detention (Detention), DOCS
                                (documentation), DocsFee, EBS (Emergency Bunker Surcharge), DTHC (from Destination Terminal Handling Charge), GRI (General
                                Rate Surcharge), GAC (Gulf of Aden Surcharge) , HWS (Heavy-Weight Surcharge, similar to OWS - Over-Weight Surcharge), Heavy Lift
                                Charge, IMO Surcharge, ISPS (The International Ship and Port Facility Security Code fee), ODF (Documentation Fee - Origin), PCS
                                (Panama Channel Surcharge), PSS (Peak Season Surcharge), PSE (Port Security Charge - Export), PCS (Port Congestion Surcharge),
                                SEC (security charges), Storage, SCS (Suez Channel Surcharge), WarRisk and War Risk Surcharge, Wharfage, WSC (Winter Surcharge),
                                D&D, reefer plugin, liftgate fee, etc. <br><br>
                                In case the service providers (third parties) impose and submit for payment the above fees and charges (with the provision of
                                supporting documents), the Customer is indisputably obliged to pay them at the first request of SHIP 247 within 3 (three) working
                                days. In case of non-payment or late payment of the above fees and charges, SHIP 247 reserves the right to suspend the provision of
                                services or refuse at all without compensating for any losses to the Customer, as well as to demand the payment of appropriate fines
                                that may be applied to SHIP 247 by service providers for non-payment of the above fees and charges.
                                <br><br>11. All payments to SHIP 247 shall be made to the account that indicated below, or such other account as SHIP 247 may nominate from
                                time to time.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
</div>
</body>
</html>
