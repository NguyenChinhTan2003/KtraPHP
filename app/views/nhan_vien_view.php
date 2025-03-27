<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Nhân Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        
        /* Responsive table strategy */
        @media screen and (max-width: 640px) {
            .responsive-table {
                display: block;
                width: 100%;
                overflow-x: auto;
            }
            
            .responsive-table thead {
                display: none;
            }
            
            .responsive-table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #ddd;
            }
            
            .responsive-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: right;
                padding: 0.5rem;
                border-bottom: 1px solid #eee;
            }
            
            .responsive-table td::before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
            }
        }
    </style>
</head>
<body class="bg-gray-100 p-4 md:p-6">
    <div class="container mx-auto max-w-7xl bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Header with Responsive Logout -->
        <div class="bg-blue-600 text-white p-4 flex flex-col md:flex-row justify-between items-center">
            <h2 class="text-xl md:text-2xl font-bold mb-2 md:mb-0">THÔNG TIN NHÂN VIÊN</h2>
            <a href="index.php?controller=auth&action=logout" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                Đăng xuất
            </a>
        </div>

        <!-- Success Messages -->
        <div class="p-4">
            <?php if (isset($_GET['message']) && $_GET['message'] === 'add_success'): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    Nhân viên đã được thêm thành công!
                </div>
            <?php elseif (isset($_GET['message']) && $_GET['message'] === 'edit_success'): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    Thông tin nhân viên đã được cập nhật thành công!
                </div>
            <?php elseif (isset($_GET['message']) && $_GET['message'] === 'delete_success'): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    Nhân viên đã được xóa thành công!
                </div>
            <?php endif; ?>
        </div>

        <!-- Add Employee Button -->
        <?php if ($userRole == 2): ?>
            <div class="p-4">
                <a href="index.php?controller=nhanvien&action=add" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">
                    + Thêm Nhân Viên
                </a>
            </div>
        <?php endif; ?>

        <!-- Responsive Employee Table -->
        <div class="overflow-x-auto p-4">
            <table class="min-w-full responsive-table divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã NV</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên NV</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giới tính</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nơi Sinh</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phòng</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lương</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($employees as $employee): ?>
                        <tr class="hover:bg-gray-100">
                            <td data-label="Mã NV" class="px-4 py-3 whitespace-nowrap"><?php echo htmlspecialchars($employee['Ma_NV']); ?></td>
                            <td data-label="Tên NV" class="px-4 py-3 whitespace-nowrap"><?php echo htmlspecialchars($employee['Ten_NV']); ?></td>
                            <td data-label="Giới tính" class="px-4 py-3 whitespace-nowrap">
                                <?php
                                $genderImage = '';
                                if ($employee['Phai'] === 'NAM') {
                                    $genderImage = 'public/uploads/man.png';
                                } elseif ($employee['Phai'] === 'NU') {
                                    $genderImage = 'public/uploads/girl.png';
                                }
                                if ($genderImage) {
                                    echo '<img src="' . htmlspecialchars($genderImage) . '" alt="' . htmlspecialchars($employee['Phai']) . '" class="w-8 h-8 inline-block">';
                                } else {
                                    echo htmlspecialchars($employee['Phai']);
                                }
                                ?>
                            </td>
                            <td data-label="Nơi Sinh" class="px-4 py-3 whitespace-nowrap"><?php echo htmlspecialchars($employee['Noi_Sinh']); ?></td>
                            <td data-label="Phòng" class="px-4 py-3 whitespace-nowrap"><?php echo htmlspecialchars($employee['Ten_Phong']); ?></td>
                            <td data-label="Lương" class="px-4 py-3 whitespace-nowrap"><?php echo htmlspecialchars(number_format($employee['Luong'])); ?> VND</td>
                            <td data-label="Thao Tác" class="px-4 py-3 whitespace-nowrap">
                                <?php if ($userRole == 2): ?>
                                    <div class="flex space-x-2">
                                        <a href="index.php?controller=nhanvien&action=edit&id=<?php echo htmlspecialchars($employee['Ma_NV']); ?>"
                                            class="text-blue-500 hover:text-blue-700 mr-2"
                                            title="Sửa">
                                            ✏️
                                        </a>
                                        <a href="index.php?controller=nhanvien&action=delete&id=<?php echo htmlspecialchars($employee['Ma_NV']); ?>"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?')"
                                            class="text-red-500 hover:text-red-700"
                                            title="Xóa">
                                            🗑️
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <span class="text-gray-400">Không có quyền</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Responsive Pagination -->
        <div class="bg-gray-50 px-4 py-3 flex flex-col md:flex-row items-center justify-between border-t border-gray-200">
            <?php if ($totalPages > 1): ?>
                <div class="flex-1 flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-2 md:mb-0">
                        <p class="text-sm text-gray-700">
                            Hiển thị
                            <span class="font-medium"><?php echo count($employees); ?></span>
                            trong tổng số
                            <span class="font-medium"><?php echo $totalEmployees; ?></span>
                            nhân viên
                        </p>
                    </div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php if ($page > 1): ?>
                            <a href="index.php?controller=nhanvien&action=index&page=<?php echo $page - 1; ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="index.php?controller=nhanvien&action=index&page=<?php echo $i; ?>" aria-current="page" class="<?php echo ($i === $page) ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium'; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="index.php?controller=nhanvien&action=index&page=<?php echo $page + 1; ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteLinks = document.querySelectorAll('a[title="Xóa"]');
            deleteLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (!confirm('Bạn có chắc chắn muốn xóa nhân viên này?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script> -->
</body>
</html>