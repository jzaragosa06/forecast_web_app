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

    // ===========================================================================================================
    //this will temporarily save data from third-party source
    public function temporary_save_external(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $csvFile = $request->file('csv_file');
            $filename = $request->get('filename');
            $path = $csvFile->storeAs('seqal_temporary_uploads', $filename);

            $uploadedFile = SeqalTempFiles::create([
                'file_id' => 1,
                'user_id' => Auth::id(),
                'type' => $request->get('type'),
                'freq' => $request->get('freq'),
                'filename' => $filename,
                'description' => $request->get('description'),
                'filepath' => $path,
                'source' => $request->get('source'),
            ]);
            return response()->json([
                'redirect_url' => route('seqal.preprocess_external', $uploadedFile->id)
            ]);
        }
    }


    public function to_graph_for_preprocessing_external($id)
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
        $source = $file->source;


        if ($type == "univariate") {
            return view('uploadData.univariate', compact('data', 'headers', 'type', 'freq', 'description', 'filename', 'source'));

        } else {
            return view('uploadData.multivariate', compact('data', 'headers', 'type', 'freq', 'description', 'filename', 'source'));

        }

    }
}