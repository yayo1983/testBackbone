<?php

namespace Database\Seeders;

use App\Models\PostalCode;
use App\Models\Settlement;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostalCodeSeeder extends Seeder
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
            $arrayPC= [];
            foreach($phpArray['table'] as $cpData){
                if(in_array($cpData['d_codigo'], $arrayPC) == false){
                   $postalCode = new PostalCode();
                   $postalCode->locality = $cpData['d_ciudad'] ?? ' ';
                   $postalCode->zip_code = $cpData['d_codigo'];
                   $postalCode->save();

                    array_push($arrayPC, $cpData['d_codigo']); 
                }
            }

        } catch (Exception $e) {
           throw $e; 
        }
    }
}
