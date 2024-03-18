<div class="rounded-lg bg-gray-50">
    <div class="rounded-lg bg-gray-50">
        <div class="detail-box">
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">ID</span>
                        <span class="value">{{ $booking->payment->id }}</span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">BL</span>
                        <span class="value">{{ isset($track_booking_response['data']) ?
                            $track_booking_response['data']?->transportDocumentId : '-'
                            }}</span>
                    </div>
                </div>
            </div>
            <div class="w-3/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">from</span>
                        <span class="value">{{isset($booking->origin->fullname) ?
                            $booking->origin->fullname : ''}}</span>
                    </div>
                </div>
            </div>

            <div class="w-3/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">to</span>
                        <span class="value">{{isset($booking->destination->fullname) ?
                            $booking->destination->fullname : ''}}</span>
                    </div>
                </div>
            </div>

            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">amount</span>
                        <span class="value">${{ $booking->payment->amount }}</span>
                    </div>
                </div>
            </div>

            @if(empty($booking->payment))
            <div class="w-2/12">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="head">Due</span>
                        <span class="value">9 jan 2023</span>
                    </div>
                </div>
            </div>
            @endif

            <div class="w-2/12">
                <div class="flex justify-between flex-col items-end h-full">
                    <div><span class="badge progress BOOKING_STATUS_IN_PROGRESS">
                            <a href="#">{{ $booking->payment->status }}</a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex justify-between flex-col items-end h-full">
                    <div><span class="badge DOWNLOAD_IN_PROGRESS">
                            <a
                                href="{{ $booking->payment ? route($route.'generate.pdf.invoice', ['bookingID' => $booking->id]) : '#' }}">
                                Download</a>
                        </span></div>
                </div>
            </div>
            <div class="w-2/12">
                <div class="flex justify-between flex-col items-end h-full">
                    <div><span class="badge progress VIEW_IN_PROGRESS">
                            <a
                                href="{{ $booking->payment ? route($route.'payment.details', $booking->payment->id) : '#' }}">View
                                Details</a>
                        </span></div>
                </div>
            </div>
            @if(empty($booking->payment))
            <div class="w-2/12">
                <div class="flex justify-between flex-col items-end h-full">
                    <div><span class="badge progress PAY_IN_PROGRESS">
                            <a href="#">Pay</a>
                        </span></div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>