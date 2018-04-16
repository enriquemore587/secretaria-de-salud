<?php
	require_once("../modelos/consultas.php");
	$funcion = $_POST['funcion'];

	if($funcion =='botones')
	{
		$valor = $_POST['valor'];
		$instancia = new Consultas();
		$r=$instancia -> botones($valor);
		echo json_encode($r);
	}
	if($funcion=='ubicaciones')
	{
		$valor = $_POST['valor'];
		$instancia = new Consultas();
		$r=$instancia -> ubicaciones($valor);
		echo json_encode($r);
	}

	if($funcion == 1)
	{
		$valor = $_POST['valor'];
		$array = explode("|", $valor);
		if ($array[0] == 'unidades') {
			$instancia = new Consultas();
			$r=$instancia -> _1($valor);
			echo json_encode($r);
		}else if ($array[0]  == 'servicios') {
			$instancia = new Consultas();
			$r=$instancia -> _2($valor);
			echo json_encode($r);
		}else if ($array[0]  == 'afeccion_principal') {
			$instancia = new Consultas();
			$r=$instancia -> _afeccion_principal($valor);
			echo json_encode($r);
		}else if ($array[0]  == 'registros') {
			$instancia = new Consultas();
			$r=$instancia -> registros($valor);
			echo json_encode($r);
		}

	}
	if($funcion == 1.1)
	{
		$valor = $_POST['valor'];

		$array = explode("|", $valor);

		if ($array[0] == 'TODOS LOS SERVICIOS') {
			$instancia = new Consultas();
			$r=$instancia -> _12($valor);
			echo json_encode($r);
		}else{
			$instancia = new Consultas();
			$r=$instancia -> _11($valor);
			echo json_encode($r);
		}
	}
	if($funcion == 1.2)
	{

		$valor = $_POST['valor'];

		$array = explode("|", $valor);

		if ($array[0] == 'TODOS LOS SERVICIOS') {
			$instancia = new Consultas();
			$r=$instancia -> _13_servicio($valor);
			echo json_encode($r);
		}else if ($array[0] == 'SERVICIOS EGRESO'){
			$instancia = new Consultas();
			$r=$instancia -> _14_servicio($valor);
			echo json_encode($r);
		}else if ($array[0] == 'SERVICIOS INGRESO'){
			$instancia = new Consultas();
			$r=$instancia -> _15_servicio($valor);
			echo json_encode($r);
		}
	}
	if($funcion == 1.3)
    	{
    		$valor = $_POST['valor'];

    		$array = explode("|", $valor);

    		$array2 = explode("*", $array[0]);

    		if ($array2[1] == 'TODOS LOS SERVICIOS') {
    			$instancia = new Consultas();
    			$r=$instancia -> _16_servicio($valor);
    			echo json_encode($r);
    		}else if ($array2[1] == 'SERVICIOS EGRESO'){
    			$instancia = new Consultas();
    			$r=$instancia -> _17_servicio($valor);
    			echo json_encode($r);
    		}else if ($array2[1] == 'SERVICIOS INGRESO'){
    			$instancia = new Consultas();
    			$r=$instancia -> _18_servicio($valor);
    			echo json_encode($r);
    		}
    	}
    if($funcion == 1.31)
    	{
    		$valor = $_POST['valor'];

    		$array = explode("|", $valor);

    		$array2 = explode("*", $array[0]);


            $instancia = new Consultas();
            $r=$instancia -> _16_afeccion($valor);
            echo json_encode($r);

    	}
	if ($funcion == 1.4)
	{
		$valor = $_POST['valor'];
		$instancia = new Consultas();
		$r=$instancia -> unidadesEstancia($valor);
		echo json_encode($r);
	}
	if ($funcion == "getDelegaciones")
    	{
    		$valor = $_POST['valor'];
    		$instancia = new Consultas();
    		$r=$instancia -> getDelegaciones($valor);
    		echo json_encode($r);
    	}

	if ($funcion == 1.5)
	{
		$valor = $_POST['valor'];
		$instancia = new Consultas();
		$r=$instancia -> cantidad1_5($valor);
		echo json_encode($r);
	}
	if ($funcion == 1.51)
	{
		$valor = $_POST['valor'];
		$instancia = new Consultas();
		$r=$instancia -> cantidad1_51($valor);
		echo json_encode($r);
	}
	if ($funcion == "ubicacionesServicios")
        	{
        		$valor = $_POST['valor'];

        		$array = explode("|", $valor);

        		$array2 = explode("*", $array[0]);

        		if ($array2[2] == 'TODOS LOS SERVICIOS') {
        			$instancia = new Consultas();
        			$r=$instancia -> ubicacionesServicios1($valor);
        			echo json_encode($r);
        		}else if ($array2[2] == 'SERVICIOS EGRESO'){
        			$instancia = new Consultas();
        			$r=$instancia -> ubicacionesServicios2($valor);
        			echo json_encode($r);
        		}else if ($array2[2] == 'SERVICIOS INGRESO'){
        			$instancia = new Consultas();
        			$r=$instancia -> ubicacionesServicios3($valor);
        			echo json_encode($r);
        		}
        	}

    if ($funcion == "lugaresServicioEnfermedad")
            	{
            		$valor = $_POST['valor'];

            		$array = explode("|", $valor);

            		$array2 = explode("*", $array[0]);

            		if ($array2[2] == 'TODOS LOS SERVICIOS') {
            			$instancia = new Consultas();
            			$r=$instancia -> lugaresServicioEnfermedad1($valor);
            			echo json_encode($r);
            		}else if ($array2[2] == 'SERVICIOS EGRESO'){
            			$instancia = new Consultas();
            			$r=$instancia -> lugaresServicioEnfermedad2($valor);
            			echo json_encode($r);
            		}else if ($array2[2] == 'SERVICIOS INGRESO'){
            			$instancia = new Consultas();
            			$r=$instancia -> lugaresServicioEnfermedad3($valor);
            			echo json_encode($r);
            		}
            	}

    if ($funcion == "ubicacionesEnfermedades")
        	{
        		$valor = $_POST['valor'];

        		$array = explode("|", $valor);

        		$array2 = explode("*", $array[0]);

        		if ($array2[2] == 'TODOS LOS SERVICIOS') {
        			$instancia = new Consultas();
        			$r=$instancia -> ubicacionesEnfermedades1($valor);
        			echo json_encode($r);
        		}else if ($array2[2] == 'SERVICIOS EGRESO'){
        			$instancia = new Consultas();
        			$r=$instancia -> ubicacionesEnfermedades2($valor);
        			echo json_encode($r);
        		}else if ($array2[2] == 'SERVICIOS INGRESO'){
        			$instancia = new Consultas();
        			$r=$instancia -> ubicacionesEnfermedades3($valor);
        			echo json_encode($r);
        		}
        	}

    if ($funcion == "enfermedadesServicios")
            	{
            		$valor = $_POST['valor'];

            		$array = explode("|", $valor);

            		$array2 = explode("*", $array[0]);

            		if ($array2[2] == 'TODOS LOS SERVICIOS') {
            			$instancia = new Consultas();
            			$r=$instancia -> enfermedadesServicios1($valor);
            			echo json_encode($r);
            		}else if ($array2[2] == 'SERVICIOS EGRESO'){
            			$instancia = new Consultas();
            			$r=$instancia -> enfermedadesServicios2($valor);
            			echo json_encode($r);
            		}else if ($array2[2] == 'SERVICIOS INGRESO'){
            			$instancia = new Consultas();
            			$r=$instancia -> enfermedadesServicios3($valor);
            			echo json_encode($r);
            		}
            	}
            	if ($funcion == "servicios_enfermedades")
                            	{
                            		$valor = $_POST['valor'];

                            		$array = explode("|", $valor);

                            		$array2 = explode("*", $array[0]);

                            		if ($array2[2] == 'TODOS LOS SERVICIOS') {
                            			$instancia = new Consultas();
                            			$r=$instancia -> servicios_enfermedades1($valor);
                            			echo json_encode($r);
                            		}else if ($array2[2] == 'SERVICIOS EGRESO'){
                            			$instancia = new Consultas();
                            			$r=$instancia -> servicios_enfermedades2($valor);
                            			echo json_encode($r);
                            		}else if ($array2[2] == 'SERVICIOS INGRESO'){
                            			$instancia = new Consultas();
                            			$r=$instancia -> servicios_enfermedades3($valor);
                            			echo json_encode($r);
                            		}
                            	}
    if ($funcion == "dataChart")
                	{
                		$valor = $_POST['valor'];

                		$array = explode("|", $valor);

                		$array2 = explode("*", $array[0]);

                		if ($array2[2] == 'TODOS LOS SERVICIOS') {
                			$instancia = new Consultas();
                			$r=$instancia -> dataChart1($valor);
                			echo json_encode($r);
                		}else if ($array2[2] == 'SERVICIOS EGRESO'){
                			$instancia = new Consultas();
                			$r=$instancia -> dataChart2($valor);
                			echo json_encode($r);
                		}else if ($array2[2] == 'SERVICIOS INGRESO'){
                			$instancia = new Consultas();
                			$r=$instancia -> dataChart3($valor);
                			echo json_encode($r);
                		}
                	}
    if ($funcion == "dataChart_afeccion")
                    	{
                    		$valor = $_POST['valor'];

                    		$array = explode("|", $valor);

                    		$array2 = explode("*", $array[0]);

                    		if ($array2[2] == 'TODOS LOS SERVICIOS') {
                    			$instancia = new Consultas();
                    			$r=$instancia -> dataChart_afeccion1($valor);
                    			echo json_encode($r);
                    		}else if ($array2[2] == 'SERVICIOS EGRESO'){
                    			$instancia = new Consultas();
                    			$r=$instancia -> dataChart_afeccion2($valor);
                    			echo json_encode($r);
                    		}else if ($array2[2] == 'SERVICIOS INGRESO'){
                    			$instancia = new Consultas();
                    			$r=$instancia -> dataChart_afeccion3($valor);
                    			echo json_encode($r);
                    		}
                    	}
    if ($funcion == "mapa1")
                    	{
                    		$valor = $_POST['valor'];

                    		$array = explode("|", $valor);

                    		$array2 = explode("*", $array[0]);

                    		if ($array2[2] == 'TODOS LOS SERVICIOS') {
                    			$instancia = new Consultas();
                    			$r=$instancia -> mapa11($valor);
                    			echo json_encode($r);
                    		}else if ($array2[2] == 'SERVICIOS EGRESO'){
                    			$instancia = new Consultas();
                    			$r=$instancia -> mapa12($valor);
                    			echo json_encode($r);
                    		}else if ($array2[2] == 'SERVICIOS INGRESO'){
                    			$instancia = new Consultas();
                    			$r=$instancia -> mapa13($valor);
                    			echo json_encode($r);
                    		}
                    	}
    if ($funcion == "mapa2")
                            	{
                            		$valor = $_POST['valor'];

                            		$array = explode("|", $valor);

                            		$array2 = explode("*", $array[0]);

                            		if ($array2[2] == 'TODOS LOS SERVICIOS') {
                            			$instancia = new Consultas();
                            			$r=$instancia -> mapa21($valor);
                            			echo json_encode($r);
                            		}else if ($array2[2] == 'SERVICIOS EGRESO'){
                            			$instancia = new Consultas();
                            			$r=$instancia -> mapa22($valor);
                            			echo json_encode($r);
                            		}else if ($array2[2] == 'SERVICIOS INGRESO'){
                            			$instancia = new Consultas();
                            			$r=$instancia -> mapa23($valor);
                            			echo json_encode($r);
                            		}
                            	}
    if ($funcion == "mapa3")
                        	{
                        		$valor = $_POST['valor'];

                        		$array = explode("|", $valor);

                        		$array2 = explode("*", $array[0]);

                        		if ($array2[2] == 'TODOS LOS SERVICIOS') {
                        			$instancia = new Consultas();
                        			$r=$instancia -> mapa31($valor);
                        			echo json_encode($r);
                        		}else if ($array2[2] == 'SERVICIOS EGRESO'){
                        			$instancia = new Consultas();
                        			$r=$instancia -> mapa32($valor);
                        			echo json_encode($r);
                        		}else if ($array2[2] == 'SERVICIOS INGRESO'){
                        			$instancia = new Consultas();
                        			$r=$instancia -> mapa33($valor);
                        			echo json_encode($r);
                        		}
                        	}
    if ($funcion == "grafoGeneral")
                	{
                		$valor = $_POST['valor'];

                		$array = explode("|", $valor);

                		$array2 = explode("*", $array[0]);

                		if ($array2[2] == 'TODOS LOS SERVICIOS') {
                			$instancia = new Consultas();
                			$r=$instancia -> grafoGeneral1($valor);
                			echo json_encode($r);
                		}else if ($array2[2] == 'SERVICIOS EGRESO'){
                			$instancia = new Consultas();
                			$r=$instancia -> grafoGeneral2($valor);
                			echo json_encode($r);
                		}else if ($array2[2] == 'SERVICIOS INGRESO'){
                			$instancia = new Consultas();
                			$r=$instancia -> grafoGeneral3($valor);
                			echo json_encode($r);
                		}
                	}
            	if ($funcion == "dataChartEnfermedad")
                {
                    $valor = $_POST['valor'];
                    $instancia = new Consultas();
                    $r=$instancia -> dataChartEnfermedad($valor);
                    echo json_encode($r);

                }

    if ($funcion == "numRegistros")
            	{
            		$valor = $_POST['valor'];

            		$array = explode("|", $valor);

            		$array2 = explode("*", $array[0]);

            		if ($array2[2] == 'TODOS LOS SERVICIOS') {
            			$instancia = new Consultas();
            			$r=$instancia -> numRegistros1($valor);
            			echo json_encode($r);
            		}else if ($array2[2] == 'SERVICIOS EGRESO'){
            			$instancia = new Consultas();
            			$r=$instancia -> numRegistros2($valor);
            			echo json_encode($r);
            		}else if ($array2[2] == 'SERVICIOS INGRESO'){
            			$instancia = new Consultas();
            			$r=$instancia -> numRegistros3($valor);
            			echo json_encode($r);
            		}
            	}
            	if ($funcion == "numRegistros_enfermedades")
                        	{
                        		$valor = $_POST['valor'];

                        		$array = explode("|", $valor);

                        		$array2 = explode("*", $array[0]);

                        		if ($array2[2] == 'TODOS LOS SERVICIOS') {
                        			$instancia = new Consultas();
                        			$r=$instancia -> numRegistros_enfermedades1($valor);
                        			echo json_encode($r);
                        		}else if ($array2[2] == 'SERVICIOS EGRESO'){
                        			$instancia = new Consultas();
                        			$r=$instancia -> numRegistros_enfermedades2($valor);
                        			echo json_encode($r);
                        		}else if ($array2[2] == 'SERVICIOS INGRESO'){
                        			$instancia = new Consultas();
                        			$r=$instancia -> numRegistros_enfermedades3($valor);
                        			echo json_encode($r);
                        		}
                        	}
?>