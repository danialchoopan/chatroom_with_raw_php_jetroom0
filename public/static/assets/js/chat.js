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
    const userRole = chatContainer.getAttribute('data-role');
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

            div.className = `message-bubble ${isMe ? 'message-out' : 'message-in'} relative group`;

            let content = `
                <div class="message-info flex justify-between items-start">
                    <span class="message-author">${isMe ? 'شما' : author}</span>
                    ${(userRole === 'admin' && !isPrivate) ? `
                        <button class="delete-msg-btn hidden group-hover:block text-red-400 hover:text-red-500 transition-all ml-2" data-id="${msg.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    ` : ''}
                </div>
            `;

            if (msg.message) {
                content += `<div class="message-text">${formatMessage(msg.message)}</div>`;
            }

            if (msg.image_path) {
                content += `<img src="${msg.image_path}" class="message-image shadow-md cursor-pointer" onclick="window.open(this.src)">`;
            }

            content += `<div class="message-time">${msg.created_at.split(' ')[1]}</div>`;

            div.innerHTML = content;
            messageContainer.appendChild(div);

            // Add listener to delete button
            const deleteBtn = div.querySelector('.delete-msg-btn');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    if (confirm('آیا از حذف این پیام اطمینان دارید؟')) {
                        deleteMessage(msg.id);
                    }
                });
            }
        });

        lastMessageIds = currentIds;

        // Auto scroll to bottom if user is not looking at history
        if (!isUserScrolling) {
            scrollToBottom();
        }
    }

    function deleteMessage(id) {
        const formData = new FormData();
        formData.append('message_id', id);

        fetch('/api/admin/delete-message', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(res => {
            if (res.success) {
                fetchMessages();
            } else {
                alert('خطا در حذف پیام');
            }
        });
    }

    function formatMessage(text) {
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
