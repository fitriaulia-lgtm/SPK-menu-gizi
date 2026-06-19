<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    protected $fillable = ['code', 'name'];

    public function alternativeValues()
    {
        return $this->hasMany(AlternativeValue::class, 'alternative_id');
    }
}
