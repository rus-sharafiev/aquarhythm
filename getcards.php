<?php
$mysqli = new mysqli("localhost", "", "", "");
	
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if (!$mysqli->set_charset("utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli->error);
    exit();
}

$key = $_POST['key'];

$query = "
SELECT * FROM cat 
WHERE
category LIKE '%$key%' OR 
series LIKE '%$key%' OR 
name LIKE '%$key%' OR 
id LIKE '$key%' 
ORDER BY series";

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

if ($stmt->num_rows == 0) {
	?>
	<div>Ничего не найдено, измените условия поиска</div>
	<?php
}else if ($stmt->num_rows == 1) {
	$stmt->fetch();?>
<script>
	window.open('/item/?art=<?php echo $id ?>', "_self");
</script>
<?php
} else { 
	$serarray = array();
	if ($searchresult = $mysqli->query($query)) {
		while ($row = $searchresult->fetch_assoc()) {
			if (!in_array(array($row["dir"], $row["category"], $row["series"]), $serarray)) {
				$serarray[] = array($row["dir"], $row["category"], $row["series"]);
			} 	
		}
		$searchresult->free();
	}

	foreach ($serarray as $arr) { ?>
	<div id="categories">
        <a href="<?php echo $arr[0] ?>" class="cattile">
            <div class='catimage'>
				<img src="<?php echo $arr[0] ?>image.png" alt="<?php echo $arr[1] ?> <?php echo $arr[2] ?>" width="200">
			</div>
			<div class="catname">
				<?php printf ($arr[1]); ?>
			</div>
			<div class="sername">
				<?php printf ($arr[2]); ?>
			</div>
	   </a> 
	   <?php
		$stmt->data_seek(0);
   		while ($stmt->fetch()) {
			if ($series == $arr[2] && $category == $arr[1]){
				include 'tile.php';
			}
		} ?>
	</div><?php
	};
}

$stmt->close();
$mysqli->close();
?>
