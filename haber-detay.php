<html lang="tr">
	<head>
		<?php 
			include "inc/head.php";
		?>
		<title><?= $haber_detay_title; ?></title>
	</head>
	<body>
		<?php 
			include "inc/nav.php";
		?>
		
		<main>
			<section id="bolum-11">
				<div class="row">
					<div class="col-100">
						<img src="images/<?= $haber_detay_resim; ?>" alt="">
					</div>
				</div>
				<div class="row">
					<div class="col-66">
						<h2><?= $haber_detay_baslik; ?></h2>
						<p><?= $haber_detay_aciklama; ?></p>
					</div>
					<div class="col-33">
						<h2>Son Haberler</h2>
						<?php
							foreach($sonhabersor as $sonhaber) {?>
								<div class="row">
									<div class="col-66">
										<p><b><a href="haber-detay?konu=<?= slugify($sonhaber["baslik"]); ?>&haber-no=<?= $sonhaber["id"]; ?>"><?= $sonhaber["baslik"]; ?></a></b></p>
										<p><b>Gönderim Tarihi:</b> <?= $sonhaber["tarih"]; ?></p>
									</div>
									<div class="col-33">
										<a href="haber-detay?konu=<?= slugify($sonhaber["baslik"]); ?>&haber-no=<?= $sonhaber["id"]; ?>"><img src="images/<?= $sonhaber["resim"]; ?>" alt="<?= $sonhaber["seo_alt"]; ?>"></a>
									</div>
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