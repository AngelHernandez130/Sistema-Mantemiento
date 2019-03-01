<?php
require_once "lib/nusoap.php";

function getPersonas($atributos)
{
	if($atributos=="nombre")
		return join (",",array("Fernantux","kasdjaksdjak"));
	return "No hay personas :(";


}
function isNumber($number)
{
	if(is_numeric($number))
		return "yes";
	return "no";

}

function calculaRFCURP($paterno,$materno,$nombre,$fe,$se,$edo) {

  $paterno1st = substr($paterno, 0, 2); 
$materno1st =substr($materno, 0, 1);
 $nombre1st = substr($nombre, 0, 1);  
 $fecha1=$fe;  
 $sexo1=$se;
 $edo1=$edo;
   // $paterno1st=str_replace("Ñ", "X", $paterno);
 
   if($materno1st=="")
   {
  	$materno1st="X";
   }
   $resultado=$paterno1st.$materno1st.$nombre1st;
  if($resultado=="PEDO")
   {
   	$resultado=str_replace("E", "X", $resultado);
   }
   if($resultado=="PUTO"||$resultado=="PUTA")
   {
   	$resultado=str_replace("U", "X", $resultado);
   }
    if($resultado=="PITO"||$resultado=="PIPI")
   {
   	$resultado=str_replace("I", "X", $resultado);
   }
  $pos17=substr($fecha1, 0, 2);
  if ($pos17<="99" && $pos17 >="50") {
    $pos17f="0";
    # code...
  }
  elseif ($pos17>="00"||$pos17<="49") {
    $pos17f="A";
  }
 
 $pos14=substr($paterno, 2, 1);
$pos15=substr($materno, 1, 1);
$pos16=substr($nombre, 1, 1);
if ($pos14=="") {
  $pos14="X";
}
if ($pos15=="") {
  $pos15="X";
}
if ($pos16=="") {
  $pos16="X";
}
  $rf1=$resultado.$fecha1.$sexo1.$edo1.$pos14.$pos15.$pos16.$pos17f."9";
  $rf1=strtoupper($rf1);
return $rf1;
}




$server= new soap_server();
$server -> configureWSDL("webserv","urn:webserv");
$server ->register("getPersonas",
	array("nombre"=>"xsd:string"),
	array("return"=>"xsd:string")
	);

$server->register("calculaRFCURP",
	array("paterno" => "xsd:string","materno" => "xsd:string","nombre" => "xsd:string"),
	array("fe" => "xsd:string"),
  array("se" => "xsd:string" ,"edo" =>"xsd:string"),
	
//  array("fe" => "xsd:string"),
	array("return" => "xsd:string")
	);



$server->register("isNumber");

if(!isset($HTTP_RAW_POST_DATA))
$HTTP_RAW_POST_DATA=file_get_contents("php://input");


$server->service($HTTP_RAW_POST_DATA);
?>
