<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    static public function getQualByCode($code)
    {
        if ($code == 'd') {
            return 'دبلوم';
        } elseif ($code == 'b') {
            return 'بكلوريوس';
        } elseif ($code == 'm') {
            return 'ماجستير';
        } else {
            return 'دكتوراه';
        }
    }
}
