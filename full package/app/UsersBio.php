<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersBio extends Model
{
    protected $table = 'users_bio';
    protected $fillable = ['bio_ar','bio_en',];
}
