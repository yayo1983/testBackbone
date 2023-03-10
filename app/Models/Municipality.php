<?php

namespace App\Models;

use App\Services\CPService;
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
        $objectM->key = intval($this->code);
        $cpService = new CPService();
        $objectM->name = strtoupper($cpService->removeAccents($this->name));
        return $objectM;
    }
}
