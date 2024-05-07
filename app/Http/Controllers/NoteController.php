<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        ]);
    }

    public function create(): array
    {
        
    }

    public function store(StoreNoteRequest $request): JsonResponse
    {
        $note = Note::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Note Created successfully!",
            'note' => $note
        ], 200);
    }

    public function show($id): array
    {
       
    }

    public function edit(): array
    {
        
    }

    public function update($id): array
    {
        
    }

    public function destroy($id): array
    {
        
    }
}
