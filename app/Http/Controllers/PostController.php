<?php

namespace App\Http\Controllers;

use App\Models\CommentNotification;
use App\Models\FileAssociation;
use App\Models\UpvotePost;
use Exception;
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
        session()->flash('success', 'Posted successfully!');
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
        // Fetch all comment notifications for the post and the authenticated user
        $comment_notifications = CommentNotification::where("post_id", $id)
            ->where("post_owner_id", Auth::id())
            ->get();

        if ($comment_notifications->isNotEmpty()) {
            foreach ($comment_notifications as $notification) {
                $notification->read = true;
                $notification->save();
            }
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
        $myPosts = Post::where('user_id', $currentUserId)->withCount('upvotes')
            ->orderBy('upvotes_count', 'desc')
            ->get();

        $otherPosts = Post::where('user_id', '!=', $currentUserId)
            ->withCount('upvotes')
            ->orderBy('upvotes_count', 'desc')
            ->get();

        // Pass both collections to the view
        return view('posts.index', compact('myPosts', 'otherPosts', 'file_assocs'));
    }

    public function upvote($post_id)
    {
        // Ensure the user is authenticated
        $user = Auth::id();

        // Check if the user has already upvoted the file
        $existingUpvote = UpvotePost::where('post_id', $post_id)
            ->where('user_id', $user)
            ->first();

        if ($existingUpvote) {
            session()->flash('fail', 'You have already upvoted this post');
            return redirect()->route('posts.index');
        }

        // Add the upvote
        UpvotePost::create([
            'post_id' => $post_id,
            'user_id' => $user,
        ]);

        session()->flash('success', 'Upvote successfully added');
        return redirect()->route('posts.index');
    }

    public function delete($post_id)
    {

        try {
            $post = Post::where('id', $post_id)->first();
            $title = $post->title;
            $post->delete();

            session()->flash('success', $title . " deleted successfully");
            return redirect()->route('crud.index');
        } catch (Exception $e) {
            session()->flash('fail', "Fail to delete");
            return redirect()->route('crud.index');
        }
    }
}