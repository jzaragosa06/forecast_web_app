<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileAssociation;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index()
    {
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

        return view('home', compact('files'));
    }

    public function manage_result_files()
    {
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


        return view('CRUD.results_in_table', compact('files'));
    }

}
