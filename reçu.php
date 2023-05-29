<?php
session_start();
require('fpdf185/fpdf.php');
require "db.php";
require "security.php";
$idreserv=$_GET['idreserv'];

$query=$connection->prepare("SELECT * FROM reserver WHERE idreserv=?");
$query->execute(array($idreserv));

class PDF extends FPDF
{
// En-tête
function Header()
{
    // Logo
    $this->Image('image/favicon.png',15,5,18);
    // Police Arial gras 15
    $this->SetFont('Arial','B',15);
    //couleur
    $this->SetTextColor(131,95,255);
    // Décalage à droite
    $this->Cell(80);
    // Titre
    $this->Cell(30,10,utf8_decode('Réçu'),0,'C');
    // Saut de ligne
    $this->Ln(20);
}
// Pied de page
function Footer()
{
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Arial','I',8);
    // Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

while ($ligne=$query->fetch()) {

	$sql=$connection->prepare("SELECT nom as nom FROM client WHERE idcli=?");
	$sql->execute(array($ligne['idcli']));
	$nom=$sql->fetch()['nom'];


	$sql=$connection->prepare("SELECT numtel as numtel FROM client WHERE idcli=?");
	$sql->execute(array($ligne['idcli']));
	$numtel=$sql->fetch()['numtel'];

	$sql=$connection->prepare("SELECT type as type FROM voiture WHERE idvoit=?");
	$sql->execute(array($ligne['idvoit']));
	$type=$sql->fetch()['type'];

	$sql=$connection->prepare("SELECT frais as frais FROM voiture WHERE idvoit=?");
	$sql->execute(array($ligne['idvoit']));
	$frais=$sql->fetch()['frais'];

	$reste=$frais-$ligne['montant_avance'];

	if ($ligne['payement']=="tout payé") {
		$reste=0;
	}

	$pdf->Cell(50,10,utf8_decode('Date du réservation : '.$ligne['date_reserv']),0,'C');
	$pdf->Cell(50,10,utf8_decode('Date du voyage  : '.$ligne['date_voyage']),0,'C');
	$pdf->Cell(40,10,utf8_decode('Nom du client : '.$nom.' / Contact : '.$numtel),0,'C');
	$pdf->Cell(40,10,utf8_decode('Voiture '.$ligne['idvoit'].' / Type de voiture : '.$type.' / Place : '.$ligne['place']),0,'C');
	$pdf->Cell(40,10,utf8_decode('Frais : '.$frais.' Ar'),0,'C');
	$pdf->Cell(40,10,utf8_decode('Payement : '.$ligne['payement']),0,'C');
	$pdf->Cell(40,10,utf8_decode('Montant Avance : '.$ligne['montant_avance'].' Ar /Reste : '.$reste.' Ar'),0,'C');
}
$pdf->Output();

?>