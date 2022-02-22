<?php session_start(); ?>

<!DOCTYPE html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>АКВАРИТМ</title>
<link type="image/png" sizes="16x16" rel="icon" href="/favicon-16.png">
<link type="image/png" sizes="32x32" rel="icon" href="/favicon-32.png">
<link type="image/png" sizes="96x96" rel="icon" href="/favicon-96.png">
<link type="image/png" sizes="120x120" rel="icon" href="/favicon-120.png">
<link href="/css/cart.css" rel="stylesheet">
<link href="/css/main.css" rel="stylesheet">
<link href="/css/mobile.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="/js/jquery.js"></script>
<script src="/js/jquery-ui.js"></script>

<?php 
include 'header.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = Array();
}

$cartid = $_POST['id'] ?? NULL;

if ($_SESSION['cart'] ?? NULL) {
	if (in_array(Array ( "id" => $cartid ), $_SESSION['cart'])) {
		$key = array_search(Array ( "id" => $cartid), $_SESSION['cart']);
		unset($_SESSION['cart'][$key]);
		unset($_SESSION['order'][$key]);
	} else if ($cartid != NULL) {
		$_SESSION['cart'][] = ["id" => $cartid];
		$_SESSION['order'][] = ["id" => $cartid, "q" => '1'];
	}
} else if ($cartid != NULL) {
	$_SESSION['cart'] = Array();
	$_SESSION['order'] = Array();
	$_SESSION['cart'][] = ["id" => $cartid];
	$_SESSION['order'][] = ["id" => $cartid, "q" => '1'];
}
?>

<main>
	<?php
	if ($_SESSION['cart'] ?? NULL) { ?>

	<form id="order-form" autocomplete="off" action="" method="post">
		<div>Данные клиента</div>
		<input type="tel" id="order-phone" name="order_phone" placeholder="Номер телефона без +7" pattern="[0-9]{10}" required>
		<input type="text" id="order-name" name="order_name" placeholder="Имя или название организации" pattern="^[А-Яа-яЁё\s]+$" maxlength="30" required>
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
	
</main>

<div id="submit-window-background" class='hidden'>
	<div id="submit-window">
		<div id="submit-window-text">Подтвердить заказ на сумму<div id="submit-window-sum"><?php echo number_format($cart_sum, 2, ',', ' '); ?> руб.?</div></div>
		<div id="submit-window-ok-button">Ok</div>
		<div id="submit-window-cancel-button" onClick="closeSubmitWindow()">Отменить</div>
	</div>
</div>

<script>
	$('#order-submit').click( function() {
        var isValid = document.querySelector('#order-form').reportValidity();
        if (isValid) {
		    $('#submit-window-background').removeClass('hidden')
        }
	});

	function closeSubmitWindow() {
		$('#submit-window-background').addClass('hidden')
	};

	function clearCart() {
		$.ajax({
			url: '/clearcart.php',
			type: 'post',
			data: '',
			dataType: "html",
			success: function() {
				$("main").html('<div id="empty-cart"><div class="material-icons-outlined" style="font-size: 200px">shopping_cart</div><div>Козина пуста</div></div>')
				$("#cart-count").addClass('hidden');
			}
		});
	};
</script>

<script>
	function increaseQtt(qtt_data) {
		$.ajax({
			url: '/increaseqtt.php',
			type: "POST",
			data: { id: qtt_data },
			dataType: "html",
			success: function(data) {
				$("#qtt-" + qtt_data).html(data);
				$.post( 'item_sum.php', { id: qtt_data },  function( data ) {
					$("#sum-" + qtt_data).html(data);
				});
				$("#order-sum").load('cart_sum.php');
				$("#submit-window-sum").load('cart_sum.php');
			}
		});
	};
	function decreaseQtt(qtt_data) {
		$.ajax({
			url: '/decreaseqtt.php',
			type: "POST",
			data: { id: qtt_data },
			dataType: "html",
			success: function(data) {
				$("#qtt-" + qtt_data).html(data);
				$.post( 'item_sum.php', { id: qtt_data },  function( data ) {
					$("#sum-" + qtt_data).html(data);
				});
				$("#order-sum").load('cart_sum.php');
				$("#submit-window-sum").load('cart_sum.php');
			}
		});
	};
</script>

<script>
	function removeFromCart(data) {
		$.ajax({
			url: '/remove_from_cart.php',
			type: "POST",
			data: { id: data },
			dataType: "html",
			success: function(page) {
				$("main").html(page);
				$("#cart-count").removeClass('hidden').load('/cartcount.php');
				if ($("#cart-button-" + data).hasClass('add-to-cart')) {
					$("#cart-button-" + data).removeClass('add-to-cart').addClass('remove-from-cart');
				} else {
					$("#cart-button-" + data).addClass('add-to-cart').removeClass('remove-from-cart');
				}
			}
		});
		$(document).ajaxStop(function() {
			if ($("#cart-count").text() == '') {
				$("#cart-count").addClass('hidden');
			}
		});
	};
</script>

<script>
$("#submit-window-ok-button").click( function() {
        $.ajax({
            url: 'order.php',
            type: 'POST',
            data: $('#order-form').serialize(),
            success: function() {               
				$('#submit-window').html('<div id="submit-window-text">Заказ оформлен.<br>Мы свяжемся с Вами в ближайшее время</div><div id="submit-window-close-button" onClick="okSubmitWindow()">Ok</div>');
            }
        });
});
</script>

<script>
    function okSubmitWindow() {
	    window.location='/';	
	    $('#submit-window-background').addClass('hidden'); 
	    clearCart();
    };
</script>