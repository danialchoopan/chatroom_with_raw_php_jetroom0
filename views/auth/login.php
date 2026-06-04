<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="flex items-center justify-center h-full">
    <div class="bg-gray-800 p-8 rounded shadow-lg w-96">
        <h2 class="text-2xl font-bold mb-6 text-center text-white">ورود به حساب</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-500 text-white p-2 rounded mb-4 text-sm"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-500 text-white p-2 rounded mb-4 text-sm"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form action="/login" method="POST" class="flex flex-col gap-4">
            <input type="text" name="username" placeholder="نام کاربری" class="p-2 rounded bg-gray-700 text-white border-none outline-none" required>
            <input type="password" name="password" placeholder="رمز عبور" class="p-2 rounded bg-gray-700 text-white border-none outline-none" required>
            <button type="submit" class="bg-indigo-500 text-white p-2 rounded font-bold hover:bg-indigo-600 transition">ورود</button>
        </form>

        <p class="mt-4 text-sm text-center">
            حساب ندارید؟ <a href="/register" class="text-indigo-400">ثبت‌نام کنید</a>
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
