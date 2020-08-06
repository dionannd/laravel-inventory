<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loss extends Model
{
    protected $guarded = [];

    public function purchase()
    {
    	return $this->belongsTo(Purchase::class, 'product_id', 'id');
    }

    public function product()
    {
    	return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
