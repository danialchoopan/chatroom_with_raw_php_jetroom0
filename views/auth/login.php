<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="min-h-screen flex items-center justify-center p-4 bg-main">
    <div class="w-full max-w-md">
        <div class="bg-card rounded-2xl shadow-2xl overflow-hidden border border-divider">
            <div class="p-8">
                <div class="text-center mb-10">
                    <h1 class="text-4xl font-black text-indigo-400 mb-2">جتروم</h1>
                    <p class="text-muted">خوش آمدید! وارد حساب خود شوید.</p>
                </div>

                <?php if (isset($error)): ?>
                    <div class="bg-red-500/10 border border-red-500 text-red-500 p-4 rounded-xl text-sm mb-6 text-center font-bold">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="/login" method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-muted mb-2 mr-1">نام کاربری</label>
                        <input type="text" name="username" required
                               class="w-full bg-input border-divider rounded-xl py-3 px-4 text-main outline-none focus:ring-2 focus:ring-indigo-500/20"
                               placeholder="username">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-muted mb-2 mr-1">رمز عبور</label>
                        <input type="password" name="password" required
                               class="w-full bg-input border-divider rounded-xl py-3 px-4 text-main outline-none focus:ring-2 focus:ring-indigo-500/20"
                               placeholder="••••••••">
                    </div>
                    <button type="submit" class="btn btn-primary w-full py-4 text-lg">
                        ورود به سیستم
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-muted text-sm">
                        حساب کاربری ندارید؟
                        <a href="/register" class="text-indigo-400 font-bold hover:underline">ثبت‌نام کنید</a>
                    </p>
                </div>
            </div>
            <div class="bg-indigo-600/10 p-4 text-center border-t border-divider">
                <p class="text-[10px] text-muted uppercase tracking-widest font-bold">Secure Multi-Room Chat System</p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
