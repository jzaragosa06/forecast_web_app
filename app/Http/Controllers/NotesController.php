<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function save(Request $request)
    {
        $formattedContent = $request->get('notesContent');
        $file_assoc_id = $request->get('file_assoc_id');

        $note = Note::where('file_assoc_id', $file_assoc_id)->first();

        if ($note) {
            $note->update([
                'content' => $request->input('notesContent'),
            ]);
            return response()->json(['message' => 'Note updated successfully!']);

        } else {
            Note::create([
                'file_assoc_id' => $file_assoc_id,
                'content' => $formattedContent,
            ]);

            return response()->json(['message' => 'Note saved successfully!']);

        }

    }
}
