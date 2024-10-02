<?php

namespace App\Http\Controllers;

use App\Models\FileUserShare;
use Auth;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Storage;
use App\Models\ChatHistory;
use App\Models\Note;
use App\Models\User;


class ShareController extends Controller
{
    public function shareFileWithUsers(Request $request)
    {
        // // Validate the incoming data
        // $request->validate([
        //     'file_assoc_id' => 'required|exists:file_associations,file_assoc_id',
        //     'shared_to_user_ids' => 'required|array', // Array of user IDs
        //     'shared_to_user_ids.*' => 'exists:users,id', // Validate each user ID exists
        // ]);

        // Get the file association ID and the user IDs
        $fileAssocId = $request->input('file_assoc_id');
        $sharedToUserIds = $request->input('shared_to_user_ids');
        $sharedByUserId = Auth::id(); // ID of the user sharing the file

        // Loop through each user ID and insert into file_user_shares table
        foreach ($sharedToUserIds as $sharedToUserId) {
            // Check if this file has already been shared to this user
            $alreadyShared = FileUserShare::where('file_assoc_id', $fileAssocId)
                ->where('shared_to_user_id', $sharedToUserId)
                ->exists();

            if (!$alreadyShared) {
                // Insert a new record for each user in the file_user_shares table
                FileUserShare::create([
                    'file_assoc_id' => $fileAssocId,
                    'shared_to_user_id' => $sharedToUserId,
                    'shared_by_user_id' => $sharedByUserId,
                ]);

                // Optionally, create a notification for each shared user
                Notification::create([
                    'user_id' => $sharedToUserId,  // The user who is receiving the shared file
                    'file_assoc_id' => $fileAssocId,
                    'shared_by_user_id' => $sharedByUserId,
                    'read' => false,  // Notification is unread by default
                ]);
            }
        }

        // Redirect back or return success response
        return redirect()->route('home');
    }


    //this function allow the users to view the shared files to them. 
    // public function view_shared_file($file_assoc_id, $user_id)
    // {
    //     // Fetch the file association and join with the files table to get the file details.
    //     $file_assoc = DB::table('file_associations')
    //         ->join('files', 'file_associations.file_id', '=', 'files.file_id')
    //         ->where('file_associations.file_assoc_id', $file_assoc_id)
    //         ->where('file_associations.user_id', $user_id)
    //         ->select('file_associations.*', 'files.type as file_type')
    //         ->first();

    //     if (!$file_assoc) {
    //         abort(404, 'File Association not found');
    //     }

    //     $operation = $file_assoc->operation;
    //     $inputFileType = $file_assoc->file_type;

    //     // Access the associated file content
    //     $json = Storage::get($file_assoc->associated_file_path);
    //     $jsonData = json_decode($json, true);
    //     $note = Note::where('file_assoc_id', $file_assoc_id)->first();
    //     $history = ChatHistory::where('file_assoc_id', $file_assoc_id)->first();


    //     // Handle different operations and file types
    //     if ($operation == "forecast") {
    //         if ($inputFileType == "univariate") {
    //             return view('results.forecast_uni', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history]);
    //         } else {
    //             return view('results.forecast_multi', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history]);
    //         }
    //     } elseif ($operation == "trend") {
    //         if ($inputFileType == "univariate") {
    //             return view('results.trend_uni', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history]);
    //         } else {
    //             return view('results.trend_multi', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history]);
    //         }
    //     } else {
    //         if ($inputFileType == "univariate") {
    //             return view('results.seasonality_uni', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history]);
    //         } else {
    //             return view('results.seasonality_multi', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history]);
    //         }
    //     }
    // }
    public function view_shared_file($file_assoc_id, $user_id)
    {


        // Fetch the file association and join with the files table to get the file details.
        $file_assoc = DB::table('file_associations')
            ->join('files', 'file_associations.file_id', '=', 'files.file_id')
            ->where('file_associations.file_assoc_id', $file_assoc_id)
            ->where('file_associations.user_id', $user_id)
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


        //===============================================================================
        //we need to handle the notification message being read and the shared file being read. 
        // $notif  = Notification::where('user_id')
        $notif = Notification::where('user_id', Auth::id())->where('file_assoc_id', $file_assoc_id)->first();
        $notif->read = 1;
        $notif->save();

        // ==============================================================================

        // Handle different operations and file types
        if ($operation == "forecast") {
            if ($inputFileType == "univariate") {
                return view('sharedFiles.forecast_uni', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history]);
            } else {
                return view('sharedFiles.forecast_multi', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history]);
            }
        } elseif ($operation == "trend") {
            if ($inputFileType == "univariate") {
                return view('sharedFiles.trend_uni', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history]);
            } else {
                return view('sharedFiles.trend_multi', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history]);
            }
        } else {
            if ($inputFileType == "univariate") {
                return view('sharedFiles.seasonality_uni', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history]);
            } else {
                return view('sharedFiles.seasonality_multi', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note, 'history' => $history]);
            }
        }
    }

    public function index()
    {
        $userId = Auth::id();

        // Files shared with the current user
        $sharedWithMe = DB::table('file_user_shares')
            ->join('file_associations', 'file_user_shares.file_assoc_id', '=', 'file_associations.file_assoc_id')
            ->join('users', 'file_user_shares.shared_by_user_id', '=', 'users.id')
            ->where('file_user_shares.shared_to_user_id', '=', $userId)
            ->select(
                'file_associations.file_assoc_id',
                'file_associations.assoc_filename',
                'file_associations.associated_file_path',
                'users.id as user_id',
                'users.name as shared_by',
                'file_user_shares.created_at as shared_at'
            )
            ->get();

        // Files shared by the current user with others
        $filesSharedByMe = DB::table('file_user_shares')
            ->join('file_associations', 'file_user_shares.file_assoc_id', '=', 'file_associations.file_assoc_id')
            ->join('users', 'file_user_shares.shared_to_user_id', '=', 'users.id')
            ->where('file_user_shares.shared_by_user_id', '=', $userId)
            ->select(
                'file_associations.assoc_filename',
                'file_associations.associated_file_path',
                'users.name as shared_to',
                'file_user_shares.created_at as shared_at'
            )
            ->get();

        // Pass data to the view
        return view('sharedFiles.index', compact('sharedWithMe', 'filesSharedByMe'));
    }

}
