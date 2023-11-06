<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contragent extends Model
{
    use HasFactory, HasUuids;

    public $fillable = [
        'name',
        'type_id',
        'edrpou',
        'contract_no'
    ];

    public function type()
    {
        return $this->belongsTo(ContragentTypes::class, 'type_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function meterReadings()
    {
        return $this->hasMany(MeterReading::class);
    }

    public function gdkTests()
    {
        return $this->hasMany(GdkTest::class);
    }

    public function info()
    {
        return $this->hasMany(ContragentsInfo::class);
    }

    public function lastInfo()
    {
        return $this->hasOne(ContragentsInfo::class)->orderByDesc('date');
    }
}
