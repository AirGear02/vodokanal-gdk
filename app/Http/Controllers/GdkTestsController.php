<?php

namespace App\Http\Controllers;

use App\Models\Contragents;
use App\Models\GdkMeasurements;
use App\Models\GdkTest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GdkTestsController extends Controller
{
    public function index()
    {
        $last_act_no  = GdkTest::max('act_no') ?? 10;
        $measurements = GdkMeasurements::orderBy('order_index')->get();
        return Inertia::render('GdkTests/Create', [
            'contragents'    => Contragents::all(),
            'default_act_no' => $last_act_no,
            'measurements'   => $measurements,
        ]);
    }
}
