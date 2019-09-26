<?php
namespace App;

class Funciones{


	public static function dump( $data ){

	  print '<pre>';
	  print_r($data);
	  print '</pre>';

	}


	public static function extension_archivo( $archivo ) {

		$res = explode(".", $archivo);
		$extension = $res[count($res)-1];
		return $extension ;

	}

	public static function MostrarDia_Espaniol( $DIAIngles ) {

		$DIATexto = '';

		switch ($DIAIngles) {
            case "Monday":
                $DIATexto =  "Lunes";
                break;
            case "Tuesday":
                $DIATexto =  "Martes";
                break;
            case "Wednesday":
                $DIATexto =  "Miércoles";
                break;
            case "Thursday":
                $DIATexto =  "Jueves";
                break;
            case "Friday":
                $DIATexto =  "Viernes";
                break;
            case "Saturday":
                $DIATexto =  "Sábado";
                break;
            case "Sunday":
                $DIATexto =  "Domingo";
                break;
        }

		return $DIATexto ;

	}


    public static function Cambiar_fecha_a_Normal ( $fecha_Hora ){  
	

		if(strlen(trim($fecha_Hora))> 0){ 

			if(strlen(trim($fecha_Hora))=='10'){
				$fecha_Hora_ok = $fecha_Hora." 00:00:00";
			}else if(strlen(trim($fecha_Hora))>'10'){
				$fecha_Hora_ok = $fecha_Hora;
			}

			list($fecha,$hora)=explode(" ",$fecha_Hora_ok);		
			list($year,$month,$day)=explode("-",$fecha);

			if(checkdate((int)$month,(int)$day,(int)$year)){		
				$lafecha = $day."-".$month."-".$year;
			}else{
				$lafecha = NULL;
			}

		}else{
			$lafecha = NULL;
		}
		
		return  $lafecha ; 
		
		/*
		ereg (  "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})" ,  $fecha ,  $mifecha );  
		$lafecha = $mifecha [ 3 ]. "-" . $mifecha [ 2 ]. "-" . $mifecha [ 1 ];
		if($lafecha == '--') $lafecha = '';
		return  $lafecha ;  
		*/
	}


	public static function Cambiar_fecha_a_Mysql ( $fecha_Hora ){  

		if(strlen(trim($fecha_Hora))> 0){ 

			if(strlen(trim($fecha_Hora))=='10'){
				$fecha_Hora_ok = $fecha_Hora." 00:00:00";
			}else if(strlen(trim($fecha_Hora))>'10'){
				$fecha_Hora_ok = $fecha_Hora;
			}
			
			list($fecha,$hora)=explode(" ",$fecha_Hora_ok);	
			list($day,$month,$year)=explode("-",$fecha);

			
			if(checkdate((int)$month,(int)$day,(int)$year)){		
				$lafecha = $year."-".$month."-".$day;
			}else{
				$lafecha = NULL;
			}

		}else{
			$lafecha = NULL;
		}
		
		return  $lafecha;
		
		/*
		ereg (  "([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})" ,  $fecha ,  $mifecha );  
		$lafecha = $mifecha [ 3 ]. "-" . $mifecha [ 2 ]. "-" . $mifecha [ 1 ];  
		if($lafecha == '--') $lafecha = '';
		return  $lafecha ;  
		*/
	}


	public static function cambiar_Fecha_a_SqlServer ( $fecha_Hora ){  
	
		if(strlen(trim($fecha_Hora))> 0){ 

			if(strlen(trim($fecha_Hora))=='10'){
				$fecha_Hora_ok = $fecha_Hora." 00:00:00";
			}else if(strlen(trim($fecha_Hora))>'10'){
				$fecha_Hora_ok = $fecha_Hora;
			}

			list($fecha,$hora)=explode(" ",$fecha_Hora_ok);		
			list($day,$month,$year)=explode("-",$fecha);

			if(checkdate((int)$month,(int)$day,(int)$year)){		
				$lafecha = $month."-".$day."-".$year;
			}else{
				$lafecha = NULL;
			}

		}else{
			$lafecha = NULL;
		}
		
		return  $lafecha; 
		
		/*
		ereg (  "([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})" ,  $fecha ,  $mifecha );  
		$lafecha =  $mifecha [ 2 ]. "-" . $mifecha [ 1 ]. "-" .$mifecha [ 3 ];  
	    if($lafecha == '--') $lafecha = '';
		return  $lafecha ;  
		*/
	}



	public static function Reducir_Imagen($ruta1,$ruta2,$ancho,$alto)
    {
	    # se obtene la dimension y tipo de imagen
	    $datos=getimagesize ($ruta1);
	    
	    $ancho_orig = $datos[0]; # Anchura de la imagen original
	    $alto_orig = $datos[1];    # Altura de la imagen original
	    $tipo = $datos[2];
    
	    if ($tipo==1){ # GIF
	        if (function_exists("imagecreatefromgif"))
	            $img = imagecreatefromgif($ruta1);
	        else
	            return false;
	    }else if ($tipo==2){ # JPG
	        if (function_exists("imagecreatefromjpeg"))
	            $img = imagecreatefromjpeg($ruta1);
	        else
	            return false;
	    }else if ($tipo==3){ # PNG
	        if (function_exists("imagecreatefrompng"))
	            $img = imagecreatefrompng($ruta1);
	        else
	            return false;
	    }
    
	    # Se calculan las nuevas dimensiones de la imagen
	    if ($ancho_orig>$alto_orig)
	        {
	        $ancho_dest=$ancho;
	        $alto_dest=($ancho_dest/$ancho_orig)*$alto_orig;
	    }else{
	        $alto_dest=$alto;
	        $ancho_dest=($alto_dest/$alto_orig)*$ancho_orig;
	    }

	    // imagecreatetruecolor, solo estan en G.D. 2.0.1 con PHP 4.0.6+
	    $img2=@imagecreatetruecolor($ancho_dest,$alto_dest) or $img2=imagecreate($ancho_dest,$alto_dest);

	    // Redimensionar
	    // imagecopyresampled, solo estan en G.D. 2.0.1 con PHP 4.0.6+
	    @imagecopyresampled($img2,$img,0,0,0,0,$ancho_dest,$alto_dest,$ancho_orig,$alto_orig) or imagecopyresized($img2,$img,0,0,0,0,$ancho_dest,$alto_dest,$ancho_orig,$alto_orig);

	    // Crear fichero nuevo, según extensión.
	    if ($tipo==1) // GIF
	        if (function_exists("imagegif"))
	            imagegif($img2, $ruta2);
	        else
	            return false;

	    if ($tipo==2) // JPG
	        if (function_exists("imagejpeg"))
	            imagejpeg($img2, $ruta2);
	        else
	            return false;

	    if ($tipo==3)  // PNG
	        if (function_exists("imagepng"))
	            imagepng($img2, $ruta2);
	        else
	            return false;
    
    	return true;
    } 


}