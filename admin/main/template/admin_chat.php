<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Chat</title>
    <style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .admin-chat-container {
        display: flex;
        width: 90%;
        max-width: 900px;
        height: 600px;
        background: white;
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .user-list {
        width: 30%;
        background-color: #e9f0fa;
        border-right: 1px solid #ccc;
        padding: 10px;
        overflow-y: auto;
    }

    .user-list button {
        width: 100%;
        padding: 10px;
        margin-bottom: 5px;
        border: none;
        background: #007bff;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
    }

    .chat-box-container {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    #chat-box {
        flex: 1;
        overflow-y: auto;
        padding: 10px;
        background: #f9f9f9;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .message {
        padding: 12px 15px;
        border-radius: 20px;
        max-width: 75%;
        font-size: 14px;
        word-wrap: break-word;
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

    .input-container {
        display: flex;
        padding: 10px;
        gap: 10px;
        border-top: 1px solid #ccc;
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

    button#send {
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.3s ease;
    }

    button#send:hover {
        background: #0056b3;
    }
    </style>
</head>

<body>
    <div class="admin-chat-container">
        <div class="user-list" id="user-list">
            <h4>Users</h4>
        </div>

        <div class="chat-box-container">
            <div id="chat-box"></div>
            <div class="input-container">
                <textarea id="message" placeholder="Type a message..."></textarea>
                <button id="send">Send</button>
            </div>
        </div>
    </div>

    <script type="module" src="../../../admin/main/js/admin_chat.js"></script>
</body>

</html>