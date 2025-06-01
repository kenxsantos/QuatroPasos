import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
import {
  getFirestore,
  collection,
  addDoc,
  query,
  orderBy,
  onSnapshot,
  where,
  serverTimestamp,
} from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";

// Replace this with your own config
const firebaseConfig = {
  apiKey: "AIzaSyB0jgzZ3qUtFOmh3AdJrwvPK3K6Clbw9Cg",
  authDomain: "quatropasoschat.firebaseapp.com",
  projectId: "quatropasoschat",
  storageBucket: "quatropasoschat.firebasestorage.app",
  messagingSenderId: "155209716251",
  appId: "1:155209716251:web:dd8ea20abd7b7142d79ebe",
  measurementId: "G-FQ8JRQRC72",
};

const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

const customerId = localStorage.getItem("customerId");
const adminId = "admin";
const conversationId = [customerId, adminId].sort().join("_");

const chatBox = document.getElementById("chat-box");
const messageInput = document.getElementById("message");
const sendBtn = document.getElementById("send");

function loadMessages() {
  const q = query(
    collection(db, "messages"),
    where("conversationId", "==", conversationId),
    orderBy("timestamp")
  );

  onSnapshot(q, (snapshot) => {
    chatBox.innerHTML = "";
    snapshot.forEach((doc) => {
      const data = doc.data();
      const msgDiv = document.createElement("div");
      msgDiv.classList.add(
        "message",
        data.sender === customerId ? "outgoing" : "incoming"
      );
      msgDiv.textContent = data.text;
      chatBox.appendChild(msgDiv);
    });

    chatBox.scrollTop = chatBox.scrollHeight;
  });
}

sendBtn.addEventListener("click", async () => {
  const text = messageInput.value.trim();
  if (!text) return;

  await addDoc(collection(db, "messages"), {
    sender: customerId,
    receiver: adminId,
    text,
    timestamp: serverTimestamp(),
    conversationId,
  });

  messageInput.value = "";
});

loadMessages();
