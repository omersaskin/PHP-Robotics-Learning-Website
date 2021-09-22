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
			<section id="bolum-6">
				<?php
					echo '
						<div class="row">
							<div class="col-50">
								<img src="images/'.$sayfa_resim.'" alt="'.$sayfa_seo_alt.'">
							</div>
							<div class="col-50">
								<h2>'.$sayfa_baslik.'</h2>
								<p>'.$sayfa_aciklama.'</p>
							</div>
						</div>
					';
				?>	
			</section>
		</main>
		
		<?php 
			include "inc/footer.php"; 
		?>
	</body>
</html>