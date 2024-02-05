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
<body style="background-color: #F6F6F6; font-family: 'Figtree', sans-serif; font-size: 16px; margin: 0; padding: 0;">
<div style="max-width: 600px; width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; color: #000000; line-height: 1.5;">
    <table style="width: 100%;">
        <tr>
            <td style="padding-bottom: 30px; font-family: 'Figtree', sans-serif;">
                <img src="{{ asset('/images/logo.png') }}" alt="Ship247 Logo" style="width: 160px; margin: 0 auto;" />
            </td>
        </tr>

        <tr>
            <td style="font-family: 'Figtree', sans-serif;font-size: 16px;">
                <span style="font-size: 20px; margin-bottom: 10px; display: block;">Hello <strong>{{$booking->user->fullname}}</strong>, </span>
                Thank you for placing your booking with <a href="https://ship247.com" style="color: #D23C3C;">ship247.com</a> <br /><br />
                You will find your booking details below. <br /> <br />
                <a href="{{ route('customer.bookings.show', ['booking' => $booking->id]) }}">
                    <img src="{{ asset('images/email-booking-button.png') }}" alt="" style="width: 160px;" />
                </a>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-top: 4px solid #E8E8E8; margin-top: 30px">
        <tr>
            <td style="padding: 20px 0; font-family: 'Figtree', sans-serif;font-size: 16px;">
                <strong>BOOKING #{{str_pad($booking->id, 6, '0', STR_PAD_LEFT)}}</strong>
            </td>
            <td style="text-align: right; padding: 20px 0; font-family: 'Figtree', sans-serif;font-size: 16px;">
                <strong>{{$booking->created_at->format('j M Y')}}</strong>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="border-top: 1px solid #E8E8E8; padding-top: 10px; line-height: 2; font-family: 'Figtree', sans-serif;font-size: 16px;">
                <strong>POL : </strong> {{$booking->origin->fullname}} <br />
                <strong>POD : </strong> {{$booking->destination->fullname}} <br />
                <strong>TYPE : </strong>  {{$booking->container_size}} x {{$booking->no_of_containers}} <br />
                <strong>ETD : </strong>   {{  \Carbon\Carbon::parse($booking->departure_date_time)->format('d, M, Y')}} <br />
                <strong>ETA : </strong>   {{  \Carbon\Carbon::parse($booking->arrival_date_time)->format('d, M, Y')}} <br />
                <strong>PICKUP :</strong> {{$booking->is_checked_pickup_charges == "Y" ?  "Yes" : "No"}} <br />
                <strong>DELIVERY :</strong>  {{$booking->is_checked_delivery_charges == "Y" ?  "Yes" : "No"}} <br />
                <strong>TRANSPORTATION :</strong>  {{$booking->transportation}} <br />
                @foreach($booking->addons as $addon)
                    @if($addon->type === 'toggle')
                    <strong>{{strtoupper($addon->name)}} :</strong> Yes <br />
                    @endif
                @endforeach
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <table style="width: 100%; padding-top: 30px; ">
                    <tr>
                        <th style="text-align: left;border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px;font-family: 'Figtree', sans-serif;font-size: 14px;">
                            Details
                        </th>

                        <th style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px; padding-right: 10px; text-align: right;font-family: 'Figtree', sans-serif;font-size: 14px;">
                            PRICE
                        </th>
                    </tr>

                    @if($booking->is_checked_basic_ocean_freight == "Y")
                      <tr>
                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px;font-family: 'Figtree', sans-serif;font-size: 14px;">
                            Ocean Freight
                        </td>

                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px; padding-right: 10px; text-align: right;font-family: 'Figtree', sans-serif;font-size: 14px;">
                            USD {{ number_format($booking->basic_ocean_freight, 0) }}
                        </td>
                    </tr>
                    @endif
               
                    @if($booking->is_checked_pickup_charges == "Y")
                    <tr>
                
                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px;font-family: 'Figtree', sans-serif;font-size: 14px;">
                            Pickup Charges
                        </td>

                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px; padding-right: 10px; text-align: right;font-family: 'Figtree', sans-serif;font-size: 14px;">
                             {{ $booking->pickup_charges > 0 ? 'USD '. number_format($booking->pickup_charges, 0) : "AMOUNT WILL BE SHARED LATER" }}
                        </td>
                    </tr>
                    @endif
                 
                    @if($booking->is_checked_origin_charges == "Y")
                    <tr>
                      

                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px;font-family: 'Figtree', sans-serif;font-size: 14px;">
                            Origin Charges
                        </td>

                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px; padding-right: 10px; text-align: right;font-family: 'Figtree', sans-serif;font-size: 14px;">
                            USD {{ number_format($booking->origin_charges, 0) }}
                        </td>
                    </tr>
                    @endif
                  
                  
                    @if($booking->is_checked_destination_charges == "Y")
                    <tr>
                    

                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px;font-family: 'Figtree', sans-serif;font-size: 14px;">
                            Destination Charges
                        </td>

                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px; padding-right: 10px; text-align: right;font-family: 'Figtree', sans-serif;font-size: 14px;">
                            USD {{ number_format($booking->destination_charges, 0) }}
                        </td>
                    </tr>
                    @endif
          
                    @if($booking->is_checked_delivery_charges == "Y")
                    <tr>
                    

                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px;font-family: 'Figtree', sans-serif;font-size: 14px;">
                            Delivery Charges
                        </td>

                        <td style="border-bottom: 1px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px; padding-right: 10px; text-align: right;font-family: 'Figtree', sans-serif;font-size: 14px;">
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
                                    USD {{ number_format($addon->value, 0) }}
                                @else
                                    {{$addon->value}}
                                @endif
                            @elseif($addon->type === 'counter')
                                @if($addon->step)
                                    USD {{ number_format($addon->value * $addon->step, 0) }}
                                @else
                                    USD {{ number_format($addon->value, 0) }}
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach

                    <!-- Total -->
                    <tr>
                        <td colspan="3" style="border-bottom: 4px solid #E8E8E8; padding-bottom: 4px; padding-top: 4px; padding-right: 10px; text-align: right;font-family: 'Figtree', sans-serif;font-size: 14px;">
                            <strong>Total: ~USD {{ number_format($booking->amount, 0) }}</strong>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; padding-top: 10px; ">
                    <tr>
                        <td colspan="2" style="padding-top: 8px;font-family: 'Figtree', sans-serif;font-size: 14px;">
                            For any special requirements please contact <a href="mailto:INFO@SHIP247.COM" style="color: #000000; font-weight: 700;">INFO@SHIP247.COM</a>
                        </td>
                    </tr>

                    <tr>

                        <?php
                            $additionalContainerFreeTimeValue = null;

                            foreach ($booking->addons as $addon) {
                                if ($addon->name == "Additional Container Free Time at POD") {
                                    $additionalContainerFreeTimeValue = $addon->value;
                                    break; // Assuming there is only one such addon; you can remove this line if there can be multiple and you want to get the first one.
                                }
                            }
                        ?>

                        <td colspan="2" style="padding-top: 10px; color: #A8A8A8; font-size: 14px;font-family: 'Figtree', sans-serif;">
                            <strong style="display: block;">REMARKS:</strong>
                            FREE TIME PER CONTAINER: {{$additionalContainerFreeTimeValue}} DAYS (THIS IS CHANGEABLE BASED ON WHAT THEY ADD AND WHAT WE ALREADY HAVE) <br />
                            SHIP247 reserves the right to cancel any booking without prior notice. This is inclusive of but not limited to compliance with the terms and conditions. Late payment fees apply on all overdue payments. <br /><br />
                            <small>TERMS AND CONDITIONS APPLY.</small>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top: 30px;">
                            <a href="https://ship247.com" style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #000000;font-family: 'Figtree', sans-serif;">ship247.com</a>
                        </td>

                        <td style="padding-top: 30px; text-align: right;">
                            <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #000000; text-decoration: underline;font-family: 'Figtree', sans-serif;">+12-536-9963</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
