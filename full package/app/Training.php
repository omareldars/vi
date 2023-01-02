<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
   protected $fillable = ['type', 'image', 'title', 'dsc', 'user_id',];

   function user() {
       return $this->belongsTo(User::class);
   }
}
