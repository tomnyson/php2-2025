<?php
require_once "model/CategoryModel.php";
require_once "view/helpers.php";
require_once "model/CartModel.php";
require_once 'model/OrderModel.php';
require_once 'utils.php';

// enum StatusOrder: string
// {
//     case Pending = 'pending';
//     case Confirm = 'confirm';
//     case Shipping = 'shipping';
//     case Success = 'success';
//     case Cancel = 'cancel';
// }

// enum StatusPayment: string
// {
//     case Pending = 'pending';
//     case Success = 'success';
//     case Cancel = 'cancel';
//     case Error = 'error';
// }
class CartController
{
    private $cartModel;
    private $orderModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->orderModel = new OrderModel();
    }

    public function index()
    {
        $user_id = $_SESSION['user']['id'] ?? null;
        $session_id = session_id();
        $carts = $this->cartModel->getCart($user_id, $session_id);
        //compact: gom bien dien thanh array
        renderView("view/cart/list.php", compact('carts'), "carts List");
    }

    public function checkout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $payment = $_POST['payment'];
            if ($payment == 'cod') {
                /**
                 * carts hien  tai
                 * 
                 */
                $user_id = $_SESSION['user']['id'] ?? null;
                $session_id = session_id();
                $carts = $this->cartModel->getCart($user_id, $session_id);
                $total = 0;
                foreach ($carts as $cart) {
                    $total += $cart['price'] * $cart['quantity'];
                }
                $code = uniqid(); // code của order
                $address = $_POST['address'] ?? null;
                $note = $_POST['note'] ?? null;
                $email = $_POST['email'] ?? null;
                $status = 'pendding';
                $isCreate = $this->orderModel->createOrder(
                    $user_id,
                    $code,
                    $total,
                    $address,
                    $note,
                    $status,
                    $payment,
                    $carts
                );
                /**
                 * xoa gio hang
                 * gui email
                 * hien thi trang thanh toan thanh con
                 */
                $to = 'tabletkindfire.@gmail.com';
                $from = 'tabletkindfire.@gmail.com';
                $subject = 'Order Notification';
                $content = "You have a new order with code: $code";
                Utils::send($to, $from, $subject, $content);




            } else if ($payment == 'vnpay') {

            }
        } else {
            $user_id = $_SESSION['user']['id'] ?? null;
            $session_id = session_id();
            $carts = $this->cartModel->getCart($user_id, $session_id);
            //compact: gom bien dien thanh array
            renderView("view/cart/checkout.php", compact('carts'), "carts List");
        }
    }



    // public function show($id) {
    //     $categories = $this->categoryModel->getCategoryById($id);
    //     renderView("view/category_detail.php", compact('categories'), "categories Detail");
    // }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $user_id = $_SESSION['user']['id'] ?? null;
            $cart_session = session_id();
            $sku = $_POST['sku'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $this->cartModel->addCart($user_id, $cart_session, $sku, $quantity, $price);
            header("Location: /carts");
        } else {
            renderView("view/category_create.php", [], "Create category");
        }
    }

    public function updateQuantity($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity = $_POST['quantity'];
            $this->cartModel->updateQuantity($id, $quantity);
            $_SESSION['message'] = "Cart updated successfully";
            header("Location: /carts");
        } else {
            header("Location: /carts");
        }
    }
    // public function edit($id){
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $name = $_POST['name'];
    //         $this->categoryModel->updateCategory($id, $name);
    //         header("Location: /categories");
    //     } else {
    //         $categories = $this->categoryModel->getCategoryById($id);
    //         renderView("view/category_edit.php", compact('categories'), "Edit categories");
    //     }
    // }
    public function delete($id)
    {
        $this->cartModel->deleteCart($id);
        header("Location: /carts");
        exit;
    }
    public function testvnpay()
    {
        // error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        /**
         * 
         *
         * @author CTT VNPAY
         */
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
        $vnp_TxnRef = rand(1, 10000); //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = 10000;//$_POST['amount']; // Số tiền thanh toán
        $vnp_Locale = "vn"; //$_POST['language']; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = "";// $_POST['bankCode']; //Mã phương thức thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán
        $vnp_TmnCode = $_ENV['VNPAYCODE'];
        $vnp_Returnurl= $_ENV['VNPRETURN'];
        $vnp_HashSecret  = $_ENV['VNPHASECRET'];
        $vnp_Url = $_ENV['VNURL'];
        try {
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount * 100,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
                "vnp_OrderType" => "other",
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_ExpireDate" => $expire
            );
            // echo "<pre>";
            // var_dump($inputData);
            // echo "</pre>";
            // die();
        } catch (Exception $e) {
            printf("Error processing" . $e->getMessage());
        }

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }


        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
        die();

    }
    public function vnpayReturn() {
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $vnp_HashSecret = $_ENV['VNPHASECRET'];
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        if ($secureHash == $vnp_HashSecret) {
            if ($_GET['vnp_ResponseCode'] == '00') {
                echo "<span style='color:blue'>GD Thanh cong</span>";
            } else {
                echo "<span style='color:red'>GD Khong thanh cong</span>";
            }
        } else {
            echo "<span style='color:red'>Chu ky khong hop le</span>";
        }
    }
}
