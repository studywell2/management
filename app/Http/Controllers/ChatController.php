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

            // 🧠 Define the base prompt for your assistant
            $messages = [
                ['role' => 'system', 'content' => 'You are a helpful school assistant that explains subjects simply and clearly.'],
                ['role' => 'user', 'content' => $request->message],
            ];

            // 🎯 Try first with GPT-3.5
            try {
                $response = $client->chat()->create([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => $messages,
                ]);
            } catch (\OpenAI\Exceptions\RateLimitException $e) {
                // ⚙️ If rate-limited, fallback to GPT-4o-mini
                $response = $client->chat()->create([
                    'model' => 'gpt-4o-mini',
                    'messages' => $messages,
                ]);
            }

            // ✅ Extract and return answer
            $answer = $response->choices[0]->message->content ?? 'Sorry, I could not generate a response.';
            return response()->json(['answer' => $answer]);

        } catch (\OpenAI\Exceptions\ErrorException $e) {
            return response()->json(['answer' => '⚠️ OpenAI error: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            return response()->json(['answer' => '⚠️ Unexpected error: ' . $e->getMessage()]);
        }
    }
}
