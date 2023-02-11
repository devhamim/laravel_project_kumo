<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class catagory extends Model
{
    use HasFactory;
    use SoftDeletes;

protected $guarded = ['id'];
// protected $fillable =['catagory_img'];

    function relation_to_user(){
        return $this->belongsTo(User::class,'addad_by');
    }
}
