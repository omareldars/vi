<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formfield extends Model
{
    public function step () {
        return $this->belongsTo(Step::class);
    }
    protected $table ='form_fields';

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }
}
