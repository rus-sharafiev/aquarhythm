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
		<div>УНИВЕРСАЛЬНЫЕ НАСОСНЫЕ СТАНЦИИ АКВАРОБОТ</div>
	</div>
	<div id="category-description">
		Предназначены для подачи чистой холодной воды,
		не содержащей абразивных частиц и волокнистых включений, 
		из неглубоких колодцев и скважин, накопительных
		резервуаров и других источников водоснабжения в автоматическом 
		режиме (включаясь и выключаясь по мере расходования 
		воды потребителем), а также для повышения давления 
		в магистральном водопроводе.<br><br>
		Станции «АКВАРОБОТ» универсальные собираются на базе
		поверхностных насосов, оснащены гидроаккумулятором
		объёмом 24 л, реле давления PM/5-3W со встроенным
		манометром и блоком управления «ТУРБИ» с датчиком
		потока.<br><br>
		Реле давления управляет включением и выключением
		насоса по заданным значениям минимального и максимального 
		давления. Датчик потока «ТУРБИ» обладает повышенной 
		чувствительностью 2 л/мин и обеспечивает надежное отключение 
		станции в случаях, когда насос не может
		набрать заданное давление вык лючения («сухой ход»,
		утечки в системе, заклинивание рабочего колеса) и в других
		аварийных ситуациях.<br><br>
		Преимущества универсальной станции «АКВАРОБОТ»:<br>
		• Возможность установки верхнего и нижнего порога давления в системе;<br>
		• Обеспечивает надежное отключение насоса:<br>
		—при отсутствии воды в системе водоснабжения, либо
		в режиме слабой производительности скважины
		(«сухой ход»);<br>
		—при заклинивании рабочего колеса насоса;<br>
		—при наличии утечек в системе (менее 2 л/мин);<br>
		—при неправильном подключении станции к источнику
		водоснабжения;<br>
		—при понижении напряжения электросети.<br>
	</div>
	<div id="category-image">
	  <object data="image.svg"></object>
	</div>
</div>

<?php

$query = "SELECT * FROM cat 
WHERE category LIKE 'УНИВЕРСАЛЬНЫЕ НАСОСНЫЕ СТАНЦИИ АКВАРОБОТ'
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