 <?php
error_reporting(E_ERROR | E_PARSE);

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$message = trim($_POST['message']);
date_default_timezone_set('UTC');
$fromwho='313034@stud.umk.pl';
$temat = 'Wiadomość ze strony 313034';
$protokol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
$website = "$protokol://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$date = date('j.m.Y \o \g\o\d\z\. H:m:s');

$text='Wiadomość ze strony: '.$website.PHP_EOL.'<br>Imię i Nazwisko: '.$name.'<br>Adres Email: '.$email.'<br>Treść Wiadomości:<br><pre>'.$message.'</pre><br>Wiadomość zostałą wysłana dnia '.$date;

$temat = '=?UTF-8?B?' . base64_encode($temat) . '?=';
$how  = 'Content-type: text/html; charset=UTF-8' . PHP_EOL;
$how .= 'From: =?UTF-8?B?' . base64_encode($name) . "?= <$email>" . PHP_EOL;
if (mail($fromwho, $temat, $text, $how)) {
    echo 1;
} else {
    echo 2;
}


 ?>
