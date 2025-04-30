<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Customer Chat</title>
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: #eef2f7;
    }

    .chat-container {
        width: 100%;
        max-width: 500px;
        height: 600px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    #chat-box {
        flex: 1;
        padding: 10px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 8px;
        background: #f9f9f9;
    }

    .message {
        padding: 12px;
        border-radius: 20px;
        font-size: 14px;
        max-width: 75%;
        word-wrap: break-word;
    }

    .incoming {
        background-color: #e1f5fe;
        align-self: flex-start;
    }

    .outgoing {
        background-color: #c8e6c9;
        align-self: flex-end;
    }

    .input-container {
        display: flex;
        padding: 10px;
        gap: 10px;
        border-top: 1px solid #ccc;
    }

    textarea {
        flex: 1;
        resize: none;
        padding: 10px;
        border-radius: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
    }

    button#send {
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 8px;
        cursor: pointer;
    }
    </style>
</head>

<body>
    <div class="chat-container">
        <div id="chat-box"></div>
        <div class="input-container">
            <textarea id="message" placeholder="Type your message..."></textarea>
            <button id="send">Send</button>
        </div>
    </div>

    <script type="module" src="./js/chat.js"></script>
</body>

</html>