<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


class LLMController extends Controller
{
    public function ask(Request $request)
    {
        $message = $request->input('message');
        $about = $request->input('about');

        try {
            $response = Http::post('http://127.0.0.1:5000/api/llm', [
                "message" => $message,
                "about" => $about,
            ]);

            if ($response->successful()) {
                // return $response->body();
                return response()->json(['response' => $response->json()['response']]);
            } else {
                return response()->json([
                    'message' => 'Failed to communicate with AI server',
                    'error' => $response->body()
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error communicating with AI server',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
