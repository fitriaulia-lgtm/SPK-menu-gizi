<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AlternativeValue;

class Alternative extends Model
{
    protected $table = 'alternatives';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'code', 'name', 'score'
    ];

    public $timestamps = false;

    public function alternativeValues()
    {
        return $this->hasMany(AlternativeValue::class, 'alternative_id');
    }
}
