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
				<h2>Gönderiler</h2>
				<div class="col-100" style="overflow-x:auto;">
					<table>
						<tr>
							<th>Fotoğraf</th>
							<th>Başlık</th>
							<th>Açıklama</th>
							<th>Tarih</th>
							<th>Title</th>
							<th>SEO Url</th>
							<th>SEO Alt</th>
							<th>Aktiflik</th>
							<th>Sil</th>
						</tr>
						<?php 
							while($blogcek=$blogsor->fetch(PDO::FETCH_ASSOC)) {?>
								<tr>
									<td><img src="../images/<?= $blogcek["resim"]; ?>"></td>
									<td><?= $blogcek["baslik"]; ?></td>
									<td><?= $blogcek["aciklama"]; ?></td>
									<td><?= $blogcek["tarih"]; ?></td>
									<td><?= $blogcek["title"]; ?></td>
									<td><?= $blogcek["seo_url"]; ?></td>
									<td><?= $blogcek["seo_alt"]; ?></td>
									<td><?= $blogcek["aktiflik"]; ?></td>
									<td><a href="../inc/config.php?gonderiSil_no=<?= $blogcek["id"]; ?>">Sil</a></td>
								</tr>
							<?php }
						?>
					</table>	
					<?php
					if(isset($_GET["status"]) && $_GET["status"] == "true") {
						echo '<h4>Gönderi başarıyla silindi.</h4>';
					} elseif(isset($_GET["status"]) && $_GET["status"] == "false") {
							echo '<h4>Malesef gönderi silinemedi!</h4>';
						}
					?>							
				</div>
			</div>
			<div class="pagination">
				<?php

					$s=0;

					while ($s < $toplam_sayfa4) {

						$s++; ?>

						<?php 

							if ($s==$blog) {?>

								<a href="blog.php?blog=<?php echo $s; ?>" class="active"><?php echo $s; ?></a>

						<?php } else {?>

								<a href="blog.php?blog=<?php echo $s; ?>"><?php echo $s; ?></a>

						<?php }

					}

				?>
			</div>
			<div class="row">
				<h2>Gönderi Oluştur</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST" enctype="multipart/form-data">			
						<table>
							<tr>
								<th>Fotoğraf</th>
								<th>Başlık</th>
								<th>Açıklama</th>
								<th>Title</th>
								<th>SEO Url</th>
								<th>SEO Alt</th>
								<th>İşlem</th>
							</tr>
							<tr>
								<td><input type="file" name="resim"></td>
								<td><input type="text" name="baslik" placeholder="Başlık giriniz"></td>
								<td><textarea type="text" name="aciklama" placeholder="Açıklama giriniz"></textarea></td>
								<td><input type="text" name="title" placeholder="Title giriniz"></td>
								<td><input type="text" name="seo_url" placeholder="SEO Url giriniz"></td>
								<td><input type="text" name="seo_alt" placeholder="SEO Alt giriniz"></td>
								<td><input type="submit" name="gonderi_olustur" value="Tamamla"></td>
							</tr>
						</table>						
					</form>
					<?php
					if(isset($_GET["status"]) && $_GET["status"] == "basarili") {
						echo '<h4>Gönderi başarıyla eklendi.</h4>';
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
				<h2>Gönderi Düzenle</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST" enctype="multipart/form-data">
						<table>
							<tr>
								<th>Fotoğraf</th>
								<th>Başlık</th>
								<th>Açıklama</th>
								<th>Title</th>
								<th>SEO Url</th>
								<th>SEO Alt</th>
								<th>İşlem</th>
							</tr>
							<?php 
								foreach($rows7 as $row) {?>
									<tr>
										<input type="hidden" name="id" value="<?= $row["id"]; ?>">
										<td><input type="file" name="resim"></td>
										<td><input type="text" name="baslik" value="<?= $row["baslik"]; ?>"></td>
										<td><textarea type="text" name="aciklama"><?= $row["aciklama"]; ?></textarea></td>
										<td><input type="text" name="title" value="<?= $row["title"]; ?>"></td>
										<td><input type="text" name="seo_url" value="<?= $row["seo_url"]; ?>"></td>
										<td><input type="text" name="seo_alt" value="<?= $row["seo_alt"]; ?>"></td>
										<td><input type="submit" name="gonderi_guncelle" value="Tamamla"></td>
									</tr>
								<?php }
							?>
						</table>	
					</form>
				</div>
			</div>
			<div class="row">
				<h2>Yorumlar</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST">
						<table>
							<tr>
								<th>İsim</th>
								<th>Yorum</th>
								<th>Tarih</th>
								<th>Durum</th>
								<th>Cevap</th>
								<th>Sil</th>
								<th>İşlem</th>
							</tr>
							<?php 
								foreach($rows11 as $row) {?>
									<tr>
										<input type="hidden" name="id" value="<?= $row["id"]; ?>">
										<td><input type="text" name="isim" value="<?= $row["isim"]; ?>"></td>
										<td><?= $row["yorum"]; ?></td>
										<td><?= $row["tarih"]; ?></td>
										<td><a href="#">Aktif</a></td>
										<td><input type="text" name="cevap" value="<?= $row["cevap"]; ?>"></td>
										<td><a href="#">Onay</a></td>
										<td><input type="submit" name="yorum_guncelle" value="Tamamla"></td>
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