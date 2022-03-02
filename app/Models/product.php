<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Core\HelperFunction;

class product extends Model
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











}
