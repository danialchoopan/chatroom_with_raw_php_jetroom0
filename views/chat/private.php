<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="flex h-full" data-receiver-id="<?php echo $receiver['id']; ?>">
    <!-- Sidebar: Mini (just to keep layout consistent or go back) -->
    <div class="sidebar flex flex-col p-4">
        <a href="/chat" class="bg-gray-700 p-2 rounded text-center text-sm mb-6 hover:bg-gray-600">بازگشت به لابی</a>

        <h2 class="font-bold text-white text-sm mb-4">گفتگوی خصوصی با:</h2>
        <div class="flex items-center gap-2 p-2 bg-indigo-500 rounded">
            <span class="font-bold text-white"><?php echo htmlspecialchars($receiver['username']); ?></span>
        </div>
    </div>

    <!-- Main Chat Area -->
    <div class="chat-area flex flex-col">
        <header class="p-4 border-b border-gray-900 shadow-sm">
            <h1 class="font-bold text-white">@ <?php echo htmlspecialchars($receiver['username']); ?></h1>
        </header>

        <div id="messages" class="flex-grow overflow-y-auto p-4 flex flex-col gap-2">
            <!-- Messages will be loaded here via JS -->
        </div>

        <div class="input-container p-2 flex items-center gap-2">
            <label for="image-input" class="cursor-pointer p-2 hover:bg-gray-600 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                <input type="file" id="image-input" class="hidden" accept="image/*">
            </label>
            <input type="text" id="message-input" placeholder="پیام خصوصی به <?php echo htmlspecialchars($receiver['username']); ?>" class="bg-transparent flex-grow border-none outline-none text-white p-2">
            <button id="send-btn" class="bg-indigo-500 p-2 rounded text-white font-bold hover:bg-indigo-600">ارسال</button>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
