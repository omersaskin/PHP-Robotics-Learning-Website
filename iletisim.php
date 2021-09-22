<html lang="tr">
	<head>
		<?php 
			include "inc/head.php";
		?>
		<title>İletişim - Coderomer.com</title>
	</head>
	<body>
		<?php 
			include "inc/nav.php";
		?>
		
		<main>
			<section id="bolum-10">
				<div class="row">
					<div class="col-50">
						<h2>İletişim Bilgilerimiz</h2>
						<p><b>Adres:</b> <?= $iletisim_adres; ?></p>
						<p><b>Telefon:</b> <?= $iletisim_telefon; ?></p>
						<p><b>E-Posta:</b> <?= $iletisim_eposta; ?></p>
<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d24026.415335638598!2d27.483167386969388!3d41.17158162419126!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1str!2str!4v1632154438806!5m2!1str!2str" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
					</div>
					<div class="col-50">
						<form action="" method="POST">
							<label for="name"><b>İsim</b></label>
							<input type="text"  name="isim" required="" placeholder="İsim giriniz">
							<label for="email"><b>E-Posta</b></label>
							<input type="text" name="eposta" required="" placeholder="E-Posta giriniz">
							<label for="message"><b>Mesaj</b></label>
							<textarea rows="8" name="mesaj" required="" placeholder="Mesaj giriniz"></textarea>
							<div class="g-recaptcha" data-sitekey="6Le7QeIbAAAAAD_1MymsxboBEjTP9DtfYTAzR2Rk"></div>
							<input type="submit" name="mesaj_olustur" value="Gönder">
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
					</div>
				</div>
			</section>
		</main>
		
		<?php 
			include "inc/footer.php"; 
		?>
	</body>
</html>