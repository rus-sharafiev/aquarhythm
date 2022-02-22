<?php
session_start();

$qtt_id = $_POST['id'];

foreach ($_SESSION['order'] as $key => $value) {
    if ($_SESSION['order'][$key]['id'] == $qtt_id) {
        if ($_SESSION['order'][$key]['q'] < 100) {
            $_SESSION['order'][$key]['q']++;
        }        
        echo $_SESSION['order'][$key]['q'];
    }
}

?>
