<?php

namespace App\Http\Controllers;
use App\Models\File;
use Storage;


use Illuminate\Http\Request;

class TSSeqAlController extends Controller
{
    public function index($file_id)
    {

        $file = File::where('file_id', $file_id)->firstOrFail();
        $filepath = $file->filepath;
        $fileContent = Storage::get($filepath);
        $rows = array_map('str_getcsv', explode("\n", $fileContent)); // Convert CSV to array
        $header = array_shift($rows); // Get header row

        // Prepare time series array
        $series = [];
        foreach ($rows as $row) {
            if (count($row) > 1) {
                // First column is the date, others are values
                $series[] = [
                    'date' => $row[0],
                    'values' => array_slice($row, 1)
                ];
            }
        }

        $timeSeriesData = [
            'file_id' => $file_id,
            'filename' => $file->filename,
            'freq' => $file->freq,
            'type' => $file->type,
            'description' => $file->description,
            'header' => $header,
            'data' => $series,
        ];
        return view('alignment.index', compact('timeSeriesData'));
    }

    public function save_preprocess_fillna_seqal(Request $request)
    {
        // Log the incoming request to see if all data is present
        \Log::info('Request Data: ', $request->all());

        $file_id = $request->get('file_id');
        $type = $request->get('type');
        $freq = $request->get('freq');
        $filename = $request->get('filename');
        $description = $request->get('description');
        $headers = $request->get('headers');
        $data = $request->get('data');

        // Log important variables for debugging
        \Log::info('File ID: ' . $file_id);
        \Log::info('Headers: ' . print_r($headers, true));
        \Log::info('Data: ' . print_r($data, true));

        // return view('uploadData.multivariate', data: compact(var_name: var_name: 'data', 'headers', 'type', 'freq', 'description', 'filename'));

        return response()->json([
            'redirect_url' => route('seqal.multi', [
                'file_id' => $file_id,
                'type' => $type,
                'freq' => $freq,
                'filename' => $filename,
                'description' => $description,
                'headers' => $headers,
                'data' => $data
            ])
        ]);
    }


    public function showMultivariateData(Request $request)
    {
        // Extract all the required data from the request (coming from the redirect URL)
        $data = $request->get('data');
        $headers = $request->get('headers');
        $type = $request->get('type');
        $freq = $request->get('freq');
        $description = $request->get('description');
        $filename = $request->get('filename');


        return view('uploadData.multivariate', compact('data', 'headers', 'type', 'freq', 'description', 'filename'));
    }





}