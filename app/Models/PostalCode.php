<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    public function settlements()
    {
        return $this->belongsTo(Settlement::class, 's_id');
    }
    
    public function getPostalCodeAttribute(): array{
        $settlements = [];
        array_push($settlements, $this->settlements->settlement);
        $objectCP = new stdClass;
        $objectCP-> zip_code  = $this->zip_code;
        $objectCP-> locality  = $this->locality;
        $objectCP-> federal_entity = $this->settlements->municipality->federalEntity->federalentity;
        $objectCP-> settlements = $settlements;
        $objectCP-> municipality = $this->settlements->municipality->municipality;
        return get_object_vars($objectCP);
    }
}
