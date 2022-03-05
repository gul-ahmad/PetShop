<?php

namespace App\Models;

use App\Core\HelperFunction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Brand extends Model
{
  use HasFactory,Sluggable;

    protected $fillable = ['title','slug','uuid'];

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

      public function sluggable(): array
      {
          return [
              'slug' => [
                  'source' => 'title'
              ]
          ];
      }
}
