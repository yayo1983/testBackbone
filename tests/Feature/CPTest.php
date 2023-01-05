<?php

namespace Tests\Feature;

use App\Models\FederalEntity;
use App\Models\Municipality;
use App\Services\CPService;
use Tests\TestCase;

class CPTest extends TestCase
{ 

    /**
     * Check the federal entity code.
     *
     * @return void
     */
    public function test_federalEntityCode()
    {
        $fe = FederalEntity::where('name', 'Aguascalientes')->first();
        $this->assertEquals("01", $fe->code);
    }

    /**
     * Check the municipality
     *
     * @return void
     */
    public function test_MunicipalityCode()
    {
        $m = Municipality::where('name', 'Aguascalientes')->first();
        $this->assertEquals("001", $m->code);
    }

    /**
     * Check the municipality
     *
     * @return void
     */
    public function test_MunicipalityState()
    {
        $m = Municipality::where('name', 'Aguascalientes')->first();
        $state = FederalEntity::where('name', 'Aguascalientes')->first();
        $this->assertEquals($state->id, $m->fe_id);
    }
    
    
    /**
     * Check the federal entity in the table code postal.
     *
     * @return void
     */
    public function test_federalEntityName()
    {
        $serviceCP = new CPService();
        $result = $serviceCP->cp2("76000");
        $this->assertEquals($result['federal_entity']->name, "QUERETARO");
    }
}
