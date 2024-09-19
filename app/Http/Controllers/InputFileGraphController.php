<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Storage;

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
            'filename' => $file->filename,
            'header' => $header,
            'data' => $series,
        ];

        return view('inputFileGraph.index', compact('timeSeriesData'));
    }
}