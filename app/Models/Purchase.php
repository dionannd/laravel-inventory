<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function finance()
    {
        return $this->belongsTo(Finance::class, 'finance_id', 'id');
    }

    public function loss()
    {
        return $this->hasOne(Loss::class);
    }
}
