<?php

$host = "";
$username ="";
$password = "";
$database ="";

$con = mysqli_connect($host,$username,$password,$database);

// Bağlantı kontrolü
if (mysqli_connect_errno())
  echo "Bağlantı kurulamadı: " . mysqli_connect_error();

$kullaniciadi = $_GET['username'];
$vuid = $_GET['vuid'];


$sql = "SELECT * FROM users WHERE username = '$kullaniciadi' AND vuid = '$vuid'";


$result = mysqli_query($con, $sql);



if( mysqli_num_rows($result) > 0 ){

mysqli_query($con, "UPDATE users SET aktif = 1 WHERE username='$kullaniciadi' AND vuid='$vuid'");

$kayit = mysqli_query($con, "UPDATE users SET vuid = 'Verified' WHERE username='$kullaniciadi' AND vuid='$vuid'");

        if($kayit){
            echo '
            
            <html>
    <head>
        
        <title>Ay şen doğyulanıyoy muşun!?</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <meta name="author" content="Hakurei Remilia">
        
        <meta name="robots" content="noindex">
        
        
        <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
        <link rel="manifest" href="../site.webmanifest">
        <link rel="stylesheet" href="../css/text-selection.css" />
    
    </head>
</html>
            
            <center>An itibarı ile aktivasyonun başarılı \(≧▽≦)/ 
            <br>Eğer site ile ilgili bir haber yapılacak olursa
            <br>diye e-posta adresin listeye alındı.
            
            <br>Evet.
            <br>Bu listeden çıkamazsın.
            <br>Site yöneticisi böyle karar kılmış...</center>';
    }else
        echo 'Kızma ama bir hata ile karşılaTım (ﾉω･､)
        Site yöneticisine e-posta atmayı dene.';


}else
{

echo '
    
    <html>
    <head>
        
        <title>Ops! Bir sorunumuz va~r...</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <meta name="author" content="Hakurei Remilia">
        
        <meta name="robots" content="noindex">
        
        <link rel="stylesheet" href="../css/text-selection.css" />
        
        <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
        <link rel="manifest" href="../site.webmanifest">
    
    </head>
</html>

    <br>
    <center>Hmm (￣W￣;)... Yaptığım kontrollere göre ya link geçersiz ya da zaten aktivasyonun tamamlanmış.
    <br>
    <br>Bence gereği yok ama bir yanlışlık olduğunu düşünüyorsan <a href="mailto:admin@scarletdevilmansion.org">yöneticiye</a> mail atmayı aklında bulundur derim.
    <br>
    <br>Meşgul adam yani, anime falan izleyip internette takılıyor. Rahatsız etmek olmaz şimdi...</center>';
}

mysqli_close($con);

?>