<?php

namespace App\Services;

use App\Models\Location;
use Carbon\Carbon;
use App\Http\Traits\RequestApi;
use Illuminate\Support\Facades\Http;
use App\Http\Interfaces\APIProcessRequest;
use Illuminate\Support\Facades\Log;

class MaerskAPI implements APIProcessRequest
{
    use RequestApi;

    protected const ROOT_URL = 'https://api.maersk.com';

    public static function processRequest($url)
    {
        return Http::withHeaders(['Consumer-Key' => env('MAERSK_API_KEY')])->get($url);
    }

    public static function getLocationsByCity($city)
    {
        $url = self::ROOT_URL . "/reference-data/locations?locationType=CITY";
        $url .= "&cityName={$city}&vesselOperatorCarrierCode=MAEU";
        $url .= "&sort=countryName,cityName&limit=25";

        return self::sendRequest($url);
    }

    public static function getPointToPointSchedules($origin_code, $origin_name, $origin_geolocation_id,
                                                    $destination_code, $destination_name, $destination_geolocation_id,
                                                    $container_size, $departure_date)
    {
        $cargo_type = str_contains($container_size, 'R') ? 'REEF' : 'DRY';
        $url = self::ROOT_URL . "/products/ocean-products";
        $url .= "?carrierCollectionOriginGeoID={$origin_geolocation_id}&carrierDeliveryDestinationGeoID={$destination_geolocation_id}";
        $url .= "&vesselOperatorCarrierCode=MAEU&cargoType={$cargo_type}&ISOEquipmentCode={$container_size}&stuffingWeight=18000";
        $url .= "&weightMeasurementUnit=KGS&stuffingVolume=10&volumeMeasurementUnit=MTQ&exportServiceMode=CY";
        $url .= "&importServiceMode=CY&startDate={$departure_date}&startDateType=D&dateRange=P4W";
        $url .= "&sort=countryName,cityName&limit=25";

        $response = self::sendRequest($url, self::RESPONSE_TYPE_PHP);

        $return_data = [
            'success' => false,
            'data' => [],
        ];

        if (!isset($response['data'])) {
            return $return_data;
        }

        if (isset($response['success']) && $response['success']) {
            $maersk_filtered_data = [];
            foreach ($response['data'][0]->oceanProducts[0]->transportSchedules as $data) {
                $departure_date = Carbon::parse($data->departureDateTime);
                $arrival_date = Carbon::parse($data->arrivalDateTime);
                $valid_till = Carbon::parse($data->departureDateTime)->subDays(2);
                $voyage_number = "";
                if (isset($data->transportLegs[0], $data->transportLegs[0]->transport,
                    $data->transportLegs[0]->transport->carrierDepartureVoyageNumber)) {
                    $voyage_number = $data->transportLegs[0]->transport->carrierDepartureVoyageNumber;
                }
                $maersk_filtered_data[] = [
                    'company_id' => env('MAERSK_COMPANY_ID'),
                    'company_name' => 'Maersk',
                    'origin_code' => $origin_code,
                    'origin_name' => $origin_name,
                    'destination_code' => $destination_code,
                    'destination_name' => $destination_name,
                    'etd' => $departure_date->format('Y-m-d'),
                    'eta' => $arrival_date->format('Y-m-d'),
                    'valid_till' => $valid_till->format('Y-m-d'),
                    'tt' => round($data->transitTime / 1440),
                    'voyage_number' => $voyage_number,
                ];
            }

            $return_data = [
                'success' => true,
                'data' => $maersk_filtered_data,
            ];
        }

        return $return_data;
    }

    public static function getLocationByUNLocCode($code)
    {
        $url = self::ROOT_URL . "/reference-data/locations?locationType=CITY";
        $url .= "&UNLocationCode={$code}&vesselOperatorCarrierCode=MAEU";
        $url .= "&sort=cityName&limit=25";

        return self::sendRequest($url, self::RESPONSE_TYPE_PHP);
    }

    public static function scrapePriceByOriginDestination($origin, $destination, $container_size, $departure_date)
    {
        $url = env('MAERSK_PRICE_SCRAPE_API_ENDPOINT');
        $url .= "?origin={$origin}";
        $url .= "&destination={$destination}";
        $url .= "&container_type={$container_size}";
        $url .= "&date={$departure_date}";

        return self::sendRequest($url, self::RESPONSE_TYPE_PHP);
    }

    public static function getPointToPointSchedulesWithPricing(Location $origin, Location $destination, $container_size, $departure_date)
    {
        $origin_param = $origin->city ? $origin->city . ', ' . $origin->country->name : $origin->port . ', ' . $origin->country->name;
        $destination_param = $destination->city ? $destination->city . ', ' . $destination->country->name : $destination->port . ', ' . $destination->country->name;

        $url = env('MAERSK_PRICE_SCRAPE_API_ENDPOINT');
        $url .= "?origin={$origin_param}";
        $url .= "&destination={$destination_param}";
        $url .= "&container_type={$container_size}";
        $url .= "&date={$departure_date}";

        $response = self::sendRequest($url, self::RESPONSE_TYPE_PHP, true);

        $return_data = [
            'success' => false,
            'data' => [],
        ];

        if (!isset($response['data'])) {
            return $return_data;
        }

        $decoded_data = json_decode($response['data']);

        if ($decoded_data->data->status === 'failed') {
            return $return_data;
        }

        $maersk_filtered_data = [];

        foreach ($decoded_data->data->schedules as $data) {
            $maersk_filtered_data[] = [
                'company_id' => env('MAERSK_COMPANY_ID'),
                'company_name' => "Maersk",
                'pickup_name' => $origin->shortname,
                'origin_code' => $origin->code,
                'destination_code' => $destination->code,
                'delivery_name' => $destination->shortname,
                'etd' => $data->departure_date,
                'eta' => $data->arrival_date,
                'valid_till' => Carbon::parse($data->departure_date)->subDays(2)->format('Y-m-d'),
                'tt' => Carbon::parse($data->departure_date)->diffInDays(Carbon::parse($data->arrival_date)),
                'price_details' => [
                    'origin_charges' => $data?->origin_charges_total_usd ?? 0,
                    'freight_charges' => $data?->freight_charges_total_usd ?? 0,
                    'destination_charges' => $data?->destination_charges_total_usd ?? 0,
                ]
            ];
        }

        $return_data = [
            'success' => true,
            'data' => $maersk_filtered_data,
        ];

        return $return_data;
    }
}
