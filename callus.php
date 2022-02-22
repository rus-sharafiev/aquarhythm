<?php
$phone = $_POST['phone'];
$name = $_POST['name'];

$headers = 'From: Позвонить клиенту <zvonok@ritm-rt.ru>';
if (strlen($name) < 30) {
    $message = "Номер телефона: ".$phone."\r\nИмя: ".$name."\r\n";
    $message = wordwrap($message, 70, "\r\n");
    mail('srr@live.ru', 'Заявка на звонок с сайта от '.$name, $message, $headers);
}
?>