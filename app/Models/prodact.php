<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prodact extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    // relation to subcategory
    function rel_to_subcategory(){
        return $this->belongsTo(subcatagory::class, 'subcatagory_id');
    }

    // relation to subcategory
    function rel_to_category(){
        return $this->belongsTo(catagory::class, 'catagory_id');
    }
    // relation to inventore
    function rel_to_inventore(){
        return $this->hasMany(inventory::class, 'prodact_id');
    }

}
