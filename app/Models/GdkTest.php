<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GdkTest extends Model
{
    use HasUuids;

    public $table = 'gdk_tests';

    public function gdkMeasurements()
    {
        return $this->belongsToMany(GdkMeasurements::class, 'gdk_test_measurements')
            ->withPivot(['proposed_coefficient', 'real_coefficient'])
            ->using(new class extends Pivot {
                use HasUuids;
            });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
