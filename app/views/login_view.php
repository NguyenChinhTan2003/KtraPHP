<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Đăng nhập</h2>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form action="index.php?controller=auth&action=login" method="post">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">
                        Tên đăng nhập
                    </label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        required 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Nhập tên đăng nhập"
                    >
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                        Mật khẩu
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Nhập mật khẩu"
                    >
                </div>
                <div class="flex items-center justify-center">
                    <button 
                        type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:scale-105"
                    >
                        Đăng nhập
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Optional: Footer or Additional Information -->
        <div class="text-center text-gray-500 text-sm">
            © <?php echo date('Y'); ?> Hệ thống Quản lý Nhân viên
        </div>
    </div>

    <script>
        // Optional: Add client-side validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const username = document.getElementById('username');
            const password = document.getElementById('password');
            
            if (username.value.trim() === '' || password.value.trim() === '') {
                e.preventDefault();
                alert('Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu');
            }
        });
    </script>
</body>
</html>