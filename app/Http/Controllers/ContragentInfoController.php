<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContragentInfo\StoreContragentInfoRequest;
use App\Http\Requests\ContragentInfo\UpdateContragentInfoRequest;
use App\Http\Requests\Contragents\UpdateContragentsRequest;
use App\Models\Contragent;
use App\Models\ContragentsInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ContragentInfoController extends Controller
{
    public function store(Contragent $contragent, StoreContragentInfoRequest $request)
    {
        $info = $contragent->info()->create($request->validated());
        return response()->json(['info' => $info]);
    }

    public function update(Contragent $contragent, ContragentsInfo $info, UpdateContragentInfoRequest $request)
    {
        $info->update($request->validated());
        return response()->json(['info' => $info]);
    }
}
