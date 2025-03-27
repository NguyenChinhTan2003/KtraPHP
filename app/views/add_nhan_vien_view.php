<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Nhân Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Thêm Nhân Viên Mới</h2>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?controller=nhanvien&action=add" method="post" class="space-y-4">
            <div>
                <label for="Ma_NV" class="block text-gray-700 font-bold mb-2">Mã Nhân Viên:</label>
                <input 
                    type="text" 
                    id="Ma_NV" 
                    name="Ma_NV" 
                    required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Nhập mã nhân viên"
                >
            </div>

            <div>
                <label for="Ten_NV" class="block text-gray-700 font-bold mb-2">Tên Nhân Viên:</label>
                <input 
                    type="text" 
                    id="Ten_NV" 
                    name="Ten_NV" 
                    required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Nhập tên nhân viên"
                >
            </div>

            <div>
                <label for="Phai" class="block text-gray-700 font-bold mb-2">Giới tính:</label>
                <select 
                    id="Phai" 
                    name="Phai" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="NAM">Nam</option>
                    <option value="NU">Nữ</option>
                </select>
            </div>

            <div>
                <label for="Noi_Sinh" class="block text-gray-700 font-bold mb-2">Nơi Sinh:</label>
                <input 
                    type="text" 
                    id="Noi_Sinh" 
                    name="Noi_Sinh" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Nhập nơi sinh"
                >
            </div>

            <div>
                <label for="Ma_Phong" class="block text-gray-700 font-bold mb-2">Phòng Ban:</label>
                <select 
                    id="Ma_Phong" 
                    name="Ma_Phong" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="QT">Quản Trị</option>
                    <option value="TC">Tài Chính</option>
                    <option value="KT">Kỹ Thuật</option>
                    <option value="NS">Nhân Sự</option>
                    <option value="KD">Kinh Doanh</option>
                </select>
            </div>

            <div>
                <label for="Luong" class="block text-gray-700 font-bold mb-2">Lương:</label>
                <input 
                    type="number" 
                    id="Luong" 
                    name="Luong" 
                    min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Nhập mức lương"
                >
            </div>

            <div>
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300 ease-in-out"
                >
                    Thêm Nhân Viên
                </button>
            </div>
        </form>
    </div>

    <script>
        // Optional: Client-side validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const maNV = document.getElementById('Ma_NV');
            const tenNV = document.getElementById('Ten_NV');
            const luong = document.getElementById('Luong');

            // Basic validation
            if (maNV.value.trim() === '') {
                e.preventDefault();
                alert('Vui lòng nhập Mã Nhân Viên');
                maNV.focus();
                return;
            }

            if (tenNV.value.trim() === '') {
                e.preventDefault();
                alert('Vui lòng nhập Tên Nhân Viên');
                tenNV.focus();
                return;
            }

            if (luong.value === '' || parseInt(luong.value) < 0) {
                e.preventDefault();
                alert('Vui lòng nhập mức lương hợp lệ');
                luong.focus();
                return;
            }
        });
    </script>
</body>
</html>