<?php

namespace App\Http\Controllers;

use App\Models\FileAssociation;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Auth;
use PhpParser\Node\Stmt\TryCatch;
use Storage;
use App\Models\Logs;


class ManageOperationsController extends Controller
{
    public function manage(Request $request)
    {
        $file_id = $request->get("file_id");
        $operation = $request->get("operation");

        // Get the file information using the file ID and user ID
        $file = File::where('user_id', Auth::id())->where('file_id', $file_id)->firstOrFail();

        // Retrieve the file content from storage
        $file_content = Storage::get($file->filepath);

        // Extract type, frequency, and description from the file record
        $type = $file->type;
        $freq = $file->freq;
        $description = $file->description;

        // Log the file ID and operation
        dump('File ID: ' . $file_id);
        dump('Operation: ' . $operation);

        if ($operation == "forecast") {
            $steps = $request->get("horizon");
            $method = $request->input('method');

            if ($type == 'univariate') {
                try {
                    $response = Http::attach(
                        'inputFile',
                        $file_content,
                        basename($file->filepath)
                    )->post('http://127.0.0.1:5000/api/forecast-univariate', [
                                'type' => $type,
                                'freq' => $freq,
                                'description' => $description,
                                'steps' => $steps,
                                'method' => $method
                            ]);

                    if ($response->successful()) {
                        $jsonFilename = pathinfo(basename($file->filepath), PATHINFO_FILENAME) . '-initial-' . now()->timestamp . '.json';
                        $jsonPath = 'resultJSON/' . $jsonFilename;
                        Storage::put($jsonPath, json_encode($response->body()));

                        $assoc_filename = 'forecast-on-' . $file->filename . 'created-' . now()->timestamp;

                        FileAssociation::create([
                            'file_id' => $file_id,
                            'user_id' => Auth::id(),
                            'assoc_filename' => $assoc_filename,
                            'associated_file_path' => $jsonPath,
                            'operation' => $operation,
                        ]);


                        Logs::create([
                            'user_id' => Auth::id(),
                            'action' => 'Perform Forecast',
                            'description' => 'Successfully performed a forecast on file ' . $file->filename,
                        ]);
                    }
                } catch (\Throwable $th) {
                    Logs::create([
                        'user_id' => Auth::id(),
                        'action' => 'Perform Forecast',
                        'description' => 'Failed to performed a forecast on file ' . $file->filename,
                    ]);
                }

            } else {
                try {
                    $response = Http::timeout(300) // Increase timeout to 120 seconds
                        ->attach(
                            'inputFile',
                            $file_content,
                            basename($file->filepath)
                        )->post('http://127.0.0.1:5000/api/forecast-multivariate', [
                                'type' => $type,
                                'freq' => $freq,
                                'description' => $description,
                                'steps' => $steps,
                                'method' => $method
                            ]);


                    if ($response->successful()) {
                        $jsonFilename = pathinfo(basename($file->filepath), PATHINFO_FILENAME) . '-initial-' . now()->timestamp . '.json';
                        $jsonPath = 'resultJSON/' . $jsonFilename;
                        Storage::put($jsonPath, json_encode($response->body()));

                        $assoc_filename = 'forecast-on-' . $file->filename . 'created-' . now()->timestamp;


                        FileAssociation::create([
                            'file_id' => $file_id,
                            'user_id' => Auth::id(),
                            'assoc_filename' => $assoc_filename,
                            'associated_file_path' => $jsonPath,
                            'operation' => $operation,
                        ]);

                        Logs::create([
                            'user_id' => Auth::id(),
                            'action' => 'Perform Forecast',
                            'description' => 'Successfully performed a forecast on file ' . $file->filename,
                        ]);
                    }
                } catch (\Throwable $th) {
                    Logs::create([
                        'user_id' => Auth::id(),
                        'action' => 'Perform Forecast',
                        'description' => 'Failed to performed a forecast on file ' . $file->filename,
                    ]);
                }
            }

            return redirect()->route('home');

        } elseif ($operation == "trend") {
            // Log the file ID and operation
            dump('File ID: ' . $file_id);
            dump('Operation: ' . $operation);

            try {
                $response = Http::attach(
                    'inputFile',
                    $file_content,
                    basename($file->filepath)
                )->post('http://127.0.0.1:5000/api/trend', [
                            'type' => $type,
                            'freq' => $freq,
                            'description' => $description
                        ]);

                if ($response->successful()) {
                    $jsonFilename = pathinfo(basename($file->filepath), PATHINFO_FILENAME) . '-initial-' . now()->timestamp . '.json';
                    $jsonPath = 'resultJSON/' . $jsonFilename;
                    Storage::put($jsonPath, json_encode($response->body()));

                    $assoc_filename = 'trend-on-' . $file->filename . 'created-' . now()->timestamp;


                    FileAssociation::create([
                        'file_id' => $file_id,
                        'user_id' => Auth::id(),
                        'assoc_filename' => $assoc_filename,
                        'associated_file_path' => $jsonPath,
                        'operation' => $operation,
                    ]);


                    Logs::create([
                        'user_id' => Auth::id(),
                        'action' => 'Analyze Trend',
                        'description' => 'Successfully analyzed trend on ' . $file->filename . ' using Facebook Prophet.',
                    ]);
                }

            } catch (\Throwable $th) {
                Logs::create([
                    'user_id' => Auth::id(),
                    'action' => 'Analyze Trend',
                    'description' => 'Failed analyzed trend on ' . $file->filename . ' using Facebook Prophet.',
                ]);
            }

            return redirect()->route('home');

        } else {
            // Handle seasonality
            dump('File ID: ' . $file_id);
            dump('Operation: ' . $operation);

            try {
                $response = Http::attach(
                    'inputFile',
                    $file_content,
                    basename($file->filepath)
                )->post('http://127.0.0.1:5000/api/seasonality', [
                            'type' => $type,
                            'freq' => $freq,
                            'description' => $description
                        ]);

                if ($response->successful()) {
                    $jsonFilename = pathinfo(basename($file->filepath), PATHINFO_FILENAME) . '-initial-' . now()->timestamp . '.json';
                    $jsonPath = 'resultJSON/' . $jsonFilename;
                    Storage::put($jsonPath, json_encode($response->body()));


                    $assoc_filename = 'seasonality-on-' . $file->filename . 'created-' . now()->timestamp;

                    FileAssociation::create([
                        'file_id' => $file_id,
                        'user_id' => Auth::id(),
                        'assoc_filename' => $assoc_filename,

                        'associated_file_path' => $jsonPath,
                        'operation' => $operation,
                    ]);


                    Logs::create([
                        'user_id' => Auth::id(),
                        'action' => 'Analyze Seasonality',
                        'description' => 'Successfully analyzed seasonality on ' . $file->filename . ' using Facebook Prophet.',
                    ]);
                }

            } catch (\Throwable $th) {
                Logs::create([
                    'user_id' => Auth::id(),
                    'action' => 'Analyze Seasonality',
                    'description' => 'Failed to analyzed seasonality on ' . $file->filename . ' using Facebook Prophet.',
                ]);
            }

            return redirect()->route('home');
        }
    }
}
