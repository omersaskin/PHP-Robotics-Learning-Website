<!DOCTYPE html>
<html lang="tr">
<head>
	<?php
		include "inc/head.php";
	?>
</head>
<body> 
	<?php
		include "inc/nav.php";
	?>

	 <main>
		<section id="bolum-1">
			<div class="row">
				<h2>İletişim</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST">
						<input type="hidden" name="id">
						<table>
							<tr>
								<th>Adres</th>
								<th>Telefon</th>
								<th>E-Posta</th>
								<th>Facebook</th>
								<th>Twitter</th>
								<th>Youtube</th>
								<th>Instagram</th>
								<th>İşlem</th>
							</tr>
							<?php 
								foreach($rows8 as $row) {?>
									<tr>
										<td><input type="text" name="adres" value="<?= $row["adres"]; ?>"></td>
										<td><input type="text" name="telefon" value="<?= $row["telefon"]; ?>"></td>
										<td><input type="text" name="eposta" value="<?= $row["eposta"]; ?>"></td>
										<td><input type="text" name="facebook" value="<?= $row["facebook"]; ?>"></td>
										<td><input type="text" name="twitter" value="<?= $row["twitter"]; ?>"></td>
										<td><input type="text" name="youtube" value="<?= $row["youtube"]; ?>"></td>
										<td><input type="text" name="instagram" value="<?= $row["instagram"]; ?>"></td>
										<td><input type="submit" name="iletisim_guncelle" value="Tamamla"></td>
									</tr>
								<?php }
							?>
						</table>	
					</form>
				</div>
			</div>
		</section>
	 </main>

	<?php 
		include "inc/footer.php";
	?>
	 
</body>
</html>