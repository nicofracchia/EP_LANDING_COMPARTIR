<?php
		/* ***** CONEXION ***** */
	if($_SERVER['SERVER_NAME'] == 'localhost'){
		$hostBD = 'localhost';
		$usuarioBD = 'root';
		$passBD = '';
		$baseBD = 'appdateLegislativo';
	}else{
		$hostBD = 'prowebsolutions.com.ar';
		$usuarioBD = 'pwGeneral';
		$passBD = '123456321asd';
		$baseBD = 'appdateLegislativo';
	}
	if($_SERVER['SERVER_NAME'] == 'esferapublica.com.ar'){
		$hostBD = 'localhost';
		$usuarioBD = 'prowebsolutions';
		$passBD = '123456321asd';
		$baseBD = 'appdate';
	}
	$conexion = mysqli_connect($hostBD,$usuarioBD,$passBD,$baseBD);

	$SQL = "SELECT * FROM noticias WHERE id = '".$_REQUEST['ID']."'";
	$RS = mysqli_query($conexion, $SQL);
	$RES = mysqli_fetch_array($RS);
	
	
	$SQL_SECCIONES = "SELECT * FROM secciones WHERE";
	$secciones = explode('|',$RES['secciones']);
	foreach($secciones as $s){
		if($s != ''){
			$SQL_SECCIONES .= " id = '".$s."' OR ";
		}
	}
	$SQL_SECCIONES .= " id = 'cvsxs'";
	$RS_SECCIONES = mysqli_query($conexion, $SQL_SECCIONES);
	$RES['secciones'] = '';
	while($s = mysqli_fetch_object($RS_SECCIONES)){
		$RES['secciones'] .= $s->seccion." | ";
	}
	$RES['secciones'] = substr($RES['secciones'],0,-2);
	
	$SQL_LEGISLATURAS = "SELECT * FROM legislaturas WHERE";
	$legislaturas = explode('|',$RES['legislaturas']);
	foreach($legislaturas as $l){
		if($l != ''){
			$SQL_LEGISLATURAS .= " id = '".$l."' OR ";
		}
	}
	$SQL_LEGISLATURAS .= " id = 'cvsxs'";
	$RS_LEGISLATURAS = mysqli_query($conexion, $SQL_LEGISLATURAS);
	$RES['legislaturas'] = '';
	while($l = mysqli_fetch_object($RS_LEGISLATURAS)){
		$RES['legislaturas'] .= $l->legislatura." | ";
	}
	$RES['legislaturas'] = substr($RES['legislaturas'],0,-2);
	$RES = array_map("utf8_encode", $RES);
	
	$fecha = explode('-',$RES['fecha']);
	$fecha = $fecha[2].'/'.$fecha[1].'/'.$fecha[0];



	$to = $_REQUEST['mailCompartir'];
	$subject = strtoupper($RES['tema']).' - '.$RES['titulo'];

	$headers = "From: AppDate Legislativo - EP <appdate@esferapublica.com.ar>\r\n";
	$headers .= "Reply-To: appdate@esferapublica.com.ar\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message  = "<html><head><style type='text/css'>body {-webkit-touch-callout: none;-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;/* overflow:hidden; */}html, body{min-height:100%;width:100%;padding:0;margin:0;font-family:Ebrima;padding-top:32px;padding-bottom:30px;background:#FEFEFE;font-family:calibri;}html,body,div,span,p,table,tr,td,input,a,ul,li,select{box-sizing:border-box;}/** ***** TABLA NOTICIAS ***** **/.tablaNoticias{width:100%;margin-top:10px;border-spacing: 0;border-collapse: collapse;}.tablaNoticias td{padding:0 10px;}.tablaNoticias .tituloPrincipal{font-size:20px;color:#b9273d;font-weight:bold;padding-bottom:10px;}.tablaNoticias .filtrosNoticias{width:250px;text-align:right;}.tablaNoticias .filtrosNoticias img{margin-right:10px;width:35px;}.tablaNoticias .contNoticia{box-shadow: 0 15px 10px -10px #CCC;}.tablaNoticias .contNoticia .txtNoticia{vertical-align:top;}.tablaNoticias .txtNoticia .datosNoticia{width:100%;padding:3px 0;padding-top:20px;font-size:12px;}.tablaNoticias .txtNoticia .datosNoticia .legislaturaNoticia{color:#0b62b4;text-transform:uppercase;}.tablaNoticias .txtNoticia .datosNoticia .seccionNoticia{color:#b70b25;}.tablaNoticias .contNoticia .txtNoticia .tituloNoticia{width:100%;padding:3px 0;padding-top:0;font-size:15px;color:#3b0211;font-weight:bold;}.tablaNoticias .contNoticia .txtNoticia .resumenNoticia{width:100%;padding:3px 0;font-size:12px;color:#272926;}.tablaNoticias .contNoticia .txtNoticia .tiempoNoticia{width:100%;padding-bottom:20px;font-size:10px;color:#0b62b4;}.tablaNoticias .contNoticia .imgNoticia{text-align:center;font-size:12px;color:#0b62b4;width:30%;vertical-align:top;}.tablaNoticias .contNoticia .imgNoticia img{width:100%;margin-top:5px;margin-bottom:15px;box-shadow: 0px 0px 10px 3px #CCC;}#contenedorInternaNoticias #tablaNoticiaInterna #compartirRedes{display:none;width:270px;height:50px;position:absolute;top:40px;right:80px;background:rgba(0,0,0,0.9);padding:2px;z-index:8;}#contenedorInternaNoticias #tablaNoticiaInterna #compartirRedes a{text-decoration:none;}#contenedorInternaNoticias #tablaNoticiaInterna #compartirRedes img{width:auto;height:46px;margin:0 20px;}#contenedorInternaNoticias #tablaNoticiaInterna #noticiaMail{display:none;position:absolute;width:270px;height:auto;top:90px;right:80px;background:rgba(0,0,0,0.9);padding:2px;z-index:8;}#contenedorInternaNoticias #tablaNoticiaInterna #noticiaMail input[type=text]{width:137px;padding:5px;background:#FFF;border:none;border-radius:10px;font-size:20px;}#contenedorInternaNoticias #tablaNoticiaInterna #noticiaMail input[type=text]::-webkit-input-placeholder{color: #b70b25;text-align:center;}#contenedorInternaNoticias #tablaNoticiaInterna #noticiaMail input[type=text]::-moz-placeholder{color: #b70b25;text-align:center;}#contenedorInternaNoticias #tablaNoticiaInterna #noticiaMail input[type=text]:-ms-input-placeholder{color: #b70b25;text-align:center;}#contenedorInternaNoticias #tablaNoticiaInterna #noticiaMail input[type=text]:-moz-placeholder{color: #b70b25;text-align:center;}#contenedorInternaNoticias #tablaNoticiaInterna #noticiaMail input[type=button]{padding:10px 20px;width:128px;color:#FFF;font-size:18px;border-radius:10px;border:none;background:rgba(41,36,46,0.95);}/** ***** INTERNA NOTICIAS ***** **/#tablaNoticiaInterna {border-spacing:0;padding:0 10px;}#tablaNoticiaInterna #iconos{text-align:right;padding:0 10px;padding-right: 25px;padding-top: 10px;}#tablaNoticiaInterna #iconos img{width:20px;margin:10px 20px;margin-right:0;}#tablaNoticiaInterna #seccion1{padding:20px 0;font-size:13px;}#tablaNoticiaInterna .rojo{color:#9a081d;}#tablaNoticiaInterna .azul{color:#0b62b4;}#tablaNoticiaInterna .negro{color:#2c2c2c;}#tablaNoticiaInterna #titulo{font-size:15px;color:#2c2c2c;font-weight:bold;padding:0;text-transform:uppercase;}#tablaNoticiaInterna #seccion2{font-size:11px;padding:20px 0;}#tablaNoticiaInterna #seccion3{font-size:11px;padding:10px 0;/* border-top:solid 1px #0b62b4; */border-bottom:solid 1px #0b62b4;vertical-align:top;}#tablaNoticiaInterna #imagen{padding:10px 0;border-top:solid 1px #0b62b4;border-bottom:solid 1px #0b62b4;text-align:right;padding-bottom: 6px;}#tablaNoticiaInterna #imagen img{width:100%;}#tablaNoticiaInterna #contenido{color:#2c2c2c;font-size:15px;padding:20px 0;}#tablaNoticiaInterna #verMas{color:#0b62b4;text-align:right;padding:10px 0;font-size:15px;padding-bottom:20px;padding-right:35px;}</style></head>";
$message .= "<body>";
$message .= "<table id='tablaNoticiaInterna'>";
$message .= "	<tr>";
$message .= "		<td style='text-align:center;'>".utf8_decode("Te han compartido información desde APPDATE Legislativo! Descargala vos también!")."</td>";
$message .= "	</tr>";
$message .= "	<tr>";
$message .= "		<td id='seccion1' colspan='2'>";
$message .= "			<span class='rojo' id='nFecha'>".$fecha."</span> <span class='azul' id='nTema'>".utf8_decode($RES['tema'])."</span>";
$message .= "		</td>";
$message .= "	</tr>";
$message .= "	<tr>";
$message .= "		<td id='titulo' colspan='2'>".utf8_decode($RES['titulo'])."</td>";
$message .= "	</tr>";
$message .= "	<tr>";
$message .= "		<td id='seccion2' colspan='2'>";
if(isset($RES['secciones']) and $RES['secciones'] != ''){
$message .= "			<span class='negro'>SECCIONES:</span> <span class='rojo'>".utf8_decode($RES['secciones'])."</span> | ";
}
if(isset($RES['personas']) and $RES['personas'] != ''){
$message .= "			<span class='negro'>EN ESTA NOTA:</span> <span class='rojo'>".utf8_decode($RES['personas'])."</span> | ";
}
if(isset($RES['legislaturas']) and $RES['legislaturas'] != ''){
$message .= "			<span class='negro'>DISTRITOS</span> <span class='rojo'>".utf8_decode($RES['legislaturas'])."</span> | ";
}
if(isset($RES['distrito']) and $RES['distrito'] != ''){
$message .= "			<span class='negro'>OTRO:</span> <span class='rojo'>".utf8_decode($RES['distrito'])."</span> | ";
}
$message .= "		</td>";
$message .= "	</tr>";
$message .= "	<tr>";
$message .= "		<td id='imagen' colspan=2>";
if(isset($RES['imagen']) and $RES['imagen'] != ''){
$message .= "			<img src='".$RES['imagen']."' id='nImagen' />";
}
$message .= "		</td>";
$message .= "	</tr>";
$message .= "	<tr>";
$message .= "		<td id='contenido' colspan='2'>";
if(isset($RES['texto'])){
$message .= 			utf8_decode($RES['texto']);
}
$message .= "		</td>";
$message .= "	</tr>";
$message .= "</table>";
$message .= "</body></html>";

if(mail($to, $subject, $message, $headers)){
	echo 'El mensaje se envio correctamente!';
}else{
	echo 'Hubo un error enviando el mensaje. Por favor intente nuevamente mas tarde.';
}
?>
