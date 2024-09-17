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

    public function show(int $id): JsonResponse 
    {
        $note = Note::findOrFail($id);
        
        return response()->json([
            'status' => true,
            'note' => $note
        ], 200);
    }

    public function store(StoreNoteRequest $request): JsonResponse
    {
        $note = Note::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => "Note Created successfully!",
            'note' => $note
        ], 201);
    }

    public function update(int $id, StoreNoteRequest $request): JsonResponse
    {
        $note = Note::findOrFail($id);

        $note->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => "Note updated successfully!",
            'note' => $note
        ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $note = Note::findOrFail($id);

        $note->delete();

        return response()->json([
            'status' => true,
            'message' => "Note successfully deleted!",
            'note' => $note
        ], 200);
    }
}
