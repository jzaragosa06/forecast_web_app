<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreprocessInputFileController extends Controller
{
    public function preprocess_fillna(Request $request)
    {

        $request->validate([
            'file' => 'required|file',
            'type' => 'required',
            'freq' => 'required',
            'description' => 'string',
        ]);

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();

        // Extract the variables from the request
        $type = $request->get('type');
        $freq = $request->get('freq');
        $description = $request->get('description');

        if ($request->input('type') === 'multivariate') {
            $data = array_map('str_getcsv', file($file->getRealPath()));
            $headers = $data[0];
            array_shift($data);

            return view('uploadData.multivariate', compact('data', 'headers', 'type', 'freq', 'description', 'filename'));
        } else {
            $data = array_map('str_getcsv', file($file->getRealPath()));
            $headers = $data[0];
            array_shift($data);

            return view('uploadData.univariate', compact('data', 'headers', 'type', 'freq', 'description', 'filename'));
        }
    }




}
