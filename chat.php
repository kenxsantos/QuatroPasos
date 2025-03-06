<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Chat</title>
    <style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .chat-container {
        width: 90%;
        max-width: 450px;
        background: #fff;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* Chat Box */
    #chat-box {
        min-height: 350px;
        max-height: 400px;
        overflow-y: auto;
        padding: 10px;
        background: #f9f9f9;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        scrollbar-width: thin;
    }

    /* Messages */
    .message {
        padding: 12px 15px;
        border-radius: 20px;
        max-width: 75%;
        word-wrap: break-word;
        font-size: 14px;
    }

    .incoming {
        background: #e3f2fd;
        align-self: flex-start;
        border-radius: 15px 15px 15px 5px;
    }

    .outgoing {
        background: #c8e6c9;
        align-self: flex-end;
        border-radius: 15px 15px 5px 15px;
    }

    /* Input & Button */
    .input-container {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    textarea {
        flex: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        resize: none;
        font-size: 14px;
        outline: none;
    }

    button {
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.3s ease;
    }

    button:hover {
        background: #0056b3;
    }

    /* Responsive */
    @media (max-width: 480px) {
        .chat-container {
            width: 95%;
        }

        .message {
            font-size: 13px;
        }

        button {
            padding: 8px 12px;
        }
    }
    </style>
</head>

<body>
    <div class="chat-container">
        <h2 style="text-align: center; color: #333;">Customer Chat</h2>
        <div id="chat-box"></div>
        <div class="input-container">
            <textarea id="message" placeholder="Type your message..."></textarea>
            <button id="send">Send</button>
        </div>
    </div>
    <script src="./js/chat.js"></script>
    <script>
    const role = 'customer';
    initializeChat(role);
    </script>
</body>

</html>