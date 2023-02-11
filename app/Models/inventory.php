<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inventory extends Model
{
    use HasFactory;

    // inventry to prodact relation
    function rel_to_prodact(){
        return $this->belongsTo(prodact::class, 'prodact_id');
    }
    // inventry to color relation
    function rel_to_color(){
        return $this->belongsTo(color::class, 'color_id');
    }
    // inventry to size relation
    function rel_to_size(){
        return $this->belongsTo(size::class, 'size_id');
    }
}
