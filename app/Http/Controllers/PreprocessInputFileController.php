<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreprocessInputFileController extends Controller
{
    public function preprocess_fillna(Request $request)
    {

        $request->validate([
            'file' => 'required|file',
            'description' => 'string',
        ]);

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $source = "uploads";
        // Extract the variables from the request
        $type = "";
        // $freq = $request->get('freq');
        $description = $request->get('description');

        $data = array_map('str_getcsv', file($file->getRealPath()));
        $headers = $data[0];
        array_shift($data);

        if (sizeof($headers) == 2) {
            $type = "univariate";

        } else {
            $type = "multivariate";
        }

        if ($type === 'multivariate') {
            return view('uploadData.multivariate', compact('data', 'headers', 'type', 'description', 'filename', 'source'));
        } else {
            return view('uploadData.univariate', compact('data', 'headers', 'type', 'description', 'filename', 'source'));
        }


    }




}