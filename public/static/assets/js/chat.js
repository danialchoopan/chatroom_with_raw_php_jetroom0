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

    function fetchMessages() {
        let url = isPrivate ? `/api/private/messages?user_id=${receiverId}` : `/api/chat/messages?room_id=${roomId}`;

        fetch(url)
            .then(response => response.json())
            .then(messages => {
                renderMessages(messages);
            })
            .catch(err => console.error('Error fetching messages:', err));
    }

    let lastMessageCount = 0;
    let isUserScrolling = false;

    messageContainer.addEventListener('scroll', () => {
        const threshold = 50;
        isUserScrolling = messageContainer.scrollHeight - messageContainer.scrollTop - messageContainer.clientHeight > threshold;
    });

    function renderMessages(messages) {
        if (messages.length === lastMessageCount) return;

        messageContainer.innerHTML = '';
        messages.forEach(msg => {
            const div = document.createElement('div');
            div.className = 'message-box';

            let content = `<div class="flex items-center gap-2">
                <span class="font-bold text-white">${isPrivate ? msg.sender_name : msg.username}</span>
                <span class="text-xs text-gray-400">${msg.created_at}</span>
            </div>`;

            if (msg.message) {
                content += `<p class="mt-1">${msg.message}</p>`;
            }

            if (msg.image_path) {
                content += `<img src="${msg.image_path}" class="mt-2 rounded max-w-xs cursor-pointer" onclick="window.open(this.src)">`;
            }

            div.innerHTML = content;
            messageContainer.appendChild(div);
        });

        if (!isUserScrolling) {
            messageContainer.scrollTop = messageContainer.scrollHeight;
        }
        lastMessageCount = messages.length;
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

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                messageInput.value = '';
                fetchMessages();
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
});
