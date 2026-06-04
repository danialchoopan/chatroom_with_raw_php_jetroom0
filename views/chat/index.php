<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="flex h-full flex-row-reverse" data-room-id="<?php echo $currentRoom['id']; ?>">
    <!-- Left Sidebar: Profile, Rooms, Active PMs -->
    <div class="sidebar flex flex-col p-4 border-l border-gray-900">
        <div class="flex items-center gap-2 mb-6 p-2 bg-gray-800 rounded">
            <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center font-bold text-white">
                <?php echo mb_substr($username, 0, 1); ?>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-bold text-white"><?php echo htmlspecialchars($username); ?></span>
                <span class="text-xs text-green-500">آنلاین</span>
            </div>
        </div>

        <div class="mb-6 overflow-y-auto">
            <h2 class="font-bold text-gray-400 text-xs mb-4 uppercase tracking-widest">اتاق‌های گفتگو</h2>
            <div class="flex flex-col gap-1">
                <?php foreach ($rooms as $room): ?>
                    <a href="/chat?room_id=<?php echo $room['id']; ?>" class="room-item p-2 block text-sm transition <?php echo ($room['id'] == $currentRoom['id']) ? 'active bg-gray-700 text-white' : 'text-gray-400 hover:text-gray-200'; ?>">
                        # <?php echo htmlspecialchars($room['name']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mt-4">
            <h2 class="font-bold text-gray-400 text-xs mb-4 uppercase tracking-widest">پیام‌های خصوصی اخیر</h2>
            <div class="flex flex-col gap-1">
                <?php foreach ($activePms as $pm): ?>
                    <a href="/private?user_id=<?php echo $pm['id']; ?>" class="p-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded block transition">
                        @ <?php echo htmlspecialchars($pm['username']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mt-auto pt-4 border-t border-gray-700">
            <a href="/logout" class="text-sm text-red-400 hover:text-red-300 transition">خروج از حساب</a>
        </div>
    </div>

    <!-- Right Area: Chat Environment & Online Users -->
    <div class="chat-area flex">
        <!-- Main Chat Area -->
        <div class="flex flex-col flex-grow">
            <header class="p-4 border-b border-gray-900 shadow-sm flex justify-between items-center bg-gray-750">
                <h1 class="font-bold text-white"># <?php echo htmlspecialchars($currentRoom['name']); ?></h1>
                <p class="text-xs text-gray-400"><?php echo htmlspecialchars($currentRoom['description']); ?></p>
            </header>

            <div id="messages" class="flex-grow overflow-y-auto p-6 flex flex-col gap-4 bg-chat-pattern">
                <!-- Messages will be loaded here via JS -->
            </div>

            <div class="input-container p-3 flex items-center gap-3">
                <label for="image-input" class="cursor-pointer p-2 hover:bg-gray-600 rounded-full transition text-gray-400 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <input type="file" id="image-input" class="hidden" accept="image/*">
                </label>
                <input type="text" id="message-input" placeholder="پیام به #<?php echo htmlspecialchars($currentRoom['name']); ?>" class="bg-transparent flex-grow border-none outline-none text-white p-2 placeholder-gray-500">
                <button id="send-btn" class="bg-indigo-500 px-4 py-2 rounded text-white font-bold hover:bg-indigo-600 transition shadow-md">ارسال</button>
            </div>
        </div>

        <!-- Online Users (Part of the Right Area) -->
        <div class="user-list p-4 flex flex-col border-r border-gray-900 bg-gray-850">
            <h2 class="font-bold text-xs text-gray-500 mb-4 uppercase tracking-widest">کاربران آنلاین (<?php echo count($onlineUsers); ?>)</h2>
            <div class="flex flex-col gap-3">
                <?php foreach ($onlineUsers as $user): ?>
                    <a href="/private?user_id=<?php echo $user['id']; ?>" class="flex items-center gap-3 hover:bg-gray-800 p-2 rounded group transition">
                        <div class="relative">
                            <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center text-xs text-white font-bold">
                                <?php echo mb_substr($user['username'], 0, 1); ?>
                            </div>
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-gray-850 rounded-full"></div>
                        </div>
                        <span class="text-sm text-gray-400 group-hover:text-white transition"><?php echo htmlspecialchars($user['username']); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
