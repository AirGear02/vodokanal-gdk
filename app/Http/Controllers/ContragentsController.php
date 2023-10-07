<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContragentsRequest;
use App\Http\Requests\UpdateContragentsRequest;
use App\Models\Contragents;
use Inertia\Inertia;

class ContragentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Contragents/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContragentsRequest $request)
    {
        Contragents::create($request->validated());
        return to_route('contragents.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contragents $contragents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contragents $contragents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContragentsRequest $request, Contragents $contragents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contragents $contragents)
    {
        //
    }
}
