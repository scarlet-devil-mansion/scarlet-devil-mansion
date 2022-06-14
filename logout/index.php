<?php
session_start();
?>
<html>
 
<head>
<meta charset="utf-8"> 
<link rel="stylesheet" href="../css/text-selection.css" />
</head>
<body>
<?php
$_SESSION = array();
session_destroy();
header('Location: https://scarletdevilmansion.org/')
?>
</body>
</html>