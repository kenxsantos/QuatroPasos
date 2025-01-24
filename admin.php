<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Chat</title>
    <style>
    .chat-container {
        width: 400px;
        margin: 50px auto;
        border: 1px solid #ccc;
        padding: 10px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    #chat-box {
        min-height: 400px;
        overflow-y: auto;
        border: 1px solid #ccc;
        padding: 10px;
        background: #f9f9f9;
    }

    .message {
        margin: 5px 0;
        padding: 10px;
        border-radius: 10px;
        max-width: 70%;
    }

    .incoming {
        background-color: #e1f5fe;
        align-self: flex-start;
        text-align: left;
        border-radius: 100px;
    }

    .outgoing {
        background-color: #c8e6c9;
        border-radius: 100px;
        align-self: flex-end;
        padding: 10px 15px;
        text-align: right;
        margin-left: auto;
    }

    textarea {
        width: 100%;
        height: 50px;
        resize: none;
    }

    button {
        align-self: flex-end;
        padding: 5px 10px;
    }
    </style>
</head>

<body>
    <div class="chat-container">
        <div id="chat-box"></div>
        <textarea id="message" placeholder="Type your message..."></textarea>
        <button id="send">Send</button>
    </div>
    <script src="./js/chat.js"></script>
    <script>
    const role = 'admin';
    initializeChat(role);
    </script>
</body>

</html>