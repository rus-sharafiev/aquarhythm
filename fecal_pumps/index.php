<?php session_start(); ?>

<!DOCTYPE html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ПОВЕРХНОСТНЫЕ НАСОСЫ</title>
<link type="image/png" sizes="16x16" rel="icon" href="/favicon-16.png">
<link type="image/png" sizes="32x32" rel="icon" href="/favicon-32.png">
<link type="image/png" sizes="96x96" rel="icon" href="/favicon-96.png">
<link type="image/png" sizes="120x120" rel="icon" href="/favicon-120.png">
<link href="/css/main.css" rel="stylesheet">
<link href="/css/pumps.css" rel="stylesheet">
<link href="/css/mobile.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="/js/jquery.js"></script>
<script src="/js/jquery-ui.js"></script>
<Style>body {padding-top: 100px;}</Style>

<!-- Header -->
<?php include ($_SERVER['DOCUMENT_ROOT'].'/header.php')?>

<div id="category-container">
  <div id=category-title>
		<object data="logo.svg"></object>
		<div>ФЕКАЛЬНЫЕ НАСОСЫ</div>
	</div>
	<div id="category-description">
	Фекальные насосы предназначены для:<br><br>
	• отвода канализационных стоков промышленных объектов,
	частных домов, а также санитарно-технического оборудования
	и бытовых установок отдельных помещений;<br>
	• откачивания грязной и содержащей включения воды из затопленных
	помещений, цистерн, резервуаров;<br>
	• забор чистой или загрязнённой воды из рек, естественных
	водоёмов, колодцев;<br>
	• откачивания септиков.<br>
	</div>
	<div id="category-image">
	  <object data="image.svg"></object>
	</div>
</div>

<?php

$query = "SELECT * FROM cat 
WHERE category LIKE 'ФЕКАЛЬНЫЕ НАСОСЫ'
ORDER BY series";

$serArray = array();
if ($searchresult = $mysqli->query($query)) {
	while ($row = $searchresult->fetch_assoc()) {
		if (!in_array(array($row["series"], $row["dir"]), $serArray)) {
			$serArray[] = array($row["series"], $row["dir"]);
		} 	
	}
	$searchresult->free();
}
?>

<div id="category-series-container">
	<div id="category-series-title">СЕРИИ</div><?php
	foreach ($serArray as list($name, $path)) {?>
		<div class="category-series" onClick="window.location='<?php echo $path; ?>';">
			<div class="category-series-img">
				<img src="<?php echo $path; ?>/image.png">
			</div>
			<div class="category-series-name"><?php printf ($name); ?></div>
		</div><?php
	};?>
</div>