<?php
session_start();
include('includes/config.php');

// İstek türünü kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gelen verileri al
    $action = $_POST["action"];
    $productId = $_POST["productId"];

    // Sepetin varlığını kontrol et
    if (!empty($_SESSION['cart'][$productId])) {
        // İşlem türüne göre sepeti güncelle
        switch ($action) {
            case "increase":
                $_SESSION['cart'][$productId]['quantity']++;
                break;
            case "decrease":
                // Minimum 1 adet ürün kalmalı
                if ($_SESSION['cart'][$productId]['quantity'] > 1) {
                    $_SESSION['cart'][$productId]['quantity']--;
                }
                break;
            // Diğer durumları ekleyebilirsiniz
        }

        // Güncellenmiş sepet bilgilerini hesapla
        $totalPrice = 0;
        $totalQuantity = 0;
        foreach ($_SESSION['cart'] as $id => $item) {
            $productPrice = $item['productPrice'] + $item['shippingCharge'];
            $subtotal = $item['quantity'] * $productPrice;
            $totalPrice += $subtotal;
            $totalQuantity += $item['quantity'];
        }

        // Toplam fiyat ve miktarı session'a kaydet
        $_SESSION['tp'] = $totalPrice;
        $_SESSION['qnty'] = $totalQuantity;

        // Başarılı yanıtı döndür
        echo "success";
    } else {
        // Hata durumunu döndür
        echo "error";
    }
} else {
    // Hatalı istek durumunu döndür
    echo "invalid request";
}
?>