<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class card extends Model
{

    use HasFactory;

    protected $guarded = ['id'];

    // relation to prodact
    function rel_to_prodact(){
        return $this->belongsTo(prodact::class, 'prodact_id');
    }

    // relation to color
    function rel_to_color(){
        return $this->belongsTo(color::class, 'color_id');
    }

    // relation to size
    function rel_to_size(){
        return $this->belongsTo(size::class, 'size_id');
    }

}
