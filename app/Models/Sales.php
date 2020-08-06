<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $guarded = [];
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function finance()
    {
        return $this->belongsTo(Finance::class, 'finance_id', 'id');
    }
}
