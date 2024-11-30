<?php
namespace App\Http\Controllers;

use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Exception;

class PreprocessInputFileController extends Controller
{
    public function preprocess_fillna(Request $request)
    {

        try {
            $request->validate([
                'file' => 'required|file|mimes:csv,xls,xlsx|max:2048',
                'description' => 'nullable|string',
            ]);


            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $source = "uploads";
            $description = $request->get('description');

            // Load the spreadsheet
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
        } catch (ValidationException $e) {
            session()->flash('fail', 'Validation failed. Uploaded files should be less than 2MB: ' . $e);
            return redirect()->route('home');
        } catch (Exception $e) {
            // Handle exceptions
            session()->flash('fail', 'Failed to upload data. ' . $e->getMessage());
            return redirect()->route("home");
        }
    }
}