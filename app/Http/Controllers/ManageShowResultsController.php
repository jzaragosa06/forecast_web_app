<?php



namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\Note;
use App\Models\User;
use App\Models\File;
use Illuminate\Http\Request;
use Auth;
use Storage;
use DB;
use App\Models\Logs;

class ManageShowResultsController extends Controller
{
    public function manage($file_assoc_id)
    {
        // Fetch the file association and join with the files table to get the file details.
        $file_assoc = DB::table('file_associations')
            ->join('files', 'file_associations.file_id', '=', 'files.file_id')
            ->where('file_associations.file_assoc_id', $file_assoc_id)
            ->where('file_associations.user_id', Auth::id())
            ->select('file_associations.*', 'files.type as file_type')
            ->first();

        if (!$file_assoc) {
            abort(404, 'File Association not found');
        }


        $operation = $file_assoc->operation;
        $inputFileType = $file_assoc->file_type;

        // Access the associated file content
        $json = Storage::get($file_assoc->associated_file_path);
        $jsonData = json_decode($json, true);
        $note = Note::where('file_assoc_id', $file_assoc_id)->first();
        $history = ChatHistory::where('file_assoc_id', $file_assoc_id)->first();

        // ===================================
        //I put it here to prevent redundancy
        Logs::create([
            'user_id' => Auth::id(),
            'action' => 'View Result File',
            'description' => 'Viewed ' . $file_assoc->assoc_filename,
        ]);
        // ===================================

        $file = File::where("file_id", $file_assoc->file_id)->first();
        $description = $file->description;


        $users = User::where('id', '!=', Auth::id())->get();

        // Fetch shared users for each file association
        $shared_users = DB::table('file_user_shares')
            ->where('shared_by_user_id', Auth::id())
            ->get();

        $additional[] = [
            'description' => $description,
        ];
        // Handle different operations and file types
        if ($operation == "forecast") {
            if ($inputFileType == "univariate") {
                return view('results.forecast_uni', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history, 'users' => $users, 'shared_users' => $shared_users, 'additional' => $additional, 'description' => $description]);
            } else {
                return view('results.forecast_multi', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history, 'users' => $users, 'shared_users' => $shared_users, 'additional' => $additional, 'description' => $description]);
            }
        } elseif ($operation == "trend") {
            if ($inputFileType == "univariate") {
                return view('results.trend_uni', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history, 'users' => $users, 'shared_users' => $shared_users, 'additional' => $additional, 'description' => $description]);
            } else {
                return view('results.trend_multi', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history, 'users' => $users, 'shared_users' => $shared_users, 'additional' => $additional, 'description' => $description]);
            }
        } else {
            if ($inputFileType == "univariate") {
                return view('results.seasonality_uni', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history, 'users' => $users, 'shared_users' => $shared_users, 'additional' => $additional, 'description' => $description]);
            } else {
                return view('results.seasonality_multi', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history, 'users' => $users, 'shared_users' => $shared_users, 'additional' => $additional, 'description' => $description]);
            }
        }
    }
}