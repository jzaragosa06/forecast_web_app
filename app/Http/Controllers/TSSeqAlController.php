<?php

namespace App\Http\Controllers;
use App\Models\File;
use App\Models\SeqalTempFiles;
use Auth;
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

    public function temporary_save(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $csvFile = $request->file('csv_file');
            $filename = $request->get('filename');
            // $filename = explode('.', $filename)[0] . '_' . now();
            $path = $csvFile->storeAs('seqal_temporary_uploads', $filename);



            $uploadedFile = SeqalTempFiles::create([
                'file_id' => $request->get('file_id'),
                'user_id' => Auth::id(),
                'type' => $request->get('type'),
                'freq' => $request->get('freq'),
                'filename' => $filename,
                'description' => $request->get('description'),
                'filepath' => $path,
            ]);
            return response()->json([
                'redirect_url' => route('seqal.preprocess', $uploadedFile->id)
            ]);

        }
    }


    public function to_graph_for_preprocessing($id)
    {
        // the id here is the id of the temporary uplodaded file. 
        $file = SeqalTempFiles::where('id', $id)->first();

        $filepath = $file->filepath;
        $fileContent = Storage::get($filepath);
        $data = array_map('str_getcsv', explode("\n", $fileContent)); // Convert CSV to array
        $headers = array_shift($data); // Get header row

        $type = $file->type;
        $freq = $file->freq;
        $description = $file->description;
        $filename = $file->filename;


        //we will be forwarding to the multivariate time sereis preprocessing
        return view('uploadData.multivariate', compact('data', 'headers', 'type', 'freq', 'description', 'filename'));
    }

    // public function save_preprocess_fillna_seqal(Request $request)
    // {
    //     // Log the incoming request to see if all data is present
    //     \Log::info('Request Data: ', $request->all());

    //     $file_id = $request->get('file_id');
    //     $type = $request->get('type');
    //     $freq = $request->get('freq');
    //     $filename = $request->get('filename');
    //     $description = $request->get('description');
    //     $headers = $request->get('headers');
    //     $data = $request->get('data');

    //     // Log important variables for debugging
    //     \Log::info('File ID: ' . $file_id);
    //     \Log::info('Headers: ' . print_r($headers, true));
    //     \Log::info('Data: ' . print_r($data, true));

    //     // return view('uploadData.multivariate', data: compact(var_name: var_name: 'data', 'headers', 'type', 'freq', 'description', 'filename'));

    //     return response()->json([
    //         'redirect_url' => route('seqal.multi', [
    //             'file_id' => $file_id,
    //             'type' => $type,
    //             'freq' => $freq,
    //             'filename' => $filename,
    //             'description' => $description,
    //             'headers' => $headers,
    //             'data' => $data
    //         ])
    //     ]);
    // }


    // public function showMultivariateData(Request $request)
    // {
    //     // Extract all the required data from the request (coming from the redirect URL)
    //     $data = $request->get('data');
    //     $headers = $request->get('headers');
    //     $type = $request->get('type');
    //     $freq = $request->get('freq');
    //     $description = $request->get('description');
    //     $filename = $request->get('filename');


    //     return view('uploadData.multivariate', compact('data', 'headers', 'type', 'freq', 'description', 'filename'));
    // }





}