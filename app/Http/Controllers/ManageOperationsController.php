<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageOperationsController extends Controller
{
    public function manage(Request $request) {
        $id = $request->get("file_id");
        $operation = $request->get("operation");

        //we will simply use functions and this controller 
        if ($operation == "forecast") {

        }
        elseif ($operation == "trend") {

        }
        else {
            //seasonality

        }
    }
}
