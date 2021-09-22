<html lang="tr">
	<head>
		<?php 
			include "inc/head.php";
		?>
		<title>Blog - Kod Akademi</title>
	</head>
	<body>
		<?php 
			include "inc/nav.php";
		?>
		
		<main>
			<section id="bolum-9">
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
						// Kullanımı
						while($habercek=$habersor->fetch(PDO::FETCH_ASSOC)) {
							$Metin = $habercek["aciklama"];
							?>
							<div class="col-33">
								<a href="haber-detay?konu=<?= slugify($habercek["baslik"]); ?>&haber-no=<?= $habercek["id"]; ?>"><img src="images/<?= $habercek["resim"]; ?>" alt="<?= $habercek["seo_alt"]; ?>"></a>
								<h3><?= $habercek["baslik"]; ?></h3>
								<p><b>Gönderim Tarihi:</b> <?= $habercek["tarih"]; ?></p>
								<p><?= kisaltma($Metin,300); ?></p>
								<a href="haber-detay?konu=<?= slugify($habercek["baslik"]); ?>&haber-no=<?= $habercek["id"]; ?>">Daha Fazla <i class="fas fa-arrow-alt-circle-right"></i></a>
							</div>
						<?php }
					?>
				</div>			
				<div class="pagination">
					<?php

						$s=0;

						while ($s < $toplam_sayfa8) {

							$s++; ?>

							<?php 

								if ($s==$sayfa) {?>

									<a href="blog?sayfa=<?php echo $s; ?>" class="active"><?php echo $s; ?></a>

							<?php } else {?>

									<a href="blog?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>

							<?php }

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