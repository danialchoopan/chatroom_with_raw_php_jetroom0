document.addEventListener('DOMContentLoaded', function() {
    const messageContainer = document.getElementById('messages');
    const messageInput = document.getElementById('message-input');
    const sendBtn = document.getElementById('send-btn');
    const imageInput = document.getElementById('image-input');

    // Get room or receiver ID from attributes
    const chatContainer = document.querySelector('[data-room-id], [data-receiver-id]');
    if (!chatContainer) return; // Exit if not on chat page

    const roomId = chatContainer.getAttribute('data-room-id');
    const receiverId = chatContainer.getAttribute('data-receiver-id');
    const isPrivate = !!receiverId;
    const myUsername = document.body.getAttribute('data-my-username');

    let lastMessageIds = new Set();
    let isUserScrolling = false;

    function fetchMessages() {
        let url = isPrivate ? `/api/private/messages?user_id=${receiverId}` : `/api/chat/messages?room_id=${roomId}`;

        fetch(url)
            .then(response => response.json())
            .then(messages => {
                if (Array.isArray(messages)) {
                    renderMessages(messages);
                }
            })
            .catch(err => console.error('Error fetching messages:', err));
    }

    messageContainer.addEventListener('scroll', () => {
        const threshold = 100;
        isUserScrolling = Math.abs(messageContainer.scrollHeight - messageContainer.scrollTop - messageContainer.clientHeight) > threshold;
    });

    function renderMessages(messages) {
        // Check if there are new messages by comparing IDs
        const currentIds = new Set(messages.map(m => m.id));
        const hasNew = messages.some(m => !lastMessageIds.has(m.id));

        if (!hasNew && messages.length === lastMessageIds.size) return;

        messageContainer.innerHTML = '';

        messages.forEach(msg => {
            const div = document.createElement('div');
            const author = isPrivate ? msg.sender_name : msg.username;
            const isMe = author === myUsername;

            div.className = `message-bubble ${isMe ? 'message-out' : 'message-in'}`;

            let content = `
                <div class="message-info">
                    <span class="message-author">${isMe ? 'شما' : author}</span>
                </div>
            `;

            if (msg.message) {
                content += `<div class="message-text">${formatMessage(msg.message)}</div>`;
            }

            if (msg.image_path) {
                content += `<img src="${msg.image_path}" class="message-image shadow-md" onclick="window.open(this.src)">`;
            }

            content += `<div class="message-time">${msg.created_at.split(' ')[1]}</div>`;

            div.innerHTML = content;
            messageContainer.appendChild(div);
        });

        lastMessageIds = currentIds;

        // Auto scroll to bottom if user is not looking at history
        if (!isUserScrolling) {
            scrollToBottom();
        }
    }

    function formatMessage(text) {
        // Simple XSS is already handled by backend htmlspecialchars,
        // here we can add link detection or line break handling
        return text.replace(/\n/g, '<br>');
    }

    function scrollToBottom() {
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }

    function sendMessage() {
        const text = messageInput.value.trim();
        if (!text) return;

        const formData = new FormData();
        formData.append('message', text);
        if (isPrivate) {
            formData.append('receiver_id', receiverId);
        } else {
            formData.append('room_id', roomId);
        }

        let url = isPrivate ? '/api/private/send' : '/api/chat/send';

        messageInput.value = ''; // Clear immediately for UX

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                fetchMessages();
                isUserScrolling = false; // Force scroll to bottom on my own message
            } else {
                alert('خطا در ارسال پیام');
            }
        });
    }

    function uploadImage(file) {
        const formData = new FormData();
        formData.append('image', file);
        if (isPrivate) {
            formData.append('receiver_id', receiverId);
        } else {
            formData.append('room_id', roomId);
        }

        fetch('/api/upload', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                fetchMessages();
                isUserScrolling = false;
            } else {
                alert('خطا در آپلود: ' + res.message);
            }
        });
    }

    sendBtn.addEventListener('click', sendMessage);
    messageInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });

    imageInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            uploadImage(e.target.files[0]);
        }
    });

    // Auto Refresh every 3 seconds
    setInterval(fetchMessages, 3000);
    fetchMessages();

    // Initial scroll
    setTimeout(scrollToBottom, 500);
});
