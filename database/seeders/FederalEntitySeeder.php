<?php

namespace Database\Seeders;

use App\Models\FederalEntity;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FederalEntitySeeder extends Seeder
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
            $arrayCEstate = [];
            foreach($phpArray['table'] as $cpData){
                if(in_array($cpData['c_estado'], $arrayCEstate) == false){
                    FederalEntity::create(array(
                        'name' => $cpData['d_estado'],
                        'code' => $cpData['c_estado']
                    ));
                    array_push($arrayCEstate, $cpData['c_estado']); 
                }
            } 
        } catch (Exception $e) {
            throw $e;
        }
    }
}
