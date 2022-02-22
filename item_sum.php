<?php
session_start();

$id = $_POST['id'];
$mysqli = new mysqli("localhost", "", "", "");

foreach ($_SESSION['order'] as $order) {
	if ($order['id'] == $id) {
		$qtt_sum = $order['q'];
		if ($searchresult = $mysqli->query("SELECT * FROM price	WHERE id='$id'")) {
			while ($row = $searchresult->fetch_assoc()) {
				$price_sum = floatval($row["price"]);
			}
			$searchresult->free();
		}
		$item_sum = $qtt_sum * $price_sum;
	}
}
echo number_format($item_sum, 2, ',', ' ');
?> руб.