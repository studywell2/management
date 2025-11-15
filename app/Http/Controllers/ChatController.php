<?php

namespace App\Http\Controllers;

use OpenAI;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        try {
            $client = OpenAI::client(env('OPENAI_API_KEY'));

            $messages = [
                ['role' => 'system', 'content' => 'You are a helpful school assistant.'],
                ['role' => 'user', 'content' => $request->message],
            ];

            try {
                $response = $client->chat()->create([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => $messages,
                ]);
            } catch (\OpenAI\Exceptions\RateLimitException $e) {
                $response = $client->chat()->create([
                    'model' => 'gpt-4o-mini',
                    'messages' => $messages,
                ]);
            }

            $answer = $response->choices[0]->message->content ?? 'Sorry, I could not generate a response.';
            return response()->json(['answer' => $answer]);

        } catch (\Exception $e) {
            return response()->json(['answer' => '⚠️ Error: ' . $e->getMessage()]);
        }
    }
}
