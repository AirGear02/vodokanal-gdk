<?php

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Http\Requests\GdkTests\GdkTestStoreRequest;
use App\Models\Contragent;
use App\Models\GdkMeasurements;
use App\Models\GdkTest;
use App\Services\GdkTests\GdkTestCreateService;
use Inertia\Inertia;

class GdkTestsController extends Controller
{
    public function index(Contragent $contragent)
    {
        return Inertia::render('GdkTests/Index', [
            'contragent' => $contragent,
            'gdk_tests'  => $contragent->gdkTests()->orderByDesc('date')->get(),
        ]);
    }

    public function create(Contragent $contragent)
    {
        $last_act_no  = GdkTest::max('act_no') ?? 0;
        $measurements = GdkMeasurements::orderBy('order_index')->get();
        return Inertia::render('GdkTests/Create', [
            'contragent'     => $contragent,
            'default_act_no' => $last_act_no + 1,
            'measurements'   => $measurements,
            'tariff'         => Constants::WATER_TARIFF,
        ]);
    }

    public function store(Contragent $contragent, GdkTestStoreRequest $request, GdkTestCreateService $service)
    {
        $service->handle($contragent, $request->validated());
        return to_route('contragents.gdk-tests.index', $contragent->id);
    }

    public function show(Contragent $contragent, GdkTest $gdk_test)
    {
        $gdk_test->load('measurements');
        return Inertia::render('GdkTests/Show', [
            'contragent' => $contragent,
            'gdk_test'   => $gdk_test,
        ]);
    }
}
