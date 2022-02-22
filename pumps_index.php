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
<link href="/css/pumps.css" rel="stylesheet">
<link href="/css/tile.css" rel="stylesheet">
<link href="/css/mobile.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="/js/jquery.js"></script>
<script src="/js/jquery-ui.js"></script>

<!-- Header -->
<?php
$page_title = file_get_contents('title.txt', true);
echo("<title>$page_title</title>");
include ($_SERVER['DOCUMENT_ROOT'].'/header.php');

$categoryname = file_get_contents('cat.txt', true);
$query = "SELECT * FROM cat WHERE category = '$categoryname'";
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


if ($searchresult = $mysqli->query($query)) {
	while ($row = $searchresult->fetch_assoc()) {
		$catDir = $row["cat_dir"];
	}
	$searchresult->free();
}
?>

<div id="series-category">
	<div id=series-category-name>
		<object data="/<?php echo $catDir?>/logo.svg"></object>
		<div><?php echo $categoryname;?></div>
	</div>
	<div id="series-container">
		<?php echo file_get_contents('spec.svg') ?>
	</div>
	<?php
		while ($stmt->fetch()) {
			if ($series == file_get_contents('title.txt', true)) {
				include $_SERVER['DOCUMENT_ROOT'].'/tile.php';
			}
	};?>
</div>

<?php
$mysqli->close();
?>