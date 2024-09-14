<?php // ** lomakkeenpostittaja **
$mailto = "palaute@tksvpk.fi"; // Vaihda tähän oma osoitteesi
$heading = "Lomake www-sivulta ".$_SERVER['SERVER_NAME'];
$charset = "UTF-8";
// Poista kommentit alta jos haluat omat virhe- ja kiitossivut
// $thanks = "http://www.yourdomain.tld/thanks.html";
// $error = "http://www.yourdomain.tld/error.html";

$fields = array(
// Lomakkeen kenttien name-arvot tulee olla seuraavilla
// riveillä vastaavasti. Voit määrittää kullekin arvolle * jos
// kenttä on pakollinen täyttää. 'nimi' ja 'email' -nimiä
// ei saa kuitenkaan muuttaa tai postittaja ei toimi.
  
"nimi" => "*",  // <- "nimi" -nimeä ei saa vaihtaa 
"email" => "",  // <- "email" -nimeä ei saa vaihtaa
"viesti" => "*",
// lisää vapaasti kenttiä lomakkeesi tarpeen mukaan
);

// ÄLÄ MUOKKAA MITÄÄN TÄMÄN KOHDAN ALAPUOLELTA
if ($mailto == "mail@mydomain.tld") {die ("Unohdit konfiguroida
postittajan mailto-parametrin. Muista lukea ohjeet!");}
$content="";$values=array();foreach($fields as $field=>$value){
array_push ($values, $_POST[$field]);}$i=0; $missing="";
foreach ($fields as $field => $value){if ($fields[$field]=="*"
&& empty($values[$i])) {$missing.="$field, ";} $content .=
"[".strtoupper($field)."]: ".$values[$i]."\n\n";
if ($field=="email"){if (empty($values[$i])){$senderemail=
"ei@lahettajanosoitetta.tld";$content .= "----
(HUOM! Lähettäjä ei ilmoittanut sähköpostiosoitettaan,
joten viestiin ei voi vastata.) \r\n-----\r\n\r\n";} else {
$senderemail=$values[$i];}}$i++;} if (!empty($missing)){
if($error){header("Location:".$error); die;}else{die("Seuraavat kentät
ovat pakollisia: <b>".substr_replace ($missing,"",-2)."</b>. Ole hyvä
ja täydennä lomaketta. &raquo; <a href='javascript: history.go(-1)'>
Takaisin</a>");};}mail ($mailto, $heading, $content,"From: ".$senderemail.
"\r\nMIME-Version: 1.0\r\nContent-Type: text/plain; charset=".$charset.
"\n", "-f".$mailto); if ($thanks){header("Location:".$thanks);
}else{echo"Kiitos! Viesti lähetetty. &raquo; <a href='/'>Etusivu</a>";}; 
// Tiedoston lopussa ei saa olla tyhjiä rivinvaihtoja
?>