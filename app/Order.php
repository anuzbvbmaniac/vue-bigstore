<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'orderId';

    protected $fillable = [
        'productId', 'userId', 'quantity', 'address'
    ];

    /**
     * @return BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'userId');
    }

    /**
     * @return BelongsTo
     */
    public function product() {
        return $this->belongsTo(Product::class, 'productId');
    }
}
