<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiturgicalDay extends Model
{
    use HasFactory;
    
    protected $table = 'liturgical_days';

    protected $fillable = [
        'title',
        'slug',
        'liturgical_time_id',
        'gospel_id',
        'cycle',
        'week_number',
        'day_name',
        'celebration_type',
        'description'
    ];
}
