<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class BuilderForm extends Model
{
    use Auditable;
    protected $guarded = [];

    public function fields()
    {

        return ( $this->belongsToMany('App\Field', 'builder_fields')->withPivot('id', 'options'));

    }
}
