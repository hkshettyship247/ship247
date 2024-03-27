<form class="space-y-6 px-6 lg:px-8 pb-4 sm:pb-6 xl:pb-8" method="post" action="{{ route($route. 'booking.party_company_address') }}">
    @csrf
    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
    <input type="hidden" name="type" value="{{ $type }}">
    <div>
        <label for="companyName" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Company Name</label>
        <input type="text" name="company_name" value="{{ !empty($partyCompanyAdress) ? $partyCompanyAdress->company_name : '' }}" id="companyName" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Enter company Name" required="">
    </div>
    <div>
        <label for="address" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Address</label>
        <input type="text" name="address" value="{{ !empty($partyCompanyAdress) ? $partyCompanyAdress->address : '' }}" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required="">
    </div>
    <button type="submit" class="default-button-v2">
        <span>{{ !empty($partyCompanyAdress) ? "Update" : 'Submit'}}</span>
    </button>
</form>