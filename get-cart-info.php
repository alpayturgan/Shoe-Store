<?php
session_start();

$cartInfo = array(
  'totalPrice' => number_format($_SESSION['tp'], 2),
  'totalQuantity' => $_SESSION['qnty']
);

echo json_encode($cartInfo);
?>