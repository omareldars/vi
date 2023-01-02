<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    use Auditable;
    protected $casts = ['start'  => 'date:Y-m-d', 'end' => 'date:Y-m-d',];

}
