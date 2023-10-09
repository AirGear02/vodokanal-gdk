<?php

namespace App\Services\GdkTests;

use App\Models\GdkTest;
use Carbon\Carbon;

class GdkTestCreateService
{
    public function handle(array $data)
    {
        $gdk_test = GdkTest::create([
            'contragent_id' => $data['contragent_id'],
            'act_no'        => $data['act_no'],
            'date'          => Carbon::parse($data['date'])->toDateString(),
        ]);


    }
}
