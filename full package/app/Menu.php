<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Menu extends Model
{
  use Auditable;
  public $timestamps = false;

  protected $table = 'menus';

  protected $fillable = array('parent_id','title','ar_title','url','target','order');

  public function parent()
  {
    return $this->belongsTo('App\Menu', 'parent_id');
  }

  public function children()
  {
    return $this->hasMany('App\Menu', 'parent_id');
  }
}
