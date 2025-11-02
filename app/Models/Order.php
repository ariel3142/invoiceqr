<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function items()
{
    return $this->hasMany(OrderItem::class);
}
    use HasFactory;

    protected $fillable = [
        'buyer_name',
        'buyer_contact',
        'is_paid',
        'pickup_code',
        'pickup_status',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

}
