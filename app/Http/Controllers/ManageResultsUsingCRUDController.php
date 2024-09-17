<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\FileAssociation;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



class ManageResultsUsingCRUDController extends Controller
{
    public function show()
    {
        // $files = DB::table('files')
        //     ->leftJoin('file_associations', 'files.file_id', '=', 'file_associations.file_id')
        //     ->where('files.user_id', Auth::id())
        //     ->select(
        //         'files.file_id',
        //         'files.filename',
        //         'files.filepath',
        //         'file_associations.file_assoc_id',
        //         'file_associations.assoc_filename',
        //         'file_associations.associated_file_path',
        //         'file_associations.operation'
        //     )
        //     ->get();

        $files = FileAssociation::where('user_id', Auth::id())->get();


        return view('CRUD.index', compact('files'));
    }

    public function delete($file_assoc_id)
    {
        // Find the FileAssociation entry by its ID
        // $fileAssociation = FileAssociation::findOrFail($file_assoc_id);
        $fileAssociation = FileAssociation::where('file_assoc_id', $file_assoc_id)->firstOrFail();


        // Delete the file from the storage
        if (Storage::exists($fileAssociation->associated_file_path)) {
            Storage::delete($fileAssociation->associated_file_path);
        }

        // Delete the entry from the database
        // $fileAssociation->delete();
        DB::table('file_associations')->where('file_assoc_id', $file_assoc_id)->delete();

        return redirect()->route('crud.show');
    }


}


