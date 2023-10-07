<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'scale',
        'vendor',
        'description',
        'quantity_in_stock',
        'buy_price',
        'msrp',
    ];

    public function orderDetail(): HasOne
    {
        return $this->hasOne(OrderDetails::class);
    }

}
