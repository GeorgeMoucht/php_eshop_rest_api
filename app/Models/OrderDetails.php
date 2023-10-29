<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderDetails extends Model
{
    use HasFactory;

    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quantity_ordered',
        'price_each',
        'order_line_number',
        'product_id',
        'order_id',
    ];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
