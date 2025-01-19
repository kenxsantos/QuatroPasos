function initializeChat(role) {
  const ws = new WebSocket(`ws://localhost:8080?role=${role}`);
  const chatBox = document.getElementById("chat-box");
  const messageInput = document.getElementById("message");
  const sendButton = document.getElementById("send");

  ws.onopen = () => {
    console.log(`${role} connected to the chat server.`);
  };

  ws.onmessage = (event) => {
    try {
      const data = JSON.parse(event.data);

      // Ensure required fields are present
      if (data.from && data.message) {
        const message = `<div class="${data.from}"><strong>${data.from}:</strong> ${data.message}</div>`;
        chatBox.innerHTML += message;
      } else {
        console.error("Incomplete message data:", data);
      }
    } catch (error) {
      console.error("Error parsing WebSocket message:", error, event.data);
    }
  };

  sendButton.addEventListener("click", () => {
    const message = messageInput.value.trim();
    if (message) {
      ws.send(
        JSON.stringify({
          from: role,
          to: role === "admin" ? "customer" : "admin",
          message,
        })
      );
      messageInput.value = "";
    }
  });
}
