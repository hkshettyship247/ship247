<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\ContainerSizes;
use App\Models\Location;
use App\Models\SeaSchedule;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SeaPricingsImport implements ToModel, SkipsEmptyRows, WithValidation, WithHeadingRow, SkipsOnFailure, SkipsOnError
{
    use Importable, SkipsFailures, SkipsErrors;

    public $imported_rows_count;
    protected $companies;
    protected $containerSizes;

    public function __construct()
    {
        $this->imported_rows_count = 0;
        $this->companies = Company::where('status', 2)->pluck('name', 'id')->toArray();
        $this->containerSizes = ContainerSizes::pluck('display_label', 'value')->toArray();
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $container_size = array_search($row['container_size'], $this->containerSizes);
        $company_id = array_search($row['company'], $this->companies);
        $valid_till_date = Carbon::createFromFormat('d/m/Y', $row['valid_till'])->toDateString();
        $etd_date = Carbon::createFromFormat('d/m/Y', $row['etd'])->toDateString();
        $eta_date = Carbon::createFromFormat('d/m/Y', $row['eta'])->toDateString();
        $origin_id = Location::where('code', $row['origin'])->first()->id ?? 0;
        $destination_id = Location::where('code', $row['destination'])->first()->id ?? 0;

        if ($container_size === FALSE || $company_id === FALSE || $origin_id === 0 || $destination_id === 0) {
            return null;
        }

        $this->imported_rows_count++;

        $seaSchedule = new SeaSchedule();
        $seaSchedule->origin_id = $origin_id;
        $seaSchedule->destination_id = $destination_id;
        $seaSchedule->company_id = $company_id;
        $seaSchedule->container_size = $container_size;
        $seaSchedule->pickup_charges = floatval($row['pickup_charges']);
        $seaSchedule->origin_charges = floatval($row['origin_charges'] ?? 0);
        $seaSchedule->origin_charges_included = $seaSchedule->origin_charges <= 0 ? 1 : 0;
        $seaSchedule->ocean_freight = floatval($row['ocean_freight']);
        $seaSchedule->destination_charges = floatval($row['destination_charges'] ?? 0);
        $seaSchedule->destination_charges_included = $seaSchedule->destination_charges <= 0 ? 1 : 0;
        $seaSchedule->delivery_charges = floatval($row['delivery_charges']);
        $seaSchedule->save();

        $seaSchedule->details()->create([
            'eta' => $eta_date,
            'etd' => $etd_date,
            'valid_till' => $valid_till_date,
            'tt' => intval($row['tt']),
            'ft' => intval($row['ft']),
        ]);

        return $seaSchedule;
    }

    public function rules(): array
    {
        return [
            'container_size' => 'required|string',
            'origin' => 'required|string|min:5|max:5',
            'destination' => 'required|string|min:5|max:5',
            'pickup_charges' => 'nullable|numeric',
            'origin_charges' => 'nullable|numeric',
            'ocean_freight' => 'required|numeric',
            'destination_charges' => 'nullable|numeric',
            'delivery_charges' => 'nullable|numeric',
            'company' => 'required|string',
            'tt' => 'required|numeric',
            'ft' => 'required|numeric',
            'eta' => 'required|string',
            'etd' => 'required|string',
            'valid_till' => 'required|string',
        ];
    }
}
