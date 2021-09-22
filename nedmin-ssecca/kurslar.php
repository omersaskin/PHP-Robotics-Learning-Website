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
				<h2>Kurslar</h2>
				<div class="col-100" style="overflow-x:auto;">
					<table>
						<tr>
							<th>Kurs Adı</th>
							<th>Kurs Hakkında</th>
							<th>Gereksinimler</th>
							<th>Kazanımlar</th>
							<th>Fiyat</th>
							<th>Kurs Süresi</th>
							<th>Yeterlilikler</th>
							<th>Kursun Amacı</th>
							<th>İşlem</th>
						</tr>
						<?php 
							while($kurscek=$kurssor->fetch(PDO::FETCH_ASSOC)) {?>
								<tr>
									<td><?= $kurscek["kurs_adi"]; ?></td>
									<td><?= $kurscek["kurs_hakkinda"]; ?></td>
									<td><?= $kurscek["gereksinimler"]; ?></td>
									<td><?= $kurscek["kazanimlar"]; ?></td>
									<td><?= $kurscek["fiyat"]; ?></td>
									<td><?= $kurscek["kurs_suresi"]; ?></td>
									<td><?= $kurscek["yeterlilikler"]; ?></td>
									<td><?= $kurscek["kursun_amaci"]; ?></td>
									<td><a href="../inc/config.php?kursSil_no=<?= $kurscek["id"]; ?>">Sil</a></td>
								</tr>
							<?php }
						?>
					</table>		
					<?php
					if(isset($_GET["status"]) && $_GET["status"] == "true") {
						echo '<h4>Kurs başarıyla silindi.</h4>';
					} elseif(isset($_GET["status"]) && $_GET["status"] == "false") {
							echo '<h4>Malesef kurs silinemedi!</h4>';
						}
					?>					
				</div>
			</div>
			<div class="pagination">
				<?php

					$s=0;

					while ($s < $toplam_sayfa7) {

						$s++; ?>

						<?php 

							if ($s==$sayfa) {?>

								<a href="kurslar.php?sayfa=<?php echo $s; ?>" class="active"><?php echo $s; ?></a>

						<?php } else {?>

								<a href="kurslar.php?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>

						<?php }

					}

				?>
			</div>
			<div class="row">
				<h2>Kurs Oluştur</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST">			
						<table>
							<tr>
								<th>Kurs Adı</th>
								<th>Kurs Hakkında</th>
								<th>Gereksinimler</th>
								<th>Kazanımlar</th>
								<th>Fiyat</th>
								<th>Kurs Süresi</th>
								<th>Yeterlilikler</th>
								<th>Kursun Amacı</th>
								<th>İşlem</th>
							</tr>
							<tr>
								<td><input type="text" name="kurs_adi" placeholder="Kurs Adı giriniz"></td>
								<td><input type="text" name="kurs_hakkinda" placeholder="Hakkında giriniz"></td>
								<td><input type="text" name="gereksinimler" placeholder="Gereksinimler giriniz"></td>
								<td><input type="text" name="kazanimlar" placeholder="Kazanımlar giriniz"></td>
								<td><input type="text" name="fiyat" placeholder="Fiyat giriniz"></td>
								<td><input type="text" name="kurs_suresi" placeholder="Kurs Süresi giriniz"></td>
								<td><input type="text" name="yeterlilikler" placeholder="Yeterlilikler giriniz"></td>
								<td><input type="text" name="kursun_amaci" placeholder="Kursun Amacı giriniz"></td>
								<td><input type="submit" name="kurs_olustur" value="Tamamla"></td>
							</tr>
						</table>	
						<?php
						if(isset($_GET["status"]) && $_GET["status"] == "eklendi") {
							echo '<h4>Kurs başarıyla eklendi.</h4>';
						} elseif(isset($_GET["status"]) && $_GET["status"] == "eklenemedi") {
								echo '<h4>Malesef kurs eklenemedi!</h4>';
							}
						?>								
					</form>
				</div>
			</div>
			<div class="row">
				<h2>Kurs Güncelle</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST">
						<input type="hidden" name="id">
						<table>
							<tr>
								<th>Kurs Adı</th>
								<th>Kurs Hakkında</th>
								<th>Gereksinimler</th>
								<th>Kazanımlar</th>
								<th>Fiyat</th>
								<th>Kurs Süresi</th>
								<th>Yeterlilikler</th>
								<th>Kursun Amacı</th>
								<th>İşlem</th>
							</tr>
							<?php 
								foreach($rows13 as $row) {?>
									<tr>
										<input type="hidden" name="id" value="<?= $row["id"]; ?>">
										<td><input type="text" name="kurs_adi" value="<?= $row["kurs_adi"]; ?>"></td>
										<td><input type="text" name="kurs_hakkinda" value="<?= $row["kurs_hakkinda"]; ?>"></td>
										<td><input type="text" name="gereksinimler" value="<?= $row["gereksinimler"]; ?>"></td>
										<td><input type="text" name="kazanimlar" value="<?= $row["kazanimlar"]; ?>"></td>
										<td><input type="text" name="fiyat" value="<?= $row["fiyat"]; ?>"></td>
										<td><input type="text" name="kurs_suresi" value="<?= $row["kurs_suresi"]; ?>"></td>
										<td><input type="text" name="yeterlilikler" value="<?= $row["yeterlilikler"]; ?>"></td>
										<td><input type="text" name="kursun_amaci" value="<?= $row["kursun_amaci"]; ?>"></td>
										<td><input type="submit" name="kurs_guncelle" value="Tamamla"></td>
									</tr>
								<?php }
							?>
						</table>	
						<?php
						if(isset($_GET["status"]) && $_GET["status"] == "guncellendi") {
							echo '<h4>Kurs başarıyla guncellendi.</h4>';
						} elseif(isset($_GET["status"]) && $_GET["status"] == "guncellenemedi") {
								echo '<h4>Malesef kurs guncellenemedi!</h4>';
							}
						?>		
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