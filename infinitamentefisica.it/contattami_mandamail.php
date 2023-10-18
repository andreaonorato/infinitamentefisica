<?php
$errore = $_POST['errore'];
$successo = $_POST['successo'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$msg = $_POST['msg'];
$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
if ($nome == NULL) {header("location: " . $errore);}
else {
$miamail = "myemail@gmail.com";

$dettagli = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
$messaggio = "Mail ricevuta da " . $nome . "\nLa sua mail è: " . $email . "\nIl suo numero di telefono è: " . $tel . "\nMessaggio: " . $msg . "\nIl suo ip è: " . $ip; // . " e la sia località è: " . $details->country;
$headers = "From: " . $miamail . "\r\n" . "Reply-To: " . $miamail;

// Manda Mail
mail($miamail,"Messaggio dal sito",$messaggio,$headers);
header("location: " . $successo);
}
?>
