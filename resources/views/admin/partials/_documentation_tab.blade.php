{{-- <div class="p-4 rounded-lg bg-gray-50">
    <div class="detail-body">
        <p class="mt-0">
            <label for="attachment">
                <a class="btn btn-primary text-light" role="button" aria-disabled="false">+
                    Add Documents</a>
            </label>
            <input type="file" name="file[]" id="attachment" accept=".pdf, .doc, .docx, .xls, .xlsx"
                style="position: absolute;" multiple />
        </p>
        <p id="files-area">
            <span class="spinner"></span>
            <span id="filesList">
                <span id="files-names">
                    @foreach ($booking->documents ?? [] as $document)
                    <span class="file-block">
                        <span class="file-delete removeFile" bookingId="{{ $booking->id }}" docId="{{ $document->id }}">
                            <span>+</span>
                        </span>
                        <span class="name">{{ $document->filename }}</span></span>
                    @endforeach
                </span>
            </span>
        </p>
    </div>
</div> --}}

<div class="p-4 rounded-lg bg-gray-50">
    <div class="detail-body">
        <!-- Master Bill of Lading section -->
        <form action="{{ route($route. 'booking.storeDocuments') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="bookingId" value="{{ $booking->id }}">
            @if (Auth::user()->id === $booking->user_id)    
                <div class="documentation-sec">
                    <div class="col-md-12">
                        <div class="mb-4">
                            <h3>Master Bill of Lading</h3>
                            <div class="input-group">
                                <input type="file" class="form-control" name="master_bill_file" id="master_bill_attachment"
                                    accept=".pdf, .doc, .docx, .xls, .xlsx" style="position: absolute;">
                            </div>
                            
                            @if (!empty($booking->document->master_bill_lading))
                            <div class="col-md-4 mt-10">
                                <a href="{{ Storage::url('booking_documents/' . $booking->document->master_bill_lading) }}"
                                    download="{{ $booking->document->master_bill_lading }}" class="default-button-v2">
                                    Download Master Bill of Lading
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            <hr class="mb-5">
            <div class="documentation-sec">
                <div class="col-lg-3">
                    <!-- House Bill of Lading section -->
                    <div class="mb-4">
                        <h3>House Bill of Lading</h3>
                        <div class="input-group">
                            <input type="file" class="form-control" name="house_bill_file" id="house_bill_attachment" accept=".pdf, .doc, .docx, .xls, .xlsx" style="position: absolute;">
                        </div>
                        @if (!empty($booking->document->house_bill_lading))
                        <div class="col-md-4 mt-10">
                            <a href="{{ Storage::url('booking_documents/' . $booking->document->house_bill_lading) }}"
                                download="{{ $booking->document->house_bill_lading }}" class="default-button-v2">
                                Download House Bill of Lading
                             </a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3">
                    <!-- Certificate of Origin section -->
                    <div class="mb-4">
                        <h3>Certificate of Origin</h3>
                        <div class="input-group">
                            <input type="file" class="form-control" name="certificate_file" id="certificate_attachment" accept=".pdf, .doc, .docx, .xls, .xlsx" style="position: absolute;">
                        </div>
                        @if (!empty($booking->document->certificate_of_origin))
                        <div class="col-md-4 mt-10">
                            <a href="{{ Storage::url('booking_documents/' . $booking->document->certificate_of_origin) }}"
                                download="{{ $booking->document->certificate_of_origin }}" class="default-button-v2">
                                Download Certificate Of Origin
                             </a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3">
                    <!-- Commercial Invoice section -->
                    <div class="mb-4">
                        <h3>Commercial Invoice</h3>
                        <div class="input-group">
                            <input type="file" class="form-control" name="commercial_invoice_file" id="commercial_invoice_attachment" accept=".pdf, .doc, .docx, .xls, .xlsx" style="position: absolute;">
                        </div>
                        @if (!empty($booking->document->commercial_invoice))
                        <div class="col-md-4 mt-10">
                            <a href="{{ Storage::url('booking_documents/' . $booking->document->commercial_invoice) }}"
                                download="{{ $booking->document->commercial_invoice }}" class="default-button-v2">
                                Download Commercial Invoice
                             </a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3">
                    <!-- Packing List section -->
                    <div class="mb-4">
                        <h3>Packing List</h3>
                        <div class="input-group">
                            <input type="file" class="form-control" name="packing_list_file" id="packing_list_attachment" accept=".pdf, .doc, .docx, .xls, .xlsx" style="position: absolute;">
                        </div>
                        @if (!empty($booking->document->packing_list))
                        <div class="col-md-4 mt-10">
                            <a href="{{ Storage::url('booking_documents/' . $booking->document->packing_list) }}"
                                download="{{ $booking->document->packing_list }}" class="default-button-v2">
                                Download Packing List
                             </a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3">
                    <!-- Other document section -->
                    <div class="mb-4">
                        <h3>Other Document</h3>
                        <div class="input-group">
                            <input type="file" class="form-control" name="other_file" id="other_attachment"
                                accept=".pdf, .doc, .docx, .xls, .xlsx" style="position: absolute;">
                        </div>
                        @if (!empty($booking->document->other_document))
                        <div class="col-md-4 mt-10">
                            <a href="{{ Storage::url('booking_documents/' . $booking->document->other_document) }}"
                                download="{{ $booking->document->other_document }}" class="default-button-v2">
                                Download Other Document
                             </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <button type="submit" class="default-button-v2">
                <span>Submit</span>
            </button>
        </form>
    </div>
</div>