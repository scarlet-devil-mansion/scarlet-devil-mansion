<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="../css/text-selection.css" />
</head>
<body>
 
<?php
session_start();
 
$host = "";
$username ="";
$password = "";
$database ="";

$con = mysqli_connect($host,$username,$password,$database);

// Bağlantı kontrolü
if (mysqli_connect_errno())
  echo "Bağlantı kurulamadı: " . mysqli_connect_error();
 
$kullaniciadi = mysqli_real_escape_string($con,$_POST['username']);
$sifre = mysqli_real_escape_string($con,$_POST['pword']);

$sql="select * from users WHERE username='".$kullaniciadi."' AND pword='".$sifre."'";
//echo $sql;
$sonuc= mysqli_query($con,$sql);
if (mysqli_num_rows($sonuc)>0)
{ 
//$satir= mysqli_fetch_array($sonuc);
//echo "<center>Sayın ".$satir['ad']." ".$satir['soyad']." Hoş Geldiniz</center>";
$_SESSION['user']=$kullaniciadi;
$_SESSION['name']=$satir['ad'];
$_SESSION['surname']=$satir['soyad'];
echo '<script>window.location.href ="../";</script>';
 
} else {
echo "<center>Herhangi bir kayıt bulunamadı.</center>";
}

mysqli_close($con);

?>
</body>
</html>