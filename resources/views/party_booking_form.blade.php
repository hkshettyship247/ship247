<form class="space-y-6 px-6 lg:px-8 pb-4 sm:pb-6 xl:pb-8" method="post" action="{{ route($route. 'booking.store_receiver_documents') }}">
    @csrf
    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
    <div>
        <label for="receiverName" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Receiver Name</label>
        <input type="text" name="receiverName" value="{{ !empty($partyAdress) ? $partyAdress->receiverName : '' }}" id="receiverName" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Enter Receiver Name" required="">
    </div>
    <div>
        <label for="number" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Number</label>
        <input type="number" name="number" value="{{ !empty($partyAdress) ? $partyAdress->number : '' }}" id="number" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required="">
    </div>
    <button type="submit" class="default-button-v2">
        <span>Submit</span>
    </button>
</form>