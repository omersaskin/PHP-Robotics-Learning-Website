<?php

	/* VERITABANI BAGLANTISI */
	try {
		 $db = new PDO("mysql:host=localhost;dbname=none", "none", "none");
		 $db->query("SET CHARACTER SET utf8");
	} catch (PDOException $e){
		 print $e->getMessage();
	}

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'src/Exception.php';
	require 'src/PHPMailer.php';
	require 'src/SMTP.php';

	/* MAILLER */
	if (isset($_POST["mesaj_olustur"], $_POST['isim'], $_POST['eposta'], $_POST['mesaj'], $_POST['g-recaptcha-response'])) {
		
		if (isset($_POST['isim'], $_POST['eposta'], $_POST['mesaj'])) {
			$isim = htmlspecialchars($_POST["isim"]);
			$eposta = htmlspecialchars($_POST["eposta"]);
			$mesaj = htmlspecialchars($_POST["mesaj"]);
		}
		  
		if (isset($_POST['g-recaptcha-response'])) {
			$captcha = $_POST['g-recaptcha-response'];
		}
		  
		if (!$captcha) {
			header("Location: ../iletisim.php?status=basarisiz");
		} elseif ($control["success"] == false) {
			header("Location: ../iletisim.php?status=spam");
		}
			
		$control = reCaptchaControl($captcha);

		if($control["success"] == true && isset($_POST['isim']) && isset($_POST['eposta']) && isset($_POST['mesaj'])){
			$isim = isset($_POST['isim']) ? $_POST['isim'] : null;
			$eposta = isset($_POST['eposta']) ? $_POST['eposta'] : 'E-posta Konusu';
			$mesaj = isset($_POST['mesaj']) ? $_POST['mesaj'] : null;
			
			$mail = new PHPMailer(true); //PHPMailer Sınıfı aktif ettik.
			try {

				$mail->setLanguage('tr'); //Dil ayarını yaptık.
				//$mail->SMTPDebug = 2;  herhangi bir hata oluştuğunda ayrıntılı bir şekilde bilgi verecektir.
				$mail->isSMTP();  //SMTP ayarını aktif etmek.
				$mail->Host = 'smtp.gmail.com'; //mail servisi host name
				$mail->SMTPAuth = true; //smtp sunucu
				$mail->Username = 'pc.omer.saskin@gmail.com'; //alıcı mail adresi
				$mail->Password = 'prygsphgywrrrmpq';  //alıcı mail adresi parolası
				$mail->SMTPSecure = 'tls'; //STMP güvenliği
				$mail->Port = 587; //STMP port ayarı
				$mail->CharSet = 'UTF-8';

				// maili gönderen kişi
				$mail->setFrom($eposta, $mesaj); //Gonderen mail
				$mail->addAddress('pc.omer.saskin@gmail.com',$mesaj); //alıcı mail
				$mail->addReplyTo($eposta, $mesaj); //Gonderen mail

				$content = '
					<html>
						<head>
						</head>
						<body>
							<h1>Test edilen mail mesaj içerikteki başlik yeni</h1>
							<p>Bu bir test mail icerigi.</p>
						</body>
					</html>
				';

				$mail->isHTML(true); //HTML formatı aktif
				$mail->Subject = $mesaj; //Mesaj konusu
				$mail->Body = $content; //Mesaj içeriğini

				$mail->send();

				header("Location: ../iletisim.php?status=basarili");

			} catch (Exception $e){
				echo $e->errorMessage();
			}
		}	  		
		
	}

	function reCaptchaControl($captcha){
	  $fields = [
			  'secret' => '6Le7QeIbAAAAAD_1MymsxboBEjTP9DtfYTAzR2Rk',
			  'response' => $captcha
			];
			$ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
			curl_setopt_array($ch,[
			   CURLOPT_POST => true,
			   CURLOPT_POSTFIELDS => http_build_query($fields),
				CURLOPT_RETURNTRANSFER => true
			]);
	 
			$result = curl_exec($ch);
			curl_close($ch);
			return json_decode($result,true);
	}

			
	/* YORUM */
	if (isset($_POST['isim'], $_POST['yorum'], $_POST['gonderi_no'], $_POST['g-recaptcha-response'])) {
		
		htmlspecialchars($_POST['isim']);
		htmlspecialchars($_POST['yorum']);
		
		if (isset($_POST['isim'])) {
		  $isim = $_POST['isim'];
		}
		if (isset($_POST['yorum'])) {
		  $yorum = $_POST['yorum'];
		}
		if (isset($_POST['gonderi_no'])) {
		  $gonderi_no = $_POST['gonderi_no'];
		}
		if (isset($_POST['g-recaptcha-response'])) {
		  $captcha = $_POST['g-recaptcha-response'];
		}
		if (!$captcha) {
		  echo '<h2>Lütfen robot olmadığınızı doğrulayın.</h2>';
		  exit;
		}
		$control = reCaptchaControlYorum($captcha);

		if ($control["success"] == false) {
		  echo '<h2>Spam Gönderi!</h2>';
		} elseif($control["success"] == true) {
				
				$id = rand(0, 1000000);

				$yorum_rand_sorgu = $db->prepare("SELECT COUNT(*) FROM yorumlar WHERE id=".$id."");
				$yorum_rand_sorgu->execute();
				$yorum_say = $yorum_rand_sorgu->fetchColumn();
			
			if($yorum_say == 0) {
				$sorgu = $db->prepare("INSERT INTO yorumlar SET id=:id, isim=:isim, yorum=:yorum, gonderi_no=:gonderi_no");
				$sorgu->execute(array(':id'=> $id, ':isim'=> $isim, ':yorum'=> $yorum, ':gonderi_no'=> $gonderi_no));
				
				header("Location: ../blog-detay.php?konu=".$baslik."&gonderi-no=".$gonderi_no."&status=basarili");
			}
		
		}
	  
	}
	 
		function reCaptchaControlYorum($captcha){
		  $fields = [
				  'secret' => '6Le7QeIbAAAAAD_1MymsxboBEjTP9DtfYTAzR2Rk',
				  'response' => $captcha
				];
				$ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
				curl_setopt_array($ch,[
				   CURLOPT_POST => true,
				   CURLOPT_POSTFIELDS => http_build_query($fields),
					CURLOPT_RETURNTRANSFER => true
				]);
		 
				$result = curl_exec($ch);
				curl_close($ch);
				return json_decode($result,true);
		}	 
	 
	/* ILETISIM FORMU */

	
	/* SQL INJECTION TEMIZLEME */
	function clear_sql($data)
	{
		$bad = array("'","*","?","select","all","or","SELECT","ALL","OR","concat","-","+","(",")","union",",","group");
		$good = array("_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_");
		$result = str_replace($bad, $good, $data);
		$result = trim(addslashes($result));
		
		return $result;
	}
	
	if(isset($_GET["no"], $_GET["konu"])) {
		clear_sql($_GET["no"]);
		clear_sql($_GET["konu"]);
	} elseif(isset($_GET["sayfa-no"])) {
		clear_sql($_GET["sayfa-no"]);
	} elseif(isset($_GET["hizmet-no"])) {
		clear_sql($_GET["hizmet-no"]);
	} elseif(isset($_GET["kurs-no"])) {
		clear_sql($_GET["kurs-no"]);
	} elseif(isset($_GET["haber-no"])) {
		clear_sql($_GET["haber-no"]);
	} elseif(isset($_GET["fotograf-no"])) {
		clear_sql($_GET["fotograf-no"]);
	} elseif(isset($_POST["aranan"])) {
		clear_sql($_POST["aranan"]);
	} elseif(isset($_POST["isim"])) {
		clear_sql($_POST["isim"]);
	} elseif(isset($_POST["eposta"])) {
		clear_sql($_POST["eposta"]);
	} elseif(isset($_POST["mesaj"])) {
		clear_sql($_POST["mesaj"]);
	} elseif(isset($_POST["kurs_no"])) {
		clear_sql($_POST["kurs_no"]);
	} elseif(isset($_POST["isim"])) {
		clear_sql($_POST["isim"]);
	} elseif(isset($_POST["kurs"])) {
		clear_sql($_POST["kurs"]);
	} elseif(isset($_POST["sinif"])) {
		clear_sql($_POST["sinif"]);
	} elseif(isset($_POST["eposta"])) {
		clear_sql($_POST["eposta"]);
	} elseif(isset($_POST["telefon"])) {
		clear_sql($_POST["telefon"]);
	} elseif(isset($_POST["gonderi_no"])) {
		clear_sql($_POST["gonderi_no"]);
	} elseif(isset($_POST["baslik"])) {
		clear_sql($_POST["baslik"]);
	} elseif(isset($_POST["isim"])) {
		clear_sql($_POST["isim"]);
	} elseif(isset($_POST["yorum"])) {
		clear_sql($_POST["yorum"]);
	}
	
	/* SAYFALAMA */
	$sayfada = 9; // sayfada gösterilecek içerik miktarını belirtiyoruz.
	$sorgu=$db->prepare("select * from gonderiler");
	$sorgu->execute();
	$toplam_icerik=$sorgu->rowCount();
	$toplam_sayfa = ceil($toplam_icerik / $sayfada);
	// eğer sayfa girilmemişse 1 varsayalım.
	$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
	// eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
	if($sayfa < 1) $sayfa = 1; 
	// toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
	if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 
	$limit = ($sayfa - 1) * $sayfada;

	$gonderisor=$db->prepare("SELECT * FROM gonderiler order by id DESC limit $limit, $sayfada");
	$gonderisor->execute();
	
	/* SAYFALAMA SAYFALAR */
	$sayfada = 1; // sayfada gösterilecek içerik miktarını belirtiyoruz.
	$sorgu=$db->prepare("select * from sayfalar");
	$sorgu->execute();
	$toplam_icerik=$sorgu->rowCount();
	$toplam_sayfa1 = ceil($toplam_icerik / $sayfada);
	// eğer sayfa girilmemişse 1 varsayalım.
	$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
	// eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
	if($sayfa < 1) $sayfa = 1; 
	// toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
	if($sayfa > $toplam_sayfa1) $sayfa = $toplam_sayfa1; 
	$limit = ($sayfa - 1) * $sayfada;

	$sayfasor=$db->prepare("SELECT * FROM sayfalar order by id DESC limit $limit, $sayfada");
	$sayfasor->execute();
	
	/* SAYFALAMA BASVURU */
	$sayfada = 10; // sayfada gösterilecek içerik miktarını belirtiyoruz.
	$sorgu=$db->prepare("select * from basvurular");
	$sorgu->execute();
	$toplam_icerik=$sorgu->rowCount();
	$toplam_sayfa6 = ceil($toplam_icerik / $sayfada);
	// eğer sayfa girilmemişse 1 varsayalım.
	$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
	// eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
	if($sayfa < 1) $sayfa = 1; 
	// toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
	if($sayfa > $toplam_sayfa6) $sayfa = $toplam_sayfa6; 
	$limit = ($sayfa - 1) * $sayfada;

	$basvurusor=$db->prepare("SELECT * FROM basvurular order by id DESC limit $limit, $sayfada");
	$basvurusor->execute();
	
	/* SAYFALAMA KURSLAR */
	$sayfada = 1; // sayfada gösterilecek içerik miktarını belirtiyoruz.
	$sorgu=$db->prepare("select * from kurslar");
	$sorgu->execute();
	$toplam_icerik=$sorgu->rowCount();
	$toplam_sayfa7 = ceil($toplam_icerik / $sayfada);
	// eğer sayfa girilmemişse 1 varsayalım.
	$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
	// eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
	if($sayfa < 1) $sayfa = 1; 
	// toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
	if($sayfa > $toplam_sayfa7) $sayfa = $toplam_sayfa7; 
	$limit = ($sayfa - 1) * $sayfada;

	$kurssor=$db->prepare("SELECT * FROM kurslar order by id DESC limit $limit, $sayfada");
	$kurssor->execute();	
	
	/* SAYFALAMA HIZMETLER */
	$sayfada = 1; // sayfada gösterilecek içerik miktarını belirtiyoruz.
	$sorgu=$db->prepare("select * from hizmetler");
	$sorgu->execute();
	$toplam_icerik=$sorgu->rowCount();
	$toplam_sayfa2 = ceil($toplam_icerik / $sayfada);
	// eğer sayfa girilmemişse 1 varsayalım.
	$hizmet = isset($_GET['hizmet']) ? (int) $_GET['hizmet'] : 1;
	// eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
	if($hizmet < 1) $hizmet = 1; 
	// toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
	if($hizmet > $toplam_sayfa2) $hizmet = $toplam_sayfa2; 
	$limit = ($hizmet - 1) * $sayfada;

	$hizmetsor=$db->prepare("SELECT * FROM hizmetler order by id DESC limit $limit, $sayfada");
	$hizmetsor->execute();
	
	/* SAYFALAMA GALERI */
	$sayfada = 1; // sayfada gösterilecek içerik miktarını belirtiyoruz.
	$sorgu=$db->prepare("select * from galeri");
	$sorgu->execute();
	$toplam_icerik=$sorgu->rowCount();
	$toplam_sayfa3 = ceil($toplam_icerik / $sayfada);
	// eğer sayfa girilmemişse 1 varsayalım.
	$galeri = isset($_GET['galeri']) ? (int) $_GET['galeri'] : 1;
	// eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
	if($galeri < 1) $galeri = 1; 
	// toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
	if($galeri > $toplam_sayfa3) $galeri = $toplam_sayfa3; 
	$limit = ($galeri - 1) * $sayfada;

	$galerisor=$db->prepare("SELECT * FROM galeri order by id DESC limit $limit, $sayfada");
	$galerisor->execute();
	
	/* SAYFALAMA BLOG */
	$sayfada = 1; // sayfada gösterilecek içerik miktarını belirtiyoruz.
	$sorgu=$db->prepare("select * from gonderiler");
	$sorgu->execute();
	$toplam_icerik=$sorgu->rowCount();
	$toplam_sayfa4 = ceil($toplam_icerik / $sayfada);
	// eğer sayfa girilmemişse 1 varsayalım.
	$blog = isset($_GET['blog']) ? (int) $_GET['blog'] : 1;
	// eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
	if($blog < 1) $blog = 1; 
	// toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
	if($blog > $toplam_sayfa4) $blog = $toplam_sayfa4; 
	$limit = ($blog - 1) * $sayfada;

	$blogsor=$db->prepare("SELECT * FROM gonderiler order by id DESC limit $limit, $sayfada");
	$blogsor->execute();
	
	/* SAYFALAMA HABER */
	$sayfada = 1; // sayfada gösterilecek içerik miktarını belirtiyoruz.
	$sorgu=$db->prepare("select * from haberler");
	$sorgu->execute();
	$toplam_icerik=$sorgu->rowCount();
	$toplam_sayfa8 = ceil($toplam_icerik / $sayfada);
	// eğer sayfa girilmemişse 1 varsayalım.
	$haber = isset($_GET['haber']) ? (int) $_GET['haber'] : 1;
	// eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
	if($haber < 1) $haber = 1; 
	// toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
	if($haber > $toplam_sayfa8) $haber = $toplam_sayfa8; 
	$limit = ($haber - 1) * $sayfada;

	$habersor=$db->prepare("SELECT * FROM haberler order by id DESC limit $limit, $sayfada");
	$habersor->execute();
	
	/* HABER DETAY SAYFASI */
	if(isset($_GET["haber-no"])) {
		$no = $_GET['haber-no']; 
		$haber_detay = $db->query("SELECT * FROM haberler WHERE id = '{$no}'")->fetch(PDO::FETCH_ASSOC);
		
		$haber_detay_id = $haber_detay["id"];
		$haber_detay_title = $haber_detay["title"];
		$haber_detay_baslik = $haber_detay["baslik"];
		$haber_detay_aciklama = $haber_detay["aciklama"];
		$haber_detay_resim = $haber_detay["resim"];
	}
	
	/* GALERI DETAY SAYFASI */
	if(isset($_GET["fotograf-no"])) {
		$fotograf_no = $_GET['fotograf-no']; 
		$galeri_detay = $db->query("SELECT * FROM galeri WHERE id = '{$fotograf_no}'")->fetch(PDO::FETCH_ASSOC);
		
		$galeri_detay_id = $galeri_detay["id"];
		$galeri_detay_title = $galeri_detay["title"];
		$galeri_detay_baslik = $galeri_detay["baslik"];
		$galeri_detay_aciklama = $galeri_detay["aciklama"];
		$galeri_detay_resim = $galeri_detay["resim"];
		$galeri_detay_seo_alt = $galeri_detay["seo_alt"];
	}
	
	/* SAYFALAMA HABER */
	$sayfada = 1; // sayfada gösterilecek içerik miktarını belirtiyoruz.
	$sorgu=$db->prepare("select * from haberler");
	$sorgu->execute();
	$toplam_icerik=$sorgu->rowCount();
	$toplam_sayfa5 = ceil($toplam_icerik / $sayfada);
	// eğer sayfa girilmemişse 1 varsayalım.
	$haber = isset($_GET['haber']) ? (int) $_GET['haber'] : 1;
	// eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
	if($haber < 1) $haber = 1; 
	// toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
	if($haber > $toplam_sayfa5) $haber = $toplam_sayfa5; 
	$limit = ($haber - 1) * $sayfada;

	$habersor=$db->prepare("SELECT * FROM haberler order by id DESC limit $limit, $sayfada");
	$habersor->execute();
	
	/* BLOG DETAY SAYFASI */
	if(isset($_GET["gonderi-no"])) {
		$no = $_GET['gonderi-no']; 
		$blog_detay = $db->query("SELECT * FROM gonderiler WHERE id = '{$no}'")->fetch(PDO::FETCH_ASSOC);
		
		$blog_detay_id = $blog_detay["id"];
		$blog_detay_title = $blog_detay["title"];
		$blog_detay_baslik = $blog_detay["baslik"];
		$blog_detay_aciklama = $blog_detay["aciklama"];
		$blog_detay_resim = $blog_detay["resim"];
	}
	
	/* SON YAZILAR */
	$sonyazisor=$db->prepare("SELECT * FROM gonderiler order by id DESC limit 5");
	$sonyazisor->execute();
	
	/* SON HABERLER */
	$sonhabersor=$db->prepare("SELECT * FROM haberler order by id DESC limit 5");
	$sonhabersor->execute();
	
	/* SAYFALAR */
	$sayfalar = $db->query("SELECT * FROM sayfalar", PDO::FETCH_ASSOC);
	$hizmetler = $db->query("SELECT * FROM hizmetler", PDO::FETCH_ASSOC);
	$rows1 = $db->query("SELECT * FROM hizmetler", PDO::FETCH_ASSOC);
	$rows2 = $db->query("SELECT * FROM hizmetler", PDO::FETCH_ASSOC);
	$rows3 = $db->query("SELECT * FROM sayfalar", PDO::FETCH_ASSOC);
	$rows4 = $db->query("SELECT * FROM sayfalar", PDO::FETCH_ASSOC);
	$rows5 = $db->query("SELECT * FROM sayfalar", PDO::FETCH_ASSOC);
	
	if(isset($_GET["sayfa-no"])) {
		$sayfa_no = $_GET['sayfa-no']; 
		$sayfa_sec = $db->query("SELECT * FROM sayfalar WHERE id = '{$sayfa_no}'")->fetch(PDO::FETCH_ASSOC);

		$sayfa_baslik = $sayfa_sec["baslik"];
		$sayfa_aciklama = $sayfa_sec["aciklama"];
		$sayfa_resim = $sayfa_sec["resim"];
		$sayfa_title = $sayfa_sec["title"];
		$sayfa_description = $sayfa_sec["description"];
		$sayfa_keywords = $sayfa_sec["keywords"];
		$sayfa_author = $sayfa_sec["author"];
		$sayfa_seo_alt = $sayfa_sec["seo_alt"];
	}
	
	if(isset($_GET["hizmet-no"])) {
		$hizmet_no = $_GET['hizmet-no']; 
		$hizmet_sec = $db->query("SELECT * FROM hizmetler WHERE id = '{$hizmet_no}'")->fetch(PDO::FETCH_ASSOC);

		$hizmet_baslik = $hizmet_sec["baslik"];
		$hizmet_aciklama = $hizmet_sec["aciklama"];
		$hizmet_resim = $hizmet_sec["resim"];
		$hizmet_title = $hizmet_sec["title"];
		$hizmet_description = $hizmet_sec["description"];
		$hizmet_keywords = $hizmet_sec["keywords"];
		$hizmet_author = $hizmet_sec["author"];
		$hizmet_seo_alt = $hizmet_sec["seo_alt"];
	}
	
	/* SAYFA OLUŞTUR */
	if(isset($_FILES["resim"], $_POST["sayfa_olustur"])) {
		if ($_FILES["resim"]["size"]<1024*1024){//Dosya boyutu  aldık ve 1Mb'tan az olmasını söyledik.

			if ($_FILES["resim"]["type"]=="image/jpeg"){  //Dosya tipi aldık ve sadece jpeg olmasını söyledik.

				$baslik = $_POST["baslik"];
				$aciklama = $_POST["aciklama"];
				$title = $_POST["title"];
				$description = $_POST["description"];
				$keywords = $_POST["keywords"];
				$author = $_POST["author"];
				$seo_alt = $_POST["seo_alt"];
				$dosya_adi = $_FILES["resim"]["name"];  //Dsoya adını aldık.

				//Resimi kayıt ederken yeni bir isim oluşturalım
				$uret=array("cv","fg","th","lu","er");
				$uzanti=substr($dosya_adi,-4,4);
				$sayi_tut=rand(1,10000);

				$yeni_ad="../images/".$uret[rand(0,4)].$sayi_tut.$uzanti;

				//Dosya yeni adıyla yuklenenresimler klasörüne kaydedilecek

				if (move_uploaded_file($_FILES["resim"]["tmp_name"],$yeni_ad)){

					//Bilgileri veritabanına kayıt ediyoruz..

				$sorgu = $db->prepare("INSERT INTO sayfalar SET resim=:resim, baslik=:baslik, aciklama=:aciklama, title=:title, description=:description, keywords=:keywords, author=:author, seo_alt=:seo_alt");
				$sorgu->execute(array(':resim'=> $yeni_ad, ':baslik'=> $baslik, ':aciklama'=> $aciklama, ':title'=> $title, ':description'=> $description, ':keywords'=> $keywords, ':author'=> $author, ':seo_alt'=> $seo_alt));
				if($sorgu){
					header("Location: ../nedmin-ssecca/statik-sayfalar.php?status=basarili");
				}else{
					header("Location: ../nedmin-ssecca/statik-sayfalar.php?status=basarisiz");
				}
			}else{
				header("Location: ../nedmin-ssecca/statik-sayfalar.php?status=none");
			}
		}else{
			header("Location: ../nedmin-ssecca/statik-sayfalar.php?status=type");
		}
		}else{          
			header("Location: ../nedmin-ssecca/statik-sayfalar.php?status=size");
		}
	}

	/* SAYFA DUZENLE */
	
	
	
	
	
	
	/* HIZMET OLUŞTUR */
	if(isset($_FILES["resim"], $_POST["hizmet_olustur"])) {
		if ($_FILES["resim"]["size"]<1024*1024){//Dosya boyutu  aldık ve 1Mb'tan az olmasını söyledik.

			if ($_FILES["resim"]["type"]=="image/jpeg"){  //Dosya tipi aldık ve sadece jpeg olmasını söyledik.

				$baslik = $_POST["baslik"];
				$aciklama = $_POST["aciklama"];
				$title = $_POST["title"];
				$description = $_POST["description"];
				$keywords = $_POST["keywords"];
				$author = $_POST["author"];
				$seo_alt = $_POST["seo_alt"];
				$dosya_adi = $_FILES["resim"]["name"];  //Dsoya adını aldık.

				//Resimi kayıt ederken yeni bir isim oluşturalım
				$uret=array("cv","fg","th","lu","er");
				$uzanti=substr($dosya_adi,-4,4);
				$sayi_tut=rand(1,10000);

				$yeni_ad="../images/".$uret[rand(0,4)].$sayi_tut.$uzanti;

				//Dosya yeni adıyla yuklenenresimler klasörüne kaydedilecek

				if (move_uploaded_file($_FILES["resim"]["tmp_name"],$yeni_ad)){
					echo 'Dosya başarıyla yüklendi.';

					//Bilgileri veritabanına kayıt ediyoruz..

				$sorgu = $db->prepare("INSERT INTO hizmetler SET resim=:resim, baslik=:baslik, aciklama=:aciklama, title=:title, description=:description, keywords=:keywords, author=:author, seo_alt=:seo_alt");
				$sorgu->execute(array(':resim'=> $yeni_ad, ':baslik'=> $baslik, ':aciklama'=> $aciklama, ':title'=> $title, ':description'=> $description, ':keywords'=> $keywords, ':author'=> $author, ':seo_alt'=> $seo_alt));
				if($sorgu){
					header("Location: ../nedmin-ssecca/statik-sayfalar.php?status=basarili");
				}else{
					header("Location: ../nedmin-ssecca/statik-sayfalar.php?status=basarisiz");
				}
			}else{
				header("Location: ../nedmin-ssecca/statik-sayfalar.php?status=none");
			}
		}else{
			header("Location: ../nedmin-ssecca/statik-sayfalar.php?status=type");
		}
		}else{          
			header("Location: ../nedmin-ssecca/statik-sayfalar.php?status=size");
		}
	}

	/* HIZMET DUZENLE */
	
	
	
	
	
	
	/* GALERI */
	$resimler = $db->query("SELECT * FROM galeri", PDO::FETCH_ASSOC);
	$rows6 = $db->query("SELECT * FROM galeri", PDO::FETCH_ASSOC);
	
	/* GALERI OLUŞTUR */
	if(isset($_FILES["resim"], $_POST["fotograf_olustur"])) {
		if ($_FILES["resim"]["size"]<1024*1024){//Dosya boyutu  aldık ve 1Mb'tan az olmasını söyledik.

			if ($_FILES["resim"]["type"]=="image/jpeg"){  //Dosya tipi aldık ve sadece jpeg olmasını söyledik.

				$baslik = $_POST["baslik"];
				$aciklama = $_POST["aciklama"];
				$seo_alt = $_POST["seo_alt"];
				$dosya_adi = $_FILES["resim"]["name"];  //Dsoya adını aldık.

				//Resimi kayıt ederken yeni bir isim oluşturalım
				$uret=array("cv","fg","th","lu","er");
				$uzanti=substr($dosya_adi,-4,4);
				$sayi_tut=rand(1,10000);

				$yeni_ad="../images/".$uret[rand(0,4)].$sayi_tut.$uzanti;

				//Dosya yeni adıyla yuklenenresimler klasörüne kaydedilecek

				if (move_uploaded_file($_FILES["resim"]["tmp_name"],$yeni_ad)){
					echo 'Dosya başarıyla yüklendi.';

					//Bilgileri veritabanına kayıt ediyoruz..

				$sorgu = $db->prepare("INSERT INTO galeri SET resim=:resim, baslik=:baslik, aciklama=:aciklama, seo_alt=:seo_alt");
				$sorgu->execute(array(':resim'=> $yeni_ad, ':baslik'=> $baslik, ':aciklama'=> $aciklama, ':seo_alt'=> $seo_alt));
				if($sorgu){
					header("Location: ../nedmin-ssecca/galeri.php?status=basarili");
				}else{
					header("Location: ../nedmin-ssecca/galeri.php?status=basarisiz");
				}
			}else{
				header("Location: ../nedmin-ssecca/galeri.php?status=none");
			}
		}else{
			header("Location: ../nedmin-ssecca/galeri.php?status=type");
		}
		}else{          
			header("Location: ../nedmin-ssecca/galeri.php?status=size");
		}
	}

	/* GALERI DUZENLE */
	if(isset($_FILES["resim"], $_POST["fotograf_guncelle"])) {
		if ($_FILES["resim"]["size"]<1024*1024){//Dosya boyutu  aldık ve 1Mb'tan az olmasını söyledik.

			if ($_FILES["resim"]["type"]=="image/jpeg"){  //Dosya tipi aldık ve sadece jpeg olmasını söyledik.

				$id= $_POST["id"];
				$baslik = $_POST["baslik"];
				$aciklama = $_POST["aciklama"];
				$seo_alt = $_POST["seo_alt"];
				$dosya_adi = $_FILES["resim"]["name"];  //Dsoya adını aldık.

				//Resimi kayıt ederken yeni bir isim oluşturalım
				$uret=array("cv","fg","th","lu","er");
				$uzanti=substr($dosya_adi,-4,4);
				$sayi_tut=rand(1,10000);

				$yeni_ad="../images/".$uret[rand(0,4)].$sayi_tut.$uzanti;

				//Dosya yeni adıyla yuklenenresimler klasörüne kaydedilecek

				if (move_uploaded_file($_FILES["resim"]["tmp_name"],$yeni_ad)){
					echo 'Dosya başarıyla yüklendi.';

					//Bilgileri veritabanına kayıt ediyoruz..

				$sorgu = $db->prepare("UPDATE galeri SET resim=:resim, baslik=:baslik, aciklama=:aciklama, seo_alt=:seo_alt WHERE id=:id");
				$sorgu->execute(array(':id'=> $id, ':resim'=> $yeni_ad, ':baslik'=> $baslik, ':aciklama'=> $aciklama, ':seo_alt'=> $seo_alt));
				if($sorgu){
					header("Location: ../nedmin-ssecca/galeri.php?status=fotograf-duzenlendi");
				}else{
					header("Location: ../nedmin-ssecca/galeri.php?status=fotograf-duzenlenemedi");
				}
			}else{
				header("Location: ../nedmin-ssecca/galeri.php?status=none");
			}
		}else{
			header("Location: ../nedmin-ssecca/galeri.php?status=type");
		}
		}else{          
			header("Location: ../nedmin-ssecca/galeri.php?status=size");
		}
	}
	
	/* BLOG */
	$gonderiler = $db->query("SELECT * FROM gonderiler", PDO::FETCH_ASSOC);
	$rows7 = $db->query("SELECT * FROM gonderiler", PDO::FETCH_ASSOC);
	
	/* GONDERI OLUŞTUR */
	if(isset($_FILES["resim"], $_POST["gonderi_olustur"])) {
		if ($_FILES["resim"]["size"]<1024*1024){//Dosya boyutu  aldık ve 1Mb'tan az olmasını söyledik.

			if ($_FILES["resim"]["type"] == "image/jpeg" or "image/jpg" or "image/png"){  //Dosya tipi aldık ve sadece jpeg olmasını söyledik.
				
				$baslik = $_POST["baslik"];
				$aciklama = $_POST["aciklama"];
				$title = $_POST["title"];
				$seo_url = $_POST["seo_url"];
				$seo_alt = $_POST["seo_alt"];
				$dosya_adi = $_FILES["resim"]["name"];  //Dsoya adını aldık.

				//Resimi kayıt ederken yeni bir isim oluşturalım
				$uret=array("cv","fg","th","lu","er");
				$uzanti=substr($dosya_adi,-4,4);
				$sayi_tut=rand(1,10000);

				$yeni_ad="../images/".$uret[rand(0,4)].$sayi_tut.$uzanti;

				//Dosya yeni adıyla yuklenenresimler klasörüne kaydedilecek

				if (move_uploaded_file($_FILES["resim"]["tmp_name"],$yeni_ad)){
					echo 'Dosya başarıyla yüklendi.';

					//Bilgileri veritabanına kayıt ediyoruz..

				$id = rand(0, 1000000);

				$gonderi_rand_sorgu = $db->prepare("SELECT COUNT(*) FROM gonderiler WHERE id=".$id."");
				$gonderi_rand_sorgu->execute();
				$gonderi_say = $gonderi_rand_sorgu->fetchColumn();
	
				echo $gonderi_say.'<br>';
				echo $id;
				
				if($gonderi_say == 0) {
					$sorgu = $db->prepare("INSERT INTO gonderiler SET id=:id, baslik=:baslik, aciklama=:aciklama, resim=:resim, title=:title, seo_url=:seo_url, seo_alt=:seo_alt");
					$sorgu->execute(array( ':id'=> $id, ':baslik'=> $baslik, ':aciklama'=> $aciklama, ':resim'=> $yeni_ad, ':title'=> $title, ':seo_url'=> $seo_url, ':seo_alt'=> $seo_alt));				
				}
				
				if($sorgu){
					header("Location: ../nedmin-ssecca/blog.php?status=basarili");
				}else{
					header("Location: ../nedmin-ssecca/blog.php?status=basarisiz");
				}
			}else{
				header("Location: ../nedmin-ssecca/blog.php?status=none");
			}
		}else{
			header("Location: ../nedmin-ssecca/blog.php?status=type");
		}
		}else{          
			header("Location: ../nedmin-ssecca/blog.php?status=size");
		}
	}

	/* GONDERI DUZENLE */

	/* HABERLER */
	$habersor=$db->prepare("SELECT * FROM haberler order by id DESC limit $limit, $sayfada");
	$habersor->execute();
	
	$rows10 = $db->query("SELECT * FROM haberler", PDO::FETCH_ASSOC);
	
	/* HABER OLUŞTUR */
	if(isset($_FILES["resim"], $_POST["haber_olustur"])) {
		if ($_FILES["resim"]["size"]<1024*1024){//Dosya boyutu  aldık ve 1Mb'tan az olmasını söyledik.

			if ($_FILES["resim"]["type"] == "image/jpeg" or "image/jpg" or "image/png"){  //Dosya tipi aldık ve sadece jpeg olmasını söyledik.
				
				$baslik = $_POST["baslik"];
				$aciklama = $_POST["aciklama"];
				$title = $_POST["title"];
				$description = $_POST["description"];
				$author = $_POST["author"];
				$seo_url = $_POST["seo_url"];
				$seo_alt = $_POST["seo_alt"];
				$dosya_adi = $_FILES["resim"]["name"];  //Dsoya adını aldık.

				//Resimi kayıt ederken yeni bir isim oluşturalım
				$uret=array("cv","fg","th","lu","er");
				$uzanti=substr($dosya_adi,-4,4);
				$sayi_tut=rand(1,10000);

				$yeni_ad="../images/".$uret[rand(0,4)].$sayi_tut.$uzanti;

				//Dosya yeni adıyla yuklenenresimler klasörüne kaydedilecek

				if (move_uploaded_file($_FILES["resim"]["tmp_name"],$yeni_ad)){
					echo 'Dosya başarıyla yüklendi.';

					//Bilgileri veritabanına kayıt ediyoruz..

				$id = rand(0, 1000000);

				$gonderi_rand_sorgu = $db->prepare("SELECT COUNT(*) FROM haberler WHERE id=".$id."");
				$gonderi_rand_sorgu->execute();
				$gonderi_say = $gonderi_rand_sorgu->fetchColumn();
	
				echo $gonderi_say.'<br>';
				echo $id;
				
				if($gonderi_say == 0) {
					$sorgu = $db->prepare("INSERT INTO haberler SET id=:id, baslik=:baslik, aciklama=:aciklama, resim=:resim, title=:title, author=:author, description=:description, seo_url=:seo_url, seo_alt=:seo_alt");
					$sorgu->execute(array( ':id'=> $id, ':baslik'=> $baslik, ':aciklama'=> $aciklama, ':resim'=> $yeni_ad, ':title'=> $title, ':description'=> $description, ':author'=> $author, ':seo_url'=> $seo_url, ':seo_alt'=> $seo_alt));				
				}
				
				if($sorgu){
					header("Location: ../nedmin-ssecca/teknoloji-haberleri.php?status=haber-duzenlendi");
				}else{
					header("Location: ../nedmin-ssecca/teknoloji-haberleri.php?status=haber-duzenlenemedi");
				}
			}else{
				header("Location: ../nedmin-ssecca/teknoloji-haberleri.php?status=none");
			}
		}else{
			header("Location: ../nedmin-ssecca/teknoloji-haberleri.php?status=type");
		}
		}else{          
			header("Location: ../nedmin-ssecca/teknoloji-haberleri.php?status=size");
		}
	}
	
	/* HABER DUZENLE */
	if(isset($_FILES["resim"], $_POST["haber_guncelle"])) {
		if ($_FILES["resim"]["size"]<1024*1024){//Dosya boyutu  aldık ve 1Mb'tan az olmasını söyledik.

			if ($_FILES["resim"]["type"]=="image/jpeg"){  //Dosya tipi aldık ve sadece jpeg olmasını söyledik.

				$id= $_POST["id"];
				$baslik = $_POST["baslik"];
				$aciklama = $_POST["aciklama"];
				$title = $_POST["title"];
				$description = $_POST["description"];
				$author = $_POST["author"];
				$seo_url = $_POST["seo_url"];
				$seo_alt = $_POST["seo_alt"];
				$dosya_adi = $_FILES["resim"]["name"];  //Dsoya adını aldık.

				//Resimi kayıt ederken yeni bir isim oluşturalım
				$uret=array("cv","fg","th","lu","er");
				$uzanti=substr($dosya_adi,-4,4);
				$sayi_tut=rand(1,10000);

				$yeni_ad="../images/".$uret[rand(0,4)].$sayi_tut.$uzanti;

				//Dosya yeni adıyla yuklenenresimler klasörüne kaydedilecek

				if (move_uploaded_file($_FILES["resim"]["tmp_name"],$yeni_ad)){
					echo 'Dosya başarıyla yüklendi.';

					//Bilgileri veritabanına kayıt ediyoruz..

				$sorgu = $db->prepare("UPDATE haberler SET resim=:resim, baslik=:baslik, aciklama=:aciklama, title=:title, description=:description, author=:author, seo_url=:seo_url, seo_alt=:seo_alt WHERE id=:id");
				$sorgu->execute(array(':id'=> $id, ':resim'=> $yeni_ad, ':baslik'=> $baslik, ':aciklama'=> $aciklama, ':title'=> $title, ':description'=> $description, ':author'=> $author, ':seo_url'=> $seo_url, ':seo_alt'=> $seo_alt));
				if($sorgu){
					header("Location: ../nedmin-ssecca/teknoloji-haberleri.php?status=haber-duzenlendi");
				}else{
					header("Location: ../nedmin-ssecca/teknoloji-haberleri.php?status=haber-duzenlenemedi");
				}
			}else{
				header("Location: ../nedmin-ssecca/teknoloji-haberleri.php?status=none");
			}
		}else{
			header("Location: ../nedmin-ssecca/teknoloji-haberleri.php?status=type");
		}
		}else{          
			header("Location: ../nedmin-ssecca/teknoloji-haberleri.php?status=size");
		}
	}
	
	/* SİLME */
	if(isset($_GET["gonderiSil_no"])) {
		$id = $_GET["gonderiSil_no"];
		if($id == "755980" or $id == "899471" or $id == "216420") {
			echo "Bu gönderi silinemez!";
		} else {
			$query = $db->prepare("DELETE FROM gonderiler WHERE id=:id");
			$delete = $query->execute(array(
			   'id' => $id
			));
		}
		
		if(isset($delete)) {
			header("Location: ../nedmin-ssecca/blog.php?status=true");
		} else {
			header("Location: ../nedmin-ssecca/blog.php?status=false");
		}
	}

	if(isset($_GET["kursSil_no"])) {
		$id = $_GET["kursSil_no"];
			$query = $db->prepare("DELETE FROM kurslar WHERE id=:id");
			$delete = $query->execute(array(
			   'id' => $id
			));
			
		if(isset($delete)) {
			header("Location: ../nedmin-ssecca/kurslar.php?status=true");
		} else {
			header("Location: ../nedmin-ssecca/kurslar.php?status=false");
		}			
			
	}
		
	if(isset($_GET["haberSil_no"])) {
			$id = $_GET["haberSil_no"];
			
			$query = $db->prepare("DELETE FROM haberler WHERE id=:id");
			$delete = $query->execute(array(
			   'id' => $id
			));
		
		
		if(isset($delete)) {
			header("Location: ../nedmin-ssecca/teknoloji-haberleri.php?status=true");
		} else {
			header("Location: ../nedmin-ssecca/teknoloji-haberleri.php?status=false");
		}
	}
	
	if(isset($_GET["sayfaSil_no"])) {
		$id = $_GET["sayfaSil_no"];
		if($id == "18") {
			echo "Bu sayfa silinemez!";
		} else {
			$query = $db->prepare("DELETE FROM sayfalar WHERE id=:id");
			$delete = $query->execute(array(
			   'id' => $id
			));
		}
		
		if(isset($delete)) {
			header("Location: ../nedmin-ssecca/statik-sayfalar.php?status=true");
		} else {
			header("Location: ../nedmin-ssecca/statik-sayfalar.php?status=false");
		}
	}
	
	if(isset($_GET["hizmetSil_no"])) {
		$id = $_GET["hizmetSil_no"];
		$query = $db->prepare("DELETE FROM hizmetler WHERE id=:id");
		$delete = $query->execute(array(
		   'id' => $id
		));
		
		if(isset($delete)) {
			header("Location: ../nedmin-ssecca/statik-sayfalar.php?status=true");
		} else {
			header("Location: ../nedmin-ssecca/statik-sayfalar.php?status=false");
		}
	}
	
	if(isset($_GET["galeriSil_no"])) {
		$id = $_GET["galeriSil_no"];
		$query = $db->prepare("DELETE FROM galeri WHERE id=:id");
		$delete = $query->execute(array(
		   'id' => $id
		));
		
		if(isset($delete)) {
			header("Location: ../nedmin-ssecca/galeri.php?status=true");
		} else {
			header("Location: ../nedmin-ssecca/galeri.php?status=false");
		}
	}
	
	/* ILETISIM */
	$rows8 = $db->query("SELECT * FROM iletisim", PDO::FETCH_ASSOC);
	 
	$iletisim_sec = $db->query("SELECT * FROM iletisim WHERE id=1")->fetch(PDO::FETCH_ASSOC);

	$iletisim_adres = $iletisim_sec["adres"];
	$iletisim_telefon = $iletisim_sec["telefon"];
	$iletisim_eposta = $iletisim_sec["eposta"];
	$iletisim_facebook = $iletisim_sec["facebook"];
	$iletisim_twitter = $iletisim_sec["twitter"];
	$iletisim_youtube = $iletisim_sec["youtube"];
	$iletisim_instagram = $iletisim_sec["instagram"];
	
	if(isset($_POST["iletisim_guncelle"])) {
		$adres = $_POST["adres"];
		$telefon = $_POST["telefon"];
		$eposta = $_POST["eposta"];
		$facebook = $_POST["facebook"];
		$twitter = $_POST["twitter"];
		$youtube = $_POST["youtube"];
		$instagram = $_POST["instagram"];
		
		$sorgu = $db->prepare("UPDATE iletisim SET adres=:adres, telefon=:telefon, eposta=:eposta, facebook=:facebook, twitter=:twitter, youtube=:youtube, instagram=:instagram");
		$sorgu->execute(array(':adres'=> $adres, ':telefon'=> $telefon, ':eposta'=> $eposta, ':facebook'=> $facebook, ':twitter'=> $twitter, ':youtube'=> $youtube, ':instagram'=> $instagram));
		
		if($sorgu) {
			echo "iletisim güncellendi";
		}
	}
	
	/* YONETIM */
	$rows9 = $db->query("SELECT * FROM yonetim", PDO::FETCH_ASSOC);
	
	if(isset($_POST["yonetim_guncelle"])) {
		$kullanici_adi = $_POST["kullanici_adi"];
		$sifre = $_POST["sifre"];

		$sorgu = $db->prepare("UPDATE yonetim SET kullanici_adi=:kullanici_adi, sifre=:sifre");
		$sorgu->execute(array(':kullanici_adi'=> $kullanici_adi, ':sifre'=> $sifre));

		if($sorgu) {
			echo "iletisim güncellendi";
		}	
		
	}
	if(isset($_POST["yonetim_olustur"])) {
		$kullanici_adi = $_POST["kullanici_adi"];
		$post_sifre = $_POST["sifre"];

		$sifre = base64_encode($post_sifre);

		$sorgu = $db->prepare("INSERT INTO yonetim SET kullanici_adi=:kullanici_adi, sifre=:sifre");
		$sorgu->execute(array( ':kullanici_adi'=> $kullanici_adi, ':sifre'=> $sifre));	

		if($sorgu) {
			echo "yonetim eklendi";
		}	
		
	}
	
	/* YORUM CEVAP */
	$rows11 = $db->query("SELECT * FROM yorumlar", PDO::FETCH_ASSOC);
	$rows12 = $db->query("SELECT * FROM yorumlar", PDO::FETCH_ASSOC);
	
	if(isset($_POST["yorum_guncelle"])) {
		$id = $_POST["id"];
		$isim = $_POST["isim"];
		$cevap = $_POST["cevap"];
		
		$sorgu = $db->prepare("UPDATE yorumlar SET isim=:isim, cevap=:cevap WHERE id=:id");
		$sorgu->execute(array(':id'=> $id, ':isim'=> $isim, ':cevap'=> $cevap));
		
		if($sorgu) {
			echo "Yorum güncellendi.";
		}
	}	
	
	/* BAŞVURU EKLE */
	if(isset($_POST["basvuru_olustur"])) {

		$basvurular = $db->query("SELECT * FROM basvurular")->fetch(PDO::FETCH_ASSOC);
		
		$kurs_no = $_POST["kurs_no"];
		
		foreach($basvurular as $basvuru) {
			
			$isim = htmlspecialchars($_POST["isim"]);
			$kurs = htmlspecialchars($_POST["kurs"]);
			$sinif = htmlspecialchars($_POST["sinif"]);
			$eposta = htmlspecialchars($_POST["eposta"]);
			$telefon = htmlspecialchars($_POST["telefon"]);
			$mesaj = htmlspecialchars($_POST["mesaj"]);			
				
			$basvuru_isim = $basvuru["isim"];
			$basvuru_kurs = $basvuru["kurs"];
			$basvuru_eposta = $basvuru["eposta"];
			$basvuru_telefon = $basvuru["telefon"];			
			
			if (isset($_POST['g-recaptcha-response'])) {
			  $captcha = $_POST['g-recaptcha-response'];
			}
			
			if (!$captcha) {
			  echo '<h2>Lütfen robot olmadığınızı doğrulayın.</h2>';
			  exit;
			}
			
			$control = reCaptchaControlBasvuru($captcha);

			if ($control["success"] == false) {
			  echo '<h2>Spam Gönderi!</h2>';
			} elseif($control["success"] == true) {
					
					$id = rand(0, 1000000);

					$basvuru_rand_sorgu = $db->prepare("SELECT COUNT(*) FROM yorumlar WHERE id=".$id."");
					$basvuru_rand_sorgu->execute();
					$basvuru_say = $basvuru_rand_sorgu->fetchColumn();
				
				if($basvuru_say == 0) {
					$sorgu = $db->prepare("INSERT INTO basvurular SET isim=:isim, kurs=:kurs, sinif=:sinif, eposta=:eposta, telefon=:telefon, mesaj=:mesaj");
					$sorgu->execute(array( ':isim'=> $isim, ':kurs'=> $kurs, ':sinif'=> $sinif, ':eposta'=> $eposta, ':telefon'=> $telefon, ':mesaj'=> $mesaj));	
				} else {
					header("Location: ../kurs-detay?kurs-no=".$kurs_no."&status=tekrar");
				}
			
			}
		}

		if(isset($sorgu)) {
			header("Location: ../kurs-detay?kurs-no=".$kurs_no."&status=basarili");
		} else {
			header("Location: ../kurs-detay?kurs-no=".$kurs_no."&status=basarisiz");
		}
		
		
	}
	
			function reCaptchaControlBasvuru($captcha){
		  $fields = [
				  'secret' => '6Le7QeIbAAAAAFaaCAI7ulsOUHWtCbMOvk8P__qW',
				  'response' => $captcha
				];
				$ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
				curl_setopt_array($ch,[
				   CURLOPT_POST => true,
				   CURLOPT_POSTFIELDS => http_build_query($fields),
					CURLOPT_RETURNTRANSFER => true
				]);
		 
				$result = curl_exec($ch);
				curl_close($ch);
				return json_decode($result,true);
		}
	
	/* KURSLAR */
	$kurslar = $db->query("SELECT * FROM kurslar", PDO::FETCH_ASSOC);
	
	if(isset($_GET["kurs-no"])) {
		
		$id = $_GET["kurs-no"];
		$kurs_sec = $db->query("SELECT * FROM kurslar WHERE id='$id'")->fetch(PDO::FETCH_ASSOC);
		
		$kurs_adi = $kurs_sec["kurs_adi"];
		$kurs_suresi = $kurs_sec["kurs_suresi"];
		$yeterlilikler = $kurs_sec["yeterlilikler"];
		$kursun_amaci = $kurs_sec["kursun_amaci"];
	}
	
	/* KURS EKLE */
	if(isset($_POST["kurs_olustur"])) {
		$kurs_adi = $_POST["kurs_adi"];
		$kurs_hakkinda = $_POST["kurs_hakkinda"];
		$gereksinimler = $_POST["gereksinimler"];
		$kazanimlar = $_POST["kazanimlar"];
		$fiyat = $_POST["fiyat"];
		$kurs_suresi = $_POST["kurs_suresi"];
		$yeterlilikler = $_POST["yeterlilikler"];
		$kursun_amaci = $_POST["kursun_amaci"];
		
		$sorgu = $db->prepare("INSERT INTO kurslar SET kurs_adi=:kurs_adi, kurs_hakkinda=:kurs_hakkinda, gereksinimler=:gereksinimler, kazanimlar=:kazanimlar, fiyat=:fiyat, kurs_suresi=:kurs_suresi, yeterlilikler=:yeterlilikler, kursun_amaci=:kursun_amaci");
		$sorgu->execute(array( ':kurs_adi'=> $kurs_adi, ':kurs_hakkinda'=> $kurs_hakkinda, ':gereksinimler'=> $gereksinimler, ':kazanimlar'=> $kazanimlar, ':fiyat'=> $fiyat, ':kurs_suresi'=> $kurs_suresi, ':yeterlilikler'=> $yeterlilikler, ':kursun_amaci'=> $kursun_amaci));	

		if(isset($sorgu)) {
			header("Location: ../nedmin-ssecca/kurslar.php?status=eklendi");
		} else {
			header("Location: ../nedmin-ssecca/kurslar.php?status=eklenemedi");
		}
		
	}
	
	/* KURS GUNCELLE */
	
	$rows13 = $db->query("SELECT * FROM kurslar", PDO::FETCH_ASSOC);
	
	if(isset($_POST["kurs_guncelle"])) {
		
		$id = $_POST["id"];
		$kurs_adi = $_POST["kurs_adi"];
		$kurs_hakkinda = $_POST["kurs_hakkinda"];
		$gereksinimler = $_POST["gereksinimler"];
		$kazanimlar = $_POST["kazanimlar"];
		$fiyat = $_POST["fiyat"];
		$kurs_suresi = $_POST["kurs_suresi"];
		$yeterlilikler = $_POST["yeterlilikler"];
		$kursun_amaci = $_POST["kursun_amaci"];

		$sorgu = $db->prepare("UPDATE kurslar SET kurs_adi=:kurs_adi, kurs_hakkinda=:kurs_hakkinda, gereksinimler=:gereksinimler, kazanimlar=:kazanimlar, fiyat=:fiyat, kurs_suresi=:kurs_suresi, yeterlilikler=:yeterlilikler, kursun_amaci=:kursun_amaci WHERE id=:id");
		$sorgu->execute(array(':id'=> $id, ':kurs_adi'=> $kurs_adi, ':kurs_hakkinda'=> $kurs_hakkinda, ':gereksinimler'=> $gereksinimler, ':kazanimlar'=> $kazanimlar, ':fiyat'=> $fiyat, ':kurs_suresi'=> $kurs_suresi, ':yeterlilikler'=> $yeterlilikler, ':kursun_amaci'=> $kursun_amaci));

		if(isset($sorgu)) {
			header("Location: ../nedmin-ssecca/kurslar.php?status=guncellendi");
		} else {
			header("Location: ../nedmin-ssecca/kurslar.php?status=guncellenemedi");
		}
	}
	
	/* BASVURULAR */
?>