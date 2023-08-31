<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'number',
        'total_price',
        'payment_type',
        'payment_url',
        'payment_status',
        'delivery_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class)
            ->select('id', 'order_id', 'product_id', 'quantity');
    }
}
