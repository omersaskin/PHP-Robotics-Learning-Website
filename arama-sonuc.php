<html lang="tr">
	<head>
		<?php 
			include "inc/head.php";
		?>
		<title>Anasayfa - Kod Akademi</title>
	</head>
	<body>
		<?php 
			include "inc/nav.php";
		?>
		
	<main>
		<section id="bolum-12">
			<div class="row">
				<?php

					/* METIN KISALTMA */
					function kisaltma($kelime, $str = 10) {
						if (strlen($kelime) > $str)
						{
						if (function_exists("mb_substr")) $kelime = mb_substr($kelime, 0, $str, "UTF-8").'..';
						else $kelime = substr($kelime, 0, $str).'..';
						}
						return $kelime;
					}
						
					if(isset($_POST["aranan"])) {
						$Gelen = htmlspecialchars($_POST["aranan"]); // Kullanıcıdan gelen arama değeri
						$Ara = $db->prepare("SELECT * FROM gonderiler WHERE baslik LIKE ? LIMIT 10"); // Arama sorgusu ve limit belirtme
						$Ara->execute(array('%'.$Gelen.'%')); // "?" ifadesinin karşılığını belirtme | içerisinde x ifadesini olan verileri temsil eder.
						$Liste = $Ara->fetchAll(PDO::FETCH_ASSOC); // Veri çekmek için kullanılacak olan değişken
					}
	
					if(isset($Ara)) {
						if($Ara->rowCount() != "0"){ // Aranan kelimeye göre veri varsa
							foreach($Liste as $Bas) {
									$Metin = $Bas["aciklama"];
								?>
								<div class="col-33">
									<a href="blog-detay?konu=<?= slugify($Bas["baslik"]); ?>&gonderi-no=<?= $Bas["id"]; ?>"><img src="images/<?= $Bas["resim"]; ?>" alt="<?= $Bas["seo_alt"]; ?>"></a>
									<h3><?= $Bas["baslik"]; ?></h3>
									<p><b>Gönderim Tarihi:</b> <?= $Bas["tarih"]; ?></p>
									<p><?= kisaltma($Metin,300); ?></p>
									<a href="blog-detay?konu=<?= slugify($Bas["baslik"]); ?>&gonderi-no=<?= $Bas["id"]; ?>">Daha Fazla <i class="fas fa-arrow-alt-circle-right"></i></a>
								</div>
							<?php }
						} else { // Aranan kelimeye göre veri yoksa
							echo "Aranan kelimeye göre gönderi bulunamadı!";
						}	
					}
				?>
			</div>
		</section>
	</main>
		
		<?php 
			include "inc/footer.php"; 
		?>
	</body>
</html>