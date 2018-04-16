<?php 
	require ("conexionMysql.php");

	class Consultas extends Conexion
	{
 
		public function Consultas(){
			parent::__construct();
		}
		#CLUES,NOMBRE,EGRESO,afeccion_principal
		public function botones($valor)
		{
			$resultado="";
			if ($valor == "servicios") {
			    $resultado= $this->conexion_db->query('SELECT  distinct servicio_ingreso FROM principal.egre_filtrados order by servicio_ingreso asc');
			} elseif ($valor == "unidades") {
			    $resultado= $this->conexion_db->query('SELECT  distinct nombre FROM principal.egre_filtrados order by nombre asc;');
			}
			$datos= $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
		}

		function get_range($cadena){
			$array = explode("|", $cadena);
			$array2 = explode(" - ", $array[1]);
			$sql = " (ingre between '".$array2[0]."' and '".$array2[1]."')";
			return $sql;
		}

		public function getDelegaciones($valor)
        		{
                    $sql = "select distinct delegacion from lugares where nombre in (".$valor."'')";
                    $resultado= $this->conexion_db->query($sql);
                    $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                    return $datos;

        		}

		public function ubicacionesServicios1($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);

			$array = explode("|", $valor);

			$array2 = explode("*", $array[0]);
			if ($array2[0] == "AMBAS ESTANCIAS") {
				$sql = "(SELECT distinct nombre FROM principal.egre_filtrados where servicio_ingreso = '".$array2[1]."' and ".$fecha." ) UNION (SELECT distinct nombre FROM principal.egre_filtrados where servicio_egreso = '".$array2[1]."' and ".$fecha.") order by nombre";
    			$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}else if ($array2[0] == "CORTA ESTANCIA") {
				$sql = "(SELECT distinct nombre FROM principal.egre_filtrados where servicio_ingreso = '".$array2[1]."' and ".$fecha."  and tipo_servicio != 'NORMAL' ) UNION (SELECT distinct nombre FROM principal.egre_filtrados where servicio_egreso = '".$array2[1]."' and ".$fecha."  and tipo_servicio != 'NORMAL') order by nombre";

				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}else if ($array2[0] == "NORMAL") {
				$sql = "(SELECT distinct nombre FROM principal.egre_filtrados where servicio_ingreso = '".$array2[1]."' and ".$fecha."  and tipo_servicio = 'NORMAL' ) UNION (SELECT distinct nombre FROM principal.egre_filtrados where servicio_egreso = '".$array2[1]."' and ".$fecha."  and tipo_servicio = 'NORMAL') order by nombre";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}
		}

		public function ubicacionesServicios2($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);

			$array = explode("|", $valor);
			$array2 = explode("*", $array[0]);
			if ($array2[0] == "AMBAS ESTANCIAS") {
				$sql = "SELECT distinct nombre FROM principal.egre_filtrados where servicio_egreso = '".$array2[1]."' and ".$fecha." order by nombre";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}else if ($array2[0] == "CORTA ESTANCIA") {
				$sql = "SELECT distinct nombre FROM principal.egre_filtrados where servicio_egreso = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL' order by nombre";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}else if ($array2[0] == "NORMAL") {
				$sql = "SELECT distinct nombre FROM principal.egre_filtrados where servicio_egreso = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL' order by nombre";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}

		}



		public function ubicacionesServicios3($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);

			$array = explode("|", $valor);

			$array2 = explode("*", $array[0]);
			if ($array2[0] == "AMBAS ESTANCIAS") {
				$sql = "SELECT distinct nombre FROM principal.egre_filtrados where servicio_ingreso = '".$array2[1]."' and ".$fecha." order by nombre";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}else if ($array2[0] == "CORTA ESTANCIA") {
				$sql = "SELECT distinct nombre FROM principal.egre_filtrados where servicio_ingreso = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL' order by nombre";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}else if ($array2[0] == "NORMAL") {
				$sql = "SELECT distinct nombre FROM principal.egre_filtrados where servicio_ingreso = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL' order by nombre";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}
			
		}

		#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		public function lugaresServicioEnfermedad1($valor)
        		{
        			$instancia = new Consultas();
        			$fecha =$instancia -> get_range($valor);

        			$array = explode("|", $valor);

        			$array2 = explode("*", $array[0]);
        			if ($array2[0] == "AMBAS ESTANCIAS") {
        				$sql = "select nombre, count(*) as total from principal.tablaDesc2 where (servicio_ingreso ='".$array2[3]."' or servicio_egreso = '".$array2[3]."')and afeccion_principal ='".$array2[1]."' group by nombre order by total desc";
            			$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}else if ($array2[0] == "CORTA ESTANCIA") {
        				$sql = "select nombre, count(*) as total from principal.tablaDesc2 where (servicio_ingreso ='".$array2[3]."' or servicio_egreso = '".$array2[3]."')  and tipo_servicio != 'NORMAL' and afeccion_principal ='".$array2[1]."' group by nombre order by total desc";

        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}else if ($array2[0] == "NORMAL") {
        				$sql = "select nombre, count(*) as total from principal.tablaDesc2 where (servicio_ingreso ='".$array2[3]."' or servicio_egreso = '".$array2[3]."')  and tipo_servicio = 'NORMAL' and afeccion_principal ='".$array2[1]."' group by nombre order by total desc";
        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}
        		}

        		public function lugaresServicioEnfermedad2($valor)
        		{
        			$instancia = new Consultas();
        			$fecha =$instancia -> get_range($valor);

        			$array = explode("|", $valor);
        			$array2 = explode("*", $array[0]);
        			if ($array2[0] == "AMBAS ESTANCIAS") {
        				$sql = "select nombre, count(*) as total from principal.tablaDesc2 where servicio_egreso = '".$array2[3]."' and afeccion_principal ='".$array2[1]."' group by nombre order by total desc";
        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}else if ($array2[0] == "CORTA ESTANCIA") {

        				$sql = "select nombre, count(*) as total from principal.tablaDesc2 where servicio_egreso = '".$array2[3]."'  and tipo_servicio != 'NORMAL' and afeccion_principal ='".$array2[1]."' group by nombre order by total desc";
        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}else if ($array2[0] == "NORMAL") {
        				$sql = "select nombre, count(*) as total from principal.tablaDesc2 where servicio_egreso = '".$array2[3]."'  and tipo_servicio = 'NORMAL' and afeccion_principal ='".$array2[1]."' group by nombre order by total desc";
        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}

        		}



        		public function lugaresServicioEnfermedad3($valor)
        		{
        			$instancia = new Consultas();
        			$fecha =$instancia -> get_range($valor);

        			$array = explode("|", $valor);

        			$array2 = explode("*", $array[0]);
        			if ($array2[0] == "AMBAS ESTANCIAS") {
        				$sql = "select nombre, count(*) as total from principal.tablaDesc2 where servicio_ingreso = '".$array2[3]."' and afeccion_principal ='".$array2[1]."' group by nombre order by total desc";
        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}else if ($array2[0] == "CORTA ESTANCIA") {

        				$sql = "select nombre, count(*) as total from principal.tablaDesc2 where servicio_ingreso = '".$array2[3]."'  and tipo_servicio != 'NORMAL' and afeccion_principal ='".$array2[1]."' group by nombre order by total desc";
        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}else if ($array2[0] == "NORMAL") {

        				$sql = "select nombre, count(*) as total from principal.tablaDesc2 where servicio_ingreso = '".$array2[3]."'  and tipo_servicio = 'NORMAL' and afeccion_principal ='".$array2[1]."' group by nombre order by total desc";
        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}

        		}
		#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

		############################3
		public function ubicacionesEnfermedades1($valor)
        		{
        			$instancia = new Consultas();
        			$fecha =$instancia -> get_range($valor);

        			$array = explode("|", $valor);

        			$array2 = explode("*", $array[0]);
        			if ($array2[0] == "AMBAS ESTANCIAS") {
        				$sql = "(SELECT distinct nombre FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha." ) UNION (SELECT distinct nombre FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha.") order by nombre";
            			$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}else if ($array2[0] == "CORTA ESTANCIA") {
        				$sql = "(SELECT distinct nombre FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha."  and tipo_servicio != 'NORMAL' ) UNION (SELECT distinct nombre FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha."  and tipo_servicio != 'NORMAL') order by nombre";

        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}else if ($array2[0] == "NORMAL") {
        				$sql = "(SELECT distinct nombre FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha."  and tipo_servicio = 'NORMAL' ) UNION (SELECT distinct nombre FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha."  and tipo_servicio = 'NORMAL') order by nombre";
        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}
        		}

        		public function ubicacionesEnfermedades2($valor)
        		{
        			$instancia = new Consultas();
        			$fecha =$instancia -> get_range($valor);

        			$array = explode("|", $valor);
        			$array2 = explode("*", $array[0]);
        			if ($array2[0] == "AMBAS ESTANCIAS") {
        				$sql = "SELECT distinct nombre FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha." order by nombre";
        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}else if ($array2[0] == "CORTA ESTANCIA") {
        				$sql = "SELECT distinct nombre FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL' order by nombre";
        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}else if ($array2[0] == "NORMAL") {
        				$sql = "SELECT distinct nombre FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL' order by nombre";
        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}

        		}



        		public function ubicacionesEnfermedades3($valor)
        		{
        			$instancia = new Consultas();
        			$fecha =$instancia -> get_range($valor);

        			$array = explode("|", $valor);

        			$array2 = explode("*", $array[0]);
        			if ($array2[0] == "AMBAS ESTANCIAS") {
        				$sql = "SELECT distinct nombre FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha." order by nombre";
        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}else if ($array2[0] == "CORTA ESTANCIA") {
        				$sql = "SELECT distinct nombre FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL' order by nombre";
        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}else if ($array2[0] == "NORMAL") {
        				$sql = "SELECT distinct nombre FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL' order by nombre";
        				$resultado= $this->conexion_db->query($sql);
        				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
        				return $datos;
        			}

        		}
		###########################333333
    public function enfermedadesServicios1($valor)
    {
        $instancia = new Consultas();
        $fecha =$instancia -> get_range($valor);

        $array = explode("|", $valor);

        $array2 = explode("*", $array[0]);
        if ($array2[0] == "AMBAS ESTANCIAS") {
            #$sql = "(SELECT count(distinct afeccion_principal) as afeccion_principal FROM principal.egre_filtrados where (servicio_ingreso = '".$array2[1]."' or servicio_egreso = '".$array2[1]."' ) and ".$fecha." )";
            $sql = "(SELECT distinct afeccion_principal FROM principal.egre_filtrados where (servicio_ingreso = '".$array2[1]."' or servicio_egreso = '".$array2[1]."' ) and ".$fecha." )";
            $resultado= $this->conexion_db->query($sql);
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            return $datos;
        }else if ($array2[0] == "CORTA ESTANCIA") {
            #$sql = "(SELECT count(distinct afeccion_principal) as afeccion_principal  FROM principal.egre_filtrados where (servicio_ingreso = '".$array2[1]."' or servicio_egreso = '".$array2[1]."' )  and ".$fecha."  and tipo_servicio != 'NORMAL' ) ";
            $sql = "(SELECT distinct afeccion_principal FROM principal.egre_filtrados where (servicio_ingreso = '".$array2[1]."' or servicio_egreso = '".$array2[1]."' )  and ".$fecha."  and tipo_servicio != 'NORMAL' ) ";
            $resultado= $this->conexion_db->query($sql);
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            return $datos;
        }else if ($array2[0] == "NORMAL") {
            #$sql = "(SELECT count(distinct afeccion_principal) as afeccion_principal  FROM principal.egre_filtrados where (servicio_ingreso = '".$array2[1]."' or servicio_egreso = '".$array2[1]."' )  and ".$fecha."  and tipo_servicio = 'NORMAL' ) ";
            $sql = "(SELECT distinct afeccion_principal FROM principal.egre_filtrados where (servicio_ingreso = '".$array2[1]."' or servicio_egreso = '".$array2[1]."' )  and ".$fecha."  and tipo_servicio = 'NORMAL' ) ";
            $resultado= $this->conexion_db->query($sql);
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            return $datos;
        }
    }
    public function enfermedadesServicios2($valor)
        {
            $instancia = new Consultas();
            $fecha =$instancia -> get_range($valor);

            $array = explode("|", $valor);
            $array2 = explode("*", $array[0]);
            if ($array2[0] == "AMBAS ESTANCIAS") {
                #$sql = "SELECT count(distinct afeccion_principal) as afeccion_principal  FROM principal.egre_filtrados where servicio_egreso = '".$array2[1]."' and ".$fecha;
                $sql = "SELECT distinct afeccion_principal   FROM principal.egre_filtrados where servicio_egreso = '".$array2[1]."' and ".$fecha;
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }else if ($array2[0] == "CORTA ESTANCIA") {
                #$sql = "SELECT count(distinct afeccion_principal) as afeccion_principal  FROM principal.egre_filtrados where servicio_egreso = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL'";
                $sql = "SELECT distinct afeccion_principal FROM principal.egre_filtrados where servicio_egreso = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL'";
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }else if ($array2[0] == "NORMAL") {
                #$sql = "SELECT count(distinct afeccion_principal) as afeccion_principal FROM principal.egre_filtrados where servicio_egreso = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL'";
                $sql = "SELECT distinct afeccion_principal FROM principal.egre_filtrados where servicio_egreso = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL'";
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }
        }
        public function enfermedadesServicios3($valor)
        {
            $instancia = new Consultas();
            $fecha =$instancia -> get_range($valor);

            $array = explode("|", $valor);

            $array2 = explode("*", $array[0]);
            if ($array2[0] == "AMBAS ESTANCIAS") {
                #$sql = "SELECT count(distinct afeccion_principal) as afeccion_principal FROM principal.egre_filtrados where servicio_ingreso = '".$array2[1]."' and ".$fecha;
                $sql = "SELECT distinct afeccion_principal FROM principal.egre_filtrados where servicio_ingreso = '".$array2[1]."' and ".$fecha;
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }else if ($array2[0] == "CORTA ESTANCIA") {
                #$sql = "SELECT count(distinct afeccion_principal) as afeccion_principal FROM principal.egre_filtrados where servicio_ingreso = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL'";
                $sql = "SELECT distinct afeccion_principal FROM principal.egre_filtrados where servicio_ingreso = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL'";
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }else if ($array2[0] == "NORMAL") {
                #$sql = "SELECT count(distinct afeccion_principal) as afeccion_principal FROM principal.egre_filtrados where servicio_ingreso = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL'";
                $sql = "SELECT distinct afeccion_principal FROM principal.egre_filtrados where servicio_ingreso = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL'";
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }

        }


        ##################################################################666666666666666666666666666666666666666666666666
        public function servicios_enfermedades1($valor)
            {
                $instancia = new Consultas();
                $fecha =$instancia -> get_range($valor);

                $array = explode("|", $valor);

                $array2 = explode("*", $array[0]);
                if ($array2[0] == "AMBAS ESTANCIAS") {
                    $sql = "SELECT distinct servicio_egreso FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."'  and ".$fecha;
                    $resultado= $this->conexion_db->query($sql);
                    $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                    return $datos;
                }else if ($array2[0] == "CORTA ESTANCIA") {
                    $sql = "SELECT distinct servicio_egreso FROM principal.egre_filtrados where (afeccion_principal = '".$array2[1]."' and ".$fecha.") and tipo_servicio != 'NORMAL'";
                    $resultado= $this->conexion_db->query($sql);
                    $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                    return $datos;
                }else if ($array2[0] == "NORMAL") {
                    $sql = "SELECT distinct servicio_egreso FROM principal.egre_filtrados where (afeccion_principal = '".$array2[1]."' and ".$fecha.") and tipo_servicio = 'NORMAL'";
                    $resultado= $this->conexion_db->query($sql);
                    $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                    return $datos;
                }
            }
            public function servicios_enfermedades2($valor)
                {
                    $instancia = new Consultas();
                    $fecha =$instancia -> get_range($valor);

                    $array = explode("|", $valor);
                    $array2 = explode("*", $array[0]);
                    if ($array2[0] == "AMBAS ESTANCIAS") {

                        $sql = "SELECT distinct servicio_egreso   FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha;
                        $resultado= $this->conexion_db->query($sql);
                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                        return $datos;
                    }else if ($array2[0] == "CORTA ESTANCIA") {

                        $sql = "SELECT distinct servicio_egreso FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL'";
                        $resultado= $this->conexion_db->query($sql);
                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                        return $datos;
                    }else if ($array2[0] == "NORMAL") {

                        $sql = "SELECT distinct servicio_egreso FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL'";
                        $resultado= $this->conexion_db->query($sql);
                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                        return $datos;
                    }
                }
                public function servicios_enfermedades3($valor)
                {
                    $instancia = new Consultas();
                    $fecha =$instancia -> get_range($valor);

                    $array = explode("|", $valor);

                    $array2 = explode("*", $array[0]);
                    if ($array2[0] == "AMBAS ESTANCIAS") {

                        $sql = "SELECT distinct servicio_ingreso as servicio_egreso FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha;
                        $resultado= $this->conexion_db->query($sql);
                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                        return $datos;
                    }else if ($array2[0] == "CORTA ESTANCIA") {

                        $sql = "SELECT distinct servicio_ingreso as servicio_egreso FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL'";
                        $resultado= $this->conexion_db->query($sql);
                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                        return $datos;
                    }else if ($array2[0] == "NORMAL") {

                        $sql = "SELECT distinct servicio_ingreso asservicio_egreso  FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL'";
                        $resultado= $this->conexion_db->query($sql);
                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                        return $datos;
                    }

                }
        ###################################################################666666666666666666666666666666666666666666666666
		public function ubicaciones($valor)
		{
			$sql= "SELECT * FROM principal.lugares";
			
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
		}
		public function unicio($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);
			
			$sql = "SELECT distinct nombre FROM principal.egre_filtrados where ".$fecha." order by nombre";
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
		}
		
		public function unidadesEstancia($valor)
		{
			$instancia = new Consultas();
			$array = explode("|", $valor);
			$fecha =$instancia -> get_range($valor);

			if ($array[0] == "NORMAL") {
				$sql = "SELECT nombre FROM principal.lugares where nombre in (select NOMBRE from egre_filtrados where tipo_servicio = 'NORMAL' and ".$fecha.")";
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
			}else if ($array[0] == "CORTA ESTANCIA") {
				$sql = "SELECT nombre FROM principal.lugares where nombre in (select NOMBRE from egre_filtrados where tipo_servicio != 'NORMAL' and ".$fecha.")";
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
			}else if ($array[0] == "AMBAS ESTANCIAS"){
			$sql = "SELECT nombre FROM principal.lugares where nombre in (select NOMBRE from egre_filtrados where ".$fecha.")";
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
			}
		}
		public function cantidad1_5($valor)
		{
			$instancia = new Consultas();
			$array = explode("|", $valor);
			$fecha =$instancia -> get_range($valor);

			if ($array[0] == "NORMAL") {
				$sql = "SELECT count(*) AS registros from egre_filtrados where tipo_servicio = 'NORMAL' and ".$fecha;
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
			}else if ($array[0] == "CORTA ESTANCIA") {
				$sql = "SELECT count(*) AS registros from egre_filtrados where  tipo_servicio != 'NORMAL' and ".$fecha;
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
			}else if ($array[0] == "AMBAS ESTANCIAS"){
			$sql = "SELECT  count(*) AS registros from egre_filtrados where ".$fecha;
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
			}
		}
		public function cantidad1_51($valor)
		{
			$instancia = new Consultas();
			$array = explode("|", $valor);
			$fecha =$instancia -> get_range($valor);

			if ($array[0] == "NORMAL") {
				$sql = "SELECT count(distinct afeccion_principal) AS afeccion_principal from egre_filtrados where tipo_servicio = 'NORMAL' and ".$fecha;
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
			}else if ($array[0] == "CORTA ESTANCIA") {
				$sql = "SELECT count(distinct afeccion_principal) AS afeccion_principal from egre_filtrados where  tipo_servicio != 'NORMAL' and ".$fecha;
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
			}else if ($array[0] == "AMBAS ESTANCIAS"){
			$sql = "SELECT  count(distinct afeccion_principal) AS afeccion_principal from egre_filtrados where ".$fecha;
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
			}
		}
		public function _afeccion_principal($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);
			
			$sql = "SELECT distinct afeccion_principal FROM principal.egre_filtrados where ".$fecha."";

			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
		}
		public function registros($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);
			
			$sql = "SELECT count(*) as registros FROM principal.egre_filtrados where ".$fecha."";

			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
		}


		public function _1($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);
			
			$sql = "SELECT distinct nombre FROM principal.egre_filtrados where ".$fecha." order by nombre";
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
		}
		public function _2($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);
			
			$sql = "(SELECT distinct servicio_egreso FROM principal.egre_filtrados  where ".$fecha." ) UNION (SELECT distinct servicio_ingreso FROM principal.egre_filtrados where ".$fecha." )ORDER BY servicio_egreso";
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
		}
		public function _3($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);
			
			$sql = "SELECT distinct afeccion_principal FROM principal.egre_filtrados where ".$fecha." order by afeccion_principal";
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
		}

		public function _11($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);
			
			$sql = "SELECT distinct tipo_servicio FROM principal.egre_filtrados where ".$fecha." order by tipo_servicio";
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
		}
		public function _12($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);
			$sql = "(select distinct tipo_servicio from principal.egre_filtrados where ".$fecha." ) UNION (SELECT distinct tipo_servicio FROM principal.egre_filtrados where ".$fecha." ) order by tipo_servicio asc";
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
		}
		public function _13_servicio($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);
			
			$sql = "(SELECT distinct servicio_egreso FROM principal.egre_filtrados  where ".$fecha." ) UNION (SELECT distinct servicio_ingreso FROM principal.egre_filtrados where ".$fecha." ) ORDER BY servicio_egreso";
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
		}
		public function _14_servicio($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);
			
			$sql = "select distinct servicio_egreso from principal.egre_filtrados where ".$fecha." order by servicio_egreso";
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
		}
		public function _15_servicio($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);
			
			$sql = "select distinct servicio_ingreso as servicio_egreso from principal.egre_filtrados where ".$fecha." order by servicio_ingreso";
			$resultado= $this->conexion_db->query($sql);
			$datos = $resultado->fetch_all(MYSQLI_ASSOC);
			return $datos;
		}
		public function _16_servicio($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);

			$array = explode("|", $valor);

			$array2 = explode("*", $array[0]);
			if ($array2[0] == 'AMBAS ESTANCIAS') {
				$sql = "(SELECT distinct servicio_egreso FROM principal.egre_filtrados  where ".$fecha." ) UNION (SELECT distinct servicio_ingreso  as servicio_egreso FROM principal.egre_filtrados where ".$fecha.")  ORDER BY servicio_egreso";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}else
			if ($array2[0] == 'NORMAL') {
				$sql = "(SELECT distinct servicio_egreso FROM principal.egre_filtrados  where ".$fecha." AND (tipo_servicio = 'NORMAL') ) UNION (SELECT distinct servicio_ingreso as servicio_egreso FROM principal.egre_filtrados where ".$fecha." AND (tipo_servicio = 'NORMAL'))  ORDER BY servicio_egreso";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}else{
				$sql = "(SELECT distinct servicio_egreso FROM principal.egre_filtrados  where ".$fecha." AND (tipo_servicio != 'NORMAL') ) UNION (SELECT distinct servicio_ingreso as servicio_egreso FROM principal.egre_filtrados where ".$fecha." AND (tipo_servicio != 'NORMAL') ) ORDER BY servicio_egreso";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}
		}
		public function _17_servicio($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);
			$array = explode("|", $valor);

			$array2 = explode("*", $array[0]);
			if ($array2[0] == 'AMBAS ESTANCIAS') {
				$sql = "select distinct servicio_egreso from principal.egre_filtrados where ".$fecha."  order by servicio_egreso";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}else
			if ($array2[0] == 'NORMAL') {
				$sql = "select distinct servicio_egreso from principal.egre_filtrados where ".$fecha." AND (tipo_servicio = 'NORMAL') order by servicio_egreso";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}else{
				$sql = "select distinct servicio_egreso from principal.egre_filtrados where ".$fecha." AND (tipo_servicio != 'NORMAL') order by servicio_egreso";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}
		}
		public function _18_servicio($valor)
		{
			$instancia = new Consultas();
			$fecha =$instancia -> get_range($valor);
			
			$array = explode("|", $valor);

			$array2 = explode("*", $array[0]);

			if ($array2[0] == 'AMBAS ESTANCIAS') {
				$sql = "select distinct servicio_ingreso as servicio_egreso from principal.egre_filtrados where ".$fecha."   order by servicio_ingreso";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}else
			if ($array2[0] == 'NORMAL') {
				$sql = "select distinct servicio_ingreso as servicio_egreso from principal.egre_filtrados where ".$fecha."  AND (tipo_servicio = 'NORMAL') order by servicio_ingreso";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}else{
				$sql = "select distinct servicio_ingreso as servicio_egreso from principal.egre_filtrados where ".$fecha." AND (tipo_servicio != 'NORMAL')  order by servicio_ingreso";
				$resultado= $this->conexion_db->query($sql);
				$datos = $resultado->fetch_all(MYSQLI_ASSOC);
				return $datos;
			}
		}
		public function _16_afeccion($valor)
        {
            $instancia = new Consultas();
            $fecha =$instancia -> get_range($valor);

            $array = explode("|", $valor);

            $array2 = explode("*", $array[0]);
            if ($array2[0] == 'AMBAS ESTANCIAS') {
                $sql = "SELECT distinct afeccion_principal FROM principal.egre_filtrados  where ".$fecha." order by afeccion_principal" ;
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }else
            if ($array2[0] == 'NORMAL') {
                #$sql = "SELECT distinct afeccion_principal FROM principal.egre_filtrados  where ".$fecha." AND (tipo_servicio = 'NORMAL')";
                $sql = "SELECT distinct afeccion_principal FROM principal.egre_filtrados  where ".$fecha." AND (tipo_servicio = 'NORMAL') order by afeccion_principal" ;
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }else{
                #$sql = "(SELECT distinct servicio_egreso FROM principal.egre_filtrados  where ".$fecha." AND (tipo_servicio != 'NORMAL') ) UNION (SELECT distinct servicio_ingreso FROM principal.egre_filtrados where ".$fecha." AND (tipo_servicio != 'NORMAL') ) ORDER BY servicio_egreso";
                $sql = "SELECT distinct afeccion_principal FROM principal.egre_filtrados  where ".$fecha."AND (tipo_servicio != 'NORMAL') order by afeccion_principal" ;
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }
        }

        ####################
        public function numRegistros1($valor)
            {
                $instancia = new Consultas();
                $fecha =$instancia -> get_range($valor);

                $array = explode("|", $valor);

                $array2 = explode("*", $array[0]);
                if ($array2[0] == "AMBAS ESTANCIAS") {
                    $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where (servicio_ingreso = '".$array2[1]."' or servicio_egreso = '".$array2[1]."' ) and ".$fecha;
                    $resultado= $this->conexion_db->query($sql);
                    $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                    return $datos;
                }else if ($array2[0] == "CORTA ESTANCIA") {
                    $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where (servicio_ingreso = '".$array2[1]."' or servicio_egreso = '".$array2[1]."' )  and ".$fecha."  and tipo_servicio != 'NORMAL'";
                    $resultado= $this->conexion_db->query($sql);
                    $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                    return $datos;
                }else if ($array2[0] == "NORMAL") {
                    $sql = "SELECT  count(*) as registros FROM principal.egre_filtrados where (servicio_ingreso = '".$array2[1]."' or servicio_egreso = '".$array2[1]."' )  and ".$fecha."  and tipo_servicio = 'NORMAL'";
                    $resultado= $this->conexion_db->query($sql);
                    $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                    return $datos;
                }
            }
            public function numRegistros2($valor)
                {
                    $instancia = new Consultas();
                    $fecha =$instancia -> get_range($valor);

                    $array = explode("|", $valor);
                    $array2 = explode("*", $array[0]);
                    if ($array2[0] == "AMBAS ESTANCIAS") {
                        $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where servicio_egreso = '".$array2[1]."' and ".$fecha;
                        $resultado= $this->conexion_db->query($sql);
                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                        return $datos;
                    }else if ($array2[0] == "CORTA ESTANCIA") {
                        $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where servicio_egreso = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL'";
                        $resultado= $this->conexion_db->query($sql);
                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                        return $datos;
                    }else if ($array2[0] == "NORMAL") {
                        $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where servicio_egreso = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL'";
                        $resultado= $this->conexion_db->query($sql);
                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                        return $datos;
                    }
                }
                public function numRegistros3($valor)
                {
                    $instancia = new Consultas();
                    $fecha =$instancia -> get_range($valor);

                    $array = explode("|", $valor);

                    $array2 = explode("*", $array[0]);
                    if ($array2[0] == "AMBAS ESTANCIAS") {
                        $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where servicio_ingreso = '".$array2[1]."' and ".$fecha;
                        $resultado= $this->conexion_db->query($sql);
                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                        return $datos;
                    }else if ($array2[0] == "CORTA ESTANCIA") {
                        $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where servicio_ingreso = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL'";
                        $resultado= $this->conexion_db->query($sql);
                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                        return $datos;
                    }else if ($array2[0] == "NORMAL") {
                        $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where servicio_ingreso = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL'";
                        $resultado= $this->conexion_db->query($sql);
                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                        return $datos;
                    }

                }
                ####################################################################


                #999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
                public function numRegistros_enfermedades1($valor)
                            {
                                $instancia = new Consultas();
                                $fecha =$instancia -> get_range($valor);

                                $array = explode("|", $valor);

                                $array2 = explode("*", $array[0]);
                                if ($array2[0] == "AMBAS ESTANCIAS") {
                                    $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where (afeccion_principal = '".$array2[1]."') and ".$fecha;
                                    $resultado= $this->conexion_db->query($sql);
                                    $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                    return $datos;
                                }else if ($array2[0] == "CORTA ESTANCIA") {
                                    $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where (afeccion_principal = '".$array2[1]."' )  and ".$fecha."  and tipo_servicio != 'NORMAL'";
                                    $resultado= $this->conexion_db->query($sql);
                                    $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                    return $datos;
                                }else if ($array2[0] == "NORMAL") {
                                    $sql = "SELECT  count(*) as registros FROM principal.egre_filtrados where (afeccion_principal = '".$array2[1]."')  and ".$fecha."  and tipo_servicio = 'NORMAL'";
                                    $resultado= $this->conexion_db->query($sql);
                                    $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                    return $datos;
                                }
                            }
                            public function numRegistros_enfermedades2($valor)
                                {
                                    $instancia = new Consultas();
                                    $fecha =$instancia -> get_range($valor);

                                    $array = explode("|", $valor);
                                    $array2 = explode("*", $array[0]);
                                    if ($array2[0] == "AMBAS ESTANCIAS") {
                                        $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha;
                                        $resultado= $this->conexion_db->query($sql);
                                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                        return $datos;
                                    }else if ($array2[0] == "CORTA ESTANCIA") {
                                        $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL'";
                                        $resultado= $this->conexion_db->query($sql);
                                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                        return $datos;
                                    }else if ($array2[0] == "NORMAL") {
                                        $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL'";
                                        $resultado= $this->conexion_db->query($sql);
                                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                        return $datos;
                                    }
                                }
                                public function numRegistros_enfermedades3($valor)
                                {
                                    $instancia = new Consultas();
                                    $fecha =$instancia -> get_range($valor);

                                    $array = explode("|", $valor);

                                    $array2 = explode("*", $array[0]);
                                    if ($array2[0] == "AMBAS ESTANCIAS") {
                                        $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha;
                                        $resultado= $this->conexion_db->query($sql);
                                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                        return $datos;
                                    }else if ($array2[0] == "CORTA ESTANCIA") {
                                        $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL'";
                                        $resultado= $this->conexion_db->query($sql);
                                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                        return $datos;
                                    }else if ($array2[0] == "NORMAL") {
                                        $sql = "SELECT count(*) as registros FROM principal.egre_filtrados where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL'";
                                        $resultado= $this->conexion_db->query($sql);
                                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                        return $datos;
                                    }

                                }
                #999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
                public function dataChart1($valor)
                    {
                        $instancia = new Consultas();
                        $fecha =$instancia -> get_range($valor);
                        $array = explode("|", $valor);
                        $array2 = explode("*", $array[0]);
                        if ($array2[0] == "AMBAS ESTANCIAS") {
                            $sql = "SELECT nombre, ingre, sum(TOTAL) as total FROM principal.cb_filtro where (servicio_ingreso = '".$array2[1]."' or servicio_egreso = '".$array2[1]."' ) and ".$fecha."   group by nombre, ingre";
                            $resultado= $this->conexion_db->query($sql);
                            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                            return $datos;
                        }else if ($array2[0] == "CORTA ESTANCIA") {
                            $sql = "SELECT nombre, ingre, sum(TOTAL) as total FROM principal.cb_filtro where (servicio_ingreso = '".$array2[1]."' or servicio_egreso = '".$array2[1]."' ) and ".$fecha."  and tipo_servicio != 'NORMAL'  group by nombre, ingre";
                            $resultado= $this->conexion_db->query($sql);
                            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                            return $datos;
                        }else if ($array2[0] == "NORMAL") {
                            $sql = "SELECT nombre, ingre, sum(TOTAL) as total FROM principal.cb_filtro where (servicio_ingreso = '".$array2[1]."' or servicio_egreso = '".$array2[1]."' ) and ".$fecha."  and tipo_servicio = 'NORMAL' group by nombre, ingre";
                            $resultado= $this->conexion_db->query($sql);
                            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                            return $datos;
                        }
                    }
                    public function dataChart2($valor)
                        {
                            $instancia = new Consultas();
                            $fecha =$instancia -> get_range($valor);

                            $array = explode("|", $valor);
                            $array2 = explode("*", $array[0]);
                            if ($array2[0] == "AMBAS ESTANCIAS") {
                                $sql = "SELECT nombre, ingre, sum(TOTAL) as total FROM principal.cb_filtro where servicio_egreso = '".$array2[1]."' and ".$fecha." group by nombre, ingre";
                                $resultado= $this->conexion_db->query($sql);
                                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                return $datos;
                            }else if ($array2[0] == "CORTA ESTANCIA") {
                                $sql = "SELECT nombre, ingre, sum(TOTAL) as total FROM principal.cb_filtro where servicio_egreso = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL' group by nombre, ingre";
                                $resultado= $this->conexion_db->query($sql);
                                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                return $datos;
                            }else if ($array2[0] == "NORMAL") {
                                $sql = "SELECT nombre, ingre, sum(TOTAL) as total FROM principal.cb_filtro where servicio_egreso = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL' group by nombre, ingre";
                                $resultado= $this->conexion_db->query($sql);
                                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                return $datos;
                            }
                        }
                        public function dataChart3($valor)
                        {
                            $instancia = new Consultas();
                            $fecha =$instancia -> get_range($valor);

                            $array = explode("|", $valor);

                            $array2 = explode("*", $array[0]);
                            if ($array2[0] == "AMBAS ESTANCIAS") {
                                $sql = "SELECT nombre, ingre, sum(TOTAL) as total FROM principal.cb_filtro where servicio_ingreso = '".$array2[1]."' and ".$fecha." group by nombre, ingre";
                                $resultado= $this->conexion_db->query($sql);
                                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                return $datos;
                            }else if ($array2[0] == "CORTA ESTANCIA") {
                                $sql = "SELECT nombre, ingre, sum(TOTAL) as total FROM principal.cb_filtro where servicio_ingreso = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL' group by nombre, ingre";
                                $resultado= $this->conexion_db->query($sql);
                                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                return $datos;
                            }else if ($array2[0] == "NORMAL") {
                                $sql = "SELECT nombre, ingre, sum(TOTAL) as total FROM principal.cb_filtro where servicio_ingreso = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL' group by nombre, ingre";
                                $resultado= $this->conexion_db->query($sql);
                                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                return $datos;
                            }
                        }
                        #***************************************************************
                        public function dataChart_afeccion1($valor)
                                            {
                                                $instancia = new Consultas();
                                                $fecha =$instancia -> get_range($valor);
                                                $array = explode("|", $valor);
                                                $array2 = explode("*", $array[0]);
                                                if ($array2[0] == "AMBAS ESTANCIAS") {
                                                    $sql = "(SELECT servicio_egreso as servicio_egreso, ingre, sum(TOTAL) as total FROM principal.cb_afeccionEgresos where (afeccion_principal = '".$array2[1]."') and ".$fecha." group by servicio_egreso, ingre) union (SELECT servicio_ingreso as servicio_egreso, ingre, sum(TOTAL) as total FROM principal.cb_afeccionIngresos where (afeccion_principal = '".$array2[1]."') and ".$fecha."  group by servicio_egreso, ingre)";
                                                    $resultado= $this->conexion_db->query($sql);
                                                    $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                                    return $datos;
                                                }else if ($array2[0] == "CORTA ESTANCIA") {
                                                    #$sql = "SELECT nombre, ingre, sum(TOTAL) as total FROM principal.cb_afeccionEgresos where (afeccion_principal = '".$array2[1]."') and ".$fecha."  and tipo_servicio != 'NORMAL'  group by nombre, ingre";
                                                    $sql ="(SELECT servicio_egreso as servicio_egreso, ingre, sum(TOTAL) as total FROM principal.cb_afeccionEgresos where (afeccion_principal = '".$array2[1]."') and ".$fecha." and tipo_servicio != 'NORMAL'  group by servicio_egreso, ingre) union (SELECT servicio_ingreso as servicio_egreso, ingre, sum(TOTAL) as total FROM principal.cb_afeccionIngresos where (afeccion_principal = '".$array2[1]."') and ".$fecha."  and tipo_servicio != 'NORMAL'  group by servicio_egreso, ingre)";
                                                    $resultado= $this->conexion_db->query($sql);
                                                    $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                                    return $datos;
                                                }else if ($array2[0] == "NORMAL") {

                                                    $sql ="(SELECT servicio_egreso as servicio_egreso, ingre, sum(TOTAL) as total FROM principal.cb_afeccionEgresos where (afeccion_principal = '".$array2[1]."') and ".$fecha." and tipo_servicio = 'NORMAL'  group by servicio_egreso, ingre) union (SELECT servicio_ingreso as servicio_egreso, ingre, sum(TOTAL) as total FROM principal.cb_afeccionIngresos where (afeccion_principal = '".$array2[1]."') and ".$fecha."  and tipo_servicio = 'NORMAL'  group by servicio_egreso, ingre)";
                                                    $resultado= $this->conexion_db->query($sql);
                                                    $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                                    return $datos;
                                                }
                                            }
                                            public function dataChart_afeccion2($valor)
                                                {
                                                    $instancia = new Consultas();
                                                    $fecha =$instancia -> get_range($valor);

                                                    $array = explode("|", $valor);
                                                    $array2 = explode("*", $array[0]);
                                                    if ($array2[0] == "AMBAS ESTANCIAS") {
                                                        $sql = "SELECT servicio_egreso, ingre, sum(TOTAL) as total FROM principal.cb_afeccionEgresos where afeccion_principal = '".$array2[1]."' and ".$fecha." group by servicio_egreso, ingre";
                                                        $resultado= $this->conexion_db->query($sql);
                                                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                                        return $datos;
                                                    }else if ($array2[0] == "CORTA ESTANCIA") {
                                                        $sql = "SELECT servicio_egreso, ingre, sum(TOTAL) as total FROM principal.cb_afeccionEgresos where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL' group by servicio_egreso, ingre";
                                                        $resultado= $this->conexion_db->query($sql);
                                                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                                        return $datos;
                                                    }else if ($array2[0] == "NORMAL") {
                                                        $sql = "SELECT servicio_egreso, ingre, sum(TOTAL) as total FROM principal.cb_afeccionEgresos where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL' group by servicio_egreso, ingre";
                                                        $resultado= $this->conexion_db->query($sql);
                                                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                                        return $datos;
                                                    }
                                                }
                                                public function dataChart_afeccion3($valor)
                                                {
                                                    $instancia = new Consultas();
                                                    $fecha =$instancia -> get_range($valor);

                                                    $array = explode("|", $valor);

                                                    $array2 = explode("*", $array[0]);
                                                    if ($array2[0] == "AMBAS ESTANCIAS") {
                                                        $sql = "SELECT servicio_ingreso as servicio_egreso, ingre, sum(TOTAL) as total FROM principal.cb_afeccionIngresos where afeccion_principal = '".$array2[1]."' and ".$fecha." group by servicio_egreso, ingre";
                                                        $resultado= $this->conexion_db->query($sql);
                                                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                                        return $datos;
                                                    }else if ($array2[0] == "CORTA ESTANCIA") {
                                                        $sql = "SELECT servicio_ingreso as servicio_egreso, ingre, sum(TOTAL) as total FROM principal.cb_afeccionIngresos where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL' group by servicio_egreso, ingre";
                                                        $resultado= $this->conexion_db->query($sql);
                                                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                                        return $datos;
                                                    }else if ($array2[0] == "NORMAL") {
                                                        $sql = "SELECT servicio_ingreso as servicio_egreso, ingre, sum(TOTAL) as total FROM principal.cb_afeccionIngresos where afeccion_principal = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL' group by servicio_egreso, ingre";
                                                        $resultado= $this->conexion_db->query($sql);
                                                        $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                                        return $datos;
                                                    }
                                                }
                        #***************************************************************
