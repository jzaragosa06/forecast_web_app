<?php
namespace App\Http\Controllers;

use App\Models\PublicFiles;
use App\Models\File;
use App\Models\UpvoteFile;

use Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class PublicFilesController extends Controller
{
    public function index()
    {
        // Get all the public files
        $publicfiles = PublicFiles::all();
        return view('publicfile.index', compact('publicfiles'));
    }

    public function upload(Request $request)
    {
        try {
            $title = $request->get('title');
            $file = $request->file('file');

            // Load the uploaded file as a spreadsheet
            $spreadsheet = IOFactory::load($file->getRealPath());
            $data = $spreadsheet->getActiveSheet()->toArray();

            // Generate CSV content from the data
            $csvData = '';
            foreach ($data as $row) {
                $csvData .= implode(',', $row) . "\n";
            }

            // Define the CSV filename and path
            $processedFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_processed.csv';
            $processedFilepath = 'publicfiles/' . $processedFilename;
            $fullPath = storage_path('app/' . $processedFilepath);

            //This is for the purposes of when someone clone our project. the storage is not being subject to tracking
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0777, true);
            }

            // Save the CSV content directly to storage/app/publicfiles
            file_put_contents($fullPath, $csvData);

            // Check if data is univariate or multivariate based on column count
            $type = count($data[0]) == 2 ? "univariate" : "multivariate";

            $freq = $request->get('freq');
            $source = "public";
            $description = $request->get('description');
            $topics = $request->get('topics');

            // Save the optional thumbnail if provided
            $thumbnail_path = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnail_path = $request->file('thumbnail')->store('thumbnails', 'public');
            }

            // Save metadata to the database
            PublicFiles::create([
                'user_id' => Auth::id(),
                'title' => $title,
                'filename' => $processedFilename,
                'filepath' => $processedFilepath,
                'type' => $type,
                'freq' => $freq,
                'source' => $source,
                'description' => $description,
                'topics' => $topics,
                'thumbnail' => $thumbnail_path,
            ]);

            session()->flash('upload_success', 'File uploaded and processed successfully.');
            return redirect()->route("public-files.index");

        } catch (Exception $e) {
            // Handle any exceptions that occur during file processing
            session()->flash('upload_failed', 'Failed to upload data. Failed to parse the file. Please ensure it is a valid CSV or Excel file. Error: ' . $e->getMessage());
            return redirect()->route('public-files.index');
        }
    }

    public function add_data_to_account($id)
    {
        try {
            $publicfile = PublicFiles::where('id', $id)->first();

            File::create([
                'user_id' => Auth::id(),
                'filename' => $publicfile->filename,
                'filepath' => $publicfile->filepath,
                'type' => $publicfile->type,
                'freq' => $publicfile->freq,
                'source' => $publicfile->source,
                'description' => $publicfile->description,
            ]);

            session()->flash('add_success', 'Data successfully added to your account!');
            return redirect()->route('public-files.index');

        } catch (Exception $e) {
            session()->flash('add_failed', 'Data failed to add to your account!');
            return redirect()->route('public-files.index');
        }
    }


    public function upvote($fileId)
    {
        // Ensure the user is authenticated
        $user = Auth::id();

        // Check if the user has already upvoted the file
        $existingUpvote = UpvoteFile::where('public_file_id', $fileId)
            ->where('user_id', $user)
            ->first();

        if ($existingUpvote) {
            session()->flash('upvote_failed', 'You have already upvoted this file');
            return redirect()->route('public-files.index');
        }

        // Add the upvote
        UpvoteFile::create([
            'public_file_id' => $fileId,
            'user_id' => $user,
        ]);

        session()->flash('upvote_success', 'Upvote successfully added');

        return redirect()->route('public-files.index');
    }

    public function delete($id)
    {
        try {
            $file = PublicFiles::where('id', $id)->first();
            $title = $file->title;
            $file->delete();

            session()->flash('success', $title . " deleted successfully");
            return redirect()->route('crud.index');
        } catch (Exception $e) {
            session()->flash('fail', "Fail to delete");
            return redirect()->route('crud.index');
        }
    }

}