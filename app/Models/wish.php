<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wish extends Model
{
    use HasFactory;

    // product relation
    function rel_to_prodact(){
        return $this->belongsTo(prodact::class, 'prodact_id');
    }

    
}
