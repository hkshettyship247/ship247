<style>
    .invoice-table {
        width: 100% !important;
        border-collapse: collapse;
        margin-top: 0 !important;
    }

    .invoice-table th,
    .invoice-table td {
        border: 1px solid #E8E8E8;
        padding: 8px;
        font-family: 'Figtree', 'Arial', sans-serif;
        font-size: 14px;
        text-align: right;
    }

    .invoice-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .invoice-total td {
        border-top: 2px solid #E8E8E8;
        font-weight: bold;
    }

    .invoice-grand-total td {
        border-top: 2px solid #E8E8E8;
        font-weight: bold;
        font-size: 16px;
    }
</style>

<table class="invoice-table">
    <thead>
        <tr>
            <th>Description</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        @if($booking->is_checked_basic_ocean_freight == "Y")
        <tr>
            <td>Ocean Freight</td>
            <td>${{ number_format($booking->basic_ocean_freight, 0) }}</td>
        </tr>
        @endif

        @if($booking->is_checked_pickup_charges == "Y")
        <tr>
            <td>Pickup Charges</td>
            <td>{{ $booking->pickup_charges > 0 ? 'USD '. number_format($booking->pickup_charges, 0) : "AMOUNT WILL BE SHARED LATER" }}</td>
        </tr>
        @endif

        @if($booking->is_checked_origin_charges == "Y")
        <tr>
            <td>Origin Charges</td>
            <td>${{ number_format($booking->origin_charges, 0) }}</td>
        </tr>
        @endif

        @if($booking->is_checked_destination_charges == "Y")
        <tr>
            <td>Destination Charges</td>
            <td>${{ number_format($booking->destination_charges, 0) }}</td>
        </tr>
        @endif

        @if($booking->is_checked_delivery_charges == "Y")
        <tr>
            <td>Delivery Charges</td>
            <td>{{ $booking->delivery_charges > 0 ? 'USD '. number_format($booking->delivery_charges, 0)  :  "AMOUNT WILL BE SHARED LATER"}}</td>
        </tr>
        @endif

        @php($i= 2)
        @foreach($booking->addons as $addon)
        <tr>
            <td>
                {{$addon->name == "Additional Container Free Time at POD" ? $addon->name . ' ' . $addon->value . " days" : $addon->name}}
            </td>

            <td>
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
        <tr class="invoice-total">
            <td>
                <strong>Sub Total:</strong><br>
                <strong>Discount:</strong>
            </td>
            <td>
                <strong>${{ $booking->amount }}</strong><br>
                <strong>$0</strong>
            </td>
        </tr>

        <tr class="invoice-grand-total">
            <td>
                <strong>Grand Total:</strong>
            </td>
            <td>
                <strong>${{ number_format($booking->amount, 0) }}</strong>
            </td>
        </tr>
    </tbody>
</table>
