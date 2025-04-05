<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Thanh toán đơn hàng</h1>
    <p class="text-center text-muted">Vui lòng nhập đầy đủ thông tin để chúng tôi có thể giao hàng nhanh chóng.</p>

    <form method="POST" action="/webbanhang/Product/processCheckout" class="shadow-lg p-4 rounded bg-light">
        
        <!-- Họ tên -->
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Họ và Tên:</label>
            <input type="text" id="name" name="name" class="form-control border-primary" placeholder="Nhập họ tên của bạn" required>
        </div>

        <!-- Số điện thoại -->
        <div class="mb-3">
            <label for="phone" class="form-label fw-bold">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" class="form-control border-primary" placeholder="Nhập số điện thoại" required>
            <small class="text-muted">Ví dụ: 0901234567</small>
        </div>

        <!-- Địa chỉ giao hàng -->
        <div class="mb-3">
            <label for="address" class="form-label fw-bold">Địa chỉ nhận hàng:</label>
            <textarea id="address" name="address" class="form-control border-primary" rows="3" placeholder="Nhập địa chỉ nhận hàng" required></textarea>
        </div>

        <!-- Nút Thanh Toán -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success px-4 py-2 fw-bold">Xác nhận thanh toán</button>
            <a href="/webbanhang/Product/cart" class="btn btn-outline-secondary px-4 py-2">Quay lại giỏ hàng</a>
        </div>
    </form>
</div>

<!-- Script kiểm tra số điện thoại -->
<script>
    document.getElementById("phone").addEventListener("input", function(event) {
        const phoneInput = event.target;
        const phonePattern = /^0\d{9}$/;  // Kiểm tra số điện thoại hợp lệ (10 chữ số, bắt đầu bằng số 0)

        if (!phonePattern.test(phoneInput.value)) {
            phoneInput.classList.add("is-invalid");
        } else {
            phoneInput.classList.remove("is-invalid");
        }
    });
</script>

<?php include 'app/views/shares/footer.php'; ?>
