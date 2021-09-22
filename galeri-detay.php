<html lang="tr">
	<head>
		<?php 
			include "inc/head.php";
		?>
		<title><?= $galeri_detay_title; ?></title>
	</head>
	<body>
		<?php 
			include "inc/nav.php";
		?>
		
		<main>
			<section id="bolum-11">
				<div class="row">
					<div class="col-100">
						<img src="images/<?= $galeri_detay_resim; ?>" alt="<?= $galeri_detay_seo_alt; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-100">
						<h2><?= $galeri_detay_baslik; ?></h2>
						<p style="text-align: left;"><?= $galeri_detay_aciklama; ?></p>
					</div>
				</div>
			</section>
		</main>
		
		<?php 
			include "inc/footer.php"; 
		?>
	</body>
</html>