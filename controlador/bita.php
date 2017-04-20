<?php

require_once("../modelo/bitacora.php");
if(!isset($_SESSION)){
     session_start();
 }else{
     session_destroy();
 }

if(isset($_POST['funcion'])){
  $funcion = addslashes(trim($_POST['funcion']));
  switch($funcion){
    case 'agregarBitacora':
      agregar_bitacora();
    break;
  }
}

  function agregar_bitacora(){
    $bita = new Bitacora();
		$valArray = json_decode($_POST['valArray']);
    $valores = 0;
		$idL = $_SESSION['id'];
		$idC = $bita->idConductor($idL);
    $valores = Bitacora::contarArreglo($valArray); // Contar el no. de elementos del arreglo
    echo "Cuenta: ".$valores."<br />";
    foreach($valArray  as $campos){
      //var_dump($campos); // me ayuda para saber qué tipo de dato recibo
      $date = $campos->date;
      $kmCarga = $campos->km;
      $pagoGas = $campos->pago;

    }
    //Se evalua que tipo de conductor es
    if($bita->obtenerTipoCond($idC) == 1){
      echo "Entrooo";

    }else{
      echo "es tipo 2";
      if($bita->tipogasolinaCondu($idC) == 1){
        echo "ES MAGNA <br />";
        /*$ltMagna = $bita->calcularLtGasMagna($pagoGas);
        $bita->agregarCargaConsumible($ltMagna,$pagoGas,$idConsm);

        //Registro de la bitácora Recorrido/Viaje
        $idBitaRV = $bita->agregarBitacoraRecorrido($idC);
        //Registro de la Bitácora de Combustible
        $bita->registroBitacora($idBitaRV,$idKMCarga); */

      }else{
        echo "ES PREMIUM <br />";
        if($valores == 1){ // Evalua si sólo es una fecha
          echo "1";

          $diasF = Bitacora::EvaluarCincoDias($date);
          $totalDias = Bitacora::contarArreglo($diasF);
          echo "total: ".$totalDias;
          print_r($diasF);
          /*
          //Registro de la Bitácora Combustible
          $idBitaCom = $bita->agregarBitacoraCombustible(); // Recuperar el id de la bitacora de combustible
          $idKMCarga = $bita->agregarKmCarga($date,$kmCarga);
          $idConsm = $bita->idconsumibleConductor($idC);

          //Registro del combustible de la Gasolina
          $ltPremium = $bita->calcularLtGasPremium($pagoGas);
          $bita->agregarCargaConsumible($ltPremium,$pagoGas,$idConsm);
  				//Registro de la Bitácora de Combustible
  				$bita->registroBitacora($idBitaCom,$idKMCarga); //Reg. de la bita Combustible

          //Registro de la bitácora Recorrido/Viaje
					$idBitaRV = $bita->agregarBitacoraRecorrido($idC);
					$bita->registroBitacora($idBitaRV,$idKMCarga); //Reg. de la bita Recorrido

          // Se comienzan a realizar las operaciones
					$ltkm = $bita->calcularKmRecorridos($ltPremium,$idC); // Litros en kilometros
					echo "ltKM: ".$ltkm."</br>";
          // Cuál es el tope, o sea cuántos km rinde con esa gasolina
					$kmTope = $bita->calcularKMRendidos($kmCarga,$ltkm);
					echo "kmTOPE: ".$kmTope."</br>";
					$kmxdia = $bita->calcularKmxDia($ltkm); // Cuántos km x día recorrerá
					echo "KMdía: ".$kmxdia."</br>";

						//Calcular el kmfinal
						$kmfinal = $bita->calcularKmFinal($kmCarga,$kmxdia);
						echo "kmFinal1: ".$kmfinal."</br>";
						$kminicial = $kmCarga;

            //Obtener Fecha incio y final, así como las horas
            /*$fechadia = strtotime("+5 days",strtotime($date));
            $dateFinal = getdate($fechadia);
            echo "dateFinal".$dateFinal."<br />";
            $evalua = $bita->calcularDias($date,$dateFinal);
						$arrayFechas = Bitacora::EvaluarDias($evalua);
            $arrayFechas = $bita->fechasCincoDias($date);*
						$arrayHoras = $bita->horaAleat();

						if($bita->validarRecorridos($kmfinal,$kmTope) == true){
							echo "ENTRO IFTOPE <br/>";
							for ($i=0; $i<sizeof($arrayFechas); $i++) {
							   $fecha = $arrayFechas[$i];
							   $hora = $arrayHoras[$i];

								 // Generar los destinos y actividades aleatoriamente
								 $idDes = $bita->aleatorioDestino($idC);
		 						 $idAct = $bita->aleatorioActividad($idC);
								 $bita->registroActDes($idC,$idDes,$idAct,$idBitaRV);

								 $idkm = $bita->agregarKilometraje($fecha,$hora,$kminicial,$kmfinal,$idKMCarga);
								 $kminicial = $bita->obtenerKmInicial($idkm);

								 echo "KMINI2: ".$kminicial."</br>";
								 $kmfinal = $bita->calcularKmFinal($kminicial,$kmxdia);
								 echo "KMfinal2: ".$kmfinal."</br>";
							}
							return $kmfinal;
					}*/
        }
        // Evalua si son dos fechas
        if($valores == 2){
                                    // **** PROCESO PARA LA PRIMERA CARGA (DOS FECHAS) **** //
          $inicio = $valArray[0]->date;
          $fin = $valArray[1]->date;
          $evalua = $bita->calcularDias($inicio,$fin);
          $diasF = Bitacora::EvaluarDias($evalua);
          $noDias = Bitacora::contarArreglo($diasF);

          $idBitaCom1C = $bita->agregarBitacoraCombustible(); // Recuperar el id de la bitacora de combustible
          $idKMCarga1C = $bita->agregarKmCarga($date,$kmCarga);
          $idConsm1C = $bita->idconsumibleConductor($idC);

          //Registro del combustible de la Gasolina
          $ltPremium1C = $bita->calcularLtGasPremium($pagoGas);
          $bita->agregarCargaConsumible($ltPremium1C,$pagoGas,$idConsm1C);
  				//Registro de la Bitácora de Combustible
  				$bita->registroBitacora($idBitaCom1C,$idKMCarga1C); //Reg. de la bita Combustible

          //Registro de la bitácora Recorrido/Viaje
					$idBitaRV1C = $bita->agregarBitacoraRecorrido($idC);
					$bita->registroBitacora($idBitaRV1C,$idKMCarga); //Reg. de la bita Recorrido

          // Se comienzan a realizar las operaciones
					$ltkm1C = $bita->calcularKmRecorridos($ltPremium1C,$idC); // Litros en kilometros
					echo "ltKM: ".$ltkm1C."</br>";
          // Cuál es el tope, o sea cuántos km rinde con esa gasolina
					$kmTope1C = $bita->calcularKMRendidos($kmCarga,$ltkm1C);
					echo "kmTOPE: ".$kmTope1C."</br>";
					$kmxdia1C = $bita->calcularDiasFechas($noDias,$ltkm1C); // Cuántos km x día recorrerá
					echo "KMdía: ".$kmxdia1C."</br>";

						//Calcular el kmfinal
						$kmfinal1C = $bita->calcularKmFinal($kmCarga,$kmxdia1C);
						echo "kmFinal1: ".$kmfinal1C."</br>";
						$kminicial1C = $kmCarga;
            $arrayFechas1C = $bita->fechasCincoDias($date);
						$arrayHoras1C = $bita->horaAleat();
						if($bita->validarRecorridos($kmfinal1C,$kmTope1C) == true){
							echo "ENTRO IFTOPE <br/>";

							for ($i=0; $i<sizeof($arrayFechas1C); $i++) {
							   $fecha1C = $arrayFechas1C[$i];
							   $hora1C = $arrayHoras1C[$i];

								 // Generar los destinos y actividades aleatoriamente
								 $idDes1C = $bita->aleatorioDestino($idC);
		 						 $idAct1C = $bita->aleatorioActividad($idC);
								 $bita->registroActDes($idC,$idDes1C,$idAct1C,$idBitaRV1C);
								 $idkm1C = $bita->agregarKilometraje($fecha,$hora,$kminicial,$kmfinal,$idKMCarga);
								 $kminicial1C = $bita->obtenerKmInicial($idkm1C);

								 echo "KMINI2: ".$kminicial1C."</br>";
								 $kmfinal1C = $bita->calcularKmFinal($kminicial1C,$kmxdia1C);
								 echo "KMfinal2: ".$kmfinal1C."</br>";
							}
							return $kmfinal1C;
					}

                                        //*** PROCESO PARA LA SEGUNDA CARGA (una fecha) ***//











        }
        // Evalua si son más de dos fechas
        if($valores > 2){
          echo "si funcó... al parecer <br />";
          $inicio = $valArray[0]->date;
          $fin = $valArray[1]->date;
          echo "F_INICIO: ".$inicio."<br />";
          echo "F_FIN: ".$fin."<br />";
          $evalua = $bita->calcularDias($inicio,$fin);
          $diasF = Bitacora::EvaluarDias($evalua);
          $totalDias = Bitacora::contarArreglo($diasF);
          $fechaLimite = $diasF[$totalDias-1];
          echo "total: ".$totalDias;

          for($i=0; $i<$totalDias; $i++){
            if($inicio != $fechaLimite){
              $calcula = $bita->calcularDias($inicio,$fin);
              $fechas = Bitacora::EvaluarDias($calcula);
              $nodias = Bitacora::contarArreglo($fechas);

              /*$fechaIn = $fin;
              $fechaFin = $valArray[$i+2]->date; */

              //Comienzan las operaciones


            }
          }
        }
      }
    }
  } //Fin agregarBitacora
 ?>
