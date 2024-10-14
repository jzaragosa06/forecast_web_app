<?php

namespace App\Http\Controllers;

use App\Models\File;
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

        $files_input = File::where('user_id', Auth::id())->orderBy('created_at', 'desc')
            ->get();

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
        $files_assoc = FileAssociation::where('user_id', Auth::id())->orderBy('created_at', 'desc')
            ->get();
        // ===========================
        $users = User::where('id', '!=', Auth::id())->get();
        // ===========================


        // the file_assoc contains the results, files contains the input files and results, and files_input contains the file inputs
        return view('CRUD.index', compact('files_assoc', 'files', 'files_input', 'users'));
    }


    public function delete_file_assoc($file_assoc_id)
    {
        // Find the FileAssociation entry by its ID
        // $fileAssociation = FileAssociation::findOrFail($file_assoc_id);
        $fileAssociation = FileAssociation::where('file_assoc_id', $file_assoc_id)->first();


        // Delete the file from the storage
        if (Storage::exists($fileAssociation->associated_file_path)) {
            Storage::delete($fileAssociation->associated_file_path);
        }



        // Delete the entry from the database
        // $fileAssociation->delete();
        DB::table('file_associations')->where('file_assoc_id', $file_assoc_id)->delete();


        return redirect()->route('crud.index');
    }

    public function delete_file($file_id)
    {
        // Find the FileAssociation entry by its ID
        // $fileAssociation = FileAssociation::findOrFail($file_assoc_id);
        // $fileAssociation = FileAssociation::where('file_assoc_id', $file_assoc_id)->firstOrFail();
        $file = File::where('file_id', $file_id)->firstOrFail();


        // Delete the file from the storage
        if (Storage::exists($file->filepath)) {
            Storage::delete($file->filepath);
        }

        Logs::create([
            'user_id' => Auth::id(),
            'action' => 'Delete Input File',
            'description' => 'Successfully deleted ' . $file->filename,
        ]);


        // Delete the entry from the database
        // $fileAssociation->delete();
        DB::table('files')->where('file_id', $file_id)->delete();

        return redirect()->route('crud.index');
    }


}