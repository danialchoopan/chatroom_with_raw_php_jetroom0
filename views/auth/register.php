<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="flex items-center justify-center min-h-screen bg-gray-900">
    <div class="bg-gray-800 p-8 rounded-2xl shadow-2xl w-full max-w-md border border-gray-700">
        <div class="flex justify-center mb-6">
            <div class="bg-emerald-600 p-4 rounded-full shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
        </div>

        <h2 class="text-3xl font-extrabold mb-2 text-center text-white">ثبت‌نام</h2>
        <p class="text-gray-400 text-center mb-8 text-sm">به جمع کاربران جتروم بپیوندید</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-500/10 border border-red-500 text-red-500 p-3 rounded-lg mb-6 text-sm text-center">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="/register" method="POST" class="space-y-5">
            <div>
                <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-wide">نام کاربری</label>
                <input type="text" name="username" placeholder="Username" class="w-full p-3 rounded-xl bg-gray-700/50 text-white border border-gray-600 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all" required>
            </div>
            <div>
                <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-wide">رمز عبور</label>
                <input type="password" name="password" placeholder="Password" class="w-full p-3 rounded-xl bg-gray-700/50 text-white border border-gray-600 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all" required>
            </div>
            <button type="submit" class="w-full bg-emerald-600 text-white p-3 rounded-xl font-bold hover:bg-emerald-500 shadow-lg shadow-emerald-600/30 transition-all active:scale-95">عضویت در چت‌روم</button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-700 text-center">
            <p class="text-gray-400 text-sm">
                قبلاً ثبت‌نام کرده‌اید؟ <a href="/login" class="text-emerald-400 font-bold hover:text-emerald-300 transition">وارد شوید</a>
            </p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
