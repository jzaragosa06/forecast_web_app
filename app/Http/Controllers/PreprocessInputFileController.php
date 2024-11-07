<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class PreprocessInputFileController extends Controller
// {
//     public function preprocess_fillna(Request $request)
//     {

//         $request->validate([
//             'file' => 'required|file',
//             'description' => 'string',
//         ]);

//         $file = $request->file('file');
//         $filename = $file->getClientOriginalName();
//         $source = "uploads";
//         // Extract the variables from the request
//         $type = "";
//         // $freq = $request->get('freq');
//         $description = $request->get('description');

//         $data = array_map('str_getcsv', file($file->getRealPath()));
//         $headers = $data[0];
//         array_shift($data);

//         if (sizeof($headers) == 2) {
//             $type = "univariate";

//         } else {
//             $type = "multivariate";
//         }

//         if ($type === 'multivariate') {
//             return view('uploadData.multivariate', compact('data', 'headers', 'type', 'description', 'filename', 'source'));
//         } else {
//             return view('uploadData.univariate', compact('data', 'headers', 'type', 'description', 'filename', 'source'));
//         }


//     }




// }

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Exception;

class PreprocessInputFileController extends Controller
{
    public function preprocess_fillna(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'file' => 'required|file|mimes:csv,xls,xlsx',
            'description' => 'string',
        ]);

        try {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $source = "uploads";
            $description = $request->get('description');

            // Attempt to load the file using PhpSpreadsheet. 
            /*
             * we only allow .csv, .xls, .xlsx file. 
             * We parse this into an array that is structued like a csv 
             */
            $spreadsheet = IOFactory::load($file->getRealPath());
            $data = $spreadsheet->getActiveSheet()->toArray();
            $headers = array_shift($data); // Get headers and remove from data

            // Determine if the data is univariate or multivariate
            $type = (count($headers) == 2) ? "univariate" : "multivariate";

            // Return the appropriate view based on the data type
            if ($type === 'multivariate') {
                return view('uploadData.multivariate', compact('data', 'headers', 'type', 'description', 'filename', 'source'));
            } else {
                return view('uploadData.univariate', compact('data', 'headers', 'type', 'description', 'filename', 'source'));
            }

        } catch (Exception $e) {
            // Handle any exceptions that occur during file processing
            session()->flash('upload_failed', 'Failed to upload data. Failed to parse the file. Please ensure it is a valid CSV or Excel file.' . $e);
            return redirect()->route("home");
        }
    }
}