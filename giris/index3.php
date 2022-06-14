<?php 
session_start();
error_reporting(0);
?>
<html>
 
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="../css/text-selection.css" />
</head>
<body>
 
<?php
if ($_SESSION['user']==""){
echo '<script>window.location.href ="giris.php";</script>';
}else{
echo "Bu üçüncü sayfa, session(oturum) aktif<br>";
echo "Kullanıcı adınız :".$_SESSION['user']."<br>";
echo $_SESSION['name']." ".$_SESSION['surname'] ;
echo "<br><a href=cikis.php>Oturumdan Çıkış Yap</a>";
}
?>
 
</body>
</html>