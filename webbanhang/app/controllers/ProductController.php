<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    // 🔹 Kiểm tra quyền admin
    private function checkAdmin()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            include 'app/views/errors/no_permission.php';
            exit();
        }
    }

    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function search()
    {
        $keyword = isset($_GET['query']) ? trim($_GET['query']) : '';

        if (empty($keyword)) {
            header("Location: /webbanhang/Product");
            exit;
        }

        $products = $this->productModel->searchByName($keyword);
        include 'app/views/product/list.php';
    }

    // 🔹 Thêm sản phẩm (Chỉ admin mới vào được)
    public function add()
    {
        $this->checkAdmin();
        $categories = (new CategoryModel($this->db))->getCategories();
        include 'app/views/product/add.php';
    }

    public function save()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $image = "";

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /webbanhang/Product');
            }
        }
    }

    // 🔹 Sửa sản phẩm (Chỉ admin mới vào được)
    public function edit($id)
    {
        $this->checkAdmin();
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();

        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $image = $_POST['existing_image'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            }

            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);
            if ($edit) {
                header('Location: /webbanhang/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    // 🔹 Xóa sản phẩm (Chỉ admin mới vào được)
    public function delete($id)
    {
        $this->checkAdmin();
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    private function uploadImage($file)
    {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra xem file có phải là hình ảnh không
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }

        // Kiểm tra kích thước file (10MB)
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }

        // Chỉ cho phép một số định dạng hình ảnh nhất định
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }

        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }

        return $target_file;
    }

    // 🔹 Thêm sản phẩm vào giỏ hàng
    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }

        header('Location: /webbanhang/Product/cart');
    }

    // 🔹 Hiển thị giỏ hàng
    public function cart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/cart.php';
    }

    // 🔹 Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /webbanhang/Product/cart');
        exit();
    }

    // 🔹 Cập nhật giỏ hàng
    public function updateCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            $id = $data['id'] ?? null;
            $quantity = $data['quantity'] ?? 1;

            if ($id && isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['quantity'] = max(1, (int)$quantity);
                echo json_encode(["status" => "success", "message" => "Cập nhật giỏ hàng thành công"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Sản phẩm không tồn tại"]);
            }
        }
    }
    public function checkout()
    {
    include 'app/views/product/checkout.php';
    }
    public function processCheckout()
    {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    // Kiểm tra giỏ hàng
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Giỏ hàng trống.";
    return;
    }
    // Bắt đầu giao dịch
    $this->db->beginTransaction();
    try {
    // Lưu thông tin đơn hàng vào bảng orders
    $query = "INSERT INTO orders (name, phone, address) VALUES (:name,

:phone, :address)";

$stmt = $this->db->prepare($query);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':address', $address);
$stmt->execute();
$order_id = $this->db->lastInsertId();
// Lưu chi tiết đơn hàng vào bảng order_details
$cart = $_SESSION['cart'];
foreach ($cart as $product_id => $item) {
$query = "INSERT INTO order_details (order_id, product_id,

quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";

$stmt = $this->db->prepare($query);
$stmt->bindParam(':order_id', $order_id);
$stmt->bindParam(':product_id', $product_id);
$stmt->bindParam(':quantity', $item['quantity']);
$stmt->bindParam(':price', $item['price']);
$stmt->execute();
}
// Xóa giỏ hàng sau khi đặt hàng thành công
unset($_SESSION['cart']);
// Commit giao dịch
$this->db->commit();
// Chuyển hướng đến trang xác nhận đơn hàng
header('Location: /webbanhang/Product/orderConfirmation');
} catch (Exception $e) {
// Rollback giao dịch nếu có lỗi
$this->db->rollBack();
echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
}
}
}
public function orderConfirmation()
{
include 'app/views/product/orderConfirmation.php';
}
}
?>
