<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Chỉnh sửa sản phẩm</h1>

    <?php if ($product): ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded p-4">
                    <form action="/webbanhang/Product/update/<?php echo $product->id; ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea name="description" id="description" class="form-control" rows="4"><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Giá</label>
                            <input type="number" name="price" id="price" class="form-control" 
                                   value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category->id; ?>" 
                                            <?php echo ($category->id == $product->category_id) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Hiển thị ảnh hiện tại -->
                        <div class="mb-3 text-center">
                            <label class="form-label d-block">Ảnh hiện tại</label>
                            <img src="/webbanhang/<?php echo $product->image ? htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8') : 'uploads/no-image.png'; ?>" 
                                 alt="Product Image" class="img-fluid rounded shadow-sm" style="max-width: 200px;">
                        </div>

                        <!-- Upload ảnh mới -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Chọn ảnh mới (nếu có)</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <!-- Nút hành động -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="/webbanhang/Product" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p class="text-center text-danger mt-5">Sản phẩm không tồn tại.</p>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>
