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
		<div>ПОГРУЖНЫЕ НАСОСЫ</div>
	</div>
	<div id="category-description">
		Погружные насосы UNIPUMP предназначены для подачи
		чистой холодной воды из скважин, глубоких колодцев
		и открытых водоёмов.<br><br>
		Области применения модельного ряда погружных насосов:<br>
		• индивидуальное (автономное) водоснабжение: 
		обеспечение водой коттеджей, дачных домов, организация полива
		приусадебных участков и т. д.;<br>
		• коммунально-бытовое водоснабжение: обеспечение
		водой объектов гражданского назначения;<br>
		• сельскохозяйственное водоснабжение: обеспечение
		водой фермерских хозяйств и сельхозпроизводств, орошение 
		промышленных теплиц, мелиорация земель и т. д.;<br>
		• промышленное водоснабжение: обеспечение предприятий 
		водой для хозяйственно-питьевых нужд и выполнения 
		технологических процессов;<br>
		• водоснабжение в строительстве: обеспечение водой 
		объектов строительства, понижение уровня грунтовых и пластовых вод при производстве строительных работ.<br><br>
	</div>
	<div id="category-image">
	  <object data="table.svg"></object>
	  <object data="image.svg"></object>
	</div>
</div>

<?php

$query = "SELECT * FROM cat 
WHERE category LIKE 'ПОГРУЖНЫЕ НАСОСЫ'
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