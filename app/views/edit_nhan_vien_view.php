<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Nhân Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Sửa Thông Tin Nhân Viên</h2>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?controller=nhanvien&action=edit&id=<?php echo htmlspecialchars($employee['Ma_NV']); ?>" method="post" class="space-y-4">
            <div>
                <label for="Ma_NV" class="block text-gray-700 font-bold mb-2">Mã Nhân Viên:</label>
                <input 
                    type="text" 
                    id="Ma_NV" 
                    name="Ma_NV" 
                    value="<?php echo htmlspecialchars($employee['Ma_NV']); ?>" 
                    readonly 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed"
                >
            </div>

            <div>
                <label for="Ten_NV" class="block text-gray-700 font-bold mb-2">Tên Nhân Viên:</label>
                <input 
                    type="text" 
                    id="Ten_NV" 
                    name="Ten_NV" 
                    value="<?php echo htmlspecialchars($employee['Ten_NV']); ?>" 
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
                    <option value="NAM" <?php if ($employee['Phai'] === 'NAM') echo 'selected'; ?>>Nam</option>
                    <option value="NU" <?php if ($employee['Phai'] === 'NU') echo 'selected'; ?>>Nữ</option>
                </select>
            </div>

            <div>
                <label for="Noi_Sinh" class="block text-gray-700 font-bold mb-2">Nơi Sinh:</label>
                <input 
                    type="text" 
                    id="Noi_Sinh" 
                    name="Noi_Sinh" 
                    value="<?php echo htmlspecialchars($employee['Noi_Sinh']); ?>" 
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
                    <option value="QT" <?php if ($employee['Ma_Phong'] === 'QT') echo 'selected'; ?>>Quản Trị</option>
                    <option value="TC" <?php if ($employee['Ma_Phong'] === 'TC') echo 'selected'; ?>>Tài Chính</option>
                    <option value="KT" <?php if ($employee['Ma_Phong'] === 'KT') echo 'selected'; ?>>Kỹ Thuật</option>
                    <option value="NS" <?php if ($employee['Ma_Phong'] === 'NS') echo 'selected'; ?>>Nhân Sự</option>
                    <option value="KD" <?php if ($employee['Ma_Phong'] === 'KD') echo 'selected'; ?>>Kinh Doanh</option>
                </select>
            </div>

            <div>
                <label for="Luong" class="block text-gray-700 font-bold mb-2">Lương:</label>
                <input 
                    type="number" 
                    id="Luong" 
                    name="Luong" 
                    min="0"
                    value="<?php echo htmlspecialchars($employee['Luong']); ?>" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Nhập mức lương"
                >
            </div>

            <div>
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300 ease-in-out"
                >
                    Lưu Thay Đổi
                </button>
            </div>
        </form>
    </div>

    <script>
        // Optional: Client-side validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const tenNV = document.getElementById('Ten_NV');
            const luong = document.getElementById('Luong');

            // Basic validation
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