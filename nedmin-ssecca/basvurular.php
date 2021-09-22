<!DOCTYPE html>
<html lang="tr">
<head>
	<?php
		include "inc/head.php";
	?>
</head>
<body> 
	<?php
		include "inc/nav.php";
	?>

	 <main>
		<section id="bolum-1">
			<div class="row">
				<h2>Başvurular</h2>
				<div class="col-100" style="overflow-x:auto;">
					<table>
						<tr>
							<th>İsim</th>
							<th>Kurs</th>
							<th>Sınıf</th>
							<th>E-Posta</th>
							<th>Telefon</th>
							<th>Mesaj</th>
						</tr>
						<?php 
							while($basvurucek=$basvurusor->fetch(PDO::FETCH_ASSOC)) {?>
								<tr>
									<td><?= $basvurucek["isim"]; ?></td>
									<td><?= $basvurucek["kurs"]; ?></td>
									<td><?= $basvurucek["sinif"]; ?></td>
									<td><?= $basvurucek["eposta"]; ?></td>
									<td><?= $basvurucek["telefon"]; ?></td>
									<td><?= $basvurucek["mesaj"]; ?></td>
								</tr>
							<?php }
						?>
					</table>					
				</div>
			</div>
			<div class="pagination">
				<?php

					$s=0;

					while ($s < $toplam_sayfa6) {

						$s++; ?>

						<?php 

							if ($s==$sayfa) {?>

								<a href="basvurular.php?sayfa=<?php echo $s; ?>" class="active"><?php echo $s; ?></a>

						<?php } else {?>

								<a href="basvurular.php?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>

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