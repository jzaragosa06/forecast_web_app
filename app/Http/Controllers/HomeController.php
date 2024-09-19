<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileAssociation;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */



    public function index()
    {
        // Get the files associated with the authenticated user
        // $files = File::where('user_id', Auth::id())->get();
        $files = Auth::user()->files;
        $file_assocs = FileAssociation::where('user_id', Auth::id())->get();

        // Prepare an array to store time series data
        $timeSeriesData = [];

        // Loop through each file and extract data
        foreach ($files as $file) {
            $filePath = $file->filepath; // Get file path from database
            $fileContent = Storage::get($filePath); // Load CSV file from storage
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

            // Add data to the $timeSeriesData array
            $timeSeriesData[] = [
                'filename' => $file->filename,
                'header' => $header, // For chart labeling
                'data' => $series,
            ];
        }

        // Pass the time series data to the view
        return view('home', compact('timeSeriesData', 'files', 'file_assocs'));
    }





}
