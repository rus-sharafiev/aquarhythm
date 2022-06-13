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
<link href="css/index.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/mobile.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="/js/jquery.js"></script>
<script src="/js/jquery-ui.js"></script>

<?php

include 'header.php';

$query = "SELECT * FROM cat";
$catArray = array();
$serArray = array();
if ($searchresult = $mysqli->query($query)) {
	while ($row = $searchresult->fetch_assoc()) {
		if (!in_array(array($row["category"], $row["cat_dir"]), $catArray)) {
			$catArray[] = array($row["category"], $row["cat_dir"]);
		} 
		if (!in_array(array($row["category"], $row["series"], $row["dir"]), $serArray)) {
			$serArray[] = array($row["category"], $row["series"], $row["dir"]);
		} 	
	}
	$searchresult->free();
}
?>

<div id="mainpage">
	<div id="pumps" class="type">
		<div class="typename">Продукция <span style="color: #00AFD7; font-size: 35px">Unipump</span></div>
		<div class="categories"><?php
			foreach ($catArray as list($cat, $path)) {?>
				<div class="category">
					<div class="category-image">
						<div class="cat-name"><?php printf ($cat); ?></div>
						<object data="/<?php echo $path; ?>/image.svg"></object>
						<div class="category-link" onClick="window.location='/<?php echo $path; ?>/';"></div>
					</div>
					<div class="series">
						<div><?php
						foreach ($serArray as list($a, $b, $c)) {
							if ($a == $cat) {?>
								<a href='<?php echo $c; ?>'>
									<?php printf ($b); ?>
								</a><?php
							}
						};?></div>
						<div><?php
							echo file_get_contents('./index_content/'.$path.'.txt');
						?></div>				
					</div>					
					<div>					
						<img src='./index_content/<?php echo $path; ?>.png'></img>
					</div>
				</div><?php
			};?>
		</div>
	</div>
</div>

<?php
$mysqli->close();
?>