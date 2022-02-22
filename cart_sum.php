<?php

session_start();

$mysqli = new mysqli("localhost", "", "", "");

$cart_sum = 0;
foreach ($_SESSION['order'] as $order) {
	$qtt_sum = $order['q'];
        if ($searchresult = $mysqli->query("SELECT * FROM price	WHERE id='$order[id]'")) {
            while ($row = $searchresult->fetch_assoc()) {
            $price_sum = floatval($row["price"]);
        }
        $searchresult->free();
    }
    $item_sum = $qtt_sum * $price_sum;
    $cart_sum += $item_sum;
}

echo number_format($cart_sum, 2, ',', ' ');

?> руб.