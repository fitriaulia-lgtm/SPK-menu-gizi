<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $table = 'criterias';

    protected $fillable = ['code', 'name', 'attribute'];

    public function alternativeValues()
    {
        return $this->hasMany(AlternativeValue::class, 'criteria_id');
    }
}
