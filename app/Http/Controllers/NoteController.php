<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    public function index(): array
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

    public function store(): array
    {
        
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
