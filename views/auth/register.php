<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="min-h-screen flex items-center justify-center p-4 bg-main">
    <div class="w-full max-w-md">
        <div class="bg-card rounded-2xl shadow-2xl overflow-hidden border border-divider">
            <div class="p-8">
                <div class="text-center mb-10">
                    <h1 class="text-4xl font-black text-indigo-400 mb-2">عضویت</h1>
                    <p class="text-muted">به جمع کاربران جتروم بپیوندید.</p>
                </div>

                <?php if (isset($error)): ?>
                    <div class="bg-red-500/10 border border-red-500 text-red-500 p-4 rounded-xl text-sm mb-6 text-center font-bold">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="/register" method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-muted mb-2 mr-1">نام کاربری</label>
                        <input type="text" name="username" required
                               class="w-full bg-input border-divider rounded-xl py-3 px-4 text-main outline-none focus:ring-2 focus:ring-indigo-500/20"
                               placeholder="انتخاب نام کاربری">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-muted mb-2 mr-1">رمز عبور</label>
                        <input type="password" name="password" required
                               class="w-full bg-input border-divider rounded-xl py-3 px-4 text-main outline-none focus:ring-2 focus:ring-indigo-500/20"
                               placeholder="••••••••">
                    </div>
                    <button type="submit" class="btn btn-primary w-full py-4 text-lg">
                        ساخت حساب کاربری
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-muted text-sm">
                        قبلاً ثبت‌نام کرده‌اید؟
                        <a href="/login" class="text-indigo-400 font-bold hover:underline">وارد شوید</a>
                    </p>
                </div>
            </div>
            <div class="bg-indigo-600/10 p-4 text-center border-t border-divider">
                <p class="text-[10px] text-muted uppercase tracking-widest font-bold">Join the Community Today</p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