################################################################################################################################
public function grafoGeneral1($valor)
                    {
                        $instancia = new Consultas();
                        $fecha =$instancia -> get_range($valor);

                        $array = explode("|", $valor);

                        $array2 = explode("*", $array[0]);
                        if ($array2[0] == "AMBAS ESTANCIAS") {
                            $sql = "SELECT nombre, afeccion_principal, sexo, sum(TOTAL) as total FROM principal.tablaDesc2 where (servicio_ingreso = '".$array2[1]."' or servicio_egreso = '".$array2[1]."' ) and ".$fecha." group by nombre, afeccion_principal, sexo order by total desc";
                            $resultado= $this->conexion_db->query($sql);
                            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                            return $datos;
                        }else if ($array2[0] == "CORTA ESTANCIA") {
                            $sql = "SELECT nombre, afeccion_principal, sexo, sum(TOTAL) as total FROM principal.tablaDesc2 where (servicio_ingreso = 'DERMATOLOGIA' or servicio_egreso = 'DERMATOLOGIA' )  and ".$fecha." and tipo_servicio != 'NORMAL'  group by nombre, afeccion_principal, sexo order by total desc";
                            $resultado= $this->conexion_db->query($sql);
                            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                            return $datos;
                        }else if ($array2[0] == "NORMAL") {
                            $sql = "SELECT nombre, afeccion_principal, sexo, sum(TOTAL) as total FROM principal.tablaDesc2 where (servicio_ingreso = 'CARDIOLOGIA' or servicio_egreso = 'CARDIOLOGIA' ) and ".$fecha." and tipo_servicio = 'NORMAL'  group by nombre, afeccion_principal, sexo order by total desc";
                            $resultado= $this->conexion_db->query($sql);
                            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                            return $datos;
                        }
                    }
                    public function grafoGeneral2($valor)
                        {
                            $instancia = new Consultas();
                            $fecha =$instancia -> get_range($valor);

                            $array = explode("|", $valor);
                            $array2 = explode("*", $array[0]);
                            if ($array2[0] == "AMBAS ESTANCIAS") {
                                $sql = "SELECT nombre, afeccion_principal, sexo, sum(TOTAL) as total FROM principal.tablaDesc2 where servicio_egreso = '".$array2[1]."' and ".$fecha."   group by nombre, afeccion_principal, sexo order by total desc";
                                $resultado= $this->conexion_db->query($sql);
                                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                return $datos;
                            }else if ($array2[0] == "CORTA ESTANCIA") {
                                $sql = "SELECT nombre, afeccion_principal, sexo, sum(TOTAL) as total FROM principal.tablaDesc2 where servicio_egreso = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL' group by nombre, afeccion_principal, sexo order by total desc";
                                $resultado= $this->conexion_db->query($sql);
                                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                return $datos;
                            }else if ($array2[0] == "NORMAL") {
            $sql = "SELECT nombre, afeccion_principal, sexo, sum(TOTAL) as total FROM principal.tablaDesc2 where servicio_egreso = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL' group by nombre, afeccion_principal, sexo order by total desc";
            $resultado= $this->conexion_db->query($sql);
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            return $datos;
        }
                        }
                        public function grafoGeneral3($valor)
                        {
                            $instancia = new Consultas();
                            $fecha =$instancia -> get_range($valor);

                            $array = explode("|", $valor);

                            $array2 = explode("*", $array[0]);
                            if ($array2[0] == "AMBAS ESTANCIAS") {
                                $sql = "SELECT nombre, afeccion_principal, sexo, sum(TOTAL) as total FROM principal.tablaDesc2 where servicio_ingreso = '".$array2[1]."' and ".$fecha."   group by nombre, afeccion_principal, sexo order by total desc";
                                $resultado= $this->conexion_db->query($sql);
                                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                return $datos;
                            }else if ($array2[0] == "CORTA ESTANCIA") {
                                $sql = "SELECT nombre, afeccion_principal, sexo, sum(TOTAL) as total FROM principal.tablaDesc2 where servicio_ingreso = '".$array2[1]."' and ".$fecha." and tipo_servicio != 'NORMAL' group by nombre, afeccion_principal, sexo order by total desc";
                                $resultado= $this->conexion_db->query($sql);
                                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                return $datos;
                            }else if ($array2[0] == "NORMAL") {
                                $sql = "SELECT nombre, afeccion_principal, sexo, sum(TOTAL) as total FROM principal.tablaDesc2 where servicio_ingreso = '".$array2[1]."' and ".$fecha." and tipo_servicio = 'NORMAL' group by nombre, afeccion_principal, sexo order by total desc";
                                $resultado= $this->conexion_db->query($sql);
                                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                return $datos;
                            }
                        }
