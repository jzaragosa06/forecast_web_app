<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\File;
use Auth;
use App\Models\Logs;
use Storage;

class SaveInputController extends Controller
{

    // public function save(Request $request)
    // {
    //     try {
    //         if ($request->hasFile('csv_file')) {
    //             $csvFile = $request->file('csv_file');

    //             $filename = $request->get('filename'); // Original filename with extension
    //             $extension = pathinfo($filename, PATHINFO_EXTENSION); // Extract the file extension
    //             $nameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME); // Extract the file name without extension

    //             // Use a 4-digit timestamp (day of year + hour + minute)
    //             $timestamp = now()->format('zHi'); // 'z' gives the day of the year (0-365), 'H' for hour, 'i' for minute
    //             $filename = $nameWithoutExtension . '-' . $timestamp . '.' . $extension;



    //             $path = $csvFile->storeAs('uploads', $filename);

    //             $fileContent = Storage::get($path);
    //             $rows = array_map('str_getcsv', explode("\n", $fileContent)); // Convert CSV to array
    //             $headers = array_shift($rows); // Get header row


    //             // // Enforce row and column constraints
    //             if (count($headers) > 5) {

    //                 session()->flash('fail', "The uploaded file has more than 5 columns. Only up to 5 columns are allowed.");
    //                 return response()->json([
    //                     'redirect_url' => route('home'),
    //                 ]);
    //             }

    //             if (count($rows) > 500) {
    //                 session()->flash('fail', "The uploaded file has more than 500 rows. Only up to 500 rows are allowed.");
    //                 return response()->json([
    //                     'redirect_url' => route('home'),
    //                 ]);
    //             }

    //             $uploadedFile = File::create([
    //                 'user_id' => Auth::id(),
    //                 'filename' => $filename,
    //                 'filepath' => $path,
    //                 'type' => $request->get('type'),
    //                 'freq' => $request->get('freq'),
    //                 'description' => $request->get('description'),
    //                 'source' => $request->get('source'),

    //             ]);



    //             Logs::create([
    //                 'user_id' => Auth::id(),
    //                 'action' => 'Saved Input File',
    //                 'description' => 'Fill the missing values and save the input file in user account',
    //             ]);

    //             session()->flash('success', 'Data saved successfully!');

    //             return response()->json([
    //                 'redirect_url' => route('home'),
    //             ]);
    //         }
    //     } catch (Exception $e) {
    //         session()->flash('fail', 'Failed to save the data!');

    //         return response()->json([
    //             'redirect_url' => route('home'),
    //         ]);
    //     }
    // }

    public function save(Request $request)
    {
        try {
            if ($request->hasFile('csv_file')) {
                $csvFile = $request->file('csv_file');

                $filename = $request->get('filename'); // Original filename with extension
                $extension = pathinfo($filename, PATHINFO_EXTENSION); // Extract the file extension
                $nameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME); // Extract the file name without extension

                // Ensure the filename is unique in the 'uploads' directory
                $uniqueFilename = $this->getUniqueFilename('uploads', $nameWithoutExtension, $extension);

                // Store the file with the unique name
                $path = $csvFile->storeAs('uploads', $uniqueFilename);

                $fileContent = Storage::get($path);
                $rows = array_map('str_getcsv', explode("\n", $fileContent)); // Convert CSV to array
                $headers = array_shift($rows); // Get header row

                // Enforce row and column constraints
                if (count($headers) > 5) {
                    session()->flash('fail', "The uploaded file has more than 5 columns. Only up to 5 columns are allowed.");
                    return response()->json([
                        'redirect_url' => route('home'),
                    ]);
                }

                if (count($rows) > 500) {
                    session()->flash('fail', "The uploaded file has more than 500 rows. Only up to 500 rows are allowed.");
                    return response()->json([
                        'redirect_url' => route('home'),
                    ]);
                }

                $uploadedFile = File::create([
                    'user_id' => Auth::id(),
                    'filename' => $uniqueFilename,
                    'filepath' => $path,
                    'type' => $request->get('type'),
                    'freq' => $request->get('freq'),
                    'description' => $request->get('description'),
                    'source' => $request->get('source'),
                ]);

                Logs::create([
                    'user_id' => Auth::id(),
                    'action' => 'Saved Input File',
                    'description' => 'Fill the missing values and save the input file in user account',
                ]);

                session()->flash('success', 'Data saved successfully!');
                return response()->json([
                    'redirect_url' => route('home'),
                ]);
            }
        } catch (Exception $e) {
            session()->flash('fail', 'Failed to save the data!');
            return response()->json([
                'redirect_url' => route('home'),
            ]);
        }
    }

    /**
     * Generate a unique filename in the specified directory by appending numbers if necessary.
     *
     * @param string $directory The directory to check for existing files.
     * @param string $name The base name of the file without the extension.
     * @param string $extension The file extension.
     * @return string A unique filename.
     */
    private function getUniqueFilename($directory, $name, $extension)
    {
        $counter = 0;
        $filename = $name . '.' . $extension;
        while (Storage::exists($directory . '/' . $filename)) {
            $counter++;
            $filename = $name . '(' . $counter . ').' . $extension;
        }
        return $filename;
    }

}