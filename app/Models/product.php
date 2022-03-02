<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Core\HelperFunction;

class Product extends Model
{
    use HasFactory;

      protected $guarded = ['id'];
      //protected $fillable = ['id','name'];

      /**
       *  Boot Function
       */

      protected static function boot()
      {
          parent::boot();

          static::creating(function ($model) {

              $model->{'uuid'} = HelperFunction::_uuid();

          });
      }

       public function category(){


        return $this->hasMany(Category::class,'category_uuid','uuid');

       }











}
