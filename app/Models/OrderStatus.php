<?php

namespace App\Models;

use App\Core\HelperFunction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;
    protected $fillable = ['title','uuid'];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
    {
        return $this->hasone(Order::class);
    }
}
