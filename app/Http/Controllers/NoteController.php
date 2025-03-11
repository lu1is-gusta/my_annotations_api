<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Note;
use App\Services\Response;
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

            return Response::responseJsonSucess(null, $notes);

        } catch(\Exception $e){
            return Response::responseJsonError($e, 500);
        }
        
    }

    public function show(int $id): JsonResponse 
    {
        try{
            $note = Note::findOrFail($id);
        
            return Response::responseJsonSucess(null, $note);
            
        } catch(\Exception $e){
            return Response::responseJsonError($e, 500);
        }
    }

    public function store(NoteRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['user_id'] = $this->idUserAuth;
            
            $note = Note::create($data);
            $responseMessage = "Note Created successfully!";

            return Response::responseJsonSucess($responseMessage, $note);

        } catch (\Exception $e) {
            return Response::responseJsonError($e, 500);
        }
    }

    public function update(int $id, NoteRequest $request): JsonResponse
    {
        try {
            $note = Note::findOrFail($id);

            $note->update($request->validated());
            $responseMessage = "Note updated successfully!";

            return Response::responseJsonSucess($responseMessage, $note);

        } catch (\Exception $e) {
            return Response::responseJsonError($e, 500);
        }
        
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $note = Note::findOrFail($id);

            $note->delete();
            $responseMessage = "Note successfully deleted!";

            return Response::responseJsonSucess($responseMessage, $note);

        } catch (\Exception $e) {
            return Response::responseJsonError($e, 500);
        }
    }
}
