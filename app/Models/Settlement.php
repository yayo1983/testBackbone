<?php

namespace App\Models;

use App\Services\CPService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Settlement extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'settlements';

    protected $fillable = [
        'name', 'zone_type','settlement_type', 'id', 'm_id'
    ];

    /**
     * Get the settlement_type associated with the Settlement.
     */
    public function settlementType()
    {
        return $this->belongsTo(SettlementType::class, 'settlement_type');
    }

    /**
     * Get the   municipality that owns the Settlement.
     */
    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'm_id');
    }

    public function getSettlementAttribute(): object {
        $objectS = new stdClass;
        $objectS->key = $this->id;
        $objectS->name = strtoupper($this->name);
        $cpService = new CPService();
        $objectS->zone_type = strtoupper($cpService->removeAccents($this->zone_type));
        $objectS->settlement_type = $this->settlementType->settlementtype;
        return  $objectS;
    }
}
