<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomilyLiturgicalDay extends Model
{
    use HasFactory;
    
    protected $table = 'homily_liturgical_day';

    protected $fillable = [
        'homily_id',
        'liturgical_day_id'
    ];
}
