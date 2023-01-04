<?php

namespace Database\Seeders;

use App\Models\FederalEntity;
use App\Models\Municipality;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipalitySeeder extends Seeder
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
            $arrayCM = [];
            $arrayDM = [];
            $arrayFE = [];
            foreach($phpArray['table'] as $cpData){
                if(in_array($cpData['D_mnpio'], $arrayDM) == false || (in_array($cpData['D_mnpio'], $arrayDM) == true 
                 && in_array($cpData['c_mnpio'], $arrayCM) == false || (in_array($cpData['D_mnpio'], $arrayDM) == true 
                 && in_array($cpData['c_mnpio'], $arrayCM) == true && in_array($cpData['c_estado'], $arrayFE) == false))){
                    Municipality::create(array(
                        'name' => $cpData['D_mnpio'],
                        'code' => $cpData['c_mnpio'],
                        'fe_id' => FederalEntity::where('code', $cpData['c_estado'])->first()->id
                    ));
                    array_push($arrayCM, $cpData['c_mnpio']); 
                    array_push($arrayDM, $cpData['D_mnpio']); 
                    array_push($arrayFE, $cpData['c_estado']);
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}
