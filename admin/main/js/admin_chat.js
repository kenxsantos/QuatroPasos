import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
import {
  getFirestore,
  collection,
  query,
  where,
  getDocs,
  orderBy,
  onSnapshot,
  addDoc,
  serverTimestamp,
} from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";

// Replace with your Firebase config
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

const userList = document.getElementById("user-list");
const chatBox = document.getElementById("chat-box");
const messageInput = document.getElementById("message");
const sendBtn = document.getElementById("send");

let selectedUser = null;

async function loadUsers() {
  const q = query(collection(db, "messages"));
  const snapshot = await getDocs(q);
  const users = new Set();

  snapshot.forEach((doc) => {
    const data = doc.data();
    if (data.sender !== "admin") {
      users.add(data.sender);
    }
  });

  userList.innerHTML = "<h4>Users</h4>";
  users.forEach((user) => {
    const btn = document.createElement("button");
    btn.textContent = user;
    btn.onclick = () => {
      selectedUser = user;
      loadMessages();
    };
    userList.appendChild(btn);
  });
}

function loadMessages() {
  const conversationId = [selectedUser, "admin"].sort().join("_");

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
        data.sender === "admin" ? "outgoing" : "incoming"
      );
      msgDiv.textContent = data.text;
      chatBox.appendChild(msgDiv);
    });

    chatBox.scrollTop = chatBox.scrollHeight;
  });
}

sendBtn.addEventListener("click", async () => {
  const text = messageInput.value.trim();
  if (!text || !selectedUser) return;

  const conversationId = [selectedUser, "admin"].sort().join("_");

  await addDoc(collection(db, "messages"), {
    sender: "admin",
    receiver: selectedUser,
    text,
    timestamp: serverTimestamp(),
    conversationId,
  });

  messageInput.value = "";
});

loadUsers();
