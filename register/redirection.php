<?php

$host = "";
$username ="";
$password = "";
$database ="";

$con = mysqli_connect($host,$username,$password,$database);

// Bağlantı kontrolü
if (mysqli_connect_errno()) {
  echo "Bağlantı kurulamadı: " . mysqli_connect_error();
}

include 'PHPMailer/class.phpmailer.php';
include 'PHPMailer/class.smtp.php';
include 'PHPMailer/PHPMailerAutoload.php';
 
$adi=   mysqli_real_escape_string($con, $_POST['ad']);
$soyadi= mysqli_real_escape_string($con,$_POST['soyad']);
$eposta= mysqli_real_escape_string($con,$_POST['eposta']);
$kullaniciadi= mysqli_real_escape_string($con,$_POST['username']);
 
$yenieposta= filter_var($eposta, FILTER_SANITIZE_EMAIL);
//echo $yenieposta;
 
$sifre= mysqli_real_escape_string($con,$_POST['pword']);
$tekrarsifre= mysqli_real_escape_string($con,$_POST['pword2']);
 
$mesaj="";
if ($adi=="" || $soyadi==""){
/*Alınan her hatada farklı bir html yansıtılacak. Sayfanın görünüşü buralardan değiştirilecek.*/
$mesaj='
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <title>Ehem. Ad soyad boş mu ne.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <meta name="description" content="Yaw yaz işte ne olacak yaa.">
        <meta name="author" content="Hakurei Remilia">
        
        <meta name="robots" content="noindex">
        
        <link rel="stylesheet" href="../css/text-selection.css" />
        
        <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
        <link rel="manifest" href="../site.webmanifest">
    
    </head>
</html>
<center>Adın ve soyadını yaz. Merak etme kimseye söylemeyiz.</center>';
header("Refresh: 4; url=../register");
}

if ($sifre!=$tekrarsifre){
$mesaj='
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <title>Hmm. Şifre demek...</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <meta name="description" content="Şifreler aynı değil galiba.">
        <meta name="author" content="Hakurei Remilia">
        
        <meta name="robots" content="noindex">
        
        <link rel="stylesheet" href="../css/text-selection.css" />

        <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
        <link rel="manifest" href="../site.webmanifest">
    
    </head>
</html>
<center>Şifreler aynı olmalı anlarsın ya... Doğrulama amaçlı...</center>';
header("Refresh: 4; url=../register");
}

if (strlen($sifre)<6){
$mesaj='
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <title>Şifrende bir sorun var.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <meta name="description" content="6 haneli yapsak nasıl olur? Güvenlik amaçlı hani.">
        <meta name="author" content="Hakurei Remilia">
        
        <meta name="robots" content="noindex">
        
        <link rel="stylesheet" href="../css/text-selection.css" />

        <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
        <link rel="manifest" href="../site.webmanifest">
    
    </head>
</html>
<center>Şifreni en az 6 karakter yapta "güvenli" olsun.</center>';
header("Refresh: 4; url=../register");
}

if ($mesaj!=""){
//hata yazdırıyoruz
echo $mesaj;
}
else{
//Buraya kaydetme kodlarımız gelecek;


$kod = md5(rand(1,1000));
$kod2 = md5(rand(1,5000));
$kod3 = md5(rand(1,5000));
$sql="INSERT INTO users(ad, soyad, eposta, username, pword, vuid)
VALUES ('$adi', '$soyadi', '$yenieposta','$kullaniciadi','$sifre','$kod')";

if (!mysqli_query($con,$sql)) {
die('Hata: ' . mysqli_error($con));
}

##################
#                #
#     Mailer     #
#                #
##################

$mail = new PHPMailer();

$mail->CharSet = "UTF-8";

//Türkçe dil ayarı
$mail->setLanguage('tr', 'PHPMailer/language/');


//$mail->SMTPDebug = 3;                                  // Enable verbose debug output

$mail->isSMTP();                                         // Set mailer to use SMTP
$mail->Host = '';            // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                                  // Enable SMTP authentication
$mail->Username = 'no-reply@scarletdevilmansion.org';    // SMTP username
$mail->Password = '';                     // SMTP password
$mail->SMTPSecure = 'ssl';                               // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                       // TCP port to connect to

$mail->setFrom('no-reply@scarletdevilmansion.org', 'SDM Destek');  //Sender Mail
$mail->addAddress($yenieposta, $adi);                    // Add a recipient



  //Content
    $mail->isHTML(true);                                 //Set email format to HTML
    $mail->Subject = 'Doğrulama';
    $mail->Body    = 'Doğrulanmak için <a href="https://scarletdevilmansion.org/activation/verify.php?username='.$kullaniciadi.'&vuid='.$kod.'&first_authentication_code='.$kod2.'&temporary_secret_code='.$kod3.'">buraya</a> tıkla.';
    $mail->AltBody = 'SDM Destek Ekibi - oysa sadece 1 kişi...';
    
    if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
    }


##################
#                #
#     Mailer     #
#                #
##################

##################
#                #
#     Mailer     #
#                #
##################

//Burası bana birisi kayıt olunca bildirsin diye. Gereği yok yani.

$mail = new PHPMailer();

$mail->CharSet = "UTF-8";

//Türkçe dil ayarı
$mail->setLanguage('tr', 'PHPMailer/language/');

//$mail->SMTPDebug = 3;                                  // Enable verbose debug output

$mail->isSMTP();                                         // Set mailer to use SMTP
$mail->Host = '';            // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                                  // Enable SMTP authentication
$mail->Username = 'no-reply@scarletdevilmansion.org';    // SMTP username
$mail->Password = '';                     // SMTP password
$mail->SMTPSecure = 'ssl';                               // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                       // TCP port to connect to

$mail->setFrom('no-reply@scarletdevilmansion.org', 'SDM Destek');  //Sender Mail
$mail->addAddress(' '/* <-- Benim epostam*/, 'Destek Ekibi?');                    // Add a recipient



  //Content
    $mail->isHTML(true);                                 //Set email format to HTML
    $mail->Subject = 'Alo';
    $mail->Body    = 'Hop aloo? Biri kayıt oldu git bak aq';
    $mail->AltBody = 'Ben senim sense ben hehehe';
    
    if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
    }


##################
#                #
#     Mailer     #
#                #
##################

echo '
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <title>Kayıt olmayı başardın gibi ha?</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <meta name="description" content="Seni şuraya alalım.">
        <meta name="author" content="Hakurei Remilia">
        
        <meta name="robots" content="noindex">
        
        <link rel="stylesheet" href="../css/text-selection.css" />
        
        <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
        <link rel="manifest" href="../site.webmanifest">
    
    </head>
</html>
<center><br>Kayıt isteğin bana geldi. Şimdi e-posta adresini onaylamalısın. Üyeliğini sonra bi zaman aktif ederim :d
<br>Arkada bir kaç işlem yapılıyor yani birazdan ana sayfaya yönlendirileceksiniz.
<br>Ama eğer beklemek istemiyorsan ' . '<a href="https://scarletdevilmansion.org">tıkla.</a>
<br>Bu arada posta kutuna gelen linke basıp hesabını aktif etmeni tavsiye ederim.
</center>';
ob_start();
/*Sayfadaki kişinin yazıları okuması için verdiğim süre 16 saniye. Bence yeterde artar.*/
header("Refresh: 16; url=https://scarletdevilmansion.org");
}

mysqli_close($con);
 
?>