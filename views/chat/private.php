<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="flex h-full w-full" data-receiver-id="<?php echo $receiver['id']; ?>">

    <!-- Sidebar (Right Column in RTL) -->
    <div class="sidebar w-80 bg-gray-900 border-l border-gray-800 flex flex-col h-full shadow-2xl z-20">
        <div class="p-6 border-b border-gray-800">
            <a href="/chat" class="flex items-center gap-2 text-indigo-400 hover:text-indigo-300 transition font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                <span>بازگشت به لابی</span>
            </a>
        </div>

        <div class="p-8 flex flex-col items-center gap-4">
            <div class="relative">
                <div class="w-24 h-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl flex items-center justify-center text-4xl font-bold text-white shadow-2xl transform rotate-3">
                    <?php echo mb_substr($receiver['username'], 0, 1); ?>
                </div>
                <div class="absolute -bottom-2 -right-2 w-6 h-6 bg-green-500 border-4 border-gray-900 rounded-full"></div>
            </div>

            <div class="text-center">
                <div class="text-xl font-bold text-white"><?php echo htmlspecialchars($receiver['username']); ?></div>
                <div class="text-sm text-gray-500 mt-1">کاربر تایید شده</div>
            </div>

            <div class="w-full mt-6 space-y-3">
                <div class="bg-gray-800/50 p-4 rounded-xl border border-gray-800">
                    <div class="text-xs text-gray-500 uppercase font-bold mb-1">درباره کاربر</div>
                    <div class="text-sm text-gray-300 italic leading-relaxed">این یک گفتگوی خصوصی و امن بین شما و <?php echo htmlspecialchars($receiver['username']); ?> است.</div>
                </div>
            </div>
        </div>

        <div class="mt-auto p-6 border-t border-gray-800 text-center">
            <p class="text-xs text-gray-600 font-medium">پایان گفتگو؟ <a href="/chat" class="text-indigo-400 hover:underline">بازگشت</a></p>
        </div>
    </div>

    <!-- Main Chat Area (Left Column in RTL) -->
    <div class="chat-area flex-grow flex flex-col h-full overflow-hidden relative">
        <header class="p-4 bg-gray-800 flex items-center border-b border-gray-900 shadow-sm z-10">
            <a href="/chat" class="ml-4 p-2 text-gray-400 hover:text-white transition lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            </a>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center font-bold text-white shadow-md">
                    <?php echo mb_substr($receiver['username'], 0, 1); ?>
                </div>
                <div>
                    <h1 class="font-bold text-white leading-tight"><?php echo htmlspecialchars($receiver['username']); ?></h1>
                    <p class="text-xs text-indigo-400">پیام خصوصی</p>
                </div>
            </div>
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
                <input type="text" id="message-input" placeholder="یک پیام خصوصی بنویسید..." class="input-field flex-grow bg-transparent border-none outline-none text-white text-sm">
                <button id="send-btn" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-1 rounded-md text-sm font-bold transition">ارسال</button>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
