<?php

namespace App\Http\Controllers;

use ConsoleTVs\Charts\Classes\Highcharts\Chart;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Spatie\Browsershot\Browsershot;
use GChartPHP\GChart;
use Illuminate\Support\Facades\Storage;

class RenderImageController extends Controller
{
    public function render()
    {
        return view('renderImage');
    }
    public function saveChartImage(Request $request)
    {
        // Validate the request
        $request->validate([
            'image' => 'required|string',
        ]);

        // Get the image data
        $imageData = $request->input('image');

        // Extract the base64 encoded part
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);

        // Decode the image data
        $image = base64_decode($imageData);

        // Create a unique file name
        $fileName = 'chart_' . time() . '.png';

        // Save the image in the local storage
        Storage::disk('public')->put($fileName, $image);

        return response()->json(['message' => 'Image saved successfully!', 'file' => $fileName]);
    }

}
