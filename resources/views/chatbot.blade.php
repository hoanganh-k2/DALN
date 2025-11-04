<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phenikaa Hotel AI Chatbot</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .chat-container {
            width: 450px;
            height: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
        }

        .chat-message {
            margin: 10px 0;
            padding: 10px 15px;
            border-radius: 15px;
            max-width: 80%;
            word-wrap: break-word;
        }

        .user-message {
            background: #d1e7dd;
            align-self: flex-end;
            margin-left: auto;
        }

        .bot-message {
            background: #e9ecef;
            align-self: flex-start;
        }

        .chat-footer {
            padding: 10px;
            border-top: 1px solid #ddd;
            display: flex;
            gap: 10px;
        }

        .chat-footer input {
            flex: 1;
        }

        .bot-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
</head>

<body style="background-image: url('{{ asset('img/hero.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">


    <div class="chat-container">
        <div class="chat-header">
            🤖 Phenikaa Hotel AI
        </div>

        <div class="chat-body" id="chat-body">
            <div class="chat-message bot-message">
                Xin chào! Tôi là <b>Phenikaa Hotel AI</b> – trợ lý ảo của khách sạn Phenikaa.<br>
                Tôi có thể giúp bạn đặt phòng, xem giá và tìm hiểu dịch vụ.
            </div>
        </div>

        <div class="chat-footer">
            <input type="text" id="user-input" class="form-control" placeholder="Nhập tin nhắn...">
            <button id="send-btn" class="btn btn-primary">Gửi</button>
        </div>
    </div>

    {{-- jQuery CDN --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#send-btn').click(sendMessage);
            $('#user-input').keypress(function(e) {
                if (e.which === 13) sendMessage();
            });

            function sendMessage() {
                let message = $('#user-input').val().trim();
                if (message === '') return;

                // Hiển thị tin nhắn người dùng
                $('#chat-body').append(`<div class="chat-message user-message">${message}</div>`);
                $('#user-input').val('');

                // Cuộn xuống cuối
                $('#chat-body').scrollTop($('#chat-body')[0].scrollHeight);

                // Gửi đến server
                $.ajax({
                    url: "{{ route('chatbot.send') }}",
                    method: "POST",
                    data: {
                        message: message,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $('#chat-body').append(`<div class="chat-message bot-message" id="loading">Đang xử lý...</div>`);
                        $('#chat-body').scrollTop($('#chat-body')[0].scrollHeight);
                    },
                    success: function(response) {
                        $('#loading').remove();
                        let reply = response.message || "Xin lỗi, tôi chưa hiểu yêu cầu của bạn.";
                        $('#chat-body').append(`<div class="chat-message bot-message">${reply}</div>`);
                        $('#chat-body').scrollTop($('#chat-body')[0].scrollHeight);
                    },
                    error: function() {
                        $('#loading').remove();
                        $('#chat-body').append(`<div class="chat-message bot-message text-danger">
                    Lỗi kết nối đến hệ thống. Vui lòng thử lại sau.
                </div>`);
                    }
                });
            }
        });
    </script>

</body>

</html>