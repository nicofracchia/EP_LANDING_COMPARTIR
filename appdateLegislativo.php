<?php

	/* ***** CONEXION ***** */
	//$hostBD = 'prowebsolutions.com.ar';
	//$usuarioBD = 'pwGeneral';
	//$passBD = '123456321asd';
	//$baseBD = 'appdateLegislativo';
	$hostBD = 'localhost';
	$usuarioBD = 'prowebsolutions';
	$passBD = '123456321asd';
	$baseBD = 'appdate';
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
?>

<!DOCTYPE html>
<html> 
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="css/estilos.css" />
		<title> Appdate Legislativo</title>
		<meta property="og:url" content="esferapublica.com.ar<?php echo $_SERVER["REQUEST_URI"]; ?>" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="<?php echo $RES['tema'].' - '.$RES['titulo']; ?>" />
		<meta property="og:description" content="<?php echo str_replace('"',"'",strip_tags($RES['texto'])); ?>" />
		<?php 
			if(isset($RES['imagen']) and $RES['imagen'] != ''){
				echo "<meta property='og:image' content='".$RES['imagen']."' />";
			}
		?>
		<meta name="twitter:site" value="@eppw"/>
		<meta name="twitter:creator" content="@eppw">
		<meta name="twitter:description" content="<?php echo str_replace('"',"'",strip_tags($RES['texto'])); ?>"/>
		<?php 
			if(isset($RES['imagen']) and $RES['imagen'] != ''){
				echo "<meta name='twitter:image' content='".$RES['imagen']."' />";
			}
		?>
		<meta name="twitter:title" content="<?php echo $RES['tema'].' - '.$RES['titulo']; ?>"/>
	</head>
	<body>
		<div class='soloHead'><img src='images/soloHead.png' alt='' /></div>
		<div id='contCel'>
			<div class='contenedorNoticia'>
				<div class='fecha'>
					<span class='txtRojo'><?php echo $fecha; ?></span>
					<span class='txtAzul'><?php echo $RES['tema']; ?></span>
				</div>
				<div class='titulo'>
					<?php echo $RES['titulo']; ?>
				</div>
				<div class='varios'>
					<?php
						if(isset($RES['secciones']) and $RES['secciones'] != ''){
							echo "<span class='txtNegro'>SECCIONES:</span> <span class='txtRojo'>".$RES['secciones']."</span> | ";
						}
						if(isset($RES['personas']) and $RES['personas'] != ''){
							echo "<span class='txtNegro'>EN ESTA NOTA:</span> <span class='txtRojo'>".$RES['personas']."</span> | ";
						}
						if(isset($RES['legislaturas']) and $RES['legislaturas'] != ''){
							echo "<span class='txtNegro'>DISTRITOS:</span> <span class='txtRojo'>".$RES['legislaturas']."</span> | ";
						}
						if(isset($RES['distrito']) and $RES['distrito'] != ''){
							echo "<span class='txtNegro'>OTRO:</span> <span class='txtRojo'>".$RES['distrito']."</span> | ";
						}
					?>
				</div>
				<div class='imagen'>
					<?php 
						if(isset($RES['imagen']) and $RES['imagen'] != ''){
							echo "<img src='".$RES['imagen']."' id='nImagen' />";
						}
					?>
				</div>
				<div class='contenido'>
					<?php if(isset($RES['texto'])){echo $RES['texto'];} ?>
				</div>
				<div class='masinfo'>
					MÁS INFO
				</div>
			</div>
		
		</div>
		<div id='bannerTiendas'> 
			Appdate está pensado para tu celular. Descargá la APP desde las Tiendas Oficiales. ¡Es gratis y lo seguirá siendo!!!!
			<div style="clear:both;"> </div>
			<a href='https://play.google.com/store/apps/details?id=com.prowebsolutions.appdatelegislativo' target='_blank'><img src='images/playstore.png' /><a/>
			<a href='https://itunes.apple.com/us/app/appdate-legislativo/id1459810250?ls=1&mt=8' target='_blank'><img src='images/ios.png' /></a>
		</div>
	
		<div id='blanco'></div>
		<div class='soloFoot'><img src='images/soloFoot2.png' alt='' /></div>
	</body>
</html>