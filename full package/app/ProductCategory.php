<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class ProductCategory extends Model{

    protected $fillable = ['name_en', 'name_ar', 'img', 'user_id'];

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function products(){
        return $this->hasMany(Product::class, 'cat_id');
     }
}
