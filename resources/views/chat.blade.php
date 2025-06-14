<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AI Chat - Aryng</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + jQuery -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background: #1f2937;
            color: #fff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.2rem;
        }

        .chat-box {
            flex-grow: 1;
            overflow-y: auto;
            padding: 2rem;
            background-color: #e5e7eb;
        }

        .message {
            display: flex;
            margin-bottom: 1rem;
        }

        .message.user {
            justify-content: flex-end;
        }

        .message.ai {
            justify-content: flex-start;
        }

        .bubble {
            max-width: 70%;
            padding: 0.9rem 1.2rem;
            border-radius: 1rem;
            font-size: 0.95rem;
            line-height: 1.5;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            white-space: pre-wrap;
        }

        .user .bubble {
            background-color: #0d6efd;
            color: #fff;
            border-bottom-right-radius: 0;
        }

        .ai .bubble {
            background-color: #fff;
            color: #333;
            border-bottom-left-radius: 0;
        }

        .chat-input {
            border-top: 1px solid #ddd;
            padding: 1rem 2rem;
            background: white;
        }

        .chat-input input {
            border-radius: 2rem;
            padding-left: 1.2rem;
            padding-right: 1.2rem;
        }

        .chat-input button {
            border-radius: 2rem;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .logout-btn {
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
            padding: 0.3rem 0.75rem;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .logout-btn:hover {
            background: #dc3545;
            border-color: #dc3545;
        }

        @media (max-width: 768px) {
            .bubble {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="chat-header">
        <div>🚀 Chat with Aryng AI</div>
        <form method="POST" action="{{ route('chat.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- Chat Messages -->
    <div id="chat-box" class="chat-box">
        <!-- Messages will appear here -->
    </div>

    <!-- Input Form -->
    <div class="chat-input">
        <form id="chat-form" class="d-flex gap-2">
            <input type="text" id="message" class="form-control" placeholder="Type your message..." autocomplete="off" required>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>

    <!-- Script -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#chat-form').on('submit', function (e) {
            e.preventDefault();
            const message = $('#message').val().trim();
            if (!message) return;

            appendMessage('user', message);
            $('#message').val('');
            appendMessage('ai', '<em>Typing...</em>', true);

            $.post("{{ route('chat.handle') }}", { message }, function (data) {
                $('.loading').remove();
                appendMessage('ai', data.reply);
            }).fail(function (xhr) {
                $('.loading').remove();
                appendMessage('ai', `<span class="text-danger">❌ ${xhr.responseJSON?.reply || 'Could not connect.'}</span>`);
            });
        });

        function appendMessage(role, text, isLoading = false) {
            const bubble = `
                <div class="message ${role}${isLoading ? ' loading' : ''}">
                    <div class="bubble">${text}</div>
                </div>`;
            $('#chat-box').append(bubble);
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
        }
    </script>
</body>
</html>
