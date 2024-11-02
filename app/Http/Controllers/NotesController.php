<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Models\Logs;
use Auth;
use App\Models\FileAssociation;



class NotesController extends Controller
{
    public function save(Request $request)
    {
        $formattedContent = $request->get('notesContent');
        $file_assoc_id = $request->get('file_assoc_id');

        $note = Note::where('file_assoc_id', $file_assoc_id)->first();
        $file_assoc = FileAssociation::where('file_assoc_id', $file_assoc_id)->first();

        if ($note) {
            $note->update([
                'content' => $request->input('notesContent'),
            ]);

            Logs::create([
                'user_id' => Auth::id(),
                'action' => 'Updated Notes',
                'description' => 'Updated notes from result file ' . $file_assoc->assoc_filename,
            ]);

            // session()->flash('note_success', 'Note updated successfully!');

            return response()->json(['message' => 'Note updated successfully!']);

        } else {
            Note::create([
                'file_assoc_id' => $file_assoc_id,
                'content' => $formattedContent,
            ]);

            Logs::create([
                'user_id' => Auth::id(),
                'action' => 'Saved Notes',
                'description' => 'Saved Notes from result file ' . $file_assoc->assoc_filename,
            ]);


            // session()->flash('note_success', 'Note saved successfully!');
            return response()->json(['message' => 'Note saved successfully!']);

        }

    }
}