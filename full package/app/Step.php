<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use Auditable;
    public function cycle() {
       return $this->belongsTo(Cycle::class);
   }
   public function fields()
   {
       return ( $this->belongsToMany('App\Field', 'form_fields')->withPivot('id', 'options'));
   }

    protected $casts = ['from'  => 'date:Y-m-d', 'to' => 'date:Y-m-d',];
}
