<?php

namespace App\Imports;

use App\Models\Manifest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ManifestImport implements ToCollection, WithChunkReading, WithStartRow, WithValidation
{
    private float $totalDeclared = 0.0;

    public function __construct(
        protected Manifest $manifest,
        protected int $batchSize
    ){}

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection): void
    {
        $data = [];

        foreach ($collection as $row) {
            $this->setTotalDeclared($row[9]);

            $data[] = $this->transformRow($row);

            if (count($data) >= $this->batchSize) {
                $this->insertBatch($data);
                $data = [];
            }

        }

        if (!empty($data)) {
            $this->insertBatch($data);
        }
    }

    private function transformRow($row): array
    {
        return [
            'mwb' => $this->cleanData($row[0] ?? null),
            'tracking_number' => $this->cleanData($row[1] ?? null),
            'consignee' => $this->cleanData($row[2] ?? null),
            'cnne_address' => $this->cleanData($row[3] ?? null),
            'zip_code' => $this->cleanData($row[4] ?? null),
            'cnne_city_name' => $this->cleanData($row[5] ?? null),
            'cnne_state' => $this->cleanData($row[6] ?? null),
            'phone' => $this->cleanData($row[7] ?? null),
            'parcel_weight' => $this->cleanData($row[8] ?? null),
            'total_declared' => $this->cleanData($row[9] ?? null),
            'product_description' => $this->cleanData($row[10] ?? null),
            'email' => $this->cleanData($row[11] ?? null),
            'consignee_rfc' => $this->cleanData($row[12] ?? null),
            'consignee_curp' => $this->cleanData($row[13] ?? null),
            'shipper' => $this->cleanData($row[14] ?? null),
            'shipper_address' => $this->cleanData($row[15] ?? null),
            'shipper_phone' => $this->cleanData($row[16] ?? null),
            'shipper_mail' => $this->cleanData($row[17] ?? null),
            'manifest_id' => $this->manifest->id
        ];
    }

    private function insertBatch(array $data): void
    {
        DB::transaction(fn() => DB::table('manifest_contents')->insert($data));
    }

    private function cleanData($value): string|null
    {
        if (is_null($value)) {
            return null;
        }

        $value = $this->validationUTF8($value);

        $value = $this->replaceMiscodedWords($value);

        return preg_replace('/[^\\x20-\\x7EáéíóúÁÉÍÓÚñÑüÜàèìòùÀÈÌÒÙ]/u', '', $value);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        $rules = [
            '0' =>  ['required',function ($attribute,$value, $fail) {
                if (!$this->validateGuide($value)) {
                    $fail("El Manifiesto no es el correspondiente con el número de guía");
                }
            }],
            '12' => ['required'],
            '13' => ['required'],
            '16' => ['required'],
            '17' => ['required']
        ];
        for ($i = 0; $i < 20; $i++) {
            $rules["{$i}"][] = 'regex:/^[a-zA-Z0-9,.\'=\"!#\$%&\/\(\)\?\¡\'\¿\´\*\/\-\+_\{\}\[\]<>@ áéíóúÁÉÍÓÚñÑüÜàèìòùÀÈÌÒÙ:;]*$/u';
        }
        return $rules;
    }

    /**
     * @return array
     */
    public function customValidationMessages(): array
    {
        $messages= [
            '0.required' => ':attribute es obligatorio',
            '12.required' => ':attribute es obligatorio',
            '13.required' => ':attribute es obligatorio',
            '16.required' => ':attribute es obligatorio',
            '17.required' => ':attribute es obligatorio',
        ];

        for ($i = 0; $i < 20; $i++) {
            $messages["{$i}.regex"] = ":attribute Contiene caracteres no permitidos";
        }

        return $messages;
    }

    public function validationUTF8($value){
        if (mb_detect_encoding($value, 'UTF-8', true) === false) {
            return iconv('ISO-8859-1', 'UTF-8//IGNORE', $value);
        }
        return $value;
    }

    public function replaceMiscodedWords($value){
        return str_replace(
            array('Ã¡', 'Ã©', 'Ã­', 'Ã³', 'Ãº', 'Ã±', 'Ã±', 'Ã�', 'Ã‰', 'Ã�', 'Ã“', 'Ãš', 'Ã‘'),
            array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ'),
            $value
        );
    }

    public function validateGuide($value){
        return str_replace('-', '', $value) === str_replace('-', '', $this->manifest->number_guide);
    }

    public function getTotalDeclared(): float
    {
        return $this->totalDeclared;
    }

    public function setTotalDeclared(float $totalDeclared): void
    {
        $this->totalDeclared += $totalDeclared;
    }
}
