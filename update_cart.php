<?php
session_start();
include('includes/config.php');

if (isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $key => $val) {
        if ($val > 10) {
            $val = 10;
        }
        if ($val == 0) {
            unset($_SESSION['cart'][$key]);
        } else {
            $_SESSION['cart'][$key]['quantity'] = $val;
        }
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