################################################################################################################################
                        	public function dataChartEnfermedad($valor)
                            {
                                $instancia = new Consultas();
                                $fecha =$instancia -> get_range($valor);

                                $array = explode("|", $valor);

                                $sql = "select nombre, ingre, sum(TOTAL) as total from principal.cb_enfermedades where ".$fecha." and afeccion_principal = '".$array[0]."' group by nombre, ingre";
                                #$sql = "select nombre, ingre, sum(TOTAL) as total from cb_enfermedades group by nombre, ingre limit 0,5";
                                $resultado= $this->conexion_db->query($sql);
                                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                                return $datos;
                            }

public function mapa11($valor)
    {
        $instancia = new Consultas();
        $fecha =$instancia -> get_range($valor);
        $array = explode("|", $valor);
        $array2 = explode("*", $array[0]);
        if ($array2[0] == "AMBAS ESTANCIAS") {
            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND (servicio_egreso = '".$array2[1]."' or servicio_ingreso = '".$array2[1]."') AND ".$fecha." group by nombre ORDER BY total desc";
            $resultado= $this->conexion_db->query($sql);
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            return $datos;
        }else if ($array2[0] == "CORTA ESTANCIA") {
            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND (servicio_egreso = '".$array2[1]."' or servicio_ingreso = '".$array2[1]."') AND ".$fecha." and tipo_servicio != 'NORMAL' group by nombre ORDER BY total desc";

            $resultado= $this->conexion_db->query($sql);
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            return $datos;
        }else if ($array2[0] == "NORMAL") {
            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND (servicio_egreso = '".$array2[1]."' or servicio_ingreso = '".$array2[1]."') AND ".$fecha." and tipo_servicio = 'NORMAL' group by nombre ORDER BY total desc";
            $resultado= $this->conexion_db->query($sql);
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            return $datos;
        }
    }
    public function mapa12($valor)
        {
            $instancia = new Consultas();
            $fecha =$instancia -> get_range($valor);

            $array = explode("|", $valor);
            $array2 = explode("*", $array[0]);
            if ($array2[0] == "AMBAS ESTANCIAS") {
                $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND servicio_egreso = '".$array2[1]."' AND ".$fecha." group by nombre ORDER BY total desc";
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }else if ($array2[0] == "CORTA ESTANCIA") {
                $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND servicio_egreso = '".$array2[1]."' AND ".$fecha." and tipo_servicio != 'NORMAL' group by nombre ORDER BY total desc";
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }else if ($array2[0] == "NORMAL") {
                $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND servicio_egreso = '".$array2[1]."' AND ".$fecha." and tipo_servicio = 'NORMAL' group by nombre ORDER BY total desc";
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }
        }
        public function mapa13($valor)
        {
            $instancia = new Consultas();
                        $fecha =$instancia -> get_range($valor);

                        $array = explode("|", $valor);
                        $array2 = explode("*", $array[0]);
                        if ($array2[0] == "AMBAS ESTANCIAS") {
                            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND servicio_ingreso = '".$array2[1]."' AND ".$fecha." group by nombre ORDER BY total desc";
                            $resultado= $this->conexion_db->query($sql);
                            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                            return $datos;
                        }else if ($array2[0] == "CORTA ESTANCIA") {
                            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND servicio_ingreso = '".$array2[1]."' AND ".$fecha." and tipo_servicio != 'NORMAL' group by nombre ORDER BY total desc";
                            $resultado= $this->conexion_db->query($sql);
                            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                            return $datos;
                        }else if ($array2[0] == "NORMAL") {
                            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND servicio_ingreso = '".$array2[1]."' AND ".$fecha." and tipo_servicio = 'NORMAL' group by nombre ORDER BY total desc";
                            $resultado= $this->conexion_db->query($sql);
                            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                            return $datos;
                        }
        }


