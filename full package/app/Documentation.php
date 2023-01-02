<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    protected $fillable = ['menu_ar', 'menu_en', 'arr','content_ar', 'content_en', 'role', 'icon', 'user_id'];
}
