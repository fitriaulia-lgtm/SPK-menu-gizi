<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $table = 'criterias';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['code', 'name', 'attribute', 'weight'];

    public function alternativeValues()
    {
        return $this->hasMany(AlternativeValue::class, 'criteria_id', 'id');
    }
}
