<title>Prenota lezione</title>

<?php
	// Prendi valori dal html file
	$username = $_POST['user'];
	$password = $_POST['pass'];
    $data = $_POST['data'];
    $ora = $_POST['ora'];

		// Per evitare mysql injection
		$username = stripcslashes($username);
		$password = stripcslashes($password);
		$data = stripcslashes($data);
		$ora = stripcslashes($ora);

// Check se accede da link diretto
if ($username == NULL or $username == "ZAP")
{
echo "Vietato l'accesso!";
}
else {

	// Prima connessione server e database
	mysql_connect('localhost', 'root', 'password') or die("Impossibile connettersi al server $host");
	mysql_select_db('my_infinitamentefisica');

	//connessione table del database
	$result = mysql_query("select * from login where username = '$username' and password = '$password'")
			or die("Impossibile accedere al database ,contattare myemail@gmail.com");
	$row = mysql_fetch_array($result);

    //Check delle credenziali
	if ($row['username'] == $username && $row['password'] == $password ){

// Seconda connessione server e database
$conn = new mysqli("localhost", "root", 'password', "my_infinitamentefisica");

// Aggiunta dati MySQL
$sql = "INSERT INTO login (username, password, data, ora)
VALUES ('$username', '$password', '$data', '$ora')";

// Check se ha aggiunto i dati richiesti
 if ($conn->query($sql) === TRUE) {
    echo " ";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Manda Mail
$miamail = "myemail@gmail.com";
$resource = mysql_connect('localhost', 'root', 'password') or die("Impossibile connettersi al server $host");
mysql_select_db('my_infinitamentefisica', $resource);

$result = mysql_query('select * FROM login');
while(($row = mysql_fetch_assoc($result))) {
	$messaggio = $messaggio . PHP_EOL . "$row[username] $row[password] $row[data] $row[ora]";
}

$headers = "From: " . $miamail . "\r\n" . "Reply-To: " . $miamail;
mail($miamail,"Messaggio dal sito",$messaggio,$headers);


//Output scritto
$linea1 = "Prenotazione ricevuta, grazie $username";
$linea2 = "Hai prenotato il $data alle $ora";
$linea3 = " , se hai sbagliato riporta l'errore nella sezione CONTATTAMI del sito.";
echo '<pre>' . $linea1 . PHP_EOL . $linea2 . $linea3 . '</pre>';
echo "<input type=\"button\" onclick=\"location.href='index.html'\" value=\"RITORNA ALLA HOME\"/>";
}

else {
header("location: /403.html");


}
}
?>
