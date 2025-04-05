<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Card đăng ký -->
            <div class="card shadow-lg p-4">
                <h2 class="text-center text-primary mb-4">Đăng Ký Tài Khoản</h2>

                <!-- Hiển thị lỗi -->
                <?php if (isset($errors) && !empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $err): ?>
                                <li><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="/webbanhang/account/save" method="post">
                    <!-- Username & Fullname -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ và Tên</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nhập họ và tên" required>
                        </div>
                    </div>

                    <!-- Password & Confirm Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="confirmpassword" class="form-label">Nhập lại mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Nhập lại mật khẩu" required>
                        </div>
                    </div>

                    <!-- Nút đăng ký -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Đăng Ký</button>
                    </div>
                </form>

                <!-- Chuyển hướng đến trang đăng nhập -->
                <div class="text-center mt-3">
                    <p class="mb-0">Bạn đã có tài khoản? <a href="/webbanhang/account/login" class="text-decoration-none text-primary fw-bold">Đăng nhập ngay</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<!-- Thêm CSS -->
<style>
    .card {
        border-radius: 15px;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    .input-group-text {
        background-color: #f0f0f0;
        border-right: 0;
    }
    .form-control {
        border-left: 0;
    }
</style>
