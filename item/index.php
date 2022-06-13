<?php session_start(); ?>

<!DOCTYPE html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link type="image/png" sizes="16x16" rel="icon" href="/favicon-16.png">
<link type="image/png" sizes="32x32" rel="icon" href="/favicon-32.png">
<link type="image/png" sizes="96x96" rel="icon" href="/favicon-96.png">
<link type="image/png" sizes="120x120" rel="icon" href="/favicon-120.png">
<link href="/css/main.css" rel="stylesheet">
<link href="/css/item.css" rel="stylesheet">
<link href="/css/mobile.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="/js/jquery.js"></script>
<script src="/js/jquery-ui.js"></script>
<title>АКВАРИТМ</title>

<body>

<?php 
include ($_SERVER['DOCUMENT_ROOT'].'/header.php');

$art = $_GET['art'];
$query = "SELECT * FROM cat WHERE id='$art'";

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

while ($stmt->fetch()) { ?>
<div id="item-container">
	<div id=item-category-name>
		<object data="/<?php echo $cat_dir?>/logo.svg"></object>
		<div><?php echo $category;?></div>
	</div>
	<div class="item">
		<div class='item-image'>
			<?php if (file_exists($_SERVER['DOCUMENT_ROOT'].$dir.$image.'.jpg')) { ?>
				<img src="<?php echo $dir; echo $image; ?>.jpg" alt="Pic" width="500">
						<?php } else { ?>
				<img src="<?php echo $dir; ?>image.png" alt="Pic" width="200">
				<?php } ?>
		</div>
		<div class="item-id">Арт. <?php printf ($id); ?></div>
		<div class="item-name">
			<span class="item-name-series"><?php printf ($series); ?></span> <?php printf ($name); ?>
		</div>
		<div class="item-add">
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
			<div id="add-to-cart">    
				<div id="cart-button-<?php echo $id ?>" <?php
					if ($_SESSION['cart'] ?? NULL) {
						if (in_array(Array ( "id" => $id ), $_SESSION['cart'])) { ?>		
							class="remove-from-cart" <?php
						} else { ?>
							class="add-to-cart" <?php
						} 
					} else { ?>
						class="add-to-cart" <?php
					}?>
					onClick="addToCart(<?php echo $id ?>)">
				</div>
			</div>
		<div id="sharebutton">share</div>
		<div class="item-price">	<?php
			if ($searchresult = $mysqli->query("SELECT * FROM price	WHERE id='$id'")) {
				while ($row = $searchresult->fetch_assoc()) {
					echo number_format(floatval($row["price"]), 2, ',', ' ');
				}
				$searchresult->free();
			}	?> руб.
		</div>
	</div>
	<a id="item-series-info" href="<?php echo $dir?>">
		<?php printf ($category); ?>&ensp;<span style="font-size: 35px; font-weight: bold"><?php printf ($series); ?></span><br><br>
		Другие продукты линейки, подробное описание, характеристики, графики, размеры
	</a>
	<div id="item-series-spec">
		<?php echo file_get_contents($_SERVER['DOCUMENT_ROOT'].$dir.'spec.svg') ?>
	</div> 
</div>
<?php
}

$stmt->close();
$mysqli->close();
?>
<script>

// Share
     let shareData = {
         title: 'Акваритм',
         text: '<?php printf ($series)?> <?php printf ($name) ?>',
         url: 'https://web.rushome.keenetic.pro/item/?art=<?php echo $id ?>',
     }
     
     $("#sharebutton").on('click', function() {
         navigator.share(shareData)
     });
     
</script>
</body>