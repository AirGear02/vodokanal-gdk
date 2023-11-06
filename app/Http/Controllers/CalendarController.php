<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarNotes\CalendarNoteStoreRequest;
use App\Models\CalendarNote;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalendarController extends Controller
{
    public function index()
    {
        return Inertia::render('Calendar/Index');
    }

    public function storeNote(CalendarNoteStoreRequest $request)
    {
        $note = CalendarNote::create(array_merge($request->validated(), [
            'user_id' => auth()->id(),
        ]));

        $note->load('user');
        return response()->json(['note' => $note], 201);
    }

    public function getNotes(Request $request)
    {
        $notes = CalendarNote::with('user')
            ->where('date', '=', $request->date ?? now()->toDateString())
            ->get();

        $notes_dates = CalendarNote::pluck('date')->unique()->values();
        return response()->json(['notes' => $notes, 'note_dates' => $notes_dates]);
    }
}
