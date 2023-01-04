<?php

namespace Database\Seeders;

use App\Models\SettlementType;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettlementTypeSeeder extends Seeder
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
            $arrayST = [];
            foreach($phpArray['table'] as $cpData){
                if(in_array($cpData['d_tipo_asenta'], $arrayST) == false){
                    SettlementType::create(array(
                        'name' => $cpData['d_tipo_asenta'],
                    ));
                    array_push($arrayST, $cpData['d_tipo_asenta']); 
                }
            } 
        } catch (Exception $e) {
            throw $e;
        }
    }
}
