<?php

namespace App\Http\Controllers;

use App\Exceptions\NotesNotFoundException;
use App\Http\Requests\StoreNoteRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index(): JsonResponse
    {
        try{
            $notes = Note::all();

            return response()->json([
                'status' => true,
                'notes' => $notes
            ], 200);

        } catch(NotesNotFoundException $e){

            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 404);
        }
        
    }

    public function show(int $id): JsonResponse 
    {
        try{
            $note = Note::findOrFail($id);
        
            return response()->json([
                'status' => true,
                'note' => $note
            ], 200);
            
        } catch(NotesNotFoundException $e){

            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function store(StoreNoteRequest $request): JsonResponse
    {
        dd($request->validated());
        try {
            $note = Note::create([
                $request->validated(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'status' => true,
                'message' => "Note Created successfully!",
                'note' => $note
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 404);
        }
        

        
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
