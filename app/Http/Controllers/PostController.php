<?php

namespace App\Http\Controllers;

use App\Models\CommentNotification;
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
    // Store a new post
    // public function store(Request $request)
    // {


    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'body' => 'required|string',
    //         'topics' => 'required|string',
    //         'post_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);

    //     // If an image is uploaded, handle it
    //     if ($request->hasFile('post_image')) {
    //         $path = $request->file('post_image')->store('images');
    //     }

    //     $post = Post::create([
    //         'user_id' => Auth::id(),
    //         'title' => $request->title,
    //         'file_assoc_id' => $request->file_assoc_id,
    //         'body' => $request->body,
    //         'topics' => $request->topics,
    //         'post_image' => $path,
    //     ]);
    //     session()->flash('post_success', 'Posted successfully!');
    //     return redirect()->route('posts.show', $post->id);

    // }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'topics' => 'required|string',
            'post_image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        // Initialize $path to null in case no image is uploaded
        $path = null;

        // If an image is uploaded, handle it
        if ($request->hasFile('post_image')) {
            $path = $request->file('post_image')->store('thumbnails', 'public');
        }

        
        // Create the post with the appropriate image path (or null if no image)
        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'file_assoc_id' => $request->file_assoc_id,
            'body' => $request->body,
            'topics' => $request->topics,
            'post_image' => $path,  // Will be null if no image was uploaded
        ]);

        // Flash a success message and redirect to the post show page
        session()->flash('post_success', 'Posted successfully!');
        return redirect()->route('posts.show', $post->id);
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


        //This part indicate that that post was seen by the user
        $comment_notif = CommentNotification::where("post_id", $id)->where("post_owner_Id", Auth::id())->first();
        if ($comment_notif) {
            $comment_notif->read = 1;
            $comment_notif->save();
        }
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