<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [] ;

    function grade() {
      return $this->belongsTo(Grade::class) ;
    }

     function teacher() {
      return $this->belongsTo(Teacher::class) ;
    }
}