public function mapa21($valor)
    {
        $instancia = new Consultas();
        $fecha =$instancia -> get_range($valor);
        $array = explode("|", $valor);
        $array2 = explode("*", $array[0]);
        if ($array2[0] == "AMBAS ESTANCIAS") {
            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND (afeccion_principal = '".$array2[1]."') AND ".$fecha." group by nombre ORDER BY total desc";
            $resultado= $this->conexion_db->query($sql);
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            return $datos;
        }else if ($array2[0] == "CORTA ESTANCIA") {
            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND (afeccion_principal = '".$array2[1]."') AND ".$fecha." and tipo_servicio != 'NORMAL' group by nombre ORDER BY total desc";

            $resultado= $this->conexion_db->query($sql);
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            return $datos;
        }else if ($array2[0] == "NORMAL") {
            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND (afeccion_principal = '".$array2[1]."') AND ".$fecha." and tipo_servicio = 'NORMAL' group by nombre ORDER BY total desc";
            $resultado= $this->conexion_db->query($sql);
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            return $datos;
        }
    }
    public function mapa22($valor)
        {
            $instancia = new Consultas();
            $fecha =$instancia -> get_range($valor);

            $array = explode("|", $valor);
            $array2 = explode("*", $array[0]);
            if ($array2[0] == "AMBAS ESTANCIAS") {
                $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND (afeccion_principal = '".$array2[1]."') AND ".$fecha." group by nombre ORDER BY total desc";
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }else if ($array2[0] == "CORTA ESTANCIA") {
                $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND afeccion_principal = '".$array2[1]."' AND ".$fecha." and tipo_servicio != 'NORMAL' group by nombre ORDER BY total desc";
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }else if ($array2[0] == "NORMAL") {
                $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND afeccion_principal = '".$array2[1]."' AND ".$fecha." and tipo_servicio = 'NORMAL' group by nombre ORDER BY total desc";
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }
        }
        public function mapa23($valor)
        {
            $instancia = new Consultas();
                        $fecha =$instancia -> get_range($valor);

                        $array = explode("|", $valor);
                        $array2 = explode("*", $array[0]);
                        if ($array2[0] == "AMBAS ESTANCIAS") {
                            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND afeccion_principal = '".$array2[1]."' AND ".$fecha." group by nombre ORDER BY total desc";
                            $resultado= $this->conexion_db->query($sql);
                            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                            return $datos;
                        }else if ($array2[0] == "CORTA ESTANCIA") {
                            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND afeccion_principal = '".$array2[1]."' AND ".$fecha." and tipo_servicio != 'NORMAL' group by nombre ORDER BY total desc";
                            $resultado= $this->conexion_db->query($sql);
                            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                            return $datos;
                        }else if ($array2[0] == "NORMAL") {
                            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND afeccion_principal = '".$array2[1]."' AND ".$fecha." and tipo_servicio = 'NORMAL' group by nombre ORDER BY total desc";
                            $resultado= $this->conexion_db->query($sql);
                            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                            return $datos;
                        }
        }









