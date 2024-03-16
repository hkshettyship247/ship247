<?php

namespace App\Services;

use App\Http\Traits\RequestApi;
use Illuminate\Support\Facades\Http;
use App\Http\Interfaces\APIProcessRequest;
use Illuminate\Support\Facades\Log;

class MarineTrafficAPI implements APIProcessRequest
{
    use RequestApi;

    protected const ROOT_URL = 'https://services.marinetraffic.com/api';

    public static function processRequest($url)
    {
        return Http::timeout(30)->withOptions(['verify' => false])->get($url);
    }

    public static function subscribe($bl_no, $scac)
    {
        $url = self::ROOT_URL . "/vfcsubscribe/".env('MARINE_TRAFFIC_API_KEY');
        $url .= "?tdType=BL&scac=" . $scac . "&tdId=" . $bl_no;

        $response = self::sendRequest($url, self::RESPONSE_TYPE_PHP, true);

        if ( $response['success'] ) {
            $return_data = [
                'success' => true,
                'data' => json_decode($response['data']),
            ];
        }

        return $return_data;
    }

    public static function getTrackingInformation($shipment_id)
    {
        $url = self::ROOT_URL . "/vfcshipment/".env('MARINE_TRAFFIC_API_KEY');
        $url .= "?shipmentId=" . $shipment_id;

        $response = self::sendRequest($url, self::RESPONSE_TYPE_PHP, true);

        if ( $response['success'] ) {
            return [
                'success' => true,
                'data' => json_decode($response['data']),
            ];
        }

        return false;
    }
}
