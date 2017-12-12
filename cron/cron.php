<?php

    $link=new mysqli("localhost","root","","yungay_db") or die('Error conectando la DB');;
      
	$sql_principal ="select id_convocatoria,fecha_inicio,fecha_termino,id_estadoConvocatoria from convocatoria";
	$result=$link->query($sql_principal);



    date_default_timezone_set('America/Santiago');
    $fecha_actual= getdate();
    $fecha_hoy_formato= ''.$fecha_actual['year'].'-'.$fecha_actual['mon'].'-'.$fecha_actual['mday'];
    $fecha_hoy_final= date('Y-m-d', strtotime($fecha_hoy_formato));
	
	 while ($row =$result->fetch_assoc()) {
	 	if($row['id_estadoConvocatoria'] != 4){
			if($row['fecha_inicio']>=$fecha_hoy_final){
				$sql="update convocatoria set id_estadoConvocatoria=1 where id_convocatoria=".$row['id_convocatoria'];
				$link->query($sql);
			}
			if($row['fecha_termino']<=$fecha_hoy_final){
				$sql="update convocatoria set id_estadoConvocatoria=2 where id_convocatoria=".$row['id_convocatoria'];
				$link->query($sql);
			}
		} 
			
    }
   $link->close();
        



?>