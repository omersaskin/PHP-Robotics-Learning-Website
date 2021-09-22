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
				<h2>Haberler</h2>
				<div class="col-100" style="overflow-x:auto;">
					<table>
						<tr>
							<th>Fotoğraf</th>
							<th>Başlık</th>
							<th>Açıklama</th>
							<th>Tarih</th>
							<th>Title</th>
							<th>Description</th>
							<th>Author</th>
							<th>SEO Url</th>
							<th>SEO Alt</th>
							<th>Aktiflik</th>
							<th>Sil</th>
						</tr>
						<?php 
							while($habercek=$habersor->fetch(PDO::FETCH_ASSOC)) {?>
								<tr>
									<td><img src="../images/<?= $habercek["resim"]; ?>"></td>
									<td><?= $habercek["baslik"]; ?></td>
									<td><?= $habercek["aciklama"]; ?></td>
									<td><?= $habercek["tarih"]; ?></td>
									<td><?= $habercek["title"]; ?></td>
									<td><?= $habercek["description"]; ?></td>
									<td><?= $habercek["author"]; ?></td>
									<td><?= $habercek["seo_url"]; ?></td>
									<td><?= $habercek["seo_alt"]; ?></td>
									<td><?= $habercek["aktiflik"]; ?></td>
									<td><a href="../inc/config.php?haberSil_no=<?= $habercek["id"]; ?>">Sil</a></td>
								</tr>
							<?php }
						?>
					</table>	
					<?php
					if(isset($_GET["status"]) && $_GET["status"] == "true") {
						echo '<h4>Haber başarıyla silindi.</h4>';
					} elseif(isset($_GET["status"]) && $_GET["status"] == "false") {
							echo '<h4>Malesef haber silinemedi!</h4>';
						}
					?>							
				</div>
			</div>
			<div class="pagination">
				<?php

					$s=0;

					while ($s < $toplam_sayfa5) {

						$s++; ?>

						<?php 

							if ($s==$haber) {?>

								<a href="teknoloji-haberleri.php?haber=<?php echo $s; ?>" class="active"><?php echo $s; ?></a>

						<?php } else {?>

								<a href="teknoloji-haberleri.php?haber=<?php echo $s; ?>"><?php echo $s; ?></a>

						<?php }

					}

				?>
			</div>
			<div class="row">
				<h2>Haber Oluştur</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST" enctype="multipart/form-data">			
						<table>
							<tr>
								<th>Fotoğraf</th>
								<th>Başlık</th>
								<th>Açıklama</th>
								<th>Title</th>
								<th>Description</th>
								<th>Author</th>
								<th>SEO Url</th>
								<th>SEO Alt</th>
								<th>İşlem</th>
							</tr>
							<tr>
								<td><input type="file" name="resim"></td>
								<td><input type="text" name="baslik" placeholder="Başlık giriniz"></td>
								<td><textarea type="text" name="aciklama" placeholder="Açıklama giriniz"></textarea></td>
								<td><input type="text" name="title" placeholder="Title giriniz"></td>
								<td><input type="text" name="description" placeholder="description giriniz"></td>
								<td><input type="text" name="author" placeholder="Author giriniz"></td>
								<td><input type="text" name="seo_url" placeholder="SEO Url giriniz"></td>
								<td><input type="text" name="seo_alt" placeholder="SEO Alt giriniz"></td>
								<td><input type="submit" name="haber_olustur" value="Tamamla"></td>
							</tr>
						</table>						
					</form>
					<?php
					if(isset($_GET["status"]) && $_GET["status"] == "basarili") {
						echo '<h4>Haber başarıyla eklendi.</h4>';
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
				<h2>Haberi Düzenle</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id">
						<table>
							<tr>
								<th>Fotoğraf</th>
								<th>Başlık</th>
								<th>Açıklama</th>
								<th>Title</th>
								<th>Description</th>
								<th>Author</th>
								<th>SEO Url</th>
								<th>SEO Alt</th>
								<th>İşlem</th>
							</tr>
							<?php 
								foreach($rows10 as $row) {?>
									<tr>
										<input type="hidden" name="id" value="<?= $row["id"]; ?>">
										<td><input type="file" name="resim"></td>
										<td><input type="text" name="baslik" value="<?= $row["baslik"]; ?>"></td>
										<td><textarea type="text" name="aciklama"><?= $row["aciklama"]; ?></textarea></td>
										<td><input type="text" name="title" value="<?= $row["title"]; ?>"></td>
										<td><input type="text" name="description" value="<?= $row["description"]; ?>"></td>
										<td><input type="text" name="author" value="<?= $row["author"]; ?>"></td>
										<td><input type="text" name="seo_url" value="<?= $row["seo_url"]; ?>"></td>
										<td><input type="text" name="seo_alt" value="<?= $row["seo_alt"]; ?>"></td>
										<td><input type="submit" name="haber_guncelle" value="Tamamla"></td>
									</tr>
								<?php }
							?>
						</table>	
					</form>
					<?php
					if(isset($_GET["status"]) && $_GET["status"] == "haber-duzenlendi") {
						echo '<h4>Haber başarıyla güncellendi.</h4>';
					} elseif(isset($_GET["status"]) && $_GET["status"] == "haber-duzenlenemedi") {
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