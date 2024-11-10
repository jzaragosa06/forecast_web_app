<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileAssociation;
use App\Models\FileUserShare;
use Auth;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

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

        $file_assocs = FileAssociation::where('user_id', Auth::id())->orderBy('created_at', 'desc')
            ->get();

        $files = File::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

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


        $userId = Auth::id();
        // Join the tables
        $sharedFiles = DB::table('file_user_shares')
            ->join('file_associations', 'file_user_shares.file_assoc_id', '=', 'file_associations.file_assoc_id')
            ->join('users as shared_by_user', 'file_user_shares.shared_by_user_id', '=', 'shared_by_user.id') // For the user who shared the file
            ->where('file_user_shares.shared_to_user_id', $userId)
            ->select(
                'file_associations.assoc_filename',
                'file_associations.associated_file_path',
                'file_associations.operation',
                'shared_by_user.name as shared_by',  // To get the name of the user who shared the file
                'file_user_shares.created_at as shared_at'  // Timestamp of when the file was shared
            )
            ->get();

        $currentUserId = Auth::id();
        // Separate posts made by the current user and others
        $otherPosts = Post::where('user_id', '!=', $currentUserId)->latest()->get();



        // Pass the time series data to the view
        return view('home', compact('timeSeriesData', 'files', 'file_assocs', 'sharedFiles', 'otherPosts'));
    }
}