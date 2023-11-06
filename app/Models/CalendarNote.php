<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarNote extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'body',
        'user_id',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
