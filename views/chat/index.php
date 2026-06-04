<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="flex h-full w-full" data-room-id="<?php echo $currentRoom['id']; ?>" data-role="<?php echo $_SESSION['role'] ?? 'user'; ?>">

    <!-- Right Column (ستون سمت راست): Chat Environment & Online Users -->
    <div class="chat-area flex-grow flex h-full overflow-hidden relative">
        <!-- Main Chat (Center-ish) -->
        <div class="flex-grow flex flex-col h-full border-l border-gray-800">
            <header class="p-4 bg-gray-800 flex items-center justify-between border-b border-gray-900 shadow-sm z-10">
                <div class="flex items-center gap-4">
                    <h1 class="font-bold text-white text-lg"># <?php echo htmlspecialchars($currentRoom['name']); ?></h1>
                    <p class="text-xs text-gray-400 hidden sm:block"><?php echo htmlspecialchars($currentRoom['description']); ?></p>
                </div>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="/admin" class="bg-indigo-600/20 text-indigo-400 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-600 hover:text-white transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                        پنل مدیریت
                    </a>
                <?php endif; ?>
            </header>

            <div id="messages" class="flex-grow overflow-y-auto p-4 flex flex-col space-y-4 custom-scrollbar">
                <!-- Messages loaded via JS -->
            </div>

            <div class="input-bar border-t border-gray-900 bg-gray-800 p-4">
                <div class="flex items-center bg-gray-700 rounded-lg px-4 py-2 gap-3 shadow-inner">
                    <label for="image-input" class="cursor-pointer text-gray-400 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        <input type="file" id="image-input" class="hidden" accept="image/*">
                    </label>
                    <input type="text" id="message-input" placeholder="یک پیام بنویسید..." class="input-field flex-grow bg-transparent border-none outline-none text-white text-sm">
                    <button id="send-btn" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-1 rounded-md text-sm font-bold transition">ارسال</button>
                </div>
            </div>
        </div>

        <!-- Online Users List (Part of Right Column) -->
        <div class="w-64 bg-gray-900/50 flex flex-col h-full hidden lg:flex">
            <div class="p-4 text-xs font-bold text-gray-500 uppercase tracking-widest border-b border-gray-800">کاربران آنلاین (<?php echo count($onlineUsers); ?>)</div>
            <div class="flex-grow overflow-y-auto py-2 custom-scrollbar">
                <?php foreach ($onlineUsers as $user): ?>
                    <a href="/private?user_id=<?php echo $user['id']; ?>" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-800 transition group">
                        <div class="relative">
                            <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center font-bold text-xs text-gray-300 group-hover:bg-indigo-500 group-hover:text-white transition">
                                <?php echo mb_substr($user['username'], 0, 1); ?>
                            </div>
                            <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-gray-900 rounded-full"></div>
                        </div>
                        <div class="flex flex-col truncate">
                            <span class="text-sm text-gray-400 group-hover:text-white transition truncate"><?php echo htmlspecialchars($user['username']); ?></span>
                            <?php if ($user['role'] === 'admin'): ?>
                                <span class="text-[9px] text-indigo-400 font-bold uppercase tracking-tighter">Admin</span>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Left Column (ستون سمت چپ): Profile, Rooms, Active PMs -->
    <div class="sidebar w-80 bg-gray-900 flex flex-col h-full shadow-2xl z-20">
        <!-- User Profile -->
        <div class="p-6 bg-gray-800/50 border-b border-gray-800">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center font-bold text-white text-xl shadow-lg transform rotate-3">
                    <?php echo mb_substr($username, 0, 1); ?>
                </div>
                <div class="flex-grow">
                    <div class="text-base font-bold text-white"><?php echo htmlspecialchars($username); ?></div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-xs text-gray-400">آنلاین</span>
                    </div>
                </div>
                <a href="/logout" class="p-2 text-gray-500 hover:text-red-400 transition" title="خروج">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </a>
            </div>
        </div>

        <!-- Room List -->
        <div class="flex-grow overflow-y-auto py-4 custom-scrollbar">
            <div class="px-6 mb-2 text-xs font-bold text-gray-500 uppercase tracking-widest text-right">اتاق‌های گفتگو</div>
            <div class="space-y-1 px-3">
                <?php foreach ($rooms as $room): ?>
                    <a href="/chat?room_id=<?php echo $room['id']; ?>" class="room-item group flex items-center gap-3 p-3 rounded-xl transition <?php echo ($room['id'] == $currentRoom['id']) ? 'active bg-indigo-600/20 text-indigo-300' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-200'; ?>">
                        <div class="w-10 h-10 rounded-xl bg-gray-800 flex items-center justify-center text-lg font-bold group-hover:bg-gray-700 transition">#</div>
                        <div class="flex flex-col overflow-hidden text-right">
                            <span class="text-sm font-bold truncate"><?php echo htmlspecialchars($room['name']); ?></span>
                            <span class="text-xs opacity-60 truncate"><?php echo htmlspecialchars($room['description']); ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Active PMs -->
            <?php if (!empty($activePms)): ?>
                <div class="px-6 mt-8 mb-2 text-xs font-bold text-gray-500 uppercase tracking-widest text-right">پیام‌های خصوصی</div>
                <div class="space-y-1 px-3">
                    <?php foreach ($activePms as $pm): ?>
                        <a href="/private?user_id=<?php echo $pm['id']; ?>" class="room-item flex items-center gap-3 p-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-gray-200 transition">
                            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-sm font-bold text-white">
                                <?php echo mb_substr($pm['username'], 0, 1); ?>
                            </div>
                            <span class="text-sm font-bold"><?php echo htmlspecialchars($pm['username']); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
