<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Slider extends Model
{
  use Auditable;
  protected $table = 'sliders';
}