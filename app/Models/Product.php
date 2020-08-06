<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function place()
    {
    	return $this->belongsTo(Place::class, 'place_id', 'id');
    }

    public function purchase()
    {
    	return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }

    public function loss()
    {
    	return $this->belongsTo(Loss::class, 'loss_id', 'id');
    }
}
