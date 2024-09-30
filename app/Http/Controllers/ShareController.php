<?php

namespace App\Http\Controllers;

use App\Models\FileUserShare;
use Auth;
use Illuminate\Http\Request;
use App\Models\Notification;

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

}
