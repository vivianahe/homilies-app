<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiturgicalTime extends Model
{
    use HasFactory;
    
    protected $table = 'liturgical_times';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color'
    ];
}
