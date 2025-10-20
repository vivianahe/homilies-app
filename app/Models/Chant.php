<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chant extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'audio',
        'user_id',
    ];
}


