<?php 
session_start();

$mysqli = new mysqli("localhost", "akvarigu_main", "WjT8&LdO", "akvarigu_main");

$order_phone = $_POST['order_phone'];
$order_name = $_POST['order_name'];

$to = 'srr@live.ru';
$subject = 'Заказ от '.$order_name;

$message = "
<!DOCTYPE html>\r\n
<meta charset=utf-8>\r\n
<link href='https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap' rel='stylesheet'>\r\n

<style>
* {    
	font-family: 'Open Sans', sans-serif;
    font-size: 18px;
    color: black;
}\r\n
div {
    width: fit-content;
    padding: 10px 20px;
    margin: 10px;
	background: rgb(254,254,254);
	box-shadow: 0 1px 3px rgb(0 0 0 / 20%);
	border-radius: 14px;
}\r\n
p {
    margin: 3px 0;
    font-size: 20px;
    line-height: 1;
}\r\n
table, td, th {
    border: thin solid lightgrey;
}\r\n
tr:nth-child(even) {
    background-color: #f2f2f2;
}\r\n
table {
    margin: 10px 0;
    border-collapse: collapse;
    text-align: left;
}\r\n
caption {
    text-align: left;
}\r\n
th {    
    background-color: lightgrey;
    padding: 0 10px;
}\r\n
td {    
    padding: 0 10px;
}\r\n
span {
    font-size: 24px;
    font-weight: bold;
}\r\n
</style>

<div>\r\n
<p>Имя клиента: <span>" . $order_name . "</span></p>\r\n
<p>Контактный телефон: <span>+7" . $order_phone . "</span></p>\r\n

<table>\r\n
<caption>Данные заказа</caption>\r\n
    <tr>\r\n
        <th>Наименование</th>\r\n
        <th>Артикул</th>\r\n
        <th>Количество</th>\r\n
        <th>Цена</th>\r\n
        <th>Сумма</th>\r\n
    </tr>\r\n ";

$cart_sum = 0;
foreach ($_SESSION['order'] as $order) {
    $qtt_sum = $order['q'];
    if ($searchresult = $mysqli->query("SELECT * FROM price	WHERE id='$order[id]'")) {
        while ($row = $searchresult->fetch_assoc()) {
            $price_sum = floatval($row["price"]);
            $item_sum = $qtt_sum * $price_sum;
            $message .= "<tr><td>\r\n";
            if ($sr = $mysqli->query("SELECT * FROM cat WHERE id='$order[id]'")) {
                while ($r = $sr->fetch_assoc()) {
                    $message .= " " . $r["series"]." ".$r["name"]." \r\n";
                }
                $sr->free();
            }
            $message .= "</td>\r\n
                    <td>" . $order['id'] . "</td>\r\n
                    <td>" . $order['q'] . "</td>\r\n
                    <td>" . number_format($price_sum, 2, ',', ' ') . "</td>\r\n
                    <td>" . number_format($item_sum, 2, ',', ' ') . "</td>\r\n
                </tr>\r\n";
            }
        $searchresult->free();
        }
        $cart_sum += $item_sum;
    }
$message .= "
</table>\r\n
<span>Сумма заказа " . number_format($cart_sum, 2, ',', ' ') . " руб.</span></div>\r\n";

$headers = 'From: mail@ritm-rt.ru';

$headers  = 
'MIME-Version: 1.0' . "\r\n" .
'Content-type: text/html; charset=utf-8' . "\r\n" .
'From: Заказ с сайта <zakaz@ritm-rt.ru>';

if (strlen($order_name) < 30) {
    mail($to, $subject, $message, $headers);
}
?>