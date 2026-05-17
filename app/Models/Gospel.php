<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gospel extends Model
{
    use HasFactory;
    
    protected $table = 'gospels';

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];
}
