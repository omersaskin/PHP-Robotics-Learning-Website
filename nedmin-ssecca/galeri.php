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
				<h2>Fotoğraflar</h2>
				<div class="col-100" style="overflow-x:auto;">
					<table>
						<tr>
							<th>Fotoğraf</th>
							<th>Başlık</th>
							<th>Açıklama</th>
							<th>SEO Alt</th>
							<th>İşlem</th>
						</tr>
						<?php 
							while($galericek=$galerisor->fetch(PDO::FETCH_ASSOC)) {?>
								<tr>
									<td><img src="../images/<?= $galericek["resim"]; ?>"></td>
									<td><?= $galericek["baslik"]; ?></td>
									<td><?= $galericek["aciklama"]; ?></td>
									<td><?= $galericek["seo_alt"]; ?></td>
									<td><a href="../inc/config.php?galeriSil_no=<?= $galericek["id"]; ?>">Sil</a></td>
								</tr>
							<?php }
						?>
					</table>	
					<?php
					if(isset($_GET["status"]) && $_GET["status"] == "true") {
						echo '<h4>Fotoğraf başarıyla silindi.</h4>';
					} elseif(isset($_GET["status"]) && $_GET["status"] == "false") {
							echo '<h4>Malesef fotoğraf silinemedi!</h4>';
						}
					?>						
				</div>
			</div>
			<div class="pagination">
				<?php

					$s=0;

					while ($s < $toplam_sayfa3) {

						$s++; ?>

						<?php 

							if ($s==$galeri) {?>

								<a href="galeri.php?galeri=<?php echo $s; ?>" class="active"><?php echo $s; ?></a>

						<?php } else {?>

								<a href="galeri.php?galeri=<?php echo $s; ?>"><?php echo $s; ?></a>

						<?php }

					}

				?>
			</div>
			<div class="row">
				<h2>Fotoğraf Oluştur</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST" enctype="multipart/form-data">	
						<table>
							<tr>
								<th>Fotoğraf</th>
								<th>Başlık</th>
								<th>Açıklama</th>
								<th>SEO Alt</th>
								<th>İşlem</th>
							</tr>
							<tr>
								<td><input type="file" name="resim"></td>
								<td><input type="text" name="baslik" placeholder="Başlık giriniz"></td>
								<td><textarea type="text" name="aciklama" placeholder="Açıklama giriniz"></textarea></td>
								<td><input type="text" name="seo_alt" placeholder="SEO Alt giriniz"></td>
								<td><input type="submit" name="fotograf_olustur" value="Tamamla"></td>
							</tr>
						</table>						
					</form>
					<?php
					if(isset($_GET["status"]) && $_GET["status"] == "basarili") {
						echo '<h4>Fotoğraf başarıyla eklendi.</h4>';
					} elseif(isset($_GET["status"]) && $_GET["status"] == "basarisiz") {
							echo '<h4>Kayıt sırasında bir sorun oluştu!</h4>';
						} elseif(isset($_GET["status"]) && $_GET["status"] == "none") {
							echo '<h4>Dosya Yüklenemedi!</h4>';
						} elseif(isset($_GET["status"]) && $_GET["status"] == "type") {
							echo '<h4>Dosya yalnızca jpeg formatında olabilir!</h4>';
						} elseif(isset($_GET["status"]) && $_GET["status"] == "size") {
							echo '<h4>Dosya boyutu 1 Mb ı geçmemeli!</h4>';
						}
					?>
				</div>
			</div>
			<div class="row">
				<h2>Fotoğraf Düzenle</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST" enctype="multipart/form-data">
						<table>
							<tr>
								<th>Fotoğraf</th>
								<th>Başlık</th>
								<th>Açıklama</th>
								<th>SEO Alt</th>
								<th>İşlem</th>
							</tr>
							<?php 
								foreach($rows6 as $row) {?>
									<tr>
										<input type="hidden" name="id" value="<?= $row["id"]; ?>">
										<td><input type="file" name="resim"></td>
										<td><input type="text" name="baslik" value="<?= $row["baslik"]; ?>"></td>
										<td><textarea type="text" name="aciklama"><?= $row["aciklama"]; ?></textarea></td>
										<td><input type="text" name="seo_alt" value="<?= $row["seo_alt"]; ?>"></td>
										<td><input type="submit" name="fotograf_guncelle" value="Tamamla"></td>
									</tr>
								<?php }
							?>
						</table>		
					</form>
					<?php
					if(isset($_GET["status"]) && $_GET["status"] == "fotograf-duzenlendi") {
						echo '<h4>Fotoğraf başarıyla güncellendi.</h4>';
					} elseif(isset($_GET["status"]) && $_GET["status"] == "fotograf-duzenlenemedi") {
							echo '<h4>Kayıt sırasında bir sorun oluştu!</h4>';
						} elseif(isset($_GET["status"]) && $_GET["status"] == "none") {
							echo '<h4>Dosya Yüklenemedi!</h4>';
						} elseif(isset($_GET["status"]) && $_GET["status"] == "type") {
							echo '<h4>Dosya yalnızca jpeg formatında olabilir!</h4>';
						} elseif(isset($_GET["status"]) && $_GET["status"] == "size") {
							echo '<h4>Dosya boyutu 1 Mb ı geçmemeli!</h4>';
						}
					?>
				</div>
			</div>
		</section>
	 </main>

	<?php 
		include "inc/footer.php";
	?>
	 
</body>
</html>