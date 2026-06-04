<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="flex h-screen bg-main text-main overflow-hidden">
    <!-- Sidebar -->
    <div class="w-64 bg-sidebar flex flex-col border-l border-divider">
        <div class="p-6">
            <h1 class="text-2xl font-black text-indigo-400">پنل مدیریت</h1>
        </div>
        <nav class="flex-grow px-4 space-y-2">
            <a href="/admin" class="flex items-center gap-3 p-3 bg-indigo-600/20 text-indigo-400 rounded-xl font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>
                مدیریت کاربران
            </a>
            <a href="/admin/rooms" class="flex items-center gap-3 p-3 hover:bg-active rounded-xl transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                </svg>
                مدیریت اتاق‌ها
            </a>
            <a href="/chat" class="flex items-center gap-3 p-3 hover:bg-active rounded-xl transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
                </svg>
                بازگشت به چت
            </a>
        </nav>
        <div class="p-4 border-t border-divider">
            <div class="flex items-center gap-3 p-2">
                <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center font-bold text-white">A</div>
                <div>
                    <div class="text-sm font-bold"><?php echo $_SESSION['username']; ?></div>
                    <div class="text-xs text-muted">مدیر کل</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow flex flex-col overflow-hidden">
        <header class="h-16 bg-header border-b border-divider flex items-center px-8 justify-between">
            <h2 class="text-lg font-bold">لیست کاربران سیستم</h2>
            <div class="text-sm text-muted"><?php echo count($users); ?> کاربر ثبت شده</div>
        </header>

        <main class="flex-grow p-8 overflow-y-auto custom-scrollbar">
            <div class="bg-card rounded-2xl border border-divider overflow-hidden shadow-xl">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-indigo-600/5 text-muted text-xs uppercase tracking-wider">
                            <th class="p-4 font-bold">نام کاربری</th>
                            <th class="p-4 font-bold">نقش</th>
                            <th class="p-4 font-bold">تاریخ عضویت</th>
                            <th class="p-4 font-bold text-center">وضعیت</th>
                            <th class="p-4 font-bold text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-divider">
                        <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-active/30 transition">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-input flex items-center justify-center text-xs font-bold text-main">
                                        <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                                    </div>
                                    <span class="font-medium"><?php echo htmlspecialchars($user['username']); ?></span>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded-md text-[10px] font-bold <?php echo $user['role'] === 'admin' ? 'bg-indigo-500/20 text-indigo-400' : 'bg-input text-muted'; ?>">
                                    <?php echo $user['role'] === 'admin' ? 'مدیر' : 'کاربر عادی'; ?>
                                </span>
                            </td>
                            <td class="p-4 text-sm text-muted">
                                <?php echo date('Y/m/d H:i', strtotime($user['created_at'])); ?>
                            </td>
                            <td class="p-4 text-center">
                                <?php if ($user['is_blocked']): ?>
                                    <span class="text-red-500 text-xs font-bold flex items-center justify-center gap-1">
                                        <div class="w-2 h-2 rounded-full bg-red-500"></div> مسدود
                                    </span>
                                <?php else: ?>
                                    <span class="text-emerald-500 text-xs font-bold flex items-center justify-center gap-1">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div> فعال
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-2">
                                    <?php if ($user['role'] !== 'admin'): ?>
                                    <form action="/admin/toggle-block" method="POST" onsubmit="return confirm('آیا از تغییر وضعیت مسدودیت این کاربر اطمینان دارید؟')">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="p-2 rounded-lg hover:bg-input text-muted hover:text-main transition" title="<?php echo $user['is_blocked'] ? 'رفع مسدودیت' : 'مسدود کردن'; ?>">
                                            <?php if ($user['is_blocked']): ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            <?php else: ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                  <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd" />
                                                </svg>
                                            <?php endif; ?>
                                        </button>
                                    </form>
                                    <form action="/admin/delete-user" method="POST" onsubmit="return confirm('آیا از حذف کامل این کاربر اطمینان دارید؟ این عمل غیرقابل بازگشت است.')">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="p-2 rounded-lg hover:bg-red-500/10 text-muted hover:text-red-500 transition" title="حذف کاربر">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                              <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                    <?php else: ?>
                                        <span class="text-xs text-muted italic">بدون دسترسی</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
