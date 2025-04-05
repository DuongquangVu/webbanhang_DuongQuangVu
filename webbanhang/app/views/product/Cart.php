<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Giỏ hàng của bạn</h1>

    <?php if (!empty($cart)): ?>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($cart as $id => $item): ?>
                        <?php $subtotal = $item['price'] * $item['quantity']; ?>
                        <?php $total += $subtotal; ?>
                        <tr data-id="<?php echo $id; ?>">
                            <td>
                                <?php if ($item['image']): ?>
                                    <img src="/webbanhang/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" 
                                         alt="Product Image" 
                                         class="img-thumbnail" 
                                         style="max-width: 100px;">
                                <?php else: ?>
                                    <img src="/webbanhang/app/images/default-product.png" 
                                         alt="No Image" 
                                         class="img-thumbnail" 
                                         style="max-width: 100px;">
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="price"><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                            <td>
                                <input type="number" class="quantity form-control d-inline-block text-center" 
                                       value="<?php echo $item['quantity']; ?>" 
                                       min="1" 
                                       style="width: 60px;">
                            </td>
                            <td class="subtotal"><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</td>
                            <td>
                                <a href="/webbanhang/Product/removeFromCart/<?php echo $id; ?>" 
                                   class="btn btn-danger btn-sm btn-remove"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">
                                    Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Tổng cộng:</strong></td>
                        <td colspan="2"><strong id="total-price"><?php echo number_format($total, 0, ',', '.'); ?> VND</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center text-muted">Giỏ hàng của bạn đang trống.</p>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="/webbanhang/Product" class="btn btn-secondary">Tiếp tục mua sắm</a>
        <?php if (!empty($cart)): ?>
            <a href="/webbanhang/Product/checkout" class="btn btn-success">Thanh toán</a>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const quantityInputs = document.querySelectorAll(".quantity");

    quantityInputs.forEach(input => {
        input.addEventListener("input", function() {
            let row = this.closest("tr");
            let id = row.getAttribute("data-id");
            let price = parseFloat(row.querySelector(".price").innerText.replace(/\./g, "").replace(" VND", ""));
            let quantity = parseInt(this.value);
            
            if (quantity < 1) {
                this.value = 1;
                quantity = 1;
            }

            // Cập nhật tổng tiền sản phẩm
            let subtotal = price * quantity;
            row.querySelector(".subtotal").innerText = new Intl.NumberFormat('vi-VN').format(subtotal) + " VND";

            // Cập nhật tổng tiền toàn giỏ hàng
            updateTotalPrice();

            // Gửi AJAX cập nhật giỏ hàng
            updateCart(id, quantity);
        });
    });

    function updateTotalPrice() {
        let total = 0;
        document.querySelectorAll(".subtotal").forEach(subtotal => {
            total += parseFloat(subtotal.innerText.replace(/\./g, "").replace(" VND", ""));
        });
        document.getElementById("total-price").innerText = new Intl.NumberFormat('vi-VN').format(total) + " VND";
    }

    function updateCart(id, quantity) {
        fetch('/webbanhang/Product/updateCartAjax', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id, quantity })
        })
        .then(response => response.json())
        .then(data => console.log("Cập nhật thành công:", data))
        .catch(error => console.error("Lỗi khi cập nhật giỏ hàng:", error));
    }
});
</script>
