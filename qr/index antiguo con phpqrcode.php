<?php 

//link ejemplo
// svgqr.php?formato=svg&contenido=holamundosjjj&calidad=H&tamanio=10&borde=2


require 'phpqrcode/qrlib.php';

if (isset($_GET['formato']))
{  
if ( $_GET['formato'] == 'png' or $_GET['formato'] == 'svg')
	{$formato=urldecode($_GET['formato']);}
else { $formato = 'svg'; }
}
else { $formato= 'svg';} 

if (isset($_GET['contenido']))
{  $contenido=urldecode($_GET['contenido']); }
else { $contenido= 'no has enviado la variable contenido';} 

if (isset($_GET['calidad']))
{  $calidad=urldecode($_GET['calidad']);  }
else {$calidad= 'M'; } 

if (isset($_GET['tamanio']))
{  $tamanio=urldecode($_GET['tamanio']);  }
else {$tamanio= 8 ; } 

if (isset($_GET['borde']))
{  $borde=urldecode($_GET['borde']);  }
else {$borde= 1; } 

//Enviamos los parametros a la Función para generar código QR 
  QRcode::$formato($contenido, false, $calidad, $tamanio, $borde);
?>