<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ChatWebController;
Route::get('/', [LeadController::class, 'showForm']);
Route::post('/submit-form', [LeadController::class, 'submitForm'])->name('submit.form');
// Keep LeadController chat route
Route::get('/chat', [LeadController::class, 'showChat'])->name('chat');

// Use a different URL or name for ChatWebController if needed
Route::get('/chat-ai', [ChatWebController::class, 'view'])->name('chat.view');
Route::post('/chat/send', [ChatWebController::class, 'handle'])->name('chat.handle');

Route::post('/logout-chat', [ChatWebController::class, 'logout'])->name('chat.logout');

use App\Mail\RoadmapMail;
use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    $filename = 'ai_roadmap_test.pdf';
    \Illuminate\Support\Facades\Storage::put("public/{$filename}", 'Sample content for testing');

    Mail::to('mnandhini.mng@gmail.com')->send(new RoadmapMail($filename));
    return "Test email sent.";
});

use Illuminate\Support\Facades\Storage;

Route::get('/test-email', function () {
    $filename = 'ai_roadmap_test.pdf';
    Storage::put("public/{$filename}", 'Sample content for testing');
    return "PDF created at storage/app/public/{$filename}";
});

Route::get('/preview-email', function () {
    $filename = 'test.pdf';
    Storage::put("public/{$filename}", 'Fake content for testing...');
    return new RoadmapMail($filename);
});



Route::get('/test-openai', function () {
    try {
        $client = OpenAI::client(env('OPENAI_API_KEY'));

        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => 'What is AI?'],
            ],
        ]);

        return $response['choices'][0]['message']['content'];

    } catch (\Exception $e) {
        return '❌ Error: ' . $e->getMessage();
    }
});
