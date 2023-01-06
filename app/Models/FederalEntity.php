<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class FederalEntity extends Model
{
    use HasFactory;

    protected $table = 'federal_entities';

    public $timestamps = false;

    protected $fillable = ['name', 'code','id'];

    public function getfederalentityAttribute(): object {
        $objectFE = new stdClass;
        $objectFE->key  = intval($this->code);
        $objectFE->name = $this->name;
        $objectFE->code = null;
        return $objectFE;
    }
}
