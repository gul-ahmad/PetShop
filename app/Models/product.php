<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Core\HelperFunction;

class Product extends Model
{
    use HasFactory;

      protected $guarded = ['id'];

      protected $fillable = ['category_uuid','uuid','title','price','description','meta'];
      
      protected $casts = [
        'metadata' => 'array' // save  as a json column
     ];

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


        return $this->belongsTo(Category::class,'category_uuid','uuid');

       }











}
