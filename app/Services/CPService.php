<?php

namespace App\Services;

use Exception;
use stdClass;
use App\Models\PostalCode;

class CPService {

    public function __construct()
    {
        
    }

     /**
     * Function for return the data without model class and database
     *
     * @param Request $request
     * @since  1.0
     * @author Yasser Azán 
     *
     * @return array
     */
    public function cp (int $cp): array{
        try {
            $xmlString = file_get_contents(public_path('CPdescarga.xml'));
            $xmlObject = @simplexml_load_string($xmlString);
            $json = json_encode($xmlObject);
            $phpArray = json_decode($json, true);
            $objectCP = new stdClass;
            $objectCP-> zip_code  = '';
            $objectCP-> locality = '';
            $objectCP-> federal_entity = null;
            $objectCP->settlements = [];
            $objectCP-> municipality = null;
            $flag = false;
            $count = 0;
            foreach($phpArray['table'] as $cpData){
                if($cp == $cpData['d_codigo']){
                    $flag = true;
                    if($count == 0){
                        $count++;
                        $objectFE = new stdClass;
                        $objectFE-> key =  intval($cpData['c_estado']);
                        $objectFE-> name = strtoupper($this->removeAccents($cpData['d_estado']));
                        $objectFE-> code = null;

                        $objectM = new stdClass;
                        $objectM->key = intval($cpData['c_mnpio']);
                        $objectM->name = strtoupper($this->removeAccents($cpData['D_mnpio']));
                        
                        $objectCP-> zip_code  = $cpData['d_codigo'];
                        $objectCP-> locality = strtoupper($this->removeAccents($cpData['d_ciudad']));
                        $objectCP-> federal_entity = $objectFE;
                        $objectCP-> municipality = $objectM;
                    }
                    $objectST = new stdClass;
                    $objectST-> name = $cpData['d_tipo_asenta'];
                    $objectS = new stdClass;
                    $objectS->key = intval($cpData['id_asenta_cpcons']);
                    $objectS->name = strtoupper($this->removeAccents($cpData['d_asenta']));
                    $objectS->zone_type = strtoupper($this->removeAccents($cpData['d_zona']));
                    $objectS->settlement_type =  $objectST;
                    array_push($objectCP->settlements, $objectS) ;
                }
            } 
            if($flag){
                return get_object_vars($objectCP);
            }
            return ['Not found postal code'];
        } catch (Exception $e) {
            throw $e;
        }
        return [];
    }

    /**
     * Function for return the data with model class and database
     *
     * @param string $cp is the zip_code
     * @since  1.0
     * @author Yasser Azán 
     *
     * @return array
     */
    public function cp2 (string $cp): array{
        try {
            $postalCode = PostalCode::where('zip_code', $cp)->first();
            if($postalCode != null){
                return  $this->StandarOutPut($postalCode->postalcode);
            }
        } catch (Exception $e) {
            throw $e;
        }
        return ['Not found postal code'];
    }

    /**
     * Function for return the data with staddarized format
     *
     * @param array $cp
     * @since  1.0
     * @author Yasser Azán 
     *
     * @return array
     */
    public function StandarOutPut (array $cp){
        $cp['locality'] = strtoupper($this->removeAccents($cp['locality']));
        $cp['federal_entity']->name= strtoupper($this->removeAccents($cp['federal_entity']->name));
        return $cp;
    }

    /**
     * Function for return the data with staddarized format
     *
     * @param string $letters is one string
     * @since  1.0
     * @author Yasser Azán 
     *
     * @return string
     */
    public function removeAccents ($letters): string {
        $notPermits= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
        $permits= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
        $letters = str_replace($notPermits, $permits ,$letters);
        return $letters;
        }
}