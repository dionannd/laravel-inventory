<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Finance;

class Income extends Model
{
    protected $guarded = [];

    public function finance()
    {
        return $this->belongsTo(Finance::class, 'finance_id', 'id');
    }
}
