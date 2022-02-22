			<div class="tile">
				<a class='tile-link' href='<?= '/item/?art='.$id ?>'></a>
				<div class='tileimage'>
					<?php if (file_exists($_SERVER['DOCUMENT_ROOT'].$dir.$image.'.jpg')) { ?>
						<img src="<?php echo $dir; echo $image; ?>.jpg" alt="Pic" width="200">
					<?php } else { ?>
						<img src="<?php echo $dir; ?>image.png" alt="Pic" width="200">
					<?php } ?>
				</div>
                <div class="tileid">Арт. <?php printf ($id); ?>
				</div>
				<div class="tilename">
				<span style="font-size: 14px;"><?php printf ($series); ?></span> <?php printf ($name); ?>
				</div>
				<div class="tileadd">
					<?php 
					if ($hydroacc != "") { ?>
						<div>
							<span>Гидробак:  </span><?php printf ($hydroacc); ?>
						</div>
					<?php }
					if ($wirelength != "") { ?>
						<div>
							<span>Длина провода:  </span><?php printf ($wirelength); ?>
						</div>
					<?php }
					if ($power != "") { ?>
						<div>
							<span>Мощность:  </span><?php printf ($power); ?>
						</div>
					<?php }
					if ($pumpdia != "") { ?>
						<div>
							<span>Диаметр насоса:  </span><?php printf ($pumpdia); ?>
						</div>
					<?php }
					if ($rpm != "") { ?>
						<div>
							<span>Частота вращения:  </span><?php printf ($rpm); ?>
						</div>
					<?php }
					if ($additional != "") { ?>
						<div>
							<?php printf ($additional); ?>
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
				<div class="tile-price">	<?php
					if ($searchresult = $mysqli->query("SELECT * FROM price	WHERE id='$id'")) {
						while ($row = $searchresult->fetch_assoc()) {
							echo number_format(floatval($row["price"]), 2, ',', ' ');
						}
						$searchresult->free();
					}	?> руб.
				</div>
			</div>