<?php

namespace App\Http\Controllers;

use App\Models\File;

use Illuminate\Http\Request;
use Storage;
use Auth;
use App\Models\Logs;

class InputFileGraphController extends Controller
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
            'description' => $file->description, 
            'header' => $header,
            'data' => $series,
        ];

        Logs::create([
            'user_id' => Auth::id(),
            'action' => 'Viewed Input File',
            'description' => 'Viewed the graph of ' . $file->filename,
        ]);

        return view('inputFileGraph.index', compact('timeSeriesData'));
    }
}