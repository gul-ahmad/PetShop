<?php

namespace App\Models;

use App\Core\HelperFunction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','order_status_id','payment_id',
    'uuid','products','address','delivery_fee','amount','shipped_at'];

    protected $casts = [
        'products' => 'array', // save  as a json column
        'address' => 'array' // save  as a json column
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderstatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }
    public function payments() {

        return $this->belongsTo(Payment::class);

    }
}
