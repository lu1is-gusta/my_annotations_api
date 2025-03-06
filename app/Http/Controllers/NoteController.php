<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Note;
use Exception;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    protected $idUserAuth;

    public function __construct()
    {
        $this->idUserAuth = Auth::id();
    }

    public function index(): JsonResponse
    {
        try{
            $notes = Note::all();

            return response()->json([
                'status' => true,
                'notes' => $notes
            ], 200);
            
        } catch(\Exception $e){
            
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
            
        } catch(\Exception $e){

            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function store(NoteRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['user_id'] = $this->idUserAuth;
            
            $note = Note::create([$request->validated(), $data]);
            
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

    public function update(int $id, NoteRequest $request): JsonResponse
    {
        try {
            $note = Note::findOrFail($id);

            $note->update($request->validated());

            return response()->json([
                'status' => true,
                'message' => "Note updated successfully!",
                'note' => $note
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 404);
        }
        
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $note = Note::findOrFail($id);

            $note->delete();

            return response()->json([
                'status' => true,
                'message' => "Note successfully deleted!",
                'note' => $note
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
