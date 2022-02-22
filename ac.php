<?php
$query = "SELECT id, category, series FROM cat";
$array = array();

if ($result = $mysqli->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $array[] = ["label" => $row["category"], "category" => "Категория"];
    }
    $result->free();
}

if ($result = $mysqli->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $array[] = ["label" => $row["series"], "category" => "Серия"];
    }
    $result->free();
}

if ($result = $mysqli->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $array[] = ["label" => $row["id"], "category" => "Артикул"];
    }
    $result->free();
}

$array = array_unique($array, SORT_REGULAR);
$array = array_values($array);

?>

<script>

$( function() {
    $.widget( "custom.catcomplete", $.ui.autocomplete, {
      _create: function() {
        this._super();
        this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
      },
      _renderMenu: function( ul, items ) {
        var that = this,
          currentCategory = "";
        $.each( items, function( index, item ) {
          var li;
          if ( item.category != currentCategory ) {
            ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
            currentCategory = item.category;
          }
          li = that._renderItemData( ul, item );
          if ( item.category ) {
            li.attr( "aria-label", item.category + " : " + item.label );
          }
        });
      }
    });
	var tags = <?php echo json_encode($array) ?>;
	$( "#autocomplete" ).catcomplete({
        source: tags,
		focus: function(event, ui) {
			$("#autocomplete").val(ui.item.label);
		},
		select: function(event, ui) {
			$("#searchform").submit();
		},
		position: { 
			my: "left top-30", 
			at: "left bottom"
		},
        minLength: 3,
		open: function( event, ui ) {
			$("#autocomplete").addClass("ac");
			$("#divider").addClass("ac");
		},
		close: function( event, ui ) {
			$("#autocomplete").removeClass("ac");
			$("#divider").removeClass("ac");
		},
		appendTo: "#searchform",
	});
});
</script>