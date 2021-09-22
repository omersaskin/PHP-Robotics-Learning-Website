<html lang="tr">
	<head>
		<?php 
			include "inc/head.php";
		?>
		<title>Kurslar - Coderomer.com</title>
	</head>
	<body>
		<?php 
			include "inc/nav.php";
		?>
		
		<main>
			<section id="bolum-10">
				<div class="row">
					<div class="col-100" style="overflow-x:auto;">
						<h2>Çevrimiçi Kurslar</h2>
						<table>
							<tr>
								<th>Kurs Adı</th>
								<th>Kurs Hakkında</th>
								<th>Gereksinimler</th>
								<th>Kazanımlar</th>
								<th>Fiyat</th>
							</tr>
							<?php 
								foreach($kurslar as $row) {?>
									<tr onclick="window.location='kurs-detay?kurs-no=<?= $row["id"]; ?>';">
										<td>
											<p><?= $row["kurs_adi"]; ?></p>
										</td>
										<td><?= $row["kurs_hakkinda"]; ?></td>
										<td><?= $row["gereksinimler"]; ?></td>
										<td><?= $row["kazanimlar"]; ?></td>
										<td><?= $row["fiyat"]; ?></td>
									</tr>	
								<?php }
							?>
						</table>
						<?php
						if(isset($_GET["status"]) && $_GET["status"] == "eklendi") {
							echo '<h4>Kurs başarıyla eklendi.</h4>';
						} elseif(isset($_GET["status"]) && $_GET["status"] == "eklenemedi") {
								echo '<h4>Malesef kurs eklenemedi!</h4>';
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