<?php

// namespace App\Http\Controllers;

// use App\Models\FileAssociation;
// use Illuminate\Http\Request;
// use Auth;
// use Storage;


// class ManageShowResultsController extends Controller
// {
//     public function manage($file_assoc_id)
//     {
//         //get the file (associated result file) info from the database. 
//         // $file_assoc = FileAssociation::where('user_id', Auth::id())->where('file_assoc_id', $file_assoc_id)->firstOrFail();
//         $file_assoc = FileAssociation::where('file_assoc_id', $file_assoc_id)->firstOrFail();

//         $operation = $file_assoc->operation;

//         //access the type of the input file
//         $inputFileType = $file_assoc->file->type;
//         // $inputFileType = "forecast";


//         $json = Storage::get($file_assoc->associated_file_path);
//         $jsonData = json_decode($json, true);


//         if ($operation == "forecast") {
//             if ($inputFileType == "univariate") {
//                 return view('results.forecast_uni', ['data' => $jsonData]);
//             } else {
//                 //multivariate
//                 return view('results.forecast_multi', ['data' => $jsonData]);
//             }

//         } elseif ($operation == "trend") {
//             if ($inputFileType == "univariate") {
//                 return view('results.trend_uni', ['data' => $jsonData]);
//             } else {
//                 //multivariate
//                 return view('results.trend_multi', ['data' => $jsonData]);
//             }
//         } else {
//             //seasonality
//             if ($inputFileType == "univariate") {
//                 return view('results.seasonality_uni', ['data' => $jsonData]);
//             } else {
//                 //multivariate
//                 return view('results.seasonality_multi', ['data' => $jsonData]);
//             }
//         }


//     }
// }


namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Auth;
use Storage;
use DB; // Import DB facade

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

        // Handle different operations and file types
        if ($operation == "forecast") {
            if ($inputFileType == "univariate") {
                $note = Note::where('file_assoc_id', $file_assoc_id)->firstOrFail();
                return view('results.forecast_uni', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id, 'note' => $note]);
            } else {
                return view('results.forecast_multi', ['data' => $jsonData, 'file_assoc_id' => $file_assoc_id]);
            }
        } elseif ($operation == "trend") {
            if ($inputFileType == "univariate") {
                return view('results.trend_uni', ['data' => $jsonData]);
            } else {
                return view('results.trend_multi', ['data' => $jsonData]);
            }
        } else {
            if ($inputFileType == "univariate") {
                return view('results.seasonality_uni', ['data' => $jsonData]);
            } else {
                return view('results.seasonality_multi', ['data' => $jsonData]);
            }
        }
    }
}
