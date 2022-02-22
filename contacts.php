<!DOCTYPE html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Контакты</title>
<link type="image/png" sizes="16x16" rel="icon" href="/favicon-16.png">
<link type="image/png" sizes="32x32" rel="icon" href="/favicon-32.png">
<link type="image/png" sizes="96x96" rel="icon" href="/favicon-96.png">
<link type="image/png" sizes="120x120" rel="icon" href="/favicon-120.png">
<link href="/css/contacts.css" rel="stylesheet">
<link href="/css/main.css" rel="stylesheet">
<link href="/css/mobile.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="/js/jquery.js"></script>
<script src="/js/jquery-ui.js"></script>
<script src="https://api-maps.yandex.ru/2.1/?apikey=d80e2e81-5cb3-41bb-b529-9d7e60704737&lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
ymaps.ready(init);
function init() {
    var myMap = new ymaps.Map("map", {
        center: [55.772302, 49.187864],
     	controls: ['zoomControl'],
        zoom: 16
    });
	var myGeoObject = new ymaps.GeoObject({	
    	geometry: {
       		type: "Point",
       		coordinates: [55.773832, 49.187413]
    	},		
		properties: {
        	iconContent: "АКВАРИТМ"
    	}
	}, {
		preset: 'islands#orangeStretchyIcon'
	});
	myMap.geoObjects.add(myGeoObject);
}
</script>

<!-- <Style>body {justify-content: flex-end;}</Style> -->

<!-- Header -->
<?php include 'header.php' ?>

<div id="map"></div>
<div id="contactscontainer">
	<div id="address" class="phones">
		<span>location_on</span>
		ул. Аделя Кутуя, 153а, офис 6</br>
		г. Казань</br>
		Республика Татарстан</br>
		Россия</br>
		420087
	</div>
	<div id=phone1 class="phones">
		<span>phone</span>
		+7 843 250-15-36
	</div>
	<div id=phone2 class="phones">
		<span>smartphone</span>
		+7 927 033-28-37
	</div>
	<div id=mail class="phones">
		<span>email</span>
		info@ritm-rt.ru
	</div>
</div>

