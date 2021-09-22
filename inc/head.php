<!--	<title><?php echo $ayarcek['ayar_title'] ?></title> -->
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">  <!--
	<meta name="description" content="<?php echo $ayarcek['ayar_description'] ?>">
	<meta name="keywords" content="<?php echo $ayarcek['ayar_keywords'] ?>">
	<meta name="author" content="<?php echo $ayarcek['ayar_author'] ?>">-->
	
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css" />
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
	
	<!-- SEO DOSTU URL KODU -->
	
	<?php
		function slugify($text) {
			$find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
			$replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
			$text = strtolower(str_replace($find, $replace, $text));
			$text = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $text);
			$text = trim(preg_replace('/\s+/', ' ', $text));
			$text = str_replace(' ', '-', $text);

			return $text;
		}
	?>
	
	<!-- AYAR DOSYASI -->
	
	<?php
		include "config.php";
	?>
	
	<!-- RECAPTCHA KODU -->
	<script src="https://www.google.com/recaptcha/api.js?hl=tr"></script>