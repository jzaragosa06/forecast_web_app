<?php
namespace App\Http\Controllers;
use App\Models\FileAssociation;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Auth;
use Storage;
use App\Models\Logs;
use App\Models\User;


class ManageOperationsController extends Controller
{
    public function manage(Request $request)
    {
        $file_id = $request->get("file_id");
        $operation = $request->get("operation");

        if (!$file_id || !$operation) {
            session()->flash('fail', 'No uploaded data found!');
            return redirect()->route('home');
        }

        // Get the file information using the file ID and user ID
        $file = File::where('user_id', Auth::id())->where('file_id', $file_id)->firstOrFail();
        // Retrieve the file content from storage
        $file_content = Storage::get($file->filepath);

        // Extract type, frequency, and description from the file record
        $type = $file->type;
        $freq = $file->freq;
        $description = $file->description;
        //Set the default forecast method to without_refit. Though we removed the with_refit in our flask server.
        $method = "without_refit";

        if ($operation == "forecast") {
            $steps = $request->get("horizon");
            if ($type == 'univariate') {
                try {
                    $response = Http::timeout(300)
                        ->attach(
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

                        $filename_ext_remove = preg_replace('/\.(csv|xls|xlsx)$/i', '', $file->filename);
                        $assoc_filename = 'forecast-on-' . $filename_ext_remove . '-' . now()->timestamp;

                        $result_description = "";

                        if ($type == "univariate") {
                            $result_description = "Perform forecast on time series data on " . $filename_ext_remove . " for " . $steps . " steps into the future";
                        } else {
                            $result_description = "Perform forecast on  target time series variable (last) on " . $filename_ext_remove . " for " . $steps . " steps into the future. The other time series variables were also used to make a forecast.";
                        }

                        $file_assoc = FileAssociation::create([
                            'file_id' => $file_id,
                            'user_id' => Auth::id(),
                            'assoc_filename' => $assoc_filename,
                            'associated_file_path' => $jsonPath,
                            'operation' => $operation,
                            'description' => $result_description,

                        ]);


                        Logs::create([
                            'user_id' => Auth::id(),
                            'action' => 'Perform Forecast',
                            'description' => 'Successfully performed a forecast on file ' . $file->filename,
                        ]);
                        session()->flash('success', 'Data analyzed successfully!');
                        Log::info('file assoc id: ' . $file_assoc->file_assoc_id);
                        Log::info('Created file association:', $file_assoc->toArray());
                        return redirect(url('/results/view/results/' . $file_assoc->file_assoc_id . "?initial=true"));


                    } else {
                        Logs::create([
                            'user_id' => Auth::id(),
                            'action' => 'Perform Forecast',
                            'description' => 'Failed to performed a forecast on file ' . $file->filename,
                        ]);
                        session()->flash('fail', 'Failed to analyze data!');
                        return redirect()->route('home');
                    }
                } catch (\Throwable $th) {
                    Logs::create([
                        'user_id' => Auth::id(),
                        'action' => 'Perform Forecast',
                        'description' => 'Failed to performed a forecast on file ' . $file->filename,
                    ]);
                    session()->flash('fail', 'Failed to analyze data!');
                    return redirect()->route('home');
                }
            } else {
                try {
                    $response = Http::timeout(300)
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

                        $filename_ext_remove = preg_replace('/\.(csv|xls|xlsx)$/i', '', $file->filename);
                        $assoc_filename = 'forecast-on-' . $filename_ext_remove . '-' . now()->timestamp;


                        $result_description = "";

                        if ($type == "univariate") {
                            $result_description = "Perform forecast on time series data on " . $filename_ext_remove . " for " . $steps . " steps into the future";
                        } else {
                            $result_description = "Perform forecast on  target time series variable (last) on " . $filename_ext_remove . " for " . $steps . " steps into the future. The other time series variables were also used to make a forecast.";

                        }


                        $file_assoc = FileAssociation::create([
                            'file_id' => $file_id,
                            'user_id' => Auth::id(),
                            'assoc_filename' => $assoc_filename,
                            'associated_file_path' => $jsonPath,
                            'operation' => $operation,
                            'description' => $result_description,
                        ]);

                        Logs::create([
                            'user_id' => Auth::id(),
                            'action' => 'Perform Forecast',
                            'description' => 'Successfully performed a forecast on file ' . $file->filename,
                        ]);

                        session()->flash('success', 'Data analyzed successfully!');
                        Log::info('file assoc id: ' . $file_assoc->file_assoc_id);
                        Log::info('Created file association:', $file_assoc->toArray());
                        return redirect(url('/results/view/results/' . $file_assoc->file_assoc_id . "?initial=true"));
                    } else {
                        Logs::create([
                            'user_id' => Auth::id(),
                            'action' => 'Perform Forecast',
                            'description' => 'Failed to performed a forecast on file ' . $file->filename,
                        ]);
                        session()->flash('fail', 'Failed to analyze data!');
                        return redirect()->route('home');
                    }
                } catch (\Throwable $th) {
                    Logs::create([
                        'user_id' => Auth::id(),
                        'action' => 'Perform Forecast',
                        'description' => 'Failed to performed a forecast on file ' . $file->filename,
                    ]);
                    session()->flash('fail', 'Failed to analyze data!');
                    return redirect()->route('home');
                }

            }
        } elseif ($operation == "trend") {
            try {
                $response = Http::timeout(300)->attach(
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

                    $filename_ext_remove = preg_replace('/\.(csv|xls|xlsx)$/i', '', $file->filename);
                    $assoc_filename = 'trend-on-' . $filename_ext_remove . '-' . now()->timestamp;


                    $result_description = "";

                    if ($type == "univariate") {
                        $result_description = "Perform trend analysis on time series data on " . $filename_ext_remove;
                    } else {
                        $result_description = "Perform trend analysis on each time series variable on  " . $filename_ext_remove;

                    }
                    $file_assoc = FileAssociation::create([
                        'file_id' => $file_id,
                        'user_id' => Auth::id(),
                        'assoc_filename' => $assoc_filename,
                        'associated_file_path' => $jsonPath,
                        'operation' => $operation,
                        'description' => $result_description,
                    ]);


                    Logs::create([
                        'user_id' => Auth::id(),
                        'action' => 'Analyze Trend',
                        'description' => 'Successfully analyzed trend on ' . $file->filename . ' using Facebook Prophet.',
                    ]);
                    session()->flash('success', 'Data analyzed successfully!');
                    Log::info('file assoc id: ' . $file_assoc->file_assoc_id);
                    Log::info('Created file association:', $file_assoc->toArray());
                    return redirect(url('/results/view/results/' . $file_assoc->file_assoc_id . "?initial=true"));


                } else {
                    Logs::create([
                        'user_id' => Auth::id(),
                        'action' => 'Analyze Trend',
                        'description' => 'Failed analyzed trend on ' . $file->filename . ' using Facebook Prophet.',
                    ]);

                    session()->flash('fail', 'Failed to analyze data!');
                    return redirect()->route('home');
                }

            } catch (\Throwable $th) {
                Logs::create([
                    'user_id' => Auth::id(),
                    'action' => 'Analyze Trend',
                    'description' => 'Failed analyzed trend on ' . $file->filename . ' using Facebook Prophet.',
                ]);

                session()->flash('fail', 'Failed to analyze data!');
                return redirect()->route('home');
            }
        } else {
            // Handle seasonality
            try {
                $response = Http::timeout(300)->attach(
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

                    $filename_ext_remove = str_replace(".csv", "", strval($file->filename));
                    $assoc_filename = 'seasonality-on-' . $filename_ext_remove . '-' . now()->timestamp;
                    $result_description = "";

                    if ($type == "univariate") {
                        $result_description = "Perform seasonality analysis on time series data on " . $filename_ext_remove;
                    } else {
                        $result_description = "Perform seasonality analysis on each time series variable on  " . $filename_ext_remove;

                    }
                    $file_assoc = FileAssociation::create([
                        'file_id' => $file_id,
                        'user_id' => Auth::id(),
                        'assoc_filename' => $assoc_filename,
                        'associated_file_path' => $jsonPath,
                        'operation' => $operation,
                        'description' => $result_description,
                    ]);

                    Logs::create([
                        'user_id' => Auth::id(),
                        'action' => 'Analyze Seasonality',
                        'description' => 'Successfully analyzed seasonality on ' . $file->filename . ' using Facebook Prophet.',
                    ]);

                    session()->flash('success', 'Data analyzed successfully!');
                    Log::info('file assoc id: ' . $file_assoc->file_assoc_id);
                    Log::info('Created file association:', $file_assoc->toArray());
                    return redirect(url('/results/view/results/' . $file_assoc->file_assoc_id . "?initial=true"));


                } else {
                    Logs::create([
                        'user_id' => Auth::id(),
                        'action' => 'Analyze Seasonality',
                        'description' => 'Failed to analyzed seasonality on ' . $file->filename . ' using Facebook Prophet.',
                    ]);

                    session()->flash('fail', 'Failed to analyze data!');
                    return redirect()->route('home');
                }

            } catch (\Throwable $th) {
                Logs::create([
                    'user_id' => Auth::id(),
                    'action' => 'Analyze Seasonality',
                    'description' => 'Failed to analyzed seasonality on ' . $file->filename . ' using Facebook Prophet.',
                ]);

                session()->flash('fail', 'Failed to analyze data!');
                return redirect()->route('home');

            }

        }
    }
}