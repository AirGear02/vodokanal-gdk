<?php

namespace App\Services\GdkTests;

use App\Models\Contragent;
use App\Models\GdkTest;
use Carbon\Carbon;

class GdkTestCreateService
{
    public function handle(Contragent $contragent, array $data): GdkTest
    {
        $measurements = collect($data['measurements'])->keyBy('id')->map(fn($item) => [
            'value'                => $item['value'],
            'proposed_coefficient' => $item['proposed_coefficient'],
            'real_coefficient'     => $item['real_coefficient'],
        ]);

        $gdk_test = $contragent->gdkTests()->create(array_merge($data, [
            'coefficient' => $measurements->sum('proposed_coefficient'),
            'user_id'     => auth()->id(),
        ]));

        $gdk_test->measurements()->sync($measurements->toArray());

        $contragent->info()->updateOrCreate([
            'date' => $gdk_test->date,
        ], [
            'coefficient'         => $gdk_test->coefficient,
            'applied_coefficient' => $gdk_test->applied_coefficient,
            'avg_water_usage'     => $gdk_test->water_usage,
            'penalty_amount'      => $gdk_test->penalty_amount,
        ]);
        return $gdk_test;
    }
}
