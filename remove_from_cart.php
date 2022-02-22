<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

$cartid = $_POST['id'] ?? NULL;

$key = array_search(Array ( "id" => $cartid), $_SESSION['cart']);
unset($_SESSION['cart'][$key]);
unset($_SESSION['order'][$key]);

$mysqli = new mysqli("localhost", "", "", "");
if ($_SESSION['cart'] ?? NULL) { ?>

<form id="order-form" autocomplete="off" action="" method="post" class="right">
    <div>Данные клиента</div>
    <input type="tel" id="order-phone" name="phone" placeholder="Номер телефона без +7" pattern="[0-9]{10}" required>
    <input type="text" id="order-name" name="name" placeholder="Имя" pattern="^[А-Яа-яЁё\s]+$" maxlength="25" required>
    <div>Сумма заказа</div>
    <div id="order-sum">
        <?php 
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
    </div>
    <input type="button" id="order-submit" value="Подтвердить заказ">
</form>

<div id="cart-tiles"> 
    <div id="cart-tiles-title">Товары в заказе</div>
    
    <?php
    foreach ($_SESSION['cart'] as $cart) {
        $query = "SELECT * FROM cat WHERE id='$cart[id]'";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result(
                $id,
                $type,
                $category,
                $series,
                $name,
                $hydroacc,
                $wirelength,
                $power,
                $pumpdia,
                $rpm,
                $additional,
                $dir,
                $cat_dir,
                $image);
        }
        while ($stmt->fetch()) {?>
            <div class="cart-tile">
                <div class='cart-tile-image'>
                    <?php if (file_exists($_SERVER['DOCUMENT_ROOT'].$dir.$image.'.jpg')) { ?>
                        <img src="<?php echo $dir; echo $image; ?>.jpg" alt="Pic" width="200">
                    <?php } else { ?>
                        <img src="<?php echo $dir; ?>image.png" alt="Pic" width="200">
                    <?php } ?>
                </div>
                <div class="cart-tile-id">Арт. <?php printf ($id); ?>
                </div>
                <div class="cart-tile-name">
                <span style="font-size: 14px; line-height: 1;"><?php printf ($series); ?></span> <?php printf ($name); ?>
                </div>
                <div class="cart-tile-add">
                    <?php 
                    if ($hydroacc != "") { ?>
                    <div>
                        <span style="font-weight: lighter; font-size: 14px">Гидробак:  </span><?php printf ($hydroacc); ?>
                    </div>
                    <?php }
                    if ($wirelength != "") { ?>
                        <div>
                            <span style="font-weight: lighter; font-size: 14px">Длина провода:  </span><?php printf ($wirelength); ?>
                        </div>
                    <?php }
                    if ($power != "") { ?>
                        <div>
                            <span style="font-weight: lighter; font-size: 14px">Мощность:  </span><?php printf ($power); ?>
                        </div>
                    <?php }
                    if ($pumpdia != "") { ?>
                        <div>
                            <span style="font-weight: lighter; font-size: 14px">Диаметр насоса:  </span><?php printf ($pumpdia); ?>
                        </div>
                    <?php }
                    if ($rpm != "") { ?>
                        <div>
                            <span style="font-weight: lighter; font-size: 14px">Частота вращения:  </span><?php printf ($rpm); ?>
                        </div>
                    <?php }
                    if ($additional != "") { ?>
                        <div>
                            <span style="font-weight: lighter; font-size: 14px">Дополнительно:  </span><?php printf ($additional); ?>
                        </div>
                    <?php }
                    ?>
                </div>
                <div class="cart-tile-price"><span class="upper-text">&nbsp;Цена&nbsp;</span>
                    <div id="price-<?php echo $id ?>">
                    <?php
                    if ($searchresult = $mysqli->query("SELECT * FROM price	WHERE id='$id'")) {
                        while ($row = $searchresult->fetch_assoc()) {
                            echo number_format(floatval($row["price"]), 2, ',', ' ');
                        }
                        $searchresult->free();
                    }
                    ?> руб.
                    </div>
                </div>
                 <div class="cart-tile-qtt"><span class="upper-text">&nbsp;Количество&nbsp;</span>						
                    <div class="qtt-slider">
                        <div class="qtt-button material-icons-round" onClick="decreaseQtt(<?php echo $id ?>)">chevron_left</div>
                        <div class="qtt" id="qtt-<?php echo $id ?>">
                            <?php							
                            foreach ($_SESSION['order'] as $order) {
                                if ($order['id'] == $id) {
                                    echo $order['q'];
                                }
                            }
                            ?>
                        </div>
                        <div class="qtt-button material-icons-round" onClick="increaseQtt(<?php echo $id ?>)">chevron_right</div>
                    </div>						
                </div>
                <div class="cart-tile-sum"><span class="upper-text">&nbsp;Сумма&nbsp;</span>
                    <div id="sum-<?php echo $id ?>">
                    <?php
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
                    </div>
                </div>
                <div id="remove-from-cart" class="material-icons-round" onClick="removeFromCart(<?php echo $id ?>)">remove_circle</div>
            </div> <?php
        }
    };
    ?><div id='clear-cart' onClick="clearCart()">
        <div class="material-icons-outlined" style="font-size: 40px">remove_shopping_cart</div>
        <div>Очистить<br>корзину</div>
    </div>
</div> 
<?php
} else {
    ?> 	<div id="empty-cart">
            <div class="material-icons-outlined" style="font-size: 200px">shopping_cart</div>
            <div>Козина пуста</div>
        </div> 
    <?php
}
$mysqli->close();
?>