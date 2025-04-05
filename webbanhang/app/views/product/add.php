<?php include 'app/views/shares/header.php'; ?>

<h1>Thêm sản phẩm mới</h1>

<form id="add-product-form" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" class="form-control" required></textarea>
    </div>
    <div class="form-group">
        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" class="form-control" step="0.01" required>
    </div>
    <div class="form-group">
        <label for="category_id">Danh mục:</label>
        <select id="category_id" name="category_id" class="form-control" required>
            <option value="">Chọn danh mục</option>
            <!-- Các danh mục sẽ được tải từ API -->
        </select>
    </div>
    <div class="form-group">
        <label for="image">Ảnh sản phẩm:</label>
        <input type="file" id="image" name="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
</form>

<a href="/webbanhang/Product/list" class="btn btn-secondary mt-2">Quay lại danh sách sản phẩm</a>

<?php include 'app/views/shares/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // 📌 Tải danh mục từ API
    fetch('/webbanhang/api/category')
        .then(response => response.json())
        .then(data => {
            const categorySelect = document.getElementById('category_id');
            categorySelect.innerHTML = '<option value="">Chọn danh mục</option>';
            data.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });
        })
        .catch(error => console.error('Lỗi tải danh mục:', error));

    // 📌 Xử lý submit form thêm sản phẩm
    document.getElementById('add-product-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this); // FormData để gửi dữ liệu file

        fetch('/webbanhang/api/product', {
            method: 'POST',
            body: formData // Không cần headers vì FormData tự động thiết lập
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Product created successfully') {
                alert('Thêm sản phẩm thành công!');
                location.href = '/webbanhang/Product';
            } else {
                alert('Thêm sản phẩm thất bại: ' + (data.errors ? data.errors.join(", ") : "Lỗi không xác định"));
            }
        })
        .catch(error => console.error('Lỗi:', error));
    });
});
</script>
