<html lang="tr">
	<head>
		<?php 
			include "inc/head.php";
		?>
		<title><?= $blog_detay_title; ?></title>
	</head>
	<body>
		<?php 
			include "inc/nav.php";
		?>
		
		<main>
			<section id="bolum-11">
				<div class="row">
					<div class="col-50">
						<img style="width: 100%; height: 300px !important;" src="images/<?= $blog_detay_resim; ?>" alt="">
					</div>
					<div class="col-50">
						<h2><?= $blog_detay_baslik; ?></h2>
						<p><?= $blog_detay_aciklama; ?></p>
						<form action="" method="POST">
							<input type="hidden" name="gonderi_no" value="<?= $blog_detay_id; ?>">
							<input type="hidden" name="baslik" value="<?= $blog_detay_baslik; ?>">
							<label for="name"><b>İsim</b></label>
							<input type="text"  name="isim" required="" placeholder="İsim giriniz">
							<label for="message"><b>Yorum</b></label>
							<textarea rows="8" name="yorum" required="" placeholder="Yorum giriniz"></textarea>
							<div class="g-recaptcha" data-sitekey="6Le7QeIbAAAAAD_1MymsxboBEjTP9DtfYTAzR2Rk"></div>
							<input type="submit" value="Gönder">
						</form>
						<?php
						if(isset($_GET["status"]) && $_GET["status"] == "basarili") {
							echo '<h4>Mesajınız başarıyla gönderildi.</h4>';
						} elseif(isset($_GET["status"]) && $_GET["status"] == "basarisiz") {
								echo '<h4>Lütfen robot olmadığınızı doğrulayın.</h4>';
							} elseif(isset($_GET["status"]) && $_GET["status"] == "spam") {
								echo '<h4>Spam gönderi meydana geldi!</h4>';
							}
 						?>
						<br><br>
						<h2>Yorumlar</h2>
						<?php 
							foreach($rows12 as $row) {?>
								<div style="border-bottom: solid 1px #000; width: 100% !important;">
									<p><span style="font-weight: bold;">İsim:</span> <?= $row["isim"]; ?></p>
									<p><span style="font-weight: bold;">Yorum:</span> <?= $row["yorum"]; ?></p>
									<?php
										if(!empty($row["cevap"])) {?>
											<p><span style="font-weight: bold;">Cevap:</span> <?= $row["cevap"]; ?></p>
										<?php }
									?>
								</div>
							<?php }
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