<div class="p-4 rounded-lg bg-gray-50">
    <div class="detail-body">
        <p class="mt-0">
            <label for="attachment">
                <a class="btn btn-primary text-light" role="button" aria-disabled="false">+
                    Add Documents</a>
            </label>
            <input type="file" name="file[]" id="attachment"
                accept=".pdf, .doc, .docx, .xls, .xlsx" style="visibility: hidden; position: absolute;" multiple />
        </p>
        <p id="files-area">
            <span id="filesList">
                <span id="files-names">
                    @foreach ($booking->documents ?? [] as $documents)
                    <span class="file-block">
                        <span class="file-delete">
                            <span>+</span>
                        </span>
                        <span class="name">{{ $documents->filename }}</span></span>
                    @endforeach
                </span>
            </span>
        </p>
    </div>
</div>
<button id="uploadBtn" class="btn default-button-v2 btn-primary">Upload Files</button>