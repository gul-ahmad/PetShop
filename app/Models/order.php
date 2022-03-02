<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderstatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }
    public function payments() {

        return $this->hasMany(Payment::class);

    }
}
