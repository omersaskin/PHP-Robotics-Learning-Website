<footer>
	<div class="row">
		<div class="col-25">
			<ul>
				<li><a href="#">Uygulamayı Edinin</a></li>
				<li><a href="#">Hakkımızda</a></li>
				<li><a href="#">İletişim</a></li>
			</ul>
		</div>
		<div class="col-25">
			<ul>
				<li><a href="#">Yardım</a></li>
				<li><a href="#">İş Ortaklığı</a></li>
				<li><a href="#">Bağış Yapın</a></li>
			</ul>
		</div>
		<div class="col-25">
			<ul>
				<?php 
					foreach($sayfalar as $sayfa) {?>
						<li><a href="#"><?= $sayfa["baslik"]; ?></a></li>
					<?php }
				?>
			</ul>
		</div>
		<div class="col-25">
			<ul>  
				<a href="<?= $iletisim_facebook; ?>" target="_blank"><i style="color: #fff;" class="fab fa-facebook-f"></i></a>
				<a href="<?= $iletisim_twitter; ?>" target="_blank"><i style="color: #fff;"class="fab fa-twitter"></i></a>
				<a href="<?= $iletisim_youtube; ?>" target="_blank"><i style="color: #fff;" class="fab fa-youtube"></i></a>
				<a href="<?= $iletisim_instagram; ?>" target="_blank"><i style="color: #fff;" class="fab fa-instagram"></i></a>
			</ul>
		</div>
	</div>

	<div class="row sub-information">
		<div class="col-100">
			<center><span>Tüm Hakları Saklıdır | Coderomer.com © 2021</span></center>
		</div>
	</div>
</footer>

<script type="text/javascript">
	function responsiveMenu() {
		var x = document.getElementById("topnavID");
		if (x.className === "menu") {
			x.className += " responsive";
		} else {
			x.className = "menu";
		}
	}
</script>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script> 