<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Posts extends Model
{
 use Auditable;
 public function user()
     {
       return $this->belongsTo(User::class);
     }
}
