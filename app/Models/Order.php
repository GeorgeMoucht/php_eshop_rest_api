<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * id
 * customer_id
 * order_date
 * shipped_date
 * status
 * comments
 */

class Order extends Model
{
    use HasFactory;

    protected array $dates = ['order_date', 'shipped_date'];
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'comments',
        'status',
        'order_date',
        'shipped_date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }


    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetails::class);
    }
}
