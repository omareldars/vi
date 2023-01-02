<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $table = 'service_categories';
    protected $fillable = ['id', 'name_en', 'name_ar'];

    public function services(){
        return $this->hasMany(Service::class, 'service_category_id');
     }
}
