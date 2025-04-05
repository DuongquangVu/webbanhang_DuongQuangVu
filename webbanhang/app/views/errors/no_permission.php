<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lỗi quyền truy cập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa; /* Màu nền giống trang chính */
        }
        .error-box {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .error-box h1 {
            color: #dc3545; /* Màu đỏ Bootstrap */
            font-size: 28px;
        }
        .error-box p {
            color: #343a40; /* Màu chữ header */
            font-size: 18px;
        }
        .btn-home {
            margin-top: 20px;
            background-color: #343a40; /* Màu header */
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            font-weight: bold;
        }
        .btn-home:hover {
            background-color: #23272b; /* Màu hover header */
        }
    </style>
</head>
<body>
    <div class="error-box">
        <h1>🚫 Truy cập bị từ chối</h1>
        <p>Bạn không có quyền truy cập vào trang này.<br>Vui lòng liên hệ quản trị viên để biết thêm chi tiết.</p>
        <a href="/webbanhang/Product" class="btn-home">Quay lại trang chính</a>
    </div>
</body>
</html>
