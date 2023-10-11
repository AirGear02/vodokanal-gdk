<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contragents\StoreContragentsRequest;
use App\Http\Requests\Contragents\UpdateContragentsRequest;
use App\Models\Contragents;
use App\Models\ContragentTypes;
use Illuminate\Http\Request;
use Inertia\Inertia;
use MongoDB\Driver\Query;

class ContragentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Contragents/Index', [
            'contragent_types' => ContragentTypes::all()
        ]);
    }

    public function getAll(Request $request)
    {

        return response()->json(Contragents::with('type')
            ->when($request->filled('order_field'), fn($query) => $query
                ->orderBy($request->order_field, $request->order_direction ?? 'asc')
            )
            ->when($request->filled('search'), fn($query) => $query->where(fn($query) => $query
                    ->where('name', 'LIKE', "%$request->search%")
                    ->orWhere('edrpou', 'LIKE', "%$request->search%")
                )
            )
            ->when($request->filled('type_id'), fn($query) => $query->where(fn($query) => $query
                ->where('type_id', '=', $request->type_id)
                )
            )
            ->paginate(perPage: 3));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Contragents/Create', [
            'contragent_types' => ContragentTypes::all(),
        ]);
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
