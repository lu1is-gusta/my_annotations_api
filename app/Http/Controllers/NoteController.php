<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Note;

class NoteController extends Controller
{
    public function index(): JsonResponse
    {
        $notes = Note::all();

        return response()->json([
            'status' => true,
            'notes' => $notes
        ], 200);
    }

    public function create(StoreNoteRequest $request): JsonResponse
    {
        $note = Note::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Note Created successfully!",
            'note' => $note
        ], 201);
    }

    public function update($id)
    {
        
    }

    public function delete($id)
    {
        
    }
}
