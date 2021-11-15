<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public function propertytype()
    {
        return $this->belongsTo('App\PropertyType');
    }
}
