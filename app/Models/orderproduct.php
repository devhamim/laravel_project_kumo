<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderproduct extends Model
{
    use HasFactory;


    // relation to product
    function rel_to_prodact(){
        return $this->belongsTo(prodact::class, 'prodact_id');
    }
    // relation to color
    function rel_to_color(){
        return $this->belongsTo(color::class, 'color_id');
    }
    // relation to product
    function rel_to_size(){
        return $this->belongsTo(size::class, 'size_id');
    }
    // relation to product
    function rel_to_customer(){
        return $this->belongsTo(customerLogin::class, 'customer_id');
    }
}
