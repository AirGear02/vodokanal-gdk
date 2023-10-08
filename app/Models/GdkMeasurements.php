<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GdkMeasurements extends Model
{
    use SoftDeletes;
    public $table = 'gdk_measurements';

    public $fillable = [
        'name',
        'standard',
        'order_index',
    ];

}
