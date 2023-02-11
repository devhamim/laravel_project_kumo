<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    function rel_to_customer(){
        return $this->belongsTo(customerLogin::class, 'customer_id');
    }
    function rel_to_orderproduct(){
        return $this->belongsTo(orderproduct::class, 'customer_id');
    }
}
