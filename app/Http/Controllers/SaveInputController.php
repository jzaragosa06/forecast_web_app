<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Auth;

class SaveInputController extends Controller
{
    public function save(Request $request)
    {

        if ($request->hasFile('csv_file')) {
            $csvFile = $request->file('csv_file');
            $filename = $request->get('filename');
            $path = $csvFile->storeAs('uploads', $filename);

            $uploadedFile = File::create([
                'user_id' => Auth::id(),
                'filename' => $filename,
                'filepath' => $path,
                'type' => $request->get('type'),
                'freq' => $request->get('freq'),
                'description' => $request->get('description')

            ]);

            return response()->json([
                'redirect_url' => route('home')
            ]);
        }
    }
}
