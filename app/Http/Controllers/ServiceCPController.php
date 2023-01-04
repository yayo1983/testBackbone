<?php

namespace App\Http\Controllers;

use App\Services\CPService;

class ServiceCPController extends Controller
{ 
    
    protected CPService $serviceCP;

    public function __construct()
    {
        $this->serviceCP = new CPService();
    }
    
    /**
     * Call the service for return the data for 
     *
     * @param Request $request
     * @since  1.0
     * @author Yasser Azán 
     *
     * @return array
     */
    public function serviceCP(string  $cp=""):array{
        if(is_string($cp) && $cp !=""){
            return $this->serviceCP->cp2($cp);
            }
        return ['not valid postal code'];
    }
}
