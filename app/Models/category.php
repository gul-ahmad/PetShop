<?php

namespace App\Models;

use App\Core\HelperFunction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
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



    public function products(){

       return $this->hasMany(Product::class,'uuid','category_uuid');

    }
}