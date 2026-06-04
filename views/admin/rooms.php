<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="flex h-screen bg-main text-main overflow-hidden">
    <!-- Sidebar -->
    <div class="w-64 bg-sidebar flex flex-col border-l border-divider">
        <div class="p-6">
            <h1 class="text-2xl font-black text-indigo-400">پنل مدیریت</h1>
        </div>
        <nav class="flex-grow px-4 space-y-2">
            <a href="/admin" class="flex items-center gap-3 p-3 hover:bg-active rounded-xl transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>
                مدیریت کاربران
            </a>
            <a href="/admin/rooms" class="flex items-center gap-3 p-3 bg-indigo-600/20 text-indigo-400 rounded-xl font-bold">
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
            <h2 class="text-lg font-bold">مدیریت اتاق‌های گفتگو</h2>
            <button onclick="document.getElementById('add-room-modal').classList.remove('hidden')" class="btn btn-primary px-4 py-2 text-sm">
                افزودن اتاق جدید
            </button>
        </header>

        <main class="flex-grow p-8 overflow-y-auto custom-scrollbar">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($rooms as $room): ?>
                <div class="bg-card rounded-2xl border border-divider p-6 shadow-xl relative group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-600/10 text-indigo-400 flex items-center justify-center text-2xl font-bold">#</div>
                        <div class="flex gap-2">
                            <button onclick='editRoom(<?php echo json_encode($room); ?>)' class="p-2 text-muted hover:text-indigo-400 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                  <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </button>
                            <form action="/admin/rooms/delete" method="POST" onsubmit="return confirm('آیا از حذف این اتاق اطمینان دارید؟ تمامی پیام‌ها نیز حذف خواهند شد.')">
                                <input type="hidden" name="id" value="<?php echo $room['id']; ?>">
                                <button type="submit" class="p-2 text-muted hover:text-red-500 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold mb-1"><?php echo htmlspecialchars($room['name']); ?></h3>
                    <p class="text-xs text-indigo-400 font-mono mb-3">/chat?slug=<?php echo htmlspecialchars($room['slug']); ?></p>
                    <p class="text-sm text-muted line-clamp-2"><?php echo htmlspecialchars($room['description']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="add-room-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-card w-full max-w-md rounded-2xl border border-divider shadow-2xl overflow-hidden">
        <form id="room-form" action="/admin/rooms/add" method="POST" class="p-8">
            <h2 id="modal-title" class="text-2xl font-bold mb-6">افزودن اتاق جدید</h2>
            <input type="hidden" id="room-id" name="id">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-muted mb-2 mr-1">نام اتاق</label>
                    <input type="text" id="room-name" name="name" required placeholder="مثلاً: تکنولوژی">
                </div>
                <div>
                    <label class="block text-sm font-bold text-muted mb-2 mr-1">اسلاگ (Slug)</label>
                    <input type="text" id="room-slug" name="slug" required placeholder="مثلاً: tech">
                </div>
                <div>
                    <label class="block text-sm font-bold text-muted mb-2 mr-1">توضیحات</label>
                    <textarea id="room-desc" name="description" rows="3" placeholder="توضیح کوتاهی درباره اتاق..."></textarea>
                </div>
            </div>
            <div class="mt-8 flex gap-3">
                <button type="submit" class="btn btn-primary flex-grow py-3">ذخیره تغییرات</button>
                <button type="button" onclick="closeModal()" class="btn bg-input text-main flex-grow py-3">انصراف</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editRoom(room) {
        document.getElementById('modal-title').innerText = 'ویرایش اتاق';
        document.getElementById('room-form').action = '/admin/rooms/edit';
        document.getElementById('room-id').value = room.id;
        document.getElementById('room-name').value = room.name;
        document.getElementById('room-slug').value = room.slug;
        document.getElementById('room-desc').value = room.description;
        document.getElementById('add-room-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('add-room-modal').classList.add('hidden');
        document.getElementById('room-form').reset();
        document.getElementById('room-form').action = '/admin/rooms/add';
        document.getElementById('modal-title').innerText = 'افزودن اتاق جدید';
    }
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
.fixed { position: fixed; }
.z-50 { z-index: 50; }
.bg-black\/60 { background-color: rgba(0,0,0,0.6); }
.backdrop-blur-sm { backdrop-filter: blur(4px); }
</style>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
