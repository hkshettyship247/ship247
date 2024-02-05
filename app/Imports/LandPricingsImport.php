<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\ContainerSizes;
use App\Models\LandSchedule;
use App\Models\Location;
use App\Models\TruckType;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class LandPricingsImport implements ToModel, SkipsEmptyRows, WithValidation, WithHeadingRow, SkipsOnFailure, SkipsOnError
{
    use Importable, SkipsFailures, SkipsErrors;

    public $imported_rows_count;
    protected $companies;
    protected $containerSizes;
    protected $truckTypes;
    protected $axleTypes = [
        0 => 'None',
        2 => '2 Axles',
        3 => '3 Axles',
        4 => '4 Axles',
    ];

    public function __construct()
    {
        $this->imported_rows_count = 0;
        $this->companies = Company::where('status', 2)->pluck('name', 'id')->toArray();
        $this->containerSizes = ContainerSizes::pluck('display_label', 'value')->toArray();
        $this->truckTypes = TruckType::pluck('display_label', 'id')->toArray();
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $container_size_not_found = false;
        $container_size = "";

        $company_id = array_search($row['company'], $this->companies);
        $truck_type_id = array_search($row['truck_type'], $this->truckTypes);
        if (strtolower($row['truck_type']) === 'container') {
            $container_size = array_search($row['container_size'], $this->containerSizes);
            if (!$container_size) {
                $container_size_not_found = true;
            }
        }

        $axle_value = array_search($row['axle'], $this->axleTypes);
        $valid_till_date = Carbon::createFromFormat('d/m/Y', $row['validity'])->toDateString();
        $origin_id = Location::where('code', $row['pickup_point'])->first()->id ?? 0;
        $destination_id = Location::where('code', $row['delivery_point'])->first()->id ?? 0;

        if ($company_id === FALSE || $truck_type_id === FALSE || $origin_id === 0 || $destination_id === 0
            || (strtolower($row['truck_type']) === 'container' && $container_size_not_found)) {
            return null;
        }

        $this->imported_rows_count++;

        $landSchedule = new LandSchedule;
        $landSchedule->truck_type_id = $truck_type_id;
        $landSchedule->container_size = strtolower($row['truck_type']) === 'container' ? $container_size : '';
        $landSchedule->axle = $axle_value ?? 0;
        $landSchedule->max_load_in_ton = intval($row['max_load_in_ton']);
        $landSchedule->origin_id = $origin_id;
        $landSchedule->destination_id = $destination_id;
        $landSchedule->company_id = $company_id;
        $landSchedule->land_freight = floatval($row['land_freight']);
        $landSchedule->available_trucks = intval($row['available_trucks']);
        $landSchedule->tt = intval($row['transit_time']);
        $landSchedule->detention_charges_per_hour = floatval($row['detention_charges']);
        $landSchedule->valid_till = $valid_till_date;

        return $landSchedule;
    }

    public function rules(): array
    {
        return [
            'truck_type' => 'required|string',
            'container_size' => 'nullable|string',
            'axle' => 'required|string',
            'max_load_in_ton' => 'required|numeric',
            'pickup_point' => 'required|string|min:5|max:5',
            'delivery_point' => 'required|string|min:5|max:5',
            'land_freight' => 'required|numeric',
            'company' => 'required|string',
            'available_trucks' => 'required|numeric',
            'transit_time' => 'required|numeric',
            'detention_charges' => 'required|numeric',
            'validity' => 'required|string',
        ];
    }
}
