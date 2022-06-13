<?php 
$mysqli = new mysqli("localhost", "root", "", "aquarhythm");

if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if (!$mysqli->set_charset("utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli->error);
    exit();
}

$query = "SELECT * FROM cat";
$menuArray = array();
if ($searchresult = $mysqli->query($query)) {
	while ($row = $searchresult->fetch_assoc()) {
		if (!in_array(array($row["category"], $row["cat_dir"]), $menuArray)) {
			$menuArray[] = array($row["category"], $row["cat_dir"]);
		}
	}
	$searchresult->free();
}
?>

<div id=logo-shadow>
	<object data="/svg/logo_shadow.svg"></object>
</div>
<div id=logo>
	<object data="/svg/logo.svg"></object>
	<div onclick="window.location='/';"></div>
</div>

<header class="up">
	<div id="logo-space"></div>
	<nav>
		<div id="catalog" class="catalog" onClick="showCatalog()">Каталог</div>
		<div id="contacts" onClick="window.location='/contacts.php';">Контакты</div>
		<form action="/search.php" id="searchform" autocomplete="off" method="post">
			<input type="text" id="autocomplete" name="key" placeholder="Поиск" required>
			<input type="button" id="clearfield" value="close" class="hidden">
			<input type="button" id="submitbutton" value="search">
		</form>
		<input type="button" id="shopping-cart" value="shopping_cart" onClick="window.location='/cart.php';">
		<div id="cart-count" <?php if (!($_SESSION['cart'] ?? NULL)) { 
				echo 'class="hidden"'; 
			}?>>
			<?php if ($_SESSION['cart'] ?? NULL) { 
				echo count($_SESSION['cart']); 
			}?>
		</div>
		<div id="mobile-home" onClick="window.location='/';"><div><?php echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/svg/home.svg"); ?></div>Главная</div>
		<div id="mobile-contacts" onClick="window.location='/contacts.php';"><div><?php echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/svg/place.svg"); ?></div>Контакты</div>
		<div id="mobile-search"><div><?php echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/svg/search.svg"); ?></div>Поиск</div>
		<div id="mobile-shopping-cart" onClick="window.location='/cart.php';"><div><?php echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/svg/shopping_cart.svg"); ?></div>Корзина</div>
		<div id="mobile-catalogue" onClick="showCatalog()"><div><?php echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/svg/menu.svg"); ?></div>Каталог</div>
	</nav>
	<div id="main-menu" class="hidden">
		<div>
			<?php foreach ($menuArray as list($cat, $path)) {?>
				<a href='/<?php echo $path; ?>/'>
					<div><?php echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/".$path."/logo.svg")?></div>
					<?php printf ($cat); ?>
					<style> .a{fill:#252F3A} </style>
				</a>
			<?php } ?>
		</div>
	</div>
</header>

<?php include 'ac.php' ?>

<!-- Call us -->
<form id="callform" autocomplete="off" action="" method="post" class="right">
    <input type="tel" id="phone" name="phone" placeholder="Номер телефона без +7" pattern="[0-9]{10}" required>
    <input type="text" id="name" name="name" placeholder="Имя" pattern="^[А-Яа-яЁё\s]+$" maxlength="25" required>
    <input type="button" id="callbutton" value="Отправить заявку">
    <input type="button" id="call" value="Заказать звонок">
</form>

<script>

// Clear button 
$("#clearfield")
	.mousedown(function(e) {
		e.preventDefault();
	})
	.click( function() {
    	$("#autocomplete").val("");
	});

$("#autocomplete").keyup( function() {
    if ($("#autocomplete").val() == "") {
        $("#clearfield").addClass('hidden')
    } else {
        $("#clearfield").removeClass('hidden');
    }
});

// Catalog
function showCatalog() {
	if ($("#main-menu").hasClass("hidden")) {
		$("#main-menu").removeClass("hidden");
		$(this).addClass('active');
	} else {
		$("#main-menu").addClass("hidden");
		$(this).removeClass('active');
	}
};

// Search
$("#autocomplete").focus( function() {
    if ($("#autocomplete").val() != "") {
        $("#clearfield").removeClass('hidden');
    }
	$("#autocomplete").attr('placeholder','Поиск по артикулу, наименованию');
});

$("#autocomplete").blur( function() {
    setTimeout(function() {
        $("#clearfield").addClass('hidden');
    }, 300);
	$("#autocomplete").attr('placeholder','Поиск');
});

// Show search on mobile
$("#mobile-search").click( function() {
	if ($("#searchform").css("display") == "none") {
		$("#searchform").css("display","block");
		$("#autocomplete").focus();
	} else {
		$("#searchform").css("display","none");
    	$("#autocomplete").blur();
	}
});

if ($("#mobile-search").css("display") != "none" ) {
	$("#autocomplete").blur( function() {
		$("#searchform").css("display","none");
		$("#mobile-search").css( "width", "30px" );
	});
}
	

// Show 'n' hide the call form
$("#call").click( function () {
    if (document.getElementsByClassName('right').length > 0) {
        $("#callform").removeClass('right').addClass('left');
    } else {
        $("#callform").removeClass('left').addClass('right');
    }
});
						 
// Call form check 'n' submit
$("#callbutton").on('click', function() {
    var isValid = document.querySelector('#callform').reportValidity();
    if (isValid) {
        $.ajax( {
            url: 'callus.php',
            type: 'post',
            data: $('#callform').serialize(),
            success: function(){
                $("#callform").removeClass('left').addClass('right');
                alert("Мы свяжемся с Вами в ближайшее время");
                document.getElementById('phone').value = "";
                document.getElementById('name').value = "";
            }
        });
    }
});
	
if ($("#mobile-search").css("display") != "none") {
	$("#searchform").appendTo($("body"));
}

// Hide the mobile menu on scroll up
var didScroll;
var lastScrollTop = 0;
var delta = 20;
var navbarHeight = $("header").outerHeight();

$(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 0);

function hasScrolled() {
    var st = $(this).scrollTop();
    if(Math.abs(lastScrollTop - st) <= delta)
        return;
    if (st > lastScrollTop && st > navbarHeight){
        $("header").removeClass('up').addClass('down');
    } else {
        if(st + $(window).height() < $(document).height()) {
            $("header").removeClass('down').addClass('up');
        }
    }
    lastScrollTop = st;
}
</script>

<script>
// Search
if (document.URL.includes("search.php")) {
	//AJAX
	$("#searchform").submit( function() {
		event.preventDefault();
		if (document.querySelector('#searchform').reportValidity()) {
			$.ajax({
				url: 'getcards.php',
				type: 'post',
				data: $('#searchform').serialize(),
				dataType: "html",
				success: function(data) {
					$("#container").html(data);
					$("#autocomplete").blur();
				}
			});
		}
	});
	$("#submitbutton").click( function() {
		if (document.querySelector('#searchform').reportValidity()) {
    		$("#autocomplete").submit();
		}
	});
} else {
	$("#submitbutton").click( function() {
		if (document.querySelector('#searchform').reportValidity()) {
			$("#searchform").submit();
		}
	});
}
</script>

<script>
	function addToCart(data) {
		$.ajax({
			url: '/cart.php',
			type: "POST",
			data: { id: data },
			dataType: "html",
			success: function() {
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