public function mapa31($valor)
    {
        $instancia = new Consultas();
        $fecha =$instancia -> get_range($valor);
        $array = explode("|", $valor);
        $array2 = explode("*", $array[0]);
        if ($array2[0] == "AMBAS ESTANCIAS") {
            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND ".$fecha." group by nombre ORDER BY total desc LIMIT 0, 10";
            $resultado= $this->conexion_db->query($sql);
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            return $datos;
        }else if ($array2[0] == "CORTA ESTANCIA") {
            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND ".$fecha." and tipo_servicio != 'NORMAL' group by nombre ORDER BY total desc LIMIT 0, 10";

            $resultado= $this->conexion_db->query($sql);
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            return $datos;
        }else if ($array2[0] == "NORMAL") {
            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND ".$fecha." and tipo_servicio = 'NORMAL' group by nombre ORDER BY total desc LIMIT 0, 10";
            $resultado= $this->conexion_db->query($sql);
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            return $datos;
        }
    }
    public function mapa32($valor)
        {
            $instancia = new Consultas();
            $fecha =$instancia -> get_range($valor);

            $array = explode("|", $valor);
            $array2 = explode("*", $array[0]);
            if ($array2[0] == "AMBAS ESTANCIAS") {
                $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND ".$fecha." group by nombre ORDER BY total desc LIMIT 0, 10";
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }else if ($array2[0] == "CORTA ESTANCIA") {
                $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND ".$fecha." and tipo_servicio != 'NORMAL' group by nombre ORDER BY total desc LIMIT 0, 10";
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }else if ($array2[0] == "NORMAL") {
                $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND ".$fecha." and tipo_servicio = 'NORMAL' group by nombre ORDER BY total desc LIMIT 0, 10";
                $resultado= $this->conexion_db->query($sql);
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                return $datos;
            }
        }
        public function mapa33($valor)
        {
            $instancia = new Consultas();
                        $fecha =$instancia -> get_range($valor);

                        $array = explode("|", $valor);
                        $array2 = explode("*", $array[0]);
                        if ($array2[0] == "AMBAS ESTANCIAS") {
                            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND ".$fecha." group by nombre ORDER BY total desc LIMIT 0, 10";
                            $resultado= $this->conexion_db->query($sql);
                            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                            return $datos;
                        }else if ($array2[0] == "CORTA ESTANCIA") {
                            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND ".$fecha." and tipo_servicio != 'NORMAL' group by nombre ORDER BY total desc LIMIT 0, 10";
                            $resultado= $this->conexion_db->query($sql);
                            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                            return $datos;
                        }else if ($array2[0] == "NORMAL") {
                            $sql = "SELECT nombre, sum(total) as total FROM principal.tablaDesc2 where (nombre in (SELECT nombre FROM principal.lugares where delegacion = '".$array2[3]."') OR nombre = '".$array2[3]."') AND ".$fecha." and tipo_servicio = 'NORMAL' group by nombre ORDER BY total desc LIMIT 0, 10";
                            $resultado= $this->conexion_db->query($sql);
                            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                            return $datos;
                        }
        }



}