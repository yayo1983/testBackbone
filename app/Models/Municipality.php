<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Municipality extends Model
{
    use HasFactory;

    protected $table = 'municipalities';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'id',
        'fe_id',
        'code'
    ];

    /**
     * Get the FederalEntity that owns the Municipality.
     */
    public function federalEntity()
    {
        return $this->belongsTo(FederalEntity::class, 'fe_id');
    }

    public function getMunicipalityAttribute(): object {
        $objectM = new stdClass;
        $objectM->key = $this->id;
        $objectM->name = strtoupper($this->name);
        return $objectM;
    }
}
