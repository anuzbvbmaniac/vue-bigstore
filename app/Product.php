<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
    use SoftDeletes;

    protected $primaryKey = 'productId';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'units', 'description', 'image'
    ];

    /**
     * @return HasMany
     */
    public function orders() {
        return $this->hasMany(Order::class);
    }
}
