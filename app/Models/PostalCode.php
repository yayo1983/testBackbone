<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use stdClass;

class PostalCode  extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'postal_codes';

    protected $fillable = ['id','zip_code','locality','s_id'];

    public function __construct()
    {
        
    }

    /**
     * Get the settlements associated with the PostalCode.
     */
    public function settlements(): Relation
    {
        return $this->hasMany(Settlement::class);
    }
    
    public function getPostalCodeAttribute(): array{
        $objectCP = new stdClass;
        $objectCP-> zip_code  = $this->zip_code;
        $objectCP-> locality  = $this->locality;
        $settlements = [];
        $auxSettlements = $this->settlements()->get();  
        foreach($auxSettlements as $object){
            array_push($settlements, $object->settlement);
        }
        $objectCP-> federal_entity = $auxSettlements[0]->municipality->federalEntity->federalentity;
        $objectCP-> settlements =  $settlements;
        $objectCP-> municipality = $auxSettlements[0]->municipality->municipality;
        return get_object_vars($objectCP);
    }
}
