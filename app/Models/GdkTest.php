<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GdkTest extends Model
{
    use HasUuids;

    public $table = 'gdk_tests';

    public $fillable = [
        'user_id',
        'date',
        'act_no',
        'coefficient',
        'applied_coefficient',
        'water_usage',
        'penalty_amount',
        'tariff',
    ];

    public function measurements()
    {
        return $this->belongsToMany(GdkMeasurements::class, 'gdk_test_measurements_pivot', 'test_id', 'measurement_id')
            ->withPivot(['proposed_coefficient', 'real_coefficient', 'value'])
            ->using(new class extends Pivot {
                use HasUuids;
            });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contragent()
    {
        return $this->belongsTo(Contragent::class);
    }
}
