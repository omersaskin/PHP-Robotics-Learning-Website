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
				<h2>Yönetim Oluştur</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST">			
						<table>
							<tr>
								<th>Kullanıcı Adı</th>
								<th>Şifre</th>
								<th>İşlem</th>
							</tr>
							<tr>
								<td><input type="text" name="kullanici_adi" placeholder="Kullanıcı Adı giriniz"></td>
								<td><input type="password" name="sifre" placeholder="Şifre giriniz"></td>
								<td><input type="submit" name="yonetim_olustur" value="Tamamla"></td>
							</tr>
						</table>						
					</form>
				</div>
			</div>
			<div class="row">
				<h2>Yönetim Güncelle</h2>
				<div class="col-100" style="overflow-x:auto;">
					<form action="../inc/config.php" method="POST">
						<input type="hidden" name="id">
						<table>
							<tr>
								<th>Kullanıcı Adı</th>
								<th>Şifre</th>
								<th>İşlem</th>
							</tr>
							<?php 
								foreach($rows9 as $row) {?>
									<tr>
										<td><input type="text" name="kullanici_adi" value="<?= $row["kullanici_adi"]; ?>"></td>
										<td><input type="password" name="sifre" placeholder="Şifre giriniz"></td>
										<td><input type="submit" name="yonetim_guncelle" value="Tamamla"></td>
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