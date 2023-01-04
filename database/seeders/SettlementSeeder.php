<?php

namespace Database\Seeders;

use App\Models\Municipality;
use App\Models\Settlement;
use App\Models\SettlementType;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettlementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $xmlString = file_get_contents(public_path('CPdescarga.xml'));
            $xmlObject = @simplexml_load_string($xmlString);
            $json = json_encode($xmlObject);
            $phpArray = json_decode($json, true);           
            $arrayS = [];
            $arrayCM = [];
            $arrayFE = [];
            foreach($phpArray['table'] as $cpData){
                if(in_array($cpData['d_asenta'], $arrayS) == false || (in_array($cpData['d_asenta'], $arrayS) == true 
                && in_array($cpData['c_mnpio'], $arrayCM) == false) || (in_array($cpData['d_asenta'], $arrayS) == true 
                && in_array($cpData['c_mnpio'], $arrayCM) == true && in_array($cpData['c_estado'], $arrayFE) == false)){
                    Settlement::create(array(
                        'name' => $cpData['d_asenta'],
                        'zone_type' => $cpData['d_zona'],
                        'settlement_type' => SettlementType::where('name', $cpData['d_tipo_asenta'])->first()->id,
                        'm_id' => Municipality::where('name', $cpData['D_mnpio'])->first()->id

                    ));
                    array_push($arrayS, $cpData['d_asenta']); 
                    array_push($arrayCM, $cpData['c_mnpio']); 
                    array_push($arrayFE, $cpData['c_estado']); 
                }
            } 
        } catch (Exception $e) {
            throw $e;
        }
    }
}
