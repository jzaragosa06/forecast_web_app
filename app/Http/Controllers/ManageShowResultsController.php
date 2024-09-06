<?php

namespace App\Http\Controllers;

use App\Models\FileAssociation;
use Illuminate\Http\Request;
use Auth;
use Storage;


class ManageShowResultsController extends Controller
{
    public function manage($file_assoc_id)
    {
        //get the file (associated result file) info from the database. 
        $file_assoc = FileAssociation::where('user_id', Auth::id())->where('file_assoc_id', $file_assoc_id)->firstOrFail();
        $operation = $file_assoc->operation;

        //access the type of the input file
        $inputFileType = $file_assoc->file()->type;

        $json = Storage::get($file_assoc->associated_file_path);
        $jsonData = json_decode($json, true);


        if ($operation == "forecast") {
            if ($inputFileType == "univariate") {
                return view('results.forecast_uni', ['data' => $jsonData]);
            } else {
                //multivariate
                return view('results.forecast_multi', ['data' => $jsonData]);
            }

        } elseif ($operation == "trend") {
            if ($inputFileType == "univariate") {
                return view('results.trend_uni', ['data' => $jsonData]);
            } else {
                //multivariate
                return view('results.trend_multi', ['data' => $jsonData]);
            }
        } else {
            //seasonality
            if ($inputFileType == "univariate") {
                return view('results.seasonality_uni', ['data' => $jsonData]);
            } else {
                //multivariate
                return view('results.seasonality_multi', ['data' => $jsonData]);
            }
        }


    }
}
