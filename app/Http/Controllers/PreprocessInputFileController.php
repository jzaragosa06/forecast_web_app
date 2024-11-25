<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Exception;

class PreprocessInputFileController extends Controller
{
    public function preprocess_fillna(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'file' => 'required|file|mimes:csv,xls,xlsx',
            'description' => 'nullable|string',
        ]);

        try {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $source = "uploads";
            $description = $request->get('description');

            // Load the spreadsheet
            $spreadsheet = IOFactory::load($file->getRealPath());
            $data = $spreadsheet->getActiveSheet()->toArray();
            $headers = array_shift($data); // Get headers and remove from data

            // Enforce row and column constraints
            // if (count($headers) > 5) {

            //     throw new Exception("The uploaded file has more than 5 columns. Only up to 5 columns are allowed.");
            //     session()->flash('upload_failed', "The uploaded file has more than 5 columns. Only up to 5 columns are allowed.");
            //     return redirect()->route("home");
            // }

            // if (count($data) > 500) {
            //     throw new Exception("The uploaded file has more than 500 rows. Only up to 500 rows are allowed.");
            //     session()->flash('upload_failed', "The uploaded file has more than 500 rows. Only up to 500 rows are allowed.");
            //     return redirect()->route("home");
            // }

            // Determine if the data is univariate or multivariate
            $type = (count($headers) == 2) ? "univariate" : "multivariate";

            // Return the appropriate view based on the data type
            if ($type === 'multivariate') {
                return view('uploadData.multivariate', compact('data', 'headers', 'type', 'description', 'filename', 'source'));
            } else {
                return view('uploadData.univariate', compact('data', 'headers', 'type', 'description', 'filename', 'source'));
            }
        } catch (Exception $e) {
            // Handle exceptions
            session()->flash('fail', 'Failed to upload data. ' . $e->getMessage());
            return redirect()->route("home");
        }
    }
}