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
			<section id="bolum-7">
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
						foreach($resimler as $resim) {
						$Metin = $resim["aciklama"];
							?>
							<a href="galeri-detay?fotograf-no=<?= $resim["id"]; ?>">
								<div class="col-30 hover-img">
									<img src="images/<?= $resim["resim"]; ?>" alt="<?= $resim["seo_alt"]; ?>">
									  <figcaption>
										<h3><?= $resim["baslik"]; ?></h3>
										<p><?= kisaltma($Metin,300); ?></p>
									  </figcaption>
								</div>	
							</a>
						<?php }
					?>

				</div>
			</section>
		</main>
		
		<?php 
			include "inc/footer.php"; 
		?>
	</body>
</html>