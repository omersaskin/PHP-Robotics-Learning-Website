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
				<h2>Sayfalar</h2>
				<div class="col-100" style="overflow-x:auto;">
					<table>
						<tr>
							<th>Fotoğraf</th>
							<th>Başlık</th>
							<th>Açıklama</th>
							<th>Title</th>
							<th>Description</th>
							<th>Keywords</th>
							<th>Author</th>
							<th>SEO Alt</th>
							<th>İşlem</th>
						</tr>
						<?php 
							while($sayfacek=$sayfasor->fetch(PDO::FETCH_ASSOC)) {?>
								<tr>
									<td><img src="../images/<?= $sayfacek["resim"]; ?>"></td>
									<td><?= $sayfacek["baslik"]; ?></td>
									<td><?= $sayfacek["aciklama"]; ?></td>
									<td><?= $sayfacek["title"]; ?></td>
									<td><?= $sayfacek["description"]; ?></td>
									<td><?= $sayfacek["keywords"]; ?></td>
									<td><?= $sayfacek["author"]; ?></td>
									<td><?= $sayfacek["seo_alt"]; ?></td>
									<td><a href="../inc/config.php?sayfaSil_no=<?= $sayfacek["id"]; ?>">Sil</a></td>
								</tr>
							<?php }
						?>
					</table>		
					<?php
					if(isset($_GET["status"]) && $_GET["status"] == "true") {
						echo '<h4>Sayfa başarıyla silindi.</h4>';
					} elseif(isset($_GET["status"]) && $_GET["status"] == "false") {
							echo '<h4>Malesef sayfa silinemedi!</h4>';
						}
					?>					
				</div>
			</div>
			<div class="pagination">
				<?php

					$s=0;

					while ($s < $toplam_sayfa1) {

						$s++; ?>

						<?php 

							if ($s==$sayfa) {?>

								<a href="statik-sayfalar.php?sayfa=<?php echo $s; ?>" class="active"><?php echo $s; ?></a>

						<?php } else {?>

								<a href="statik-sayfalar.php?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>

						<?php }

					}

				?>
			</div>
			<div class="row">
				<h2>Sayfa Oluştur</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST" enctype="multipart/form-data">	
						<table>
							<tr>
								<th>Fotoğraf</th>
								<th>Başlık</th>
								<th>Açıklama</th>
								<th>Title</th>
								<th>Description</th>
								<th>Keywords</th>
								<th>Author</th>
								<th>SEO Alt</th>
								<th>İşlem</th>
							</tr>
							<tr>
								<td><input type="file" name="resim"></td>
								<td><input type="text" name="baslik" placeholder="Başlık giriniz"></td>
								<td><textarea type="text" name="aciklama" placeholder="Açıklama giriniz"></textarea></td>
								<td><input type="text" name="title" placeholder="Title giriniz"></td>
								<td><textarea type="text" name="description" placeholder="Description giriniz"></textarea></td>
								<td><input type="text" name="keywords" placeholder="Keywords giriniz"></td>
								<td><input type="text" name="author" placeholder="Author giriniz"></td>
								<td><input type="text" name="seo_alt" placeholder="SEO Alt giriniz"></td>
								<td><input type="submit" name="sayfa_olustur" value="Tamamla"></td>
							</tr>
						</table>					
					</form>
					<?php
					if(isset($_GET["status"]) && $_GET["status"] == "basarili") {
						echo '<h4>Sayfa başarıyla eklendi.</h4>';
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
				<h2>Sayfa Düzenle</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST" enctype="multipart/form-data">
						<table>
							<tr>
								<th>Fotoğraf</th>
								<th>Başlık</th>
								<th>Açıklama</th>
								<th>Title</th>
								<th>Description</th>
								<th>Keywords</th>
								<th>Author</th>
								<th>SEO Alt</th>
								<th>İşlem</th>
							</tr>
							<?php 
								foreach($rows4 as $row) {?>
									<tr>
										<input type="hidden" name="id" value="<?= $row["id"]; ?>">
										<td><input type="file" name="resim"></td>
										<td><input type="text" name="baslik" value="<?= $row["baslik"]; ?>"></td>
										<td><textarea type="text" name="aciklama"><?= $row["aciklama"]; ?></textarea></td>
										<td><input type="text" name="title" value="<?= $row["title"]; ?>"></td>
										<td><input type="text" name="description" value="<?= $row["description"]; ?>"></td>
										<td><input type="text" name="keywords" value="<?= $row["keywords"]; ?>"></td>
										<td><input type="text" name="author" value="<?= $row["author"]; ?>"></td>
										<td><input type="text" name="seo_alt" value="<?= $row["seo_alt"]; ?>"></td>
										<td><input type="submit" name="sayfa_guncelle" value="Tamamla"></td>
									</tr>
								<?php }
							?>
						</table>	
					</form>
					<?php
					if(isset($_GET["status"]) && $_GET["status"] == "basarili") {
						echo '<h4>Sayfa başarıyla eklendi.</h4>';
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
				<h2>Hizmetler</h2>
				<div class="col-100" style="overflow-x:auto;">
					<table>
						<tr>
							<th>Fotoğraf</th>
							<th>Başlık</th>
							<th>Açıklama</th>
							<th>Title</th>
							<th>Description</th>
							<th>Keywords</th>
							<th>Author</th>
							<th>SEO Alt</th>
							<th>İşlem</th>
						</tr>
						<?php 
							while($hizmetcek=$hizmetsor->fetch(PDO::FETCH_ASSOC)) {?>
								<tr>
									<td><img src="../images/<?= $hizmetcek["resim"]; ?>"></td>
									<td><?= $hizmetcek["baslik"]; ?></td>
									<td><?= $hizmetcek["aciklama"]; ?></td>
									<td><?= $hizmetcek["title"]; ?></td>
									<td><?= $hizmetcek["description"]; ?></td>
									<td><?= $hizmetcek["keywords"]; ?></td>
									<td><?= $hizmetcek["author"]; ?></td>
									<td><?= $hizmetcek["seo_alt"]; ?></td>
									<td><a href="../inc/config.php?hizmetSil_no=<?= $hizmetcek["id"]; ?>">Sil</a></td>
								</tr>
							<?php }
						?>
					</table>	
					<?php
					if(isset($_GET["status"]) && $_GET["status"] == "true") {
						echo '<h4>Sayfa başarıyla silindi.</h4>';
					} elseif(isset($_GET["status"]) && $_GET["status"] == "false") {
							echo '<h4>Malesef sayfa silinemedi!</h4>';
						}
					?>					
				</div>
			</div>
			<div class="pagination">
				<?php

					$s=0;

					while ($s < $toplam_sayfa2) {

						$s++; ?>

						<?php 

							if ($s==$hizmet) {?>

								<a href="statik-sayfalar.php?hizmet=<?php echo $s; ?>" class="active"><?php echo $s; ?></a>

						<?php } else {?>

								<a href="statik-sayfalar.php?hizmet=<?php echo $s; ?>"><?php echo $s; ?></a>

						<?php }

					}

				?>
			</div>
			<div class="row">
				<h2>Hizmet Oluştur</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST" enctype="multipart/form-data">	
						<table>
							<tr>
								<th>Fotoğraf</th>
								<th>Başlık</th>
								<th>Açıklama</th>
								<th>Title</th>
								<th>Description</th>
								<th>Keywords</th>
								<th>Author</th>
								<th>SEO Alt</th>
								<th>İşlem</th>
							</tr>
							<tr>
								<td><input type="file" name="resim"></td>
								<td><input type="text" name="baslik" placeholder="Başlık giriniz"></td>
								<td><textarea type="text" name="aciklama" placeholder="Açıklama giriniz"></textarea></td>
								<td><input type="text" name="title" placeholder="Title giriniz"></td>
								<td><textarea type="text" name="description" placeholder="Description giriniz"></textarea></td>
								<td><input type="text" name="keywords" placeholder="Keywords giriniz"></td>
								<td><input type="text" name="author" placeholder="Author giriniz"></td>
								<td><input type="text" name="seo_alt" placeholder="SEO Alt giriniz"></td>
								<td><input type="submit" name="hizmet_olustur" value="Tamamla"></td>
							</tr>
						</table>					
					</form>
				</div>
			</div>
			<div class="row">
				<h2>Hizmet Düzenle</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST" enctype="multipart/form-data">
						<table>
							<tr>
								<th>Fotoğraf</th>
								<th>Başlık</th>
								<th>Açıklama</th>
								<th>Title</th>
								<th>Description</th>
								<th>Keywords</th>
								<th>Author</th>
								<th>SEO Alt</th>
								<th>İşlem</th>
							</tr>
							<?php 
								foreach($rows2 as $row) {?>
									<tr>
										<input type="hidden" name="id" value="<?= $row["id"]; ?>">
										<td><input type="file" name="resim"></td>
										<td><input type="text" name="baslik" value="<?= $row["baslik"]; ?>"></td>
										<td><textarea type="text" name="aciklama"><?= $row["aciklama"]; ?></textarea></td>
										<td><input type="text" name="title" value="<?= $row["title"]; ?>"></td>
										<td><input type="text" name="description" value="<?= $row["description"]; ?>"></td>
										<td><input type="text" name="keywords" value="<?= $row["keywords"]; ?>"></td>
										<td><input type="text" name="author" value="<?= $row["author"]; ?>"></td>
										<td><input type="text" name="seo_alt" value="<?= $row["seo_alt"]; ?>"></td>
										<td><input type="submit" name="hizmet_guncelle" value="Tamamla"></td>
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