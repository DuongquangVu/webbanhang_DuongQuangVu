<?php include 'app/views/shares/header.php'; ?>

<h1>Sửa sản phẩm</h1>

<form id="edit-product-form" enctype="multipart/form-data">
    <input type="hidden" id="id" name="id">

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
        <select id="category_id" name="category_id" class="form-control" required></select>
    </div>

    <div class="form-group">
        <label for="image">Ảnh sản phẩm:</label>
        <input type="file" id="image" name="image" class="form-control">
        <br>
        <img id="preview" src="" alt="Ảnh sản phẩm" width="100">
    </div>

    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
</form>

<a href="/webbanhang/Product/list" class="btn btn-secondary mt-2">Quay lại danh sách sản phẩm</a>

<?php include 'app/views/shares/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const productId = <?= $editId ?>;

    // Lấy thông tin sản phẩm cần chỉnh sửa
    fetch(`/webbanhang/api/product/${productId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('id').value = data.id;
            document.getElementById('name').value = data.name;
            document.getElementById('description').value = data.description;
            document.getElementById('price').value = data.price;
            document.getElementById('category_id').value = data.category_id;
            document.getElementById('preview').src = data.image; // Hiển thị ảnh hiện tại
        });

    // Lấy danh sách danh mục
    fetch('/webbanhang/api/category')
        .then(response => response.json())
        .then(data => {
            const categorySelect = document.getElementById('category_id');
            data.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });
        });

    // Hiển thị ảnh khi chọn file mới
    document.getElementById('image').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('preview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    // Gửi dữ liệu cập nhật sản phẩm
    document.getElementById('edit-product-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch(`/webbanhang/api/product/${formData.get('id')}`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Product updated successfully') {
                location.href = '/webbanhang/Product';
            } else {
                alert('Cập nhật sản phẩm thất bại');
            }
        });
    });
});
</script>
