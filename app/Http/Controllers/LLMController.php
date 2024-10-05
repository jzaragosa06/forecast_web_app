<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\FileAssociation;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Logs;
use Auth;



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

    public function save(Request $request)
    {
        $chat_from_req = $request->input('history');
        $file_assoc_id = $request->get('file_assoc_id');

        $file_assoc = FileAssociation::where('file_assoc_id', $file_assoc_id)->first();
        $history = ChatHistory::where('file_assoc_id', $file_assoc_id)->first();


        if ($history) {
            $history->update(["history" => $chat_from_req]);

            Logs::create([
                'user_id' => Auth::id(),
                'action' => 'Converse with AI',
                'description' => 'Converse and updated the history for the file: ' . $file_assoc->assoc_filename,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Chat history updated  successfully.']);


        } else {
            //  create new
            ChatHistory::create([
                'file_assoc_id' => $file_assoc_id,
                'history' => $chat_from_req,
            ]);

            Logs::create([
                'user_id' => Auth::id(),
                'action' => 'Converse with AI',
                'description' => 'Converse and saved the history for the file: ' . $file_assoc->assoc_filename,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Chat history saved successfully.']);

        }
    }
}
