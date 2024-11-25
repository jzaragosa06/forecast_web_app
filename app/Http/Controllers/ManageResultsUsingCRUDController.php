<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileUserShare;
use App\Models\Post;
use App\Models\PublicFiles;
use Exception;
use Illuminate\Http\Request;
use Auth;
use App\Models\FileAssociation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Logs;



class ManageResultsUsingCRUDController extends Controller
{

    public function index()
    {
        // Fetch files and associations as before
        $files_input = File::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        $files = DB::table('files')
            ->leftJoin('file_associations', 'files.file_id', '=', 'file_associations.file_id')
            ->where('files.user_id', Auth::id())
            ->select(
                'files.file_id',
                'files.filename',
                'files.filepath',
                'file_associations.file_assoc_id',
                'file_associations.assoc_filename',
                'file_associations.associated_file_path',
                'file_associations.operation'
            )
            ->get();

        $files_assoc = FileAssociation::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $users = User::where('id', '!=', Auth::id())->get();

        // Fetch shared users for each file association
        $shared_users = DB::table('file_user_shares')
            ->where('shared_by_user_id', Auth::id())
            ->get();
        
            
        $posts = Post::where('user_id', Auth::id())->get();
        $files_shared_on_public = PublicFiles::where('user_id', Auth::id())->get();

        return view('CRUD.index', compact('files_assoc', 'files', 'files_input', 'users', 'shared_users', 'posts', 'files_shared_on_public'));
    }

    public function delete_file_assoc($file_assoc_id)
    {
        // Find the FileAssociation entry by its ID

        $fileAssociation = FileAssociation::where('file_assoc_id', $file_assoc_id)->first();
        $file_assoc_filename = $fileAssociation->assoc_filename;

        try {
            // Delete the file from the storage
            if (Storage::exists($fileAssociation->associated_file_path)) {
                Storage::delete($fileAssociation->associated_file_path);
            }
            DB::table('file_associations')->where('file_assoc_id', $file_assoc_id)->delete();
            DB::table('file_associations')->where('file_assoc_id', $file_assoc_id)->delete();
            $message = $file_assoc_filename . " deleted successfully!";
            session()->flash('delete_success', $message);
        } catch (\Throwable $th) {
            $message = $file_assoc_filename . " failed to delete!";
            session()->flash('delete_failed', $message);
        }
        return redirect()->route('crud.index');
    }

    public function delete_file($file_id)
    {
        // Find the FileAssociation entry by its ID
        $file = File::where('file_id', $file_id)->first();
        $filename = $file->filename;

        try {

            // Delete the file from the storage
            if (Storage::exists($file->filepath)) {
                Storage::delete($file->filepath);
            }
            // Delete the entry from the database
            DB::table('files')->where('file_id', $file_id)->delete();

            Logs::create([
                'user_id' => Auth::id(),
                'action' => 'Delete Input File',
                'description' => 'Successfully deleted ' . $filename,
            ]);
            $message = $filename . " deleted successfully!";
            session()->flash('delete_success', $message);
        } catch (\Throwable $th) {
            Logs::create([
                'user_id' => Auth::id(),
                'action' => 'Delete Input File',
                'description' => 'Failed to delete ' . $filename,
            ]);

            $message = $filename . " failed to delete!";
            session()->flash('delete_failed', $message);
        }

        return redirect()->route('crud.index');
    }


}