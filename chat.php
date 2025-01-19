<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Chat</title>
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
        height: 300px;
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 5px;
        background-color: #f9f9f9;
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
    const role = 'customer';
    initializeChat(role);
    </script>
</body>

</html>