<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Role extends Model
{
    use Auditable;
    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'role_has_permissions');
    }
}
