<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Finalscreening extends Model
{
    use Auditable;
    protected $fillable = ['company_id','step_id','judges','datetime','duration','zoom_id','start_url','join_url'];
    protected $casts = ['judges' => 'array',];
    public function company()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }
}
