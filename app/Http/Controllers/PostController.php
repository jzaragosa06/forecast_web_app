<?php

namespace App\Http\Controllers;

use App\Models\FileAssociation;
use Illuminate\Http\Request;
use App\Models\Post;
use Auth;
use App\Models\File;
use App\Models\ChatHistory;
use App\Models\Note;
use App\Models\User;
use Storage;
use DB;
use App\Models\Logs;


class PostController extends Controller
{

    // Display the post creation form
    public function create()
    {
        return view('posts.create');
    }

    // Store a new post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'topics' => 'required|string',
        ]);

        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'file_assoc_id' => $request->file_assoc_id,
            'body' => $request->body,
            'topics' => $request->topics,
        ]);

        return redirect()->route('posts.index');
    }

    // Show a specific post and its comments
    public function show($id)
    {
        $post = Post::with(['user', 'comments.replies.user'])->findOrFail($id);
        $file_assoc_id = $post->file_assoc_id;


        $file_assoc = DB::table('file_associations')
            ->join('files', 'file_associations.file_id', '=', 'files.file_id')
            ->where('file_associations.file_assoc_id', $file_assoc_id)
            ->select('file_associations.*', 'files.type as file_type')
            ->first();

        if (!$file_assoc) {
            abort(404, 'File Association not found');
        }

        $operation = $file_assoc->operation;
        $inputFileType = $file_assoc->file_type;
        $file_id = $file_assoc->file_id;

        // Access the associated file content
        $json = Storage::get($file_assoc->associated_file_path);
        $data = json_decode($json, true);

        $file_meta = [
            "operation" => $operation,
            "inputFileType" => $inputFileType,
            "file_assoc_id" => $file_assoc_id,

        ];

        // ====================================================================
        $file = File::where('file_id', $file_id)->firstOrFail();
        $filepath = $file->filepath;
        $fileDescription = $file->description;
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
            'header' => $header,
            'description' => $fileDescription, 
            'data' => $series,
        ];
        // ====================================================================
        return view('posts.show', compact('post', 'data', 'file_meta', 'timeSeriesData'));
    }


    public function index()
    {
        // Get the currently authenticated user ID
        $currentUserId = Auth::id();
        $file_assocs = FileAssociation::where('user_id', $currentUserId)->get();

        // Separate posts made by the current user and others
        $myPosts = Post::where('user_id', $currentUserId)->latest()->get();
        $otherPosts = Post::where('user_id', '!=', $currentUserId)->latest()->get();

        // Pass both collections to the view
        return view('posts.index', compact('myPosts', 'otherPosts', 'file_assocs'));
    }
}