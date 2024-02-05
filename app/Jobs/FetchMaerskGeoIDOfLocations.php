<?php

namespace App\Jobs;

use App\Models\Location;
use App\Services\MaerskAPI;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchMaerskGeoIDOfLocations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Location $location,
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = MaerskAPI::getLocationByUNLocCode($this->location->code);
        if ($response['success'] && isset($response['data'][0])) {
            if (is_array($response['data'][0])) {
                foreach ($response['data'][0] as $_location) {
                    if ($_location->UNLocationCode === $this->location->code) {
                        $this->updateLocationMaerskGeoId($this->location, $_location);
                    }
                }
            } else {
                $this->updateLocationMaerskGeoId($this->location, $response['data'][0]);
            }

            Log::debug('Found for ' . $this->location->fullname);
        } else {
            Log::debug('Not Found for ' . $this->location->fullname);
        }
    }

    protected function updateLocationMaerskGeoId(Location $location, $api_response)
    {
        $location->city = $api_response->cityName;
        $location->maersk_geo_id = $api_response->carrierGeoID;
        $location->save();
    }
}
