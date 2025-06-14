<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Lead;
use App\Mail\RoadmapMail;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Client;

class ChatWebController extends Controller
{
    public function view()
    {
        return view('chat');
    }

    public function handle(Request $request)
    {
        $userMessage = $request->input('message');

        // Get or start chat session
        $chat = Session::get('chat', []);
        $chat[] = ['role' => 'user', 'content' => $userMessage];

        try {
            // OpenAI client with SSL disabled (dev only)
            $client = \OpenAI::factory()
                ->withApiKey(env('OPENAI_API_KEY'))
                ->withHttpClient(new Client(['verify' => false]))
                ->make();

            $response = $client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => $chat,
            ]);

            $aiReply = $response['choices'][0]['message']['content'];
            $chat[] = ['role' => 'assistant', 'content' => $aiReply];
            Session::put('chat', $chat);

            return response()->json(['reply' => $aiReply]);

        } catch (\Exception $e) {
            return response()->json([
                'reply' => '❌ AI error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $chat = Session::get('chat', []);

        if (!empty($chat)) {
            $this->generateAndSendPdf($chat);
        }

        Session::flush();
        return redirect('/'); // redirects to form page
    }

   protected function generateAndSendPdf($chat)
{
    $leadId = Session::get('lead_id');
    $lead = \App\Models\Lead::find($leadId);

    if (!$lead) return;

    // 1. Add Lead details at the top
    $markdown = "# AI Roadmap Chat Summary\n\n";
    $markdown .= "**Lead Information**\n";
    $markdown .= "- Name: {$lead->first_name} {$lead->last_name}\n";
    $markdown .= "- Email: {$lead->email}\n";
    $markdown .= "- Company: {$lead->company_name}\n";
    $markdown .= "- Industry: {$lead->industry}\n";
    $markdown .= "- Company Size: {$lead->company_size}\n";
    $markdown .= "- Job Title: {$lead->job_title}\n\n";
    $markdown .= "---\n\n";
    $markdown .= "**Chat Transcript**\n\n";

    // 2. Chat content
    foreach ($chat as $msg) {
        if ($msg['role'] === 'user') {
            $markdown .= "**You asked:**\n{$msg['content']}\n\n";
        } elseif ($msg['role'] === 'assistant') {
            $markdown .= "**AI replied:**\n{$msg['content']}\n\n";
        }
    }

    // 3. Convert to HTML + PDF
    $html = \Illuminate\Support\Str::markdown($markdown);
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);

    // 4. Save file
    $filename = 'ai_roadmap_' . time() . '.pdf';
    $path = storage_path("app/public/{$filename}");

    if (!file_exists(dirname($path))) {
        mkdir(dirname($path), 0775, true);
    }

    file_put_contents($path, $pdf->output());

    // 5. Email to lead
    \Illuminate\Support\Facades\Mail::to($lead->email)
        ->send(new \App\Mail\RoadmapMail($filename));
}


}
