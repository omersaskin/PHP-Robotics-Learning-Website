<html lang="tr">
	<head>
		<?php 
			include "inc/head.php";
		?>
	<style>
		pre {
			background: #fff;
			border-left: 3px solid #ff6a00;
			color: #000;
			page-break-inside: avoid;
			font-family: monospace;
			font-size: 15px;
			line-height: 1.6;
			margin-bottom: 1.6em;
			max-width: 100%;
			overflow: auto;
			padding: 1em 1.5em;
			display: block;
			word-wrap: break-word;
			text-align:left !important;
			padding:20px !important;
		}
	</style>
		<title><?= $kurs_adi; ?> - Coderomer.com</title>
	</head>
	<body>
		<?php 
			include "inc/nav.php";
		?>
		
		<main>
			<section id="bolum-10"><!--
				<div class="row">
					<div class="col-50">
						<h2 style="color: #000;">Çevrimiçi Kurs Başvuru Formu</h2>
						<p style="color: #000; font-weight: normal;"><b>Kurs Adı:</b> <?= $kurs_adi; ?></p>
						<p style="color: #000; font-weight: normal;"><b>Kurs Süresi:</b> <?= $kurs_suresi; ?></p>
						<p style="color: #000; font-weight: normal;"><b>Yeterlilikler:</b> <?= $yeterlilikler; ?></p>
						<p style="color: #000; font-weight: normal;"><b>Kursun Amacı:</b> <?= $kursun_amaci; ?></p>
					</div>
					<div class="col-50">
						<form action="" method="POST">
							<input type="hidden" name="kurs_no" value="<?= $_GET["kurs-no"]; ?>">
							<label for="name"><b>İsim</b></label>
							<input type="text"  name="isim" required="" placeholder="İsim giriniz">
							<label for="name"><b>Sınıf Seçiniz</b></label>
							  <select id="borderSelect" name="sinif" required="">
								<option value="" disabled selected>Lütfen Sınıf Seçiniz</option>
								<option value="İlkokul 1.Sınıf">İlkokul 1.Sınıf</option>
								<option value="İlkokul 2.Sınıf">İlkokul 2.Sınıf</option>
								<option value="İlkokul 3.Sınıf">İlkokul 3.Sınıf</option>
								<option value="İlkokul 4.Sınıf">İlkokul 4.Sınıf</option>
								<option value="İlkokul 5.Sınıf">İlkokul 5.Sınıf</option>
								<option value="Ortaokul 6.Sınıf">Ortaokul 6.Sınıf</option>
								<option value="Ortaokul 7.Sınıf">Ortaokul 7.Sınıf</option>
								<option value="Ortaokul 8.Sınıf">Ortaokul 8.Sınıf</option>
								<option value="Lise 1.Sınıf">Lise 1.Sınıf</option>
								<option value="Lise 2.Sınıf">Lise 2.Sınıf</option>
								<option value="Lise 3.Sınıf">Lise 3.Sınıf</option>
								<option value="Lise 4.Sınıf">Lise 4.Sınıf</option>
							  </select>
							<label for="email"><b>E-Posta</b></label>
							<input type="text" name="eposta" required="" placeholder="E-Posta giriniz">
							<label for="phone"><b>Telefon</b></label>
							<input type="text" name="telefon" required="" placeholder="Telefon giriniz">
							<label for="message"><b>Mesaj</b></label>
							<textarea rows="8" name="mesaj" required="" placeholder="Mesaj giriniz"></textarea>
							<div class="g-recaptcha" data-sitekey="6Le7QeIbAAAAAD_1MymsxboBEjTP9DtfYTAzR2Rk"></div>
							<input type="submit" name="basvuru_olustur" value="Gönder">
						</form>
						<?php
						if(isset($_GET["status"]) && $_GET["status"] == "basarili") {
							echo '<h4>Başvurunuz başarıyla gönderildi.</h4>';
						} elseif(isset($_GET["status"]) && $_GET["status"] == "basarisiz") {
								echo '<h4>Lütfen robot olmadığınızı doğrulayın.</h4>';
							} elseif(isset($_GET["status"]) && $_GET["status"] == "spam") {
								echo '<h4>Spam gönderi meydana geldi!</h4>';
							} elseif(isset($_GET["status"]) && $_GET["status"] == "tekrar") {
								echo '<h4>Önceden bu kursu aldığınız için başvuru yapamazsınız!</h4>';
							}
 						?>
					</div>
				</div>-->
				
				<div class="row">
					<div class="col-100" style="margin: 5px; padding: 0px;">
						<h1>Web Tasarımın Temelleri</h1>
						<h2 style="font-size:16px; text-align:left;">Web Tasarım nedir?</h2>
						<li style="text-align: left;">Herhangi bir kurumun kimliğinin yansıtılması ve tanıtım faliyetlerinin sağlanması için oluşturulan web sitelerinin tasarım sürecine <b>web tasarım</b> denir.</li>
					</div>
					<div class="col-100" style="margin: 5px; padding: 0px;">
						<h2 style="font-size:16px; text-align:left;">Web Tasarım Dilleri ve Özellikleri nelerdir?</h2>
						<li style="text-align: left;">HTML, CSS ve JavaScript gibi dillerdir. Web Tasarım için front-end (Arayüz) dilleri kullanılır.</li>
					</div>
					<div class="col-100" style="margin: 5px; padding: 0px;">
						<h2 style="font-size:16px; text-align:left;">HTML nedir?</h2>
						<li style="text-align: left;">Web sitelerinin iskeletini oluşturur ve metin, görsel vb. öğeleri belirtmeye yarar.</li>
					</div>
					<div class="col-100" style="margin: 5px; padding: 0px;">
						<h2 style="font-size:16px; text-align:left;">CSS nedir?</h2>
						<li style="text-align: left;">HTML öğelerini biçimlendirmeye yarar. Örneğin metin rengini değiştirme ya da görsel genişliğini artırma gibi işlemler yapmak için kullanılır.</li>
					</div>
					<div class="col-100" style="margin: 5px; padding: 0px;">
						<h2 style="font-size:16px; text-align:left;">JavaScript nedir?</h2>
						<li style="text-align: left;">HTML öğelerini hareketli hale getirmeye yarar.</li>
					</div>
					<div class="col-100" style="margin: 5px; padding: 0px;">
						<h2 style="font-size:16px; text-align:left;">Bir HTML sayfasının yapısı nasıldır?</h2>
						<li style="text-align: left;">Html sayfasının yapısına ait basit bir örnek aşağıda verilmiştir.</li>
						<br>
						<li style="text-align: left;">Burada ek olarak Charset ifadesi kullanılmıştır ve bu ifade belgenin karakter kodlamasını belirtir. Ayrıca Lang ifadesi ise sayfanın türkçe dilinde olacağını belirtir.</li>
					</div>
					<div class="col-100">
						<pre><code>&lt;html lang=&quot;tr&quot;&gt;
	&lt;head&gt;
		&lt;meta charset=&quot;utf-8&quot;&gt;
	&lt;/head&gt;
&lt;body&gt;
	&lt;h1&gt;Bu benim ilk web sayfam!&lt;/h1&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
					</div>
					
				</div>
				
			</section>
		</main>
		
		<?php 
			include "inc/footer.php"; 
		?>
	</body>
</html>