<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Note;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $notes = $request->user()->note()->get();

        return ApiResponse::responseJsonSuccess(null, $notes);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $note = Note::findOrFail($id);
        $this->authorize('view', $note);

        return ApiResponse::responseJsonSuccess(null, $note);
    }

    public function store(NoteRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $note = Note::create($data);

        return ApiResponse::responseJsonSuccess('Note Created successfully!', $note, 201);
    }

    public function update(NoteRequest $request, int $id): JsonResponse
    {
        $note = Note::findOrFail($id);
        $this->authorize('update', $note);

        $note->update($request->validated());

        return ApiResponse::responseJsonSuccess('Note updated successfully!', $note);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $note = Note::findOrFail($id);
        $this->authorize('delete', $note);

        $note->delete();

        return ApiResponse::responseJsonSuccess('Note successfully deleted!');
    }
}
