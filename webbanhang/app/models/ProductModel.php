<?php
class ProductModel
{
    private $conn;
    private $table_name = "product";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // 📌 Lấy danh sách sản phẩm (CÓ hình ảnh)
    public function getProducts()
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name 
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Cập nhật đường dẫn ảnh
        foreach ($result as $product) {
            $product->image = $this->getImageUrl($product->image);
        }

        return $result;
    }

    // 📌 Lấy thông tin sản phẩm theo ID (CÓ hình ảnh)
    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if ($result) {
            $result->image = $this->getImageUrl($result->image);
        }

        return $result;
    }

    // 📌 Thêm sản phẩm (HỖ TRỢ ẢNH)
    public function addProduct($name, $description, $price, $category_id, $image = null)
    {
        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        $query = "INSERT INTO " . $this->table_name . " (name, description, price, category_id, image) 
                  VALUES (:name, :description, :price, :category_id, :image)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        return $stmt->execute();
    }

    // 📌 Cập nhật sản phẩm (HỖ TRỢ CẬP NHẬT ẢNH)
    public function updateProduct($id, $name, $description, $price, $category_id, $newImage = null)
    {
        // Lấy sản phẩm cũ
        $oldProduct = $this->getProductById($id);
        if (!$oldProduct) {
            return false;
        }

        // Nếu không có ảnh mới, giữ nguyên ảnh cũ
        $image = $oldProduct->image;
        if ($newImage !== null) {
            $image = $newImage;
        }

        $query = "UPDATE " . $this->table_name . " 
                  SET name=:name, description=:description, price=:price, category_id=:category_id, image=:image
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        return $stmt->execute();
    }

    // 📌 Xóa sản phẩm
    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // 📌 Xử lý đường dẫn ảnh (Sửa lỗi hiển thị ảnh)
    private function getImageUrl($imagePath)
    {
        $baseUrl = "http://localhost:8080/webbanhang/uploads/";

        // Kiểm tra nếu có ảnh thì nối vào đường dẫn, nếu không thì dùng ảnh mặc định
        if (!empty($imagePath)) {
            $fullImagePath = __DIR__ . "/../../uploads/" . $imagePath;
            return file_exists($fullImagePath) ? $baseUrl . $imagePath : $baseUrl . "default.jpg";
        } else {
            return $baseUrl . "default.jpg"; // Ảnh mặc định
        }
    }
}
?>
