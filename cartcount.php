<?php 
session_start();
if ($_SESSION['cart'] ?? NULL) {
    echo count($_SESSION['cart']);	
} 
?